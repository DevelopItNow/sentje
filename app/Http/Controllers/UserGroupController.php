<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserGroupController extends Controller
{
    public function store($group, $contact){
        return redirect()->back()->with('success', $group, $contact);
    }
}
