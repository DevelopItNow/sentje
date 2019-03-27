<?php

    namespace App\Http\Controllers;

    use App\RequestsUsers;
    use App\User;
    use Illuminate\Contracts\Encryption\DecryptException;
    use stdClass;

    class PayRequestController extends Controller
    {
        /**
         * @param $id
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
         */
        public function pay($id)
        {
            try {
                $newId = decrypt($id);
            } catch (DecryptException $e) {
                return redirect('/');
            }

            $request = RequestsUsers::find($newId);

            if ($request == null) {
                return redirect('/');
            }

            $requestInfo = new stdClass();

            $mainRequest = $request->request;

            $requestInfo->paid = $request->paid;
            $requestInfo->id = $newId;
            $requestInfo->nameRequest = decrypt($mainRequest->name);
            $requestInfo->descRequest = decrypt($mainRequest->description);
            $requestInfo->amount = $mainRequest->amount;
            $requestInfo->currency = $mainRequest->valuta;
            $requestInfo->image = $mainRequest->image;
            $requestInfo->updated_at = $mainRequest->updated_at;

            return view('requests.payrequest')->with('request', $requestInfo);

        }
    }
