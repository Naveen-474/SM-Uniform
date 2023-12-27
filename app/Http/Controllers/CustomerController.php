<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::get();
        return view('customer_details.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customer_details.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $request)
    {
        info('Hi....');
        try {
            DB::beginTransaction();
            Customer::create([
                'name' => $request->name,
                'address' => $request->address,
                'pin_code' => $request->pin_code,
                'mobile_number' => $request->mobile_number,
                'gstin' => $request->gstin,
            ]);

            DB::commit();
            return redirect()->route('customer-details.index')->with('success', 'Customer Created Successfully..!!');
        } catch (\Exception $e)
        {
            Log::error([
                'error' => [
                    'location' => 'CabController@update',
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
            ]);
            DB::rollBack();
            return redirect()->route('customer-details.index')->with('failure', 'Customer Not Created');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = Customer::findOrFail($id);
        return view('customer_details.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::findOrFail($id);
        return view('customer_details.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            Customer::where('id', $id)->update([
                'name' => $request->name,
                'address' => $request->address,
                'pin_code' => $request->pin_code,
                'mobile_number' => $request->mobile_number,
                'gstin' => $request->gstin,
            ]);

            DB::commit();

            return redirect()->route('customer-details.index')->with('success', 'Customer Updated Successfully..!!');
        } catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->route('customer-details.index')->with('success', 'Customer Not Created');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);
        DB::beginTransaction();
        try {
            $customer->delete();
            DB::commit();

            return redirect()->back()->with('success', 'Customer deleted Successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('success', 'Customer not deleted');
        }

    }
}
