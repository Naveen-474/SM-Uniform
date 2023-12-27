@section('title', 'SM Uniform - Dashboard')
@extends('layouts.app')
@section('content')
    @php
        $currentYear = date('Y');
        $currentMonth = date('m');
        $today = date('Y-m-d');

        // Total count
        $totalCount = \App\Models\Bill::count();

        // Current year count
        $currentYearCount = \App\Models\Bill::whereYear('billed_at', $currentYear)->count();

        // Current month count
        $currentMonthCount = \App\Models\Bill::whereYear('billed_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->count();

        // Today count
        $todayCount = \App\Models\Bill::whereDate('billed_at', $today)->count();
    @endphp
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Bills
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $totalCount }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Current Year Bill
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $currentYearCount }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Current Month Bill
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                              {{ $currentMonthCount }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Today's Bill Count
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $todayCount }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
