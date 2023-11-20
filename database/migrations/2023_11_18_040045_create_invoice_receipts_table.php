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
        Schema::create('invoice_receipts', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('invoice_receipt_number')->required();
            $table->unsignedBigInteger('payer_id')->integer()->nullable()->required();
            $table->string('payer_name')->required()->nullable();
            $table->integer('amount')->nullable()->required();
            $table->unsignedBigInteger('invoice_id')->integer()->nullable();

            $table->timestamps();

            $table->foreign('payer_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoiceReceipts');
    }
};
