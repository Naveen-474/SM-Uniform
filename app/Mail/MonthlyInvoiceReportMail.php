<?php

namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MonthlyInvoiceReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pdfPaths;

    public $bills;

    /**
     * Create a new message instance.
     */
    public function __construct($pdfPaths, $bills)
    {
        $this->pdfPaths = $pdfPaths;
        $this->bills = $bills;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $currentDate = Carbon::now()->subMonth();
        $subject = $currentDate->format('Y M') . ' Monthly Invoice Report';

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.monthly-invoice-report',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];
        $i = 0;

        foreach ($this->pdfPaths as $filePath) {
            $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);
            $sanitizedBillNo = str_replace('/', '_', $this->bills[$i]['bill_no']);
            $newFileName = $sanitizedBillNo . '.' . $fileExtension;
            $newFilePath = pathinfo($filePath, PATHINFO_DIRNAME) . '/' . $newFileName;
            rename($filePath, $newFilePath);
            $attachments[] = Attachment::fromPath($newFilePath);
            $i++;
        }

        return $attachments;
    }
}