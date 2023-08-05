<?php

namespace App\Http\Controllers;

use App\Models\DriverPayment;
use App\Models\DriverPaymentDetail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DriverPaymentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'driver_id' => 'required',
            'amount' => 'required|numeric',
        ]);
        $driverPayment = DriverPayment::create($validatedData);

        $driverPaymentDetails = $request->input('driver_payment_details');
        foreach ($driverPaymentDetails as $detail) {
            DriverPaymentDetail::create([
                'driver_payment_id' => $driverPayment->id,
                'order_id' => $detail['order_id'],
            ]);
        }

        return redirect()->route('driver_payments.index')->with('success', 'Driver payment created successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DriverPayment  $driverPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DriverPayment $driverPayment)
    {
        $validatedData = $request->validate([
            'driver_id' => 'required',
            'amount' => 'required|numeric',
        ]);

        $driverPayment->update($validatedData);

        $driverPaymentDetails = $request->input('driver_payment_details');
        foreach ($driverPayment->driverPaymentDetails as $paymentDetail) {
            $paymentDetail->delete();
        }
        foreach ($driverPaymentDetails as $detail) {
            DriverPaymentDetail::create([
                'driver_payment_id' => $driverPayment->id,
                'order_id' => $detail['order_id'],
            ]);
        }

        return redirect()->route('driver_payments.index')->with('success', 'Driver payment updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DriverPayment  $driverPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(DriverPayment $driverPayment)
    {
        foreach ($driverPayment->driverPaymentDetails as $paymentDetail) {
            $paymentDetail->delete();
        }
        $driverPayment->delete();

        return redirect()->route('driver_payments.index')->with('success', 'Driver payment deleted successfully');
    }
}