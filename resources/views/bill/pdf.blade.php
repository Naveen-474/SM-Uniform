<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Bill</title>
</head>
<body>
<div class="block">
    <style>
        @page {
            size: A4;
            margin: 20px;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
            font-size: 12px;
        }

        td, th {
            border: 1px solid #070707;
            padding: 8px;
        }

        tr.no-top-bottom-border th, tr.no-top-bottom-border td {
            border-top: none;
            border-bottom: none;
        }

        tr.no-left-right-border th, tr.no-left-right-border td {
            border-left: none;
            border-right: none;
        }

    </style>
    @php
       $totalProductCount = 0;
       $totalTaxableAmount = 0;
       foreach ($bill_products as $billProduct) {
           $product = $billProduct['product'];
           $totalProductCount += $billProduct['product_count'];
           $totalTaxableAmount += ($product->price * $billProduct['product_count']);
       }
       $emptyRowCount = max(0, 13 - count($bill_products));
       $totalGstAmount = $totalTaxableAmount * ($gst_percentage / 100);
       $netAmount = $totalTaxableAmount + $totalGstAmount;
    @endphp

    <table>
        <tr class="no-top-bottom-border no-left-right-border">
            <td colspan="4" style="text-align: left; font-weight: bold; font-size: 35px; color: #336699;">SM UNIFORMS
            </td>
        </tr>

        <tr class="no-top-bottom-border no-left-right-border">
            <td colspan="2">
                {{ $company_name }} <br>
                {{ $company_address }} <br>
            </td>
            <td colspan="2" style="text-align: right; vertical-align: top;">
                <span style="font-weight: bold; display: inline-block; width: 100px;">e-mail</span>
                <span style="font-weight: bold; display: inline-block; width: 5px;"> : </span>
                <span style="display: inline-block; text-align: left; width: 140px;">{{ $company_email }}</span>
                <br>

                <span style="font-weight: bold; display: inline-block; width: 100px;">Contact Number</span>
                <span style="font-weight: bold; display: inline-block; width: 5px;"> : </span>
                <span
                    style="display: inline-block; text-align: left; width: 140px;">{{ $company_mobile_number }} </span>
                <br>

            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="4" style="text-align: center; font-weight: bold;">TAX INVOICE</td>
        </tr>
        <tr>
            <td colspan="2"><span style="font-weight: bold;">GSTIN :</span> GSTNOAPBR</td>
            <td colspan="2" style="text-align: right; font-weight: bold;">ORIGINAL FOR RECIPIENT</td>
        </tr>
        <tr>
            <td colspan="2">
                <span style="font-weight: bold;">To</span> <br>
                {{$customer_name}}, <br>
                {!! nl2br(e($customer_address)) !!}, <br>
                {{$customer_pin_code}}. <br>
                <span style="font-weight: bold;">Contact Number :</span> {{$customer_mobile_number}} <br>
                <span style="font-weight: bold;">GSTIN :</span> {{$customer_gstin}} <br>
            </td>
            <td colspan="2" style="text-align: right; vertical-align: top;">
                <span style="font-weight: bold; display: inline-block; width: 120px;">Invoice No :</span>
                <span style="display: inline-block; width: 100px; text-align: left;"> {{ $bill_no }} </span><br>
                <span style="font-weight: bold; display: inline-block; width: 120px;">Invoice Date :</span>
                <span
                    style="display: inline-block; width: 100px; text-align: left;"> {{ getDateString($billed_at)}}</span>
            </td>
        </tr>
        <tr class="no-top-bottom-border">
            <td colspan="4">
                Dear Sir/Madam, <br>
                <span style="padding-left: 30px;">
                     Confirming the delivery of the following items:
                </span>

            </td>
        </tr>
    </table>

    <table>
        <tr style="text-align: center; font-weight: bold;">
            <th>S.No.</th>
            <th>Name of Product</th>
            <th>HSN</th>
            <th>Qty</th>
            <th>Rate</th>
            <th>Total</th>
        </tr>
        @php $i =1; @endphp
        @foreach ($bill_products as $billProduct)
            <tr class="no-top-bottom-border">
                <td style="text-align: center; width: 10px">{{$i}}</td>
                <td> {{ $billProduct->product->name}}</td>
                <td style="text-align: center;  width: 50px"> {{ $billProduct->product->hsn}}</td>
                <td style="text-align: center;"> {{ $billProduct['product_count']}}</td>
                <td style="text-align: center;"> {{ $billProduct->product->price}}</td>
                <td style="text-align: center;"> {{ $billProduct->product->price * $billProduct['product_count']}}</td>
            </tr>
            @php $i++; @endphp
        @endforeach
        @for ($i = 0; $i < $emptyRowCount; $i++)
            <tr class="no-top-bottom-border">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        @endfor
        <tr>
            <td colspan="3" style="text-align: right; font-weight: bold;">Total &emsp;&emsp;&emsp;</td>
            <td style="text-align: center; font-weight: bold;">{{ $totalProductCount }}</td>
            <td></td>
            <td style="text-align: center; font-weight: bold;">{{ $totalTaxableAmount }}</td>
        </tr>
    </table>

    <table>
        <tr class="no-top-bottom-border">
            <td colspan="2"></td>
        </tr>
        <tr>
            <td style="white-space: nowrap; width: auto;">
                <span style="text-align: left; font-weight: bold;">
                    Total Amount in Words :
                </span> <br>
                {{ numberToWord($netAmount) }}
            </td>
            <td style="text-align: right; vertical-align: top;">
                <span style="font-weight: bold; display: inline-block; width: 200px;">Taxable Amount</span>
                <span style="font-weight: bold; display: inline-block; width: 5px;"> : </span>
                <span
                    style="display: inline-block; width: 70px; text-align: right;">{{ number_format($totalTaxableAmount, 2) }} </span>
                <br>

                <span style="font-weight: bold; display: inline-block; width: 200px;">CGST Amount ({{ $gst_percentage/2 }} %)</span>
                <span style="font-weight: bold; display: inline-block; width: 5px;"> : </span>
                <span
                    style="display: inline-block;  width: 70px; text-align: right;">{{ number_format($totalGstAmount/2, 2) }} </span>
                <br>

                <span style="font-weight: bold; display: inline-block; width: 200px;">SGST Amount ({{ $gst_percentage/2 }} %)</span>
                <span style="font-weight: bold; display: inline-block; width: 5px;"> : </span>
                <span
                    style="display: inline-block; width: 70px; text-align: right;">{{ number_format($totalGstAmount/2, 2) }}</span>
                <br>

                <span style="font-weight: bold; display: inline-block; width: 200px;">Total Tax Amount </span>
                <span style="font-weight: bold; display: inline-block; width: 5px;"> : </span>
                <span
                    style="display: inline-block; width: 70px; text-align: right;">{{ number_format($totalGstAmount, 2) }}</span>
                <br>

                <span style="font-weight: bold; display: inline-block; width: 200px;">Net Amount </span>
                <span style="font-weight: bold; display: inline-block; width: 5px;"> : </span>
                <span
                    style="display: inline-block; width: 70px; text-align: right;">{{ number_format($netAmount, 2) }}</span>
                <br>
            </td>
        </tr>
        <tr>
            <td>
                <span style="text-align: center; font-weight: bold; display: block;">Bank Details </span> <br>
                <span style="font-weight: bold; display: inline-block; width: 140px;">Name</span>
                <span style="font-weight: bold; display: inline-block; width: 5px;"> : </span>
                <span style="display: inline-block; text-align: left;">{{ $company_bank_account_name }} / {{ $company_bank_account_holder }} </span>
                <br>

                <span style="font-weight: bold; display: inline-block; width: 140px;">Bank Name</span>
                <span style="font-weight: bold; display: inline-block; width: 5px;"> : </span>
                <span style="display: inline-block; text-align: left;">{{ $company_bank_name }} </span> <br>

                <span style="font-weight: bold; display: inline-block; width: 140px;">Branch Name</span>
                <span style="font-weight: bold; display: inline-block; width: 5px;"> : </span>
                <span style="display: inline-block; text-align: left;">{{ $company_bank_branch_name }}  </span>
                <br>

                <span style="font-weight: bold; display: inline-block; width: 140px;">Account Number</span>
                <span style="font-weight: bold; display: inline-block; width: 5px;"> : </span>
                <span style="display: inline-block; text-align: left;">{{ $company_bank_account_no }} </span>
                <br>

                <span style="font-weight: bold; display: inline-block; width: 140px;">Branch IFSC</span>
                <span style="font-weight: bold; display: inline-block; width: 5px;"> : </span>
                <span style="display: inline-block; text-align: left;">{{ $company_bank_ifsc_code }} </span>
            </td>
            <td style="text-align: right; vertical-align: middle; flex-direction: column; align-items: flex-end;">
                <img src="{{ public_path('assets/images/signature.png') }}" alt="Signature Image"
                     style="width: 100px; height: auto; margin-bottom: 5px; margin-right: 30px;">
                <div style="margin-right: 50px;">Signature</div>
            </td>
        </tr>
    </table>
</div>

</body>
</html>
