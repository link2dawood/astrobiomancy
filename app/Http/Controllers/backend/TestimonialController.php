<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Middleware\SetLocale;
use App\Models\Testimonial;
use Illuminate\Http\Request;

/**
 * Testimonials live as (person, language) rows. The admin filters by language
 * via tabs; each save targets one row, so EN and DE never collide.
 */
class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->input('lang', 'en');
        if (!in_array($lang, SetLocale::SUPPORTED, true)) {
            $lang = 'en';
        }
        $items = Testimonial::where('lang', $lang)
            ->orderBy('sort')
            ->orderBy('id', 'desc')
            ->paginate(20);
        return view('backend.testimonials.list', [
            'items'   => $items,
            'lang'    => $lang,
            'locales' => SetLocale::SUPPORTED,
        ]);
    }

    public function add()
    {
        $parents = Testimonial::whereNull('translation_of')->orderBy('name')->get(['id', 'name', 'lang']);
        return view('backend.testimonials.add', [
            'locales' => SetLocale::SUPPORTED,
            'parents' => $parents,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateInput($request);
        $data['photo'] = $this->handlePhoto($request);
        Testimonial::create($data);
        return redirect('dashboard/testimonials?lang=' . $data['lang'])->with('message', 'add');
    }

    public function edit($id)
    {
        $item = Testimonial::findOrFail($id);
        $parents = Testimonial::whereNull('translation_of')
            ->where('id', '!=', $id)
            ->orderBy('name')
            ->get(['id', 'name', 'lang']);
        return view('backend.testimonials.edit', [
            'item'    => $item,
            'locales' => SetLocale::SUPPORTED,
            'parents' => $parents,
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = Testimonial::findOrFail($id);
        $data = $this->validateInput($request);
        $photo = $this->handlePhoto($request);
        if ($photo !== null) {
            $data['photo'] = $photo;
        }
        $item->update($data);
        return redirect('dashboard/testimonials?lang=' . $data['lang'])->with('message', 'update');
    }

    public function delete($id)
    {
        $item = Testimonial::findOrFail($id);
        $lang = $item->lang;
        $item->delete();
        return redirect('dashboard/testimonials?lang=' . $lang)->with('message', 'deleted');
    }

    private function validateInput(Request $request)
    {
        $data = $request->validate([
            'lang'           => 'required|in:' . implode(',', SetLocale::SUPPORTED),
            'name'           => 'required|string|max:191',
            'content'        => 'required|string',
            'display_date'   => 'nullable|date',
            'sort'           => 'nullable|integer',
            'status'         => 'required|in:Published,Pending',
            'translation_of' => 'nullable|integer|exists:testimonials,id',
        ]);
        $data['sort'] = (int) ($data['sort'] ?? 0);
        return $data;
    }

    private function handlePhoto(Request $request)
    {
        $photo = $request->file('photo');
        if (!$photo) {
            return null;
        }
        $name = time() . '_' . preg_replace('/[^A-Za-z0-9._-]/', '', $photo->getClientOriginalName());
        $photo->move(public_path('uploads/testimonials/'), $name);
        return $name;
    }
}
