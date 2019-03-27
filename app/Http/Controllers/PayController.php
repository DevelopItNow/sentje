<?php

    namespace App\Http\Controllers;

    use App\PlannedPayment;
    use App\RequestsUsers;
    use Illuminate\Support\Facades\Config;
    use Illuminate\Support\Facades\Cookie;
    use Mollie\Laravel\Facades\Mollie;
    use Exception;

    class PayController extends Controller
    {
        public function pay($amount, $currency, $id, $type)
        {
            if ($currency == 'euro') {
                $currencyTo = 'EUR';
            }
            else {
                $currencyTo = 'GBP';
            }

            if(Config::get('app.locale') == 'nl'){
                $locale = 'nl_NL';
            }
            else{
                $locale = 'en_US';
            }

            if (strpos($amount, '.') === false) {
                $amount = $amount .'.00';
            }

            $payment = Mollie::api()->payments()->create([
                'amount' => [
                    'currency' => $currencyTo,
                    'value' => $amount,
                    // You must send the correct number of decimals, thus we enforce the use of strings
                ],
                'locale' => $locale,
                'description' => 'Sentje Payment',
//                'webhookUrl' => route('webhooks.mollie'),
                'webhookUrl' => 'http://kevindev.nl/tempp.php',
                'redirectUrl' => route('order.success', ['type' => $type, 'id' => $id]),
            ]);

            Cookie::queue('payment', $payment->id, 5);
            $payment = Mollie::api()->payments()->get($payment->id);

            // redirect customer to Mollie checkout page
            return redirect($payment->getCheckoutUrl(), 303);
        }

        public function webHook($id)
        {

        }

        public function orderSuccess($id, $type)
        {
            try {
                $payment = Mollie::api()->payments()->get(Cookie::get('payment'));
                    if ($payment->isPaid()) {
                        if ($type == 'request') {
                            $request = RequestsUsers::find($id);
                            $request->paid = true;
                            $request->save();
                        }
                        else if($type == 'planned_payment'){
                            $planned_payment = PlannedPayment::find($id);
                            $planned_payment->paid = true;
                            $planned_payment->save();
                        }
                    }
                    else {
                        return redirect()->back()->with('error', __('error.payment_error'));
                    }
                }
            catch(Exception $e){
                return redirect()->back()->with('error', __('error.payment_error'));
            }
            return view('order.success')->with(['type' => $type, 'id' => $id]);
        }
    }
