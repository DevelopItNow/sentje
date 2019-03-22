<?php

namespace App\Http\Controllers;

use App\Group;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
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
        $groups = Group::orderBy('id', 'ASC')->where('user_id', '=', \Auth::id())->paginate(10);
        return view('groups.index' , ['groups' => $groups]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('groups.create');
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
        /** @var TYPE_NAME $request */
        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required|min:3|max:500',
        ]);

        $group = new Group;
        $group->name = $request->input('name');
        $group->description = $request->input('description');
        $group->user_id = Auth::id();
        $group->save();

        return redirect('/groups')->with('success', __('group.group_added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group $group
     * @return void
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = Group::find($id);
        $contacts = User::orderBy('id', 'ASC')
            ->join('contacts', 'users.id', '=', 'contacts.contact_id')
            ->where('contacts.user_id', '=', Auth::id())
            ->paginate(10);
        $added_contacts = User::orderBy('id', 'ASC')
            ->join('contacts', 'users.id', '=', 'contacts.contact_id')
            ->join('group_user', 'group_user.user_id', '=', 'contacts.contact_id')
            ->where('group_user.group_id', '=', $id)
            ->where('contacts.user_id', '=', Auth::id())
            ->paginate(10);
        if ($group == null) {
            return redirect('/groups')->with('error', __('error.unauthorized_page'));
        }

        if ($group->user_id != Auth::id()) {
            return redirect('/groups')->with('error', __('error.unauthorized_page'));
        }

        return view('groups.edit')->with('group', $group)
            ->with('contacts', $contacts)
            ->with('added_contacts', $added_contacts);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required|min:3|max:500',
        ]);

        $group = Group::find($id);

        if ($group == null) {
            return redirect('/groups')->with('error', __('error.unauthorized_page'));
        }

        if ($group->user_id != Auth::id()) {
            return redirect('/groups')->with('error', __('error.unauthorized_page'));
        }

        $group->name = $request->input('name');
        $group->description = $request->input('description');
        $group->save();

        return redirect('/groups')->with('success', __('group.group_changed'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Group $group
     * @return void
     */
    public function destroy($id)
    {
        $group = Group::find($id);

        if ($group == null) {
            return redirect('/groups')->with('error', __('error.unauthorized_page'));
        }

        if ($group->user_id != auth()->user()->id) {
            return redirect('/groups')->with('error', __('error.unauthorized_page'));
        }
    }
}
