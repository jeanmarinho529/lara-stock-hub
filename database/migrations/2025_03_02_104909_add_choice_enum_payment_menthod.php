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
        DB::statement("ALTER TABLE `financial_transactions` CHANGE `payment_method` `payment_method` ENUM('credit_card', 'bank_transfer', 'pix', 'bank_slip', 'cash', 'future_payment', 'debit') default NULL;");
        DB::statement("ALTER TABLE `payment_method_configs` CHANGE `payment_method` `payment_method` ENUM('credit_card', 'bank_transfer', 'pix', 'bank_slip', 'cash', 'future_payment', 'debit') default NULL;");
        DB::statement("ALTER TABLE `orders` CHANGE `payment_method` `payment_method` ENUM('credit_card', 'bank_transfer', 'pix', 'bank_slip', 'cash', 'future_payment', 'debit') default NULL;");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE `financial_transactions` CHANGE `payment_method` `payment_method` ENUM('credit_card', 'bank_transfer', 'pix', 'bank_slip', 'cash') default NULL;");
        DB::statement("ALTER TABLE `payment_method_configs` CHANGE `payment_method` `payment_method` ENUM('credit_card', 'bank_transfer', 'pix', 'bank_slip', 'cash') default NULL;");
        DB::statement("ALTER TABLE `orders` CHANGE `payment_method` `payment_method` ENUM('credit_card', 'bank_transfer', 'pix', 'bank_slip', 'cash') default NULL;");
    }
};
