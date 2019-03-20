<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('contacts.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);

        $user = \App\User::where('email', $request->input('email'))->first();

        if(!is_null($user)){
            $contact = new \App\Contact;
            $contact->user_id = auth()->user()->id;
            $contact->contact_id = $user->id;

            $contact->save();

            return redirect('/home')->with('success', __('contact.contact_added'));
        }
        else{
            return redirect('/contacts')->with('error', __('contact.contact_error'));
        }
    }
}
