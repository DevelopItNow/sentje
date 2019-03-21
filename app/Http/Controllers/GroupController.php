<?php

namespace App\Http\Controllers;

use App\Group;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::orderBy('id', 'ASC')->where('user_id', '=', auth()->user()->id)->paginate(10);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required|min:3|max:500',
        ]);

        $group = new Group;
        $group->name = $request->input('name');
        $group->description = $request->input('description');
        $group->user_id = auth()->user()->id;
        $group->save();

        return redirect('/groups')->with('success', __('group.group_added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = Group::find($id);

        if ($group == null) {
            return redirect('/groups')->with('error', __('error.unauthorized_page'));
        }

        if ($group->user_id != auth()->user()->id) {
            return redirect('/groups')->with('error', __('error.unauthorized_page'));
        }

        return view('groups.edit')->with('group', $group);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
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

        if ($group->user_id != auth()->user()->id) {
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
     * @param  \App\Group  $group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        //
    }
}
