<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LocalController extends Controller
{
    public function setLocale($locale)
    {
        \Session::put('language', $locale);
        return redirect()->back();
    }
}
