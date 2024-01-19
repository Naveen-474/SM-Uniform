<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $customerName;
    public $pdfPath;

    public function __construct($customerName, $pdfPath)
    {
        $this->customerName = $customerName;
        $this->pdfPath = $pdfPath;
    }

    public function build()
    {
        try {
            return $this->view('emails.invoice')
                ->attachData(file_get_contents($this->pdfPath), 'invoice.pdf', [
                    'mime' => 'application/pdf',
                ])
                ->subject('Invoice');
        } catch (\Exception $e) {
            // Log or handle the exception as needed
            \Log::error("Error attaching PDF to email: {$e->getMessage()}");
            return $this->view('emails.invoice')->subject('Invoice');
        }
    }
}
