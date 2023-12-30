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

        // TODO :: Uncomment on next finance year
//        static::creating(function ($bill) {
//            $bill->generateBillNumber();
//        });

    }

    public function generateBillNumber()
    {
        $billedAt = $this->billed_at;
        $year = date('y', strtotime($billedAt));
        $month = strtoupper(date('M', strtotime($billedAt)));
        $day = date('d', strtotime($billedAt));

        $count = static::whereDate('billed_at', $billedAt)->count() + 1;

        $billNo = "SMU/{$year}{$month}{$day}/" . sprintf('%02d', $count);

        $this->bill_no = $billNo;
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
        return $this->hasMany(Product::class);
}
}
