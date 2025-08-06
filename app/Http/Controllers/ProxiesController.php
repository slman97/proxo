<?php

namespace App\Http\Controllers;

use App\Models\Proxies;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;

class ProxiesController extends Controller
{
    public function index()
    {
        return view('proxies.index');
    }

    public function getData(Request $request)
    {
        $proxies = Proxies::select('*');
        return DataTables::of($proxies)->make(true);
    }
    public function create()
    {
        return view('proxies.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'ip' => 'required|string|max:255',
            'port' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);

        Proxies::create([
            'ip' => $request->ip,
            'port' => $request->port,
            'type' => $request->type,
            'country' => $request->type,
            'username' => $request->username,
            'password' => $request->password,
            'last_checked_at' => Carbon::now()->format('Y-m-d'),
            'active' => '1',
        ]);

        return redirect()->route('proxies.index')->with('success', 'Proxy created successfully.');
    }
    public function destroy(Proxies $Proxy)
    {
        $Proxy->delete();

        return response()->json(['message' => 'Proxy deleted successfully']);
    }
}
