<?php
namespace App\Http\Controllers\backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Services;
use App\Http\Middleware\SetLocale;

/**
 * Service pages live as (slug x lang) rows. Save handler upserts each language
 * row independently so saving EN never wipes the DE row.
 *
 * Author : Syed Ali Raza
 */
class ServicesController extends Controller
{
    public function service($slug)
    {
        $rows = [];
        foreach (SetLocale::SUPPORTED as $loc) {
            $existing = Services::where('slug', $slug)->where('lang', $loc)->first();
            $rows[$loc] = $existing ?: (new Services(['slug' => $slug, 'lang' => $loc]));
        }
        return view('backend.pages.services', ['rows' => $rows, 'slug' => $slug]);
    }

    public function save(Request $request)
    {
        $slug = $request->input('slug');
        if (!$slug) {
            return back()->with('error', 'Missing service slug.');
        }

        foreach (SetLocale::SUPPORTED as $loc) {
            if (!$request->has('main_heading.' . $loc) && !$request->has('description.' . $loc)) {
                continue;
            }

            $row = Services::where('slug', $slug)->where('lang', $loc)->first() ?: new Services();
            $row->slug             = $slug;
            $row->lang             = $loc;
            $row->main_heading     = $request->input('main_heading.' . $loc);
            $row->second_heading   = $request->input('second_heading.' . $loc);
            $row->description      = $request->input('description.' . $loc);
            $row->meta_title       = $request->input('meta_title.' . $loc);
            $row->meta_description = $request->input('meta_description.' . $loc);

            $packages_details = [];
            $package_details_arr = (array) $request->input('package_details.' . $loc, []);
            foreach ($package_details_arr as $key => $value) {
                $packages_details[] = [
                    'package_details'            => $value,
                    'number_of_question'         => $request->input('number_of_question.' . $loc . '.' . $key),
                    'package_amount'             => $request->input('package_amount.' . $loc . '.' . $key),
                    'package_name'               => $request->input('package_name.' . $loc . '.' . $key),
                    'package_details_terms'      => $request->input('package_details_terms.' . $loc . '.' . $key),
                    'customer_ask_question_page' => $request->input('customer_ask_question_page.' . $loc . '.' . $key),
                    'package_id'                 => $request->input('package_id.' . $loc . '.' . $key),
                ];
            }
            if (!empty($packages_details)) {
                $row->packages_details = json_encode($packages_details);
            }

            $row->save();
        }

        return back()->with('message', 'add');
    }
}
