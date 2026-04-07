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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices');
            $table->decimal('amount', 18, 2);
            $table->date('payment_date');
            // $table->enum('method', ['bank_transfer', 'cash', 'check', 'other'])->default('bank_transfer');
            $table->integer('method')->default(1); // 1: bank_transfer, 2: cash, 3: check, 4: other
            $table->string('reference', 100)->nullable();
            $table->text('notes')->nullable();
            $table->string('attachment', 500)->nullable();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index('invoice_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
