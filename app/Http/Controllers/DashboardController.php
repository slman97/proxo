<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Proxies;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
public function index()
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
        
        return view('dashboard', compact('monthLabels', 'paymentsData', 'proxiesLabels', 'proxiesData'));
    }
}
