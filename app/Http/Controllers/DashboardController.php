<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $bills = Bill::get();
        return view('dashboard', compact('bills'));
    }
}
