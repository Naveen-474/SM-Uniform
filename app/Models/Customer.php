<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'customers';

    /**
     * @var array
     */
    protected $fillable = [
        'customer_no', 'name', 'address', 'pin_code', 'mobile_number', 'gstin',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $latestCustomer = static::withTrashed()->latest('id')->first();
            if ($latestCustomer) {
                $product->customer_no = 'CN' . str_pad($latestCustomer->id + 1, 3, '0', STR_PAD_LEFT);
            } else {
                $product->customer_no = 'CN001';
            }
        });
    }
}
