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
            //
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
            $bankAccount->user_id = auth()->user()->id;;
            $bankAccount->account_number = encrypt($request->input('account_number'));

            $bankAccount->save();

            return redirect('/home')->with('success', 'Account added');
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
         * @param  \App\BankAccount $bankAccount
         * @return \Illuminate\Http\Response
         */
        public function edit(BankAccount $bankAccount)
        {
            //
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @param  \App\BankAccount $bankAccount
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, BankAccount $bankAccount)
        {
            //
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  \App\BankAccount $bankAccount
         * @return \Illuminate\Http\Response
         */
        public function destroy(BankAccount $bankAccount)
        {
            //
        }
    }
