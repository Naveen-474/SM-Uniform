<?php

namespace App\Console\Commands;

use App\Mail\InvoiceEmail;
use App\Models\Bill;
use App\Models\CompanyDetail;
use App\Transformers\BillTransformer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendInvoiceToMail extends Command
{
    protected $signature = 'send:invoice-to-mail {invoice_id?}';

    protected $description = 'Send Particular Invoice to Mail';

    public function handle()
    {
        info('Send Invoice To Mail Commend Started.!!');
        try {

            $invoiceId = $this->argument('invoice_id');
            $bill = Bill::with('customer')->findOrFail($invoiceId);

            $companyDetails = CompanyDetail::first();
            $bill = (new BillTransformer)->transformForBill($bill, $companyDetails);

            $pdf = PDF::loadView('bill.pdf', $bill);
            $pdfPath = storage_path('app/invoices/' . $bill['bill_id'] . '.pdf');
            $pdf->save($pdfPath);

            // Assuming you have a 'InvoiceEmail' Mailable class
            Mail::to('naveenkutty.in@gmail.com')
                ->send(new InvoiceEmail($bill['customer_name'], $pdfPath));

            $this->info('Invoice email sent successfully.');
        } catch (\Exception $e) {
            // Handle any exceptions
            $this->error('Error: ' . $e->getMessage());
            $this->error('Error: ' . $e->getTraceAsString());
        }
    }
}
