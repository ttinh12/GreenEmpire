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
        Schema::create('customer_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            //$table->enum('type', ['call', 'email', 'meeting', 'visit', 'reminder', 'other'])->default('other');
            $table->integer('type')->default(6); // 1: call, 2: email, 3: meeting, 4: visit, 5: reminder, 6: other
            $table->string('title', 200)->nullable();
            $table->text('content');
            $table->datetime('note_date')->useCurrent();
            $table->date('follow_up_date')->nullable();
            $table->boolean('is_pinned')->default(false);
            $table->timestamps();

            $table->index('customer_id');
            $table->index('user_id');
            $table->index('note_date');
            $table->index('follow_up_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_notes');
    }
};
