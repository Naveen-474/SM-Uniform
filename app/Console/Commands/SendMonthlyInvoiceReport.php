<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Bill;
use App\Models\CompanyDetail;
use Illuminate\Console\Command;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Transformers\BillTransformer;
use App\Mail\MonthlyInvoiceReportMail;

class SendMonthlyInvoiceReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:monthly-invoice-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Monthly Invoice Report';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            info('Monthly Invoice Report Started..!!');

            $companyDetails = CompanyDetail::first();
            $bills = Bill::with('customer')
                ->whereMonth('billed_at', '=', Carbon::now()->subMonth()->month)
                ->get();

            $pdfs = [];

            foreach ($bills as $bill) {
                $transformedBill = (new BillTransformer)->transformForBill($bill, $companyDetails);
                $pdf = PDF::loadView('bill.pdf', $transformedBill);
                $pdfPath = storage_path('app/invoices/' . $transformedBill['bill_id'] . '.pdf');
                $pdf->save($pdfPath);
                $pdfs[] = $pdfPath;
            }

            Mail::to($companyDetails->email)
                ->send(new MonthlyInvoiceReportMail($pdfs, $bills));

            info('Monthly Invoice Report Sent Successfully..!!');
        } catch (\Exception $e) {
            $this->error('Error: ' . $e->getMessage());
            $this->error('Error: ' . $e->getTraceAsString());
        }
    }
}
