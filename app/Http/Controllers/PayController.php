<?php

    namespace App\Http\Controllers;

    use App\RequestsUsers;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Cookie;
    use Illuminate\Support\Facades\Session;
    use Mollie\Laravel\Facades\Mollie;
    use Exception;

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
            if ($type == 'request') {
                try{
                    $payment = Mollie::api()->payments()->get(Cookie::get('payment'));

                    if($payment->isPaid()){
                        $request = RequestsUsers::find($id);
                        $request->paid = true;
                        $request->save();
                    }
                    else{
                        return redirect()->back()->with('error', __('error.payment_error'));
                    }
                }
                catch(Exception $e){
                    return redirect()->back()->with('error', __('error.payment_error'));
                }
            }
            
            return view('order.success')->with(['type' => $type, 'id' => $id]);
        }
    }
