<?php

namespace App\Http\Controllers;

use App\Http\Requests\BillRequest;
use App\Http\Requests\CustomerRequest;
use App\Models\Bill;
use App\Models\BillProduct;
use App\Models\CompanyDetail;
use App\Models\Customer;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Transformers\BillTransformer;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bills = Bill::get();
        return view('bill.index', compact('bills'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::get();
        $products = Product::get();
        return view('bill.create', compact('customers', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BillRequest $request)
    {
        try {
            DB::beginTransaction();
            $bill = Bill::create([
                'customer_id' => $request->customer,
                'billed_at' => $request->billed_at,
            ]);
            // Check if the bill was created successfully
            if ($bill) {
                // Create bill_products entries
                foreach ($request['products'] as $key => $product) {
                    BillProduct::create([
                        'bill_id' => $bill->id,
                        'product_id' => $product,
                        'product_count' => $request['product_count'][$key],
                    ]);
                }
            }

            DB::commit();
            return response()->json(['success' => 'Bill Generated Successfully..!!'], 201);
        } catch (\Exception $e)
        {
            Log::error([
                'error' => [
                    'location' => 'BillController@update',
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ],
            ]);
            DB::rollBack();
            return response()->json(['error' => 'Bill Not Generated..!!'], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bill = Bill::with('customer')->findOrFail($id);
        $companyDetails = CompanyDetail::first();
        $bill = (new BillTransformer)->transformForBill($bill, $companyDetails);

        return view('bill.show', compact('bill'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bill = Bill::findOrFail($id);
        return view('bill.edit', compact('bill'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request, string $id)
    {
        try {
            DB::beginTransaction();
            Bill::where('id', $id)->update([
                'name' => $request->name,
                'address' => $request->address,
                'pin_code' => $request->pin_code,
                'mobile_number' => $request->mobile_number,
                'gstin' => $request->gstin,
            ]);

            DB::commit();

            return redirect()->route('bill.index')->with('success', 'Customer Updated Successfully..!!');
        } catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->route('bill.index')->with('success', 'Customer Not Created');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bill = Bill::findOrFail($id);
        DB::beginTransaction();
        try {
            $bill->delete();
            DB::commit();

            return redirect()->back()->with('success', 'Customer deleted Successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('success', 'Customer not deleted');
        }
    }

    public function downloadBill(string $id)
    {
        $bill = Bill::with('customer')->findOrFail($id);
        $companyDetails = CompanyDetail::first();
        $bill = (new BillTransformer)->transformForBill($bill, $companyDetails);
        $pdf = Pdf::loadView('bill.pdf', $bill);

        return $pdf->download($bill['bill_no'] . '.pdf');
    }
}
