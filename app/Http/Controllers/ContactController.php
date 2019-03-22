<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

class ContactController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = \App\User::orderBy('id', 'ASC')->join('contacts', 'users.id', '=', 'contacts.contact_id')->where('contacts.user_id', '=', auth()->user()->id)->paginate(10);
        return view('contacts.index', ['contacts' => $contacts]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);

        $user = \App\User::where('email', $request->input('email'))->first();

        if(!is_null($user) && $user->id != auth()->user()->id){
            try{
                $contact = new \App\Contact;
                $contact->user_id = auth()->user()->id;
                $contact->contact_id = $user->id;

                $contact->save();

                return redirect('/contacts')->with('success', __('contact.contact_added'));
            }
            catch(\Exception $e){
                return redirect('/contacts')->with('error', __('contact.error'));
            }
        }
        else{
            return redirect('/contacts')->with('error', __('contact.contact_error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = \App\Contact::where('user_id', auth()->user()->id)->where('contact_id', $id);
        $contact->delete();
        return redirect('/contacts')->with('success', __('contact.contact_deleted'));
    }
}
