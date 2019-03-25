<?php

namespace App\Http\Controllers;

use App\PlannedPayment;
use Illuminate\Http\Request;

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
        $calendar = Calendar::addEvents(array());
        return view('plannedpayments.index', compact('calendar'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PlannedPayment  $plannedPayment
     * @return \Illuminate\Http\Response
     */
    public function show(PlannedPayment $plannedPayment)
    {
        //
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
