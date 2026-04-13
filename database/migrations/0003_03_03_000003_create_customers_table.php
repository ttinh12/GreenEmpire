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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            $table->string('code', 20)->unique(); // Mã khách hàng, vd: KH001 unique để tránh trùng lặp
            $table->string('name', 200); 
            //$table->enum('type', ['company', 'school', 'government', 'individual'])->default('company'); 
            $table->integer('type')->default(1); // 1: company, 2: school, 3: government, 4: individual
            $table->text('address')->nullable();
            $table->string('province', 100)->nullable();
            $table->string('tax_code', 20)->nullable();
            $table->string('website', 300)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('fax', 20)->nullable(); 
            $table->foreignId('department_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('account_manager_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('source', 100)->nullable();
            $table->integer('status')->default(1); // 1: active, 2: potential, 3: inactive
            //$table->enum('status', ['active', 'potential', 'inactive'])->default('potential');
            //$table->string('status', 20)->default('potential');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index('status');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
