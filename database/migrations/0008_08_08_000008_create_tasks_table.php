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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('contract_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('assignee_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('creator_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('title', 300);
            $table->text('description')->nullable();

             $table->date('due_date')->nullable();

            $table->integer('priority')->default(2);
            $table->integer('status')->default(1);

            // 🔥 KANBAN
            $table->integer('position')->default(0);
            $table->decimal('sort', 20, 10)->default(0)->index();

            $table->softDeletes();

            // 🔥 TRACK TIME
            $table->datetime('started_at')->nullable();
            $table->datetime('completed_at')->nullable();

            $table->timestamps();

            $table->index(['status', 'position']);
            $table->index('assignee_id');
            $table->index('creator_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
