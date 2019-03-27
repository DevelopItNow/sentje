<?php

    namespace App\Http\Controllers;

    use App\RequestsUsers;
    use Illuminate\Http\Request;
    use Mollie\Laravel\Facades\Mollie;

    class PayController extends Controller
    {
        public function pay($amount, $currency, $id, $type)
        {
            if ($currency == 'euro') {
                $currencyTo = 'EUR';
            } else {
                $currencyTo = 'GBP';
            }

            if (strpos($amount, '.') === false) {
                $amount = $amount .'.00';
            }

            $payment = null;
            $payment = Mollie::api()->payments()->create([
                'amount' => [
                    'currency' => $currencyTo,
                    'value' => $amount,
                    // You must send the correct number of decimals, thus we enforce the use of strings
                ],
                'description' => 'Sentje Payment',
//                'webhookUrl' => route('webhooks.mollie'),
                'webhookUrl' => 'http://kevindev.nl/tempp.php',
                'redirectUrl' => route('order.success', ['type' => $type, 'id' => $id, 'mollie_id' => $payment->id]),
            ]);

            $payment = Mollie::api()->payments()->get($payment->id);

            // redirect customer to Mollie checkout page
            return redirect($payment->getCheckoutUrl(), 303);
        }

        public function webhook($id)
        {

        }

        public function orderSuccess($id, $type, $mollie_id)
        {
            if ($type == 'request') {
                $payment = Mollie::api()->payments()->get($mollie_id);

                if($payment->isPaid()){
                    $request = RequestsUsers::find($id);
                    $request->paid = true;
                    $request->save();
                }
                else{
                    return redirect()->back()->with('error', __('error.payment_error'));
                }
            }
            
            return view('order.success')->with(['type' => $type, 'id' => $id]);
        }
    }
