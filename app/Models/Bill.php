<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bill extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bills';

    /**
     * @var array
     */
    protected $fillable = [
        'bill_no', 'customer_id', 'billed_at',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at', 'billed_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            // Retrieve the latest customer created within today
            $latestCustomer = static::withTrashed()
                ->whereDate('billed_at', today())
                ->latest('billed_at')
                ->first();

            info($latestCustomer);

            // Extracting year, month, and day from the current date
            $year = date('y');
            $month = date('M');
            $date = date('d');

            // Formatting the invoice number
            $invoiceNumber = 'SMU/' . $year . strtoupper($month) . $date . '/';

            if ($latestCustomer) {
                // Extracting the last invoice number's sequential part
                $lastSequentialPart = substr($latestCustomer->bill_no, -2);

                // Incrementing the sequential part and padding it
                $sequentialPart = str_pad(((int)$lastSequentialPart + 1), 2, '0', STR_PAD_LEFT);

                // Concatenating the sequential part to the invoice number
                $invoiceNumber .= $sequentialPart;
                info([
                    '$latestCustomer' => $latestCustomer,
                    '$invoiceNumber' => $invoiceNumber,
                    '$lastSequentialPart' => $lastSequentialPart,
                    '$sequentialPart' => $sequentialPart,
                    '$invoiceNumber' => $invoiceNumber,
                ]);
            } else {
                // If there are no previous invoices, use '01' as the sequential part
                $invoiceNumber .= '01';
            }

            info($invoiceNumber);


            // Assigning the generated invoice number to the product
            $product->bill_no = $invoiceNumber;
        });

    }


    public function bill_products()
    {
        return $this->belongsToMany(BillProduct::class, 'bill_products')->withPivot('product_count');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function products()
    {

}
}
