<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class () extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE `payment_method_configs` CHANGE `payment_method` `payment_method` ENUM('credit_card', 'bank_transfer', 'pix', 'bank_slip', 'cash', 'future_payment') default NULL;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE `payment_method_configs` CHANGE `payment_method` `payment_method` ENUM('credit_card', 'bank_transfer', 'pix', 'bank_slip', 'cash') default NULL;");
    }
};
