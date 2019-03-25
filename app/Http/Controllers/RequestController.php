<?php

    namespace App\Http\Controllers;

    use App\Contact;
    use App\Group;
    use App\Request;
    use App\User;
    use Illuminate\Support\Facades\Auth;

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
            $requests = Request::orderBy('id', 'ASC')->where('user_id', '=', Auth::id())->paginate(10);
            return view('requests.index', ['requests' => $requests]);

        }

        /**
         * Show the form for creating a new resource.
         *
         * @return \Illuminate\Http\Response
         */
        public function create()
        {
            $contacts = Contact::where('user_id', '=', Auth::id())->get();

            $contactList = array();

            foreach ($contacts as $contact) {
                $contactInfo = User::where('id','=',$contact->contact_id)->first();
                array_push($contactList, ["name" => $contactInfo->name, "id" => $contactInfo->id]);
            }
            $groups = Group::where('user_id', '=', Auth::id())->get();
            return view('requests.create')->with(['contacts' => $contactList, 'groups' => $groups]);
        }

        /**
         * Store a newly created resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @return \Illuminate\Http\Response
         */
        public function store(Request $request)
        {
            //
        }

        /**
         * Display the specified resource.
         *
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function show($id)
        {
            //
        }

        /**
         * Show the form for editing the specified resource.
         *
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function edit($id)
        {
            $request = Request::find($id);

            if ($request == null) {
                return redirect('/request')->with('error', __('error.unauthorized_page'));
            }

            if ($request->user_id != Auth::id()) {
                return redirect('/request')->with('error', __('error.unauthorized_page'));
            }

            return view('requests.edit')->with('request', $request);
        }

        /**
         * Update the specified resource in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @param  int $id
         * @return \Illuminate\Http\Response
         */
        public function update(Request $request, $id)
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
