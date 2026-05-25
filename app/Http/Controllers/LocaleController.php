<?php

namespace App\Http\Controllers;

use App\Http\Middleware\SetLocale;
use Illuminate\Http\Request;

/**
 * Locale-related public endpoints (no closures, so routes can be cached).
 */
class LocaleController extends Controller
{
    /**
     * Sets the consent cookie for the requested locale and redirects back.
     */
    public function switch($switch_to)
    {
        if (!in_array($switch_to, SetLocale::SUPPORTED, true)) {
            abort(404);
        }
        $referer = request()->headers->get('referer') ?: url('/' . $switch_to);
        return redirect($referer)->cookie(SetLocale::COOKIE, $switch_to, 60 * 24 * 365);
    }

    /**
     * Redirects "/" to the resolved locale prefix.
     */
    public function root()
    {
        return redirect('/' . app()->getLocale());
    }

    /**
     * Standalone admin login view (the form posts to backend\LoginController@login_action).
     */
    public function adminLogin()
    {
        return view('backend.login.login');
    }
}
