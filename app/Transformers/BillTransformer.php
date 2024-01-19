<?php

namespace App\Transformers;

use App\Models\BillProduct;

class BillTransformer
{
    public function transformForBill($bill, $companyDetails): array
    {
        $billProducts = BillProduct::with('product')->where('bill_id', $bill->id)->get();
        $customerDetails = $bill->customer;

        return [
            'company_name' => $companyDetails->name,
            'company_address' => $companyDetails->address,
            'company_email' => $companyDetails->email,
            'company_mobile_number' => $companyDetails->mobile_number,
            'company_gstin' => $companyDetails->gstin,
            'customer_name' => $customerDetails->name,
            'customer_address' => $customerDetails->address,
            'customer_pin_code' => $customerDetails->pin_code,
            'customer_mobile_number' => $customerDetails->mobile_number,
            'customer_gstin' => $customerDetails->gstin,
            'bill_no' => $bill->bill_no,
            'billed_at' => $bill->billed_at,
            'company_bank_account_name' => $companyDetails->bank_company_account_name,
            'company_bank_account_holder' => $companyDetails->bank_account_holder,
            'company_bank_name' => $companyDetails->bank_name,
            'company_bank_branch_name' => $companyDetails->bank_branch_name,
            'company_bank_account_no' => $companyDetails->bank_account_no,
            'company_bank_ifsc_code' => $companyDetails->bank_ifsc_code,
            'bill_products' => $billProducts,
            'gst_percentage' => 5,
            'bill_id' => $bill->id,
        ];
    }
}
