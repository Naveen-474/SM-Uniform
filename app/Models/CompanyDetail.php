<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyDetail extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'company_details';

    /**
     * @var array
     */
    protected $fillable = ['name', 'owner_name', 'address', 'mobile_number', 'gstin', 'email', 'bank_account_holder',
        'bank_company_account_name', 'bank_name', 'bank_branch_name', 'bank_account_no', 'bank_ifsc_code',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at', 'deleted_at',
    ];

}
