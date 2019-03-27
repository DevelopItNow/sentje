<?php

    namespace App\Http\Controllers;

    use App\Donation;
    use App\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Config;
    use Illuminate\Support\Facades\Cookie;
    use Illuminate\Support\Facades\Crypt;
    use Mollie\Laravel\Facades\Mollie;
    use Exception;

    class DonationController extends Controller
    {
        /**
         * Display a listing of the resource.
         *
         * @param string $name
         * @return \Illuminate\Http\Response
         */
        public function index($name = '')
        {
            if ($name == '') {
                return redirect('/');
            }
            $users = user::all()->filter(function ($record) use ($name) {
                if (Crypt::decrypt($record->name) == $name) {
                    return $record;
                }
            });
            if (count($users) == 0) {
                return redirect('/');
            } else {
                $user = $users->first();
                return view('donation.index')->with(['user' => $user]);
            }
        }

        /**
         *
         */
        public function donate(Request $request)
        {
            $this->validate($request, [
                'name' => 'required|string',
                'amount' => 'required|numeric',
                'currency' => 'required',
            ]);
//            dd($request->input());
            if ($request->input('currency') == 'euro') {
                $currencyTo = 'EUR';
            } else {
                $currencyTo = 'GBP';
            }

            if (Config::get('app.locale') == 'nl') {
                $locale = 'nl_NL';
            } else {
                $locale = 'en_US';
            }
            $amount = $request->input('amount');

            if (strpos($amount, '.') === false) {
                $amount = $amount . '.00';
            }

            $donation = new Donation;
            $donation->user_id = $request->input('id');
            $user = User::find($request->input('id'));
            $donation->account_id = $user->donation_account;
            $donation->amount = $amount;
            $donation->currency = $request->input('currency');
            $donation->name = encrypt($request->input('name'));
            $donation->paid = false;
            $donation->save();

            $payment = Mollie::api()->payments()->create([
                'amount' => [
                    'currency' => $currencyTo,
                    'value' => $amount,
                    // You must send the correct number of decimals, thus we enforce the use of strings
                ],
                'locale' => $locale,
                'description' => 'Sentje Payment',
                'webhookUrl' => 'http://kevindev.nl/tempp.php',
                'redirectUrl' => route('donate.success', ['id' => $donation->id]),
            ]);

            Cookie::queue('donation', $payment->id, 5);
            $payment = Mollie::api()->payments()->get($payment->id);

            // redirect customer to Mollie checkout page
            return redirect($payment->getCheckoutUrl(), 303);
        }

        public function success($id)
        {
            try {
                $payment = Mollie::api()->payments()->get(Cookie::get('donation'));
                if ($payment->isPaid()) {
                    $donation = Donation::find($id);
                    $donation->paid = true;
                    $donation->save();
                } else {
                    return redirect('/')->with('error', __('error.payment_error'));
                }
            } catch (Exception $e) {
                return redirect('/')->with('error', __('error.payment_error'));
            }
            return view('donation.success');
        }
    }
