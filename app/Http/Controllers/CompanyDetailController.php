<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillProduct;
use App\Models\CompanyDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CompanyDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        info('Hii');
        $companyDetail = CompanyDetail::first();
        return view('system_settings.company_details.update', compact('companyDetail'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        info($request);
        try {
            DB::beginTransaction();
            $companyDetail = CompanyDetail::first();
            $old = $companyDetail ? $companyDetail->delete() : null;

            CompanyDetail::create([
                'name' => $request->company_name,
                'owner_name' => $request->company_owner_name,
                'address' => $request->company_address,
                'mobile_number' => $request->company_mobile_number,
                'email' => $request->email,
                'gstin' => $request->company_gstin,
                'bank_account_holder' => $request->bank_account_holder,
                'bank_company_account_name' => $request->bank_company_account_name,
                'bank_name' => $request->bank_name,
                'bank_branch_name' => $request->bank_branch_name,
                'bank_account_no' => $request->bank_account_no,
                'bank_ifsc_code' => $request->bank_ifsc_code,
            ]);
            info('Success..!!');
            DB::commit();
            return response()->json(['status' => 'Updated Successfully!'], 201);
//            return redirect()->route('company-details.index')->with('success', 'Customer Created Successfully..!!');
        } catch (\Exception $e) {
            Log::error([
                'error' => [
                    'location' => 'CabController@update',
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
            ]);
            DB::rollBack();
            return redirect()->route('company-details.index')->with('failure', 'Customer Not Created');
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(CompanyDetail $companyDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CompanyDetail $companyDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CompanyDetail $companyDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CompanyDetail $companyDetail)
    {
        //
    }
}
