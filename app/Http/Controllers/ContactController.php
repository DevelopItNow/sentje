<?php

namespace App\Http\Controllers;

use App\Contact;
use App\GroupUser;
use App\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

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
        return view('contacts.index', ['contacts' => Auth::user()->contacts()->with('user')->paginate(10)]);
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

        $user = User::where('email', $request->input('email'))->first();

        if(!is_null($user) && $user->id != Auth::id()){
            try{
                $contact = new Contact;
                $contact->user_id = Auth::id();
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
        Contact::where('user_id', Auth::id())->where('contact_id', $id)->delete();
        GroupUser::where('user_id', $id)->delete();

        return redirect('/contacts')->with('success', __('contact.contact_deleted'));
    }
}
