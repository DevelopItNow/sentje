<?php

    namespace App\Http\Controllers;

    use App\BankAccount;
    use Illuminate\Http\Request;

    class BankAccountController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function index()
        {
            $bankaccounts = BankAccount::orderBy('id', 'ASC')->where('user_id', '=', auth()->user()->id)->paginate(10);
            return view('accounts.index', ['bankaccounts' => $bankaccounts]);
        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            return view('accounts.create');
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
                'name' => 'required|string',
                'account_number' => 'required|string|iban',
            ]);

            $bankAccount = new BankAccount;
            $bankAccount->name = encrypt($request->input('name'));
            $bankAccount->user_id = auth()->user()->id;
            $bankAccount->account_number = encrypt($request->input('account_number'));

            $bankAccount->save();

            return redirect('/home')->with('success', __('account.account_added'));
        }

        /**
         * Display the specified resource.
         *
         * @param  \App\BankAccount $bankAccount
         * @return \Illuminate\Http\Response
         */
        public function show(BankAccount $bankAccount)
        {
            //
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param BankAccount $account
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {

            $account = BankAccount::find($id);

            if ($account == null) {
                return redirect('/account')->with('error', __('error.unauthorized_page'));
            }

            if ($account->user_id != auth()->user()->id) {
                return redirect('/account')->with('error', __('error.unauthorized_page'));
            }

            return view('accounts.edit')->with('account', $account);
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
                'account_number' => 'required|string|iban',
            ]);

            $bankAccount = BankAccount::find($id);

            if ($bankAccount == null) {
                return redirect('/account')->with('error', __('error.unauthorized_page'));
            }

            if ($bankAccount->user_id != auth()->user()->id) {
                return redirect('/account')->with('error', __('error.unauthorized_page'));
            }

            $bankAccount->name = encrypt($request->input('name'));
            $bankAccount->user_id = auth()->user()->id;
            $bankAccount->account_number = encrypt($request->input('account_number'));

            $bankAccount->save();

            return redirect('/account')->with('success', __('account.account_changed'));

        }

        /**
         * Remove the specified resource from storage.
         *
         * @param $id
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
        {

            $bankAccount = BankAccount::find($id);

            if ($bankAccount == null) {
                return redirect('/account')->with('error', __('error.unauthorized_page'));
            }

            if ($bankAccount->user_id != auth()->user()->id) {
                return redirect('/account')->with('error', __('error.unauthorized_page'));
            }

            $bankAccount->delete();
            return redirect('/account')->with('success', __('account.account_deleted'));


        }
    }
