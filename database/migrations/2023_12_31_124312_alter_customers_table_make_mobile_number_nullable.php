<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE customers MODIFY mobile_number VARCHAR(255) NULL, algorithm=inplace, lock=none;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE customers MODIFY mobile_number VARCHAR(255) NOT NULL, algorithm=inplace, lock=none;');
    }
};
