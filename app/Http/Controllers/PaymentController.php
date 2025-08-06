<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;

class PaymentController extends Controller
{
    public function index()
    {
        return view('payment.index');
    }

    public function getData(Request $request)
    {
        $payments = Payment::select('*');
        return DataTables::of($payments)->make(true);
    }
    public function create()
    {
        return view('payment.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'payment_id' => 'required|string|max:255',
            'number' => 'required|string|max:255',
            'amount' => 'required|string|max:255',
        ]);

        Payment::create([
            'payment_id' => $request->payment_id,
            'number' => $request->number,
            'amount' => $request->amount,
            'telegram_id' => $request->telegram_id,
            'date_of_payment' => Carbon::now()->format('Y-m-d'),
            'status' => 'pending',
        ]);

        return redirect()->route('payment.index')->with('success', 'Payment created successfully.');
    }
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return response()->json(['message' => 'Payment deleted successfully']);
    }
}
