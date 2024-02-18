<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Storage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UploadBillToGoogleDrive implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filePath;
    protected $bill;

    /**
     * Create a new job instance.
     */
    public function __construct($filePath, $bill)
    {
        $this->filePath = $filePath;
        $this->bill = $bill;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $filePath = $this->filePath;
        $bill = $this->bill;

        $billNo = str_replace('/', '_', $bill->bill_no); // Replace / with _
        $folderPath = 'Bills/' . $billNo . '/' . $billNo . '_' . date('Y_m_d_H_i_s', strtotime($bill->updated_at)) . '.pdf';

        try {
            Storage::disk('google')->put($folderPath, file_get_contents($filePath));
            unlink($filePath);  // Delete the local file after uploading
        } catch (\Exception $e) {
            \Log::error('Error uploading bill to Google Drive: ' . $e->getMessage());
        }
    }
}
