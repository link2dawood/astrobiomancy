<?php
namespace App\Http\Controllers\backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Hash;
use Illuminate\Support\Collection;
use App\User;
use App\Models\Aboutus;
use App\Models\Disclaimer;
use App\Models\Privacypolicy;
use App\Models\Homepage;
use App\Models\Pages;
use App\Http\Middleware\SetLocale;

/**
 * Backend page management. Singleton pages (about, disclaimer, privacy, home)
 * carry one row per locale, keyed by `lang`. Save handlers upsert only the
 * languages present in the request, so a save targeting EN cannot wipe DE.
 *
 * Author : Syed Ali Raza
 */
class PagesController extends Controller
{
    /**
     * @return array<string> Supported locale codes.
     */
    private function locales()
    {
        return SetLocale::SUPPORTED;
    }

    /**
     * Load a singleton model's row for each locale, creating blank rows on the fly
     * so the view always has something to bind to.
     *
     * @param string $modelClass FQCN of an Eloquent model
     * @return array<string, \Illuminate\Database\Eloquent\Model> keyed by locale
     */
    private function loadByLocale($modelClass)
    {
        $rows = [];
        foreach ($this->locales() as $loc) {
            $rows[$loc] = $modelClass::firstOrNew(['lang' => $loc]);
        }
        return $rows;
    }

    /**
     * Upsert the language-keyed payload onto a singleton model. Each lang is
     * persisted independently; missing langs in the request are left untouched.
     *
     * @param string $modelClass FQCN
     * @param Request $request
     * @param array<string> $fields Fields expected as field[lang] on the request
     */
    private function saveByLocale($modelClass, Request $request, array $fields)
    {
        // Legacy fallback: when fields arrive as scalars (old single-language form),
        // treat them as EN input so unmigrated views keep working.
        $legacy = false;
        foreach ($fields as $f) {
            if ($request->has($f) && !is_array($request->input($f))) {
                $legacy = true;
                break;
            }
        }

        if ($legacy) {
            $row = $modelClass::firstOrNew(['lang' => 'en']);
            foreach ($fields as $f) {
                if ($request->has($f)) {
                    $row->{$f} = $request->input($f);
                }
            }
            $row->lang = 'en';
            $row->save();
            return;
        }

        foreach ($this->locales() as $loc) {
            $touched = false;
            foreach ($fields as $f) {
                if ($request->has($f . '.' . $loc)) {
                    $touched = true;
                    break;
                }
            }
            if (!$touched) {
                continue;
            }
            $row = $modelClass::firstOrNew(['lang' => $loc]);
            foreach ($fields as $f) {
                $value = $request->input($f . '.' . $loc);
                if ($f === 'slug' && $value) {
                    // Sanitize slug: lowercase, only a-z 0-9 dash.
                    $value = strtolower(trim($value));
                    $value = preg_replace('/[^a-z0-9-]+/', '-', $value);
                    $value = trim($value, '-');
                }
                $row->{$f} = $value;
            }
            $row->lang = $loc;
            $row->save();
        }
    }

    /**
     * List every Pages-collection row, grouped by slug + language so the
     * editor can see all custom pages at a glance and duplicate any of them.
     */
    public function pagesIndex()
    {
        $pages = Pages::orderBy('slug')->orderBy('lang')->get()->groupBy('slug');
        return view('backend.pages.list', ['pageGroups' => $pages]);
    }

    public function newPage()
    {
        return view('backend.pages.new');
    }

    public function createPage(Request $request)
    {
        $request->validate([
            'slug'  => 'required|string|max:191',
            'title' => 'required|string|max:191',
        ]);

        $slug = strtolower(trim($request->slug));
        $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug);
        $slug = trim($slug, '-');

        if (Pages::where('slug', $slug)->exists()) {
            return back()->with('error', 'A page with slug "' . $slug . '" already exists.')->withInput();
        }

        // Seed an EN row; editors can add a DE counterpart later via the editor.
        $p = new Pages();
        $p->slug         = $slug;
        $p->lang         = 'en';
        $p->main_heading = $request->title;
        $p->save();

        return redirect('dashboard/pages/' . $slug)->with('message', 'add');
    }

    /**
     * Duplicate every language row of a page into a new slug. Editor lands
     * on the new page's editor with all content pre-filled.
     */
    public function duplicate($slug)
    {
        $sourceRows = Pages::where('slug', $slug)->get();
        if ($sourceRows->isEmpty()) {
            return back()->with('error', 'Source page not found.');
        }

        $newSlug = $slug . '-copy';
        $i = 2;
        while (Pages::where('slug', $newSlug)->exists()) {
            $newSlug = $slug . '-copy-' . $i++;
        }

        foreach ($sourceRows as $src) {
            $copy = $src->replicate();
            $copy->slug = $newSlug;
            $copy->save();
        }

        return redirect('dashboard/pages/' . $newSlug)->with('message', 'add');
    }

    public function page($slug)
    {
        $pages = [];
        foreach ($this->locales() as $loc) {
            // No cross-language fallback here — that previously caused the
            // DE form's hidden id to point at the EN row, so saving DE
            // overwrote EN. Leave the tab empty when no row exists for
            // this locale, and let update() create it on save.
            $pages[$loc] = Pages::where('slug', $slug)->where('lang', $loc)->first();
        }
        return view('backend.pages.page', compact('pages', 'slug'));
    }

    /**
     * Create or update a page row, scoped strictly to (id, lang). Each form
     * tab posts its own _save_lang and slug so a missing id triggers an
     * insert into the correct language slot rather than overwriting another
     * language's existing row.
     */
    public function update(Request $request)
    {
        $lang = in_array($request->_save_lang, $this->locales(), true)
            ? $request->_save_lang
            : SetLocale::DEFAULT;

        // Sanitize requested slug — lowercase + a-z 0-9 dash only.
        $requestedSlug = strtolower(trim((string) $request->slug));
        $requestedSlug = preg_replace('/[^a-z0-9-]+/', '-', $requestedSlug);
        $requestedSlug = trim($requestedSlug, '-');

        if ($request->filled('id')) {
            $pages = Pages::findOrFail($request->id);
            // Safety: if the row's lang doesn't match the form's lang, refuse
            // to update it. Prevents cross-language overwrites if the form is
            // tampered with.
            if ($pages->lang && $pages->lang !== $lang) {
                return back()->with('error', 'Refused to save: row language does not match the form language.');
            }
        } else {
            $pages = new Pages();
        }

        // Slug change handling — disallow collision with another row in the
        // same language. If the slug is being changed, redirect after save
        // so the admin doesn't 404 on the old URL.
        $oldSlug = $pages->slug ?? null;
        if ($requestedSlug && $requestedSlug !== $oldSlug) {
            $clash = Pages::where('slug', $requestedSlug)
                ->where('lang', $lang)
                ->where('id', '!=', $pages->id ?? 0)
                ->exists();
            if ($clash) {
                return back()->with('error', 'Another page already uses the slug "' . $requestedSlug . '" in ' . strtoupper($lang) . '.');
            }
            $pages->slug = $requestedSlug;
        } elseif (!$pages->slug) {
            // New row, no slug typed — fall back to the URL parameter
            $pages->slug = $request->input('_slug') ?: $requestedSlug;
        }

        $pages->lang             = $lang;
        $pages->main_heading     = $request->main_heading;
        $pages->second_heading   = $request->second_heading;
        $pages->description      = $request->description;
        $pages->meta_title       = $request->meta_title;
        $pages->meta_description = $request->meta_description;
        $pages->save();

        // If the slug changed, redirect to the editor under the NEW slug so
        // the URL bar stays in sync; otherwise plain back().
        if ($oldSlug && $pages->slug !== $oldSlug) {
            return redirect('dashboard/pages/' . $pages->slug)
                ->with('message', 'update');
        }

        return back()->with('message', $request->filled('id') ? 'update' : 'add');
    }

    public function about()
    {
        $rows = $this->loadByLocale(Aboutus::class);
        return view('backend.pages.aboutus', ['rows' => $rows]);
    }

    public function about_save(Request $request)
    {
        $this->saveByLocale(Aboutus::class, $request, [
            'main_heading', 'second_heading', 'description',
            'meta_title', 'meta_description', 'slug',
        ]);
        return back()->with('message', 'add');
    }

    public function disclaimer()
    {
        $rows = $this->loadByLocale(Disclaimer::class);
        return view('backend.pages.disclaimer', ['rows' => $rows]);
    }

    public function disclaimer_save(Request $request)
    {
        $this->saveByLocale(Disclaimer::class, $request, [
            'main_heading', 'second_heading', 'description',
            'meta_title', 'meta_description', 'slug',
        ]);
        return back()->with('message', 'add');
    }

    public function privacypolicy()
    {
        $rows = $this->loadByLocale(Privacypolicy::class);
        return view('backend.pages.privacypolicy', ['rows' => $rows]);
    }

    public function privacypolicy_save(Request $request)
    {
        $this->saveByLocale(Privacypolicy::class, $request, [
            'main_heading', 'second_heading', 'description',
            'meta_title', 'meta_description', 'slug',
        ]);
        return back()->with('message', 'add');
    }

    public function home()
    {
        $rows = $this->loadByLocale(Homepage::class);
        return view('backend.pages.homepage', ['rows' => $rows]);
    }

    public function home_save(Request $request)
    {
        // Image is shared (one banner for both langs); upload once.
        $imageName = '';
        $image = $request->file('image');
        if (isset($image)) {
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('uploads/images/'), $imageName);
        }

        foreach ($this->locales() as $loc) {
            if (!$request->has('top_header_heading.' . $loc)) {
                continue; // language not submitted — leave its row alone
            }

            $row = Homepage::firstOrNew(['lang' => $loc]);
            $row->lang                  = $loc;
            $row->top_header_heading    = $request->input('top_header_heading.' . $loc);
            $row->get_started_label     = $request->input('get_started_label.' . $loc);
            $row->top_header_subheading = $request->input('top_header_subheading.' . $loc);
            $row->get_started_link      = $request->input('get_started_link.' . $loc);
            $row->welcome_lable         = $request->input('welcome_lable.' . $loc);
            $row->weclome_text          = $request->input('weclome_text.' . $loc);
            $row->meta_title             = $request->input('meta_title.' . $loc);
            $row->meta_description       = $request->input('meta_description.' . $loc);

            if ($imageName !== '') {
                $row->banner_image = $imageName;
            }

            $qa_json = [];
            $questions = (array) $request->input('question.' . $loc, []);
            $answers   = (array) $request->input('answer.' . $loc, []);
            foreach ($questions as $i => $q) {
                $qa_json[] = ['question' => $q, 'answer' => $answers[$i] ?? ''];
            }
            $row->qa_json = json_encode($qa_json);

            $offer_data_links = [];
            $names = (array) $request->input('offer_name.' . $loc, []);
            $links = (array) $request->input('offer_link.' . $loc, []);
            $icons = (array) $request->input('offer_icon.' . $loc, []);
            foreach ($names as $i => $n) {
                $offer_data_links[] = [
                    'name'       => $n,
                    'offer_link' => $links[$i] ?? '',
                    'offer_icon' => $icons[$i] ?? '',
                ];
            }
            $row->offer_json = json_encode([
                'offer_heading'    => $request->input('offer_heading.' . $loc),
                'offer_p1'         => $request->input('offer_p1.' . $loc),
                'offer_p2'         => $request->input('offer_p2.' . $loc),
                'offer_data_links' => $offer_data_links,
            ]);

            $row->save();
        }

        return back()->with('message', 'add');
    }
}
