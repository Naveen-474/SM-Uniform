<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Invoice Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .summary {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<h2>Monthly Invoice Report</h2>
@php
    $startDate = Carbon\Carbon::now()->subMonth()->startOfMonth();
    $endDate = Carbon\Carbon::now()->subMonth()->endOfMonth();
    $groupedBills = collect($bills)->groupBy('customer_id');
@endphp

<p>From: {{ getDateString($startDate) }} To: {{ getDateString($endDate) }}</p>

<table>
    <thead>
    <tr>
        <th>Customer Name</th>
        <th>Customer ID</th>
        <th>Total Bill Count</th>
    </tr>
    </thead>
    <tbody>
    @foreach($groupedBills as $customerId => $customerBills)
        @php
            $customer = $customerBills[0]['customer'];
            $totalBillCount = count($customerBills);
        @endphp
        <tr>
            <td>{{ $customer['name'] }}</td>
            <td>{{ $customer['customer_no'] }}</td>
            <td>{{ $totalBillCount }}</td>
        </tr>
    @endforeach
    </tbody>
</table>

<div class="summary">
    <p>Total Bill Count for the Month: {{ $bills->count() }}</p>
</div>
</body>
</html>
