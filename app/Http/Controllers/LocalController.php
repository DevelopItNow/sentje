<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Session;

class LocalController extends Controller
{
    public function setLocale($locale)
    {
        Session::put('language', $locale);
        return redirect()->back();
    }
}
