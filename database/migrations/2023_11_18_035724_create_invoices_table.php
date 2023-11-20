<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
			$table->string('uuid');
			$table->string('invoice_number')->required();
			$table->unsignedBigInteger('payer_id')->integer()->nullable()->required();
			$table->integer('amount')->nullable()->required();
			$table->unsignedBigInteger('transaction_id')->integer()->nullable();
            
            $table->timestamps();

            $table->foreign('payer_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
