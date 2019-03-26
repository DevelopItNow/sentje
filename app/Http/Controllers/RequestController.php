<?php

    namespace App\Http\Controllers;

    use App\Contact;
    use App\Group;
    use App\Mail\SendPaymentRequestUrl;
    use App\PaymentRequest;
    use App\RequestsUsers;
    use App\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Mail;

    class RequestController extends Controller
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
            $requests = Auth::user()->PaymentRequests()->paginate(10);
            return view('requests.index', ['requests' => $requests]);

        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            $contacts = Auth::user()->contacts;

            $contactList = array();

            foreach ($contacts as $contact) {
                $contactInfo = User::where('id', '=', $contact->contact_id)->first();
                array_push($contactList, ["name" => $contactInfo->name, "id" => $contactInfo->id]);
            }
            $groups = Auth::user()->groups;

            $bankAccounts = Auth::user()->BankAccounts;

            return view('requests.create')->with([
                'contacts' => $contactList,
                'groups' => $groups,
                'bankaccounts' => $bankAccounts,
            ]);
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
            // Validate request
            $this->validate($request, [
                'name' => 'required|string',
                'description' => 'required|string',
                'amount' => 'required|numeric',
                'mail*' => 'nullable|email',
                'added_image' => 'nullable|image|max:1999',
                'bank_account' => 'required',
            ]);

            $hasImage = false;
            // Handle File Upload
            if ($request->hasFile('added_image')) {
                $hasImage = true;
                // Get filename with the extension
                $filenameWithExt = $request->file('added_image')->getClientOriginalName();
                // Get filename with the extension
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = $request->file('added_image')->getClientOriginalExtension();
                // Filename to store
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
                // Upload image
                $path = $request->file('added_image')->storeAs('public/added_image', $fileNameToStore);
            }

            // Make the payment request
            $paymentRequest = new PaymentRequest;
            $paymentRequest->user_id = Auth::id();
            $paymentRequest->name = encrypt($request->input('name'));
            $paymentRequest->description = encrypt($request->input('description'));
            $paymentRequest->amount = $request->input('amount');
            $paymentRequest->account_id = $request->input('bank_account');
            if ($hasImage) {
                $paymentRequest->image = $fileNameToStore;

            }
            $paymentRequest->valuta = $request->input('currency');
            $paymentRequest->save();

            // Get a list with all the user ids
            $userIdList = array();
            $userMailList = array();
            foreach ($request->input() as $key => $input) {
                // Set all the groups
                if (substr($key, 0, 6) === "group_") {
                    $groupId = substr($key, 6);
                    $group = Group::find($groupId)->first();
                    foreach ($group->users as $user) {
                        if (!in_array($user->id, $userIdList)) {
                            array_push($userIdList, $user->id);
                        }
                    }
                }
                // Set all the contacts
                if (substr($key, 0, 8) === "contact_") {
                    $contactId = substr($key, 8);
                    if (!in_array($contactId, $userIdList)) {
                        array_push($userIdList, $contactId);
                    }
                }
                // Set all the emails
                if (substr($key, 0, 4) === "mail") {
                    if ($input != null) {
                        if (!in_array($input, $userMailList)) {
                            array_push($userMailList, $input);
                        }
                    }
                }
            }


            // Send a request to all the users
            foreach ($userIdList as $id) {
                // Make the request in the db
                $requestUsers = new RequestsUsers;
                $requestUsers->request_id = $paymentRequest->id;
                $requestUsers->user_id = $id;
                $requestUsers->paid = false;
                $requestUsers->save();

                // Get user info
                $userInfo = User::find($id);


                // Send mail
                Mail::to($userInfo->email)->send(new SendPaymentRequestUrl(decrypt($userInfo->name),
                    $requestUsers->id));
            }

            // Send a request to all the emails
            foreach ($userMailList as $email) {
                // Make the request in the db
                $requestUsers = new RequestsUsers;
                $requestUsers->request_id = $paymentRequest->id;
                $requestUsers->email = $email;
                $requestUsers->paid = false;
                $requestUsers->save();

                // Send mail
                Mail::to($email)->send(new SendPaymentRequestUrl(__('request.user'), $requestUsers->id));
            }

            return redirect('/request')->with('success', __('request.success_send'));
        }

        /**
         * Display the specified resource.
         *
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function show($id)
        {
            $request = PaymentRequest::find($id);

            if ($request == null) {
                return redirect('/request')->with('error', __('error.unauthorized_page'));
            }

            if ($request->user_id != auth()->user()->id) {
                return redirect('/request')->with('error', __('error.unauthorized_page'));
            }

            $requestUser = $request->RequestUsers();
            return view('requests.show')->with(['request' => $request, 'requestUser' => $requestUser]);
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {
            return redirect('/request');
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function update(PaymentRequest $request, $id)
        {
            //
        }

        /**
         * Remove the specified resource from storage.
         *
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function destroy($id)
        {
            //
        }
    }
