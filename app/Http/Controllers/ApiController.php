<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Payment;
use App\Models\Proxies;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('mobile_token')->plainTextToken;

        return response()->json([
            'message' => 'You have successfully logged in',
            'token'   => $token,
            'user'    => $user,
        ]);
    }

    public function dashboard()
    {
        $months = range(1, 12);

        $monthLabels = array_map(function ($m) {
            return date('M', mktime(0, 0, 0, $m, 1));
        }, $months);

        $paymentsMonthly = Payment::select(
            DB::raw('MONTH(date_of_payment) as month'),
            DB::raw('count(*) as total')
        )
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        $paymentsData = [];
        foreach ($months as $m) {
            $paymentsData[] = $paymentsMonthly->get($m, 0);
        }

        $proxiesCount = Proxies::select('active', DB::raw('count(*) as total'))
            ->groupBy('active')
            ->pluck('total', 'active');

        $proxiesLabels = ['Inactive', 'Active', 'Pending'];
        $proxiesData = [
            $proxiesCount->get(0, 0),
            $proxiesCount->get(1, 0),
            $proxiesCount->get(2, 0),
        ];

        return response()->json([
            'monthLabels' => $monthLabels,
            'paymentsData' => $paymentsData,
            'proxiesLabels' => $proxiesLabels,
            'proxiesData' => $proxiesData,
        ]);
    }

    public function getProxiesData(Request $request)
    {
        $proxies = Proxies::select('*');
        return DataTables::of($proxies)->make(true);
    }
    public function getPaymentsData(Request $request)
    {
        $payments = Payment::select('*');
        return DataTables::of($payments)->make(true);
    }

    public function destroyPayments($id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json(['message' => 'Payment not found.'], 404);
        }

        $payment->delete();

        return response()->json(['message' => 'Payment deleted successfully.']);
    }

    public function storePayments(Request $request)
    {
        $request->validate([
            'payment_id' => 'required|string|max:255',
            'number' => 'required|string|max:255',
            'amount' => 'required|string|max:255',
        ]);

        $payment = Payment::create([
            'payment_id' => $request->payment_id,
            'number' => $request->number,
            'amount' => $request->amount,
            'telegram_id' => $request->telegram_id ?? null,
            'date_of_payment' => Carbon::now()->format('Y-m-d'),
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Payment created successfully.',
            'payment' => $payment,
        ], 201);
    }
    public function storeProxies(Request $request)
    {
        $request->validate([
            'ip' => 'required|string|max:255',
            'port' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'country' => 'nullable|string|max:255', 
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);

        $proxy = Proxies::create([
            'ip' => $request->ip,
            'port' => $request->port,
            'type' => $request->type,
            'country' => $request->country ?? null,
            'username' => $request->username,
            'password' => $request->password,
            'last_checked_at' => Carbon::now()->format('Y-m-d'),
            'active' => 1,
        ]);

        return response()->json([
            'message' => 'Proxy created successfully.',
            'proxy' => $proxy,
        ], 201);
    }

    public function destroyProxies($id)
    {
        $proxy = Proxies::find($id);

        if (!$proxy) {
            return response()->json(['message' => 'Proxy not found.'], 404);
        }

        $proxy->delete();

        return response()->json(['message' => 'Proxy deleted successfully']);
    }

}
