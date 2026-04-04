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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();

            $table->string('code', 30)->unique();

            $table->foreignId('customer_id')->constrained();

            $table->foreignId('department_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('title', 300);
            $table->text('description')->nullable();

            $table->decimal('value', 18, 2)->default(0);
            $table->decimal('vat_rate', 5, 2)->default(10.00);
            $table->decimal('vat_amount', 18, 2)->default(0);
            $table->decimal('total_value', 18, 2)->default(0);

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('signed_date')->nullable();

            $table->enum('status', ['draft', 'active', 'completed', 'overdue', 'cancelled'])
                ->default('draft');

            $table->text('payment_terms')->nullable();

            $table->unsignedTinyInteger('warranty_months')->default(0);

            $table->string('file_url', 500)->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->index('customer_id');
            $table->index('status');
            $table->index('end_date');
        });
    }

    /** 
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
