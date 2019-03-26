<?php

namespace App\Http\Controllers;

use App\PlannedPayment;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;

class PlannedPaymentController extends Controller
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
        $planned_payments = Auth::user()->plannedPayments;
        $calendar = Calendar::addEvents(array());
        return view('plannedpayments.index', compact('calendar'))->with(['planned_payments' => $planned_payments]);;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('plannedpayments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate request
        $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required|string',
            'amount' => 'required|numeric',
            'email' => 'required|email',
            'date' => 'required|date_format:d/m/Y|after_or_equal:today',
            'currency' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        $receiver = User::where('email', $request->input('email'))->first();
        if(!is_null($receiver) && $receiver->id != Auth::id()) {
                $planned_payment = new PlannedPayment;
                $planned_payment->sender_id = Auth::id();
                $planned_payment->receiver_id = $receiver->id;
                $planned_payment->payment_name = encrypt($request->input('name'));
                $planned_payment->currency = $request->input('currency');
                $planned_payment->planned_date = Carbon::createFromFormat('d/m/Y', $request->input('date'));
                $planned_payment->amount = $request->input('amount');
                $planned_payment->description = encrypt($request->input('description'));
                $planned_payment->save();
                return redirect('/account')->with('success', __('calendar.planned_payment_added'));
        }
        else{
            return redirect()->back()->with('error', __('calendar.receiver_error'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PlannedPayment  $plannedPayment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $planned_payment = PlannedPayment::find($id);
        $sender = User::find($planned_payment->sender_id);

        if ($planned_payment == null) {
            return redirect('/plannedpayments')->with('error', __('error.unauthorized_page'));
        }

        if ($planned_payment->receiver_id != Auth::id()) {
            return redirect('/plannedpayments')->with('error', __('error.unauthorized_page'));
        }
        return view('plannedpayments.show')->with('planned_payment', $planned_payment)->with('sender', $sender);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PlannedPayment  $plannedPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(PlannedPayment $plannedPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PlannedPayment  $plannedPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PlannedPayment $plannedPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PlannedPayment  $plannedPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(PlannedPayment $plannedPayment)
    {
        //
    }

}
