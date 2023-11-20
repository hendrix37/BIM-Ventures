<?php

use App\Enums\StatusType;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->unsignedBigInteger('payer_id')->nullable()->required();
            $table->integer('amount')->nullable()->required();
            $table->datetime('due_date')->nullable()->required();
            $table->double('vat')->nullable()->required();
            $table->boolean('is_vat')->nullabe()->required();
            $table->enum('status', StatusType::getAll())->required();

            $table->timestamps();

            $table->foreign('payer_id')->references('id')->on('users')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
