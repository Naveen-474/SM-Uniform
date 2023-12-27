<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('company_details', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('owner_name');
            $table->string('address');
            $table->string('mobile_number');
            $table->string('email');
            $table->string('gstin');
            $table->string('bank_account_holder');
            $table->string('bank_company_account_name');
            $table->string('bank_name');
            $table->string('bank_branch_name');
            $table->string('bank_account_no');
            $table->string('bank_ifsc_code');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_details');
    }
};
