<?php

namespace App\Http\Controllers;

use App\Group;
use App\User;
use Exception;

class UserGroupController extends Controller
{
    /**
     * @param $group_id
     * @param $contact_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($group_id, $contact_id)
    {
        try{
            $group = Group::find($group_id);
            $contact = User::find($contact_id);
            $group->users()->attach($contact);
            return redirect()->back()->with('success', __('group.contact_added_to_group'));
        }
        catch(Exception $e){
            return redirect()->back()->with('error', __('group.error'));
        }
    }

    /**
     * @param $group_id
     * @param $contact_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($group_id, $contact_id)
    {
        $group = Group::find($group_id);
        $contact = User::find($contact_id);
        $group->users()->detach($contact);
        return redirect()->back()->with('success', __('group.contact_deleted_from_group'));
    }
}
