<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * @var array
     */
    protected $fillable = [
        'product_id', 'name', 'display_name', 'hsn', 'price',
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $latestProduct = static::withTrashed()->latest('id')->first();
            if ($latestProduct) {
                $product->product_id = 'PI' . str_pad($latestProduct->id + 1, 3, '0', STR_PAD_LEFT);
            } else {
                $product->product_id = 'PI001';
            }
        });
    }
}
