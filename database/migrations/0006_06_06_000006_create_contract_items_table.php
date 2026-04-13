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
        Schema::create('contract_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('contract_id')    
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('item_order')->default(1);

            $table->text('description');

            $table->string('unit', 30)->nullable();

            $table->decimal('quantity', 10, 2)->default(1);

            $table->decimal('unit_price', 18, 2)->default(0);

            // ⚠️ QUAN TRỌNG NHẤT
            $table->decimal('amount', 18, 2)
                ->storedAs('quantity * unit_price');

            $table->text('notes')->nullable();

            $table->index('contract_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract_items');
    }
};
