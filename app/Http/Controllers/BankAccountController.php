<?php

    namespace App\Http\Controllers;

    use App\BankAccount;
    use danielme85\CConverter\Currency;
    use GuzzleHttp\Exception\ClientException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use League\Flysystem\Filesystem;
    use Spatie\Dropbox\Client;
    use Spatie\Dropbox\Exceptions\BadRequest;
    use Spatie\FlysystemDropbox\DropboxAdapter;

    class BankAccountController extends Controller
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
            return view('accounts.index',
                ['bankaccounts' => Auth::user()->bankaccounts()->orderBy('id', 'ASC')->paginate(10)]);
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
            $bankAccount->user_id = Auth::id();
            $bankAccount->account_number = encrypt($request->input('account_number'));

            $bankAccount->save();

            return redirect('/home')->with('success', __('account.account_added'));
        }

        /**
         * Display the specified resource.
         *
         * @param $id
         * @return void
         */
        public function show($id)
        {
            $account = BankAccount::find($id);

            if ($account == null) {
                return redirect('/account')->with('error', __('error.unauthorized_page'));
            }

            if ($account->user_id != auth()->user()->id) {
                return redirect('/account')->with('error', __('error.unauthorized_page'));
            }

            return view('accounts.show')->with('account', $account);
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {

            $account = BankAccount::find($id);
            $planned_payments = $account->plannedPayments()->where('paid', 1)->get();
            $donations = $account->donations()->where('paid', 1)->get();
            $payment_requests = $account->paymentRequests;
            $currency = new Currency(null, null, false, null, true);

            foreach ($planned_payments as $planned_payment) {
                if ($planned_payment->currency == 'pound') {
                    $planned_payment->amount = $currency->convert('GBP', 'EUR', $planned_payment->amount, 2);
                }
            }

            foreach ($payment_requests as $payment_request) {
                if ($payment_request->currency == 'pound') {
                    $payment_request->amount = $currency->convert('GBP', 'EUR', $payment_request->amount, 2);
                }
            }

            foreach ($donations as $donation) {
                if ($donation->currency == 'pound') {
                    $donation->amount = $currency->convert('GBP', 'EUR', $donation->amount, 2);
                }
            }

            if ($account == null) {
                return redirect('/account')->with('error', __('error.unauthorized_page'));
            }

            if ($account->user_id != Auth::id()) {
                return redirect('/account')->with('error', __('error.unauthorized_page'));
            }

            return view('accounts.edit')->with([
                'account' => $account,
                'planned_payments' => $planned_payments,
                'payment_requests' => $payment_requests,
                'donations' => $donations
            ]);
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

            if ($bankAccount->user_id != Auth::id()) {
                return redirect('/account')->with('error', __('error.unauthorized_page'));
            }

            $bankAccount->name = encrypt($request->input('name'));
            $bankAccount->user_id = Auth::id();
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

            if ($bankAccount->user_id != Auth::id()) {
                return redirect('/account')->with('error', __('error.unauthorized_page'));
            }

            $bankAccount->delete();
            return redirect('/account')->with('success', __('account.account_deleted'));
        }

        /**
         * Export all the accounts to a Dropbox account
         *
         * @return \Illuminate\Http\RedirectResponse
         */
        public function exportAccount()
        {
            // Exporting the account values
            $client = new Client(decrypt(Auth::user()->dropbox_token));
            try {
                $accounts = Auth::user()->bankaccounts()->orderBy('id', 'ASC')->get();


                $sendThisToDropbox = array();
                foreach ($accounts as $account) {

                    $allTheAccountInfo = array();
                    $listAccounts = array();
                    $listPlannedPayments = array();
                    $listPaymentRequests = array();
                    $listDonations = array();

                    $planned_payments = $account->plannedPayments()->where('paid', 1)->get();
                    $donations = $account->donations()->where('paid', 1)->get();
                    $payment_requests = $account->paymentRequests;
                    $currency = new Currency(null, null, false, null, true);

                    array_push($listAccounts,
                        array(
                            __('export.name') => decrypt($account->name),
                            __('export.number') => decrypt($account->account_number),
                            __('export.created_at') => date('d-m-Y - H:i:s', strtotime($account->created_at))
                        ));

                    foreach ($planned_payments as $planned_payment) {
                        if ($planned_payment->currency == 'pound') {
                            $planned_payment->amount = $currency->convert('GBP', 'EUR', $planned_payment->amount, 2);
                        }
                        array_push($listPlannedPayments,
                            array(
                                __('export.name') => decrypt($planned_payment->payment_name),
                                __('export.amount') => number_format($planned_payment->amount, 2),
                            ));
                    }
                    if (count($listPlannedPayments) > 0) {
                        array_push($allTheAccountInfo, [__('export.planned_payments') => $listPlannedPayments]);
                    }


                    foreach ($payment_requests as $payment_request) {
                        foreach ($payment_request->RequestUsers as $request_user) {
                            if ($request_user->paid == 1) {
                                if ($payment_request->currency == 'pound') {
                                    $payment_request->amount = $currency->convert('GBP', 'EUR',
                                        $payment_request->amount,
                                        2);
                                }
                                array_push($listPaymentRequests,
                                    array(
                                        __('export.name') => decrypt($payment_request->name),
                                        __('export.amount') => number_format($payment_request->amount, 2),
                                    ));
                            }
                        }
                    }
                    if (count($listPaymentRequests) > 0) {
                        array_push($allTheAccountInfo, [__('export.payment_requests') => $listPaymentRequests]);
                    }


                    foreach ($donations as $donation) {
                        if ($donation->currency == 'pound') {
                            $donation->amount = $currency->convert('GBP', 'EUR', $donation->amount, 2);
                        }
                        array_push($listDonations,
                            array(
                                __('export.name') => decrypt($donation->name),
                                __('export.amount') => number_format($donation->amount, 2),
                            ));

                    }
                    if (count($listDonations) > 0) {
                        array_push($allTheAccountInfo, [__('export.donations') => $listDonations]);
                    }
                    array_push($sendThisToDropbox, [decrypt($account->name) => $allTheAccountInfo]);
                }


                $client->upload(__('export.accounts') . ' ' . date("d-m-Y H i s") . '.json',
                    json_encode($sendThisToDropbox));

                // Redirect to account page
                return redirect('account')->with('success', __('account.export_success'));
            } catch (BadRequest $exception) {
                return redirect('account')->with('error', __('account.export_failed'));
            }
        }
    }
