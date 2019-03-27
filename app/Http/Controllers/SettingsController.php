<?php

    namespace App\Http\Controllers;

    use App\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    class SettingsController extends Controller
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

        public function index()
        {
            $user = User::find(Auth::id());
            $accounts = $user->BankAccounts;
            return view('auth.settings')->with(["user" => $user, "accounts" => $accounts]);
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @param $id
         * @return void
         * @throws \Illuminate\Validation\ValidationException
         */
        public function update(Request $request)
        {
            $this->validate($request, [
                'name' => 'required|string',
            ]);

            $user = User::find(Auth::id());

            $user->name = encrypt($request->input('name'));
            if ($request->input('dropbox_token') != null) {
                $user->dropbox_token = encrypt($request->input('dropbox_token'));
            }

            if ($request->input('donation_account') == 0) {
                $user->donation_account = $request->input(null);
            } else {
                $user->donation_account = $request->input('donation_account');
            }
            $user->save();

            return redirect('/settings')->with('success', __('auth.edit_successfully'));

        }
    }
