<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Middleware\SetLocale;
use App\Models\MenuItem;
use Illuminate\Http\Request;

/**
 * CRUD for navigation menus. Items are scoped by (lang, location); the public
 * site reads them per locale when rendering the header/footer.
 */
class MenuController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->input('lang', 'en');
        if (!in_array($lang, SetLocale::SUPPORTED, true)) {
            $lang = 'en';
        }
        $items = MenuItem::where('lang', $lang)
            ->orderBy('location')
            ->orderBy('sort')
            ->get()
            ->groupBy('location');

        return view('backend.menus.list', [
            'items'     => $items,
            'lang'      => $lang,
            'locales'   => SetLocale::SUPPORTED,
            'locations' => MenuItem::LOCATIONS,
        ]);
    }

    public function add()
    {
        return view('backend.menus.add', [
            'locales'   => SetLocale::SUPPORTED,
            'locations' => MenuItem::LOCATIONS,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'lang'     => 'required|in:' . implode(',', SetLocale::SUPPORTED),
            'location' => 'required|in:' . implode(',', array_keys(MenuItem::LOCATIONS)),
            'label'    => 'required|string|max:255',
            'url'      => 'required|string|max:1000',
        ]);

        MenuItem::create([
            'lang'     => $request->lang,
            'location' => $request->location,
            'label'    => $request->label,
            'url'      => $request->url,
            'sort'     => (int) $request->sort,
        ]);

        return redirect('dashboard/menus?lang=' . $request->lang)->with('message', 'add');
    }

    public function edit($id)
    {
        $item = MenuItem::findOrFail($id);
        return view('backend.menus.edit', [
            'item'      => $item,
            'locales'   => SetLocale::SUPPORTED,
            'locations' => MenuItem::LOCATIONS,
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = MenuItem::findOrFail($id);
        $request->validate([
            'lang'     => 'required|in:' . implode(',', SetLocale::SUPPORTED),
            'location' => 'required|in:' . implode(',', array_keys(MenuItem::LOCATIONS)),
            'label'    => 'required|string|max:255',
            'url'      => 'required|string|max:1000',
        ]);

        $item->update([
            'lang'     => $request->lang,
            'location' => $request->location,
            'label'    => $request->label,
            'url'      => $request->url,
            'sort'     => (int) $request->sort,
        ]);

        return redirect('dashboard/menus?lang=' . $request->lang)->with('message', 'update');
    }

    public function delete($id)
    {
        $item = MenuItem::findOrFail($id);
        $lang = $item->lang;
        $item->delete();
        return redirect('dashboard/menus?lang=' . $lang)->with('message', 'deleted');
    }
}
