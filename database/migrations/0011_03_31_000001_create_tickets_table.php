<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->string('ticket_code')->unique(); // thêm
            $table->string('title');
            $table->text('content');
            $table->string('name');

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('assign_id')->nullable()->constrained('users')->onDelete('set null');

            $table->unsignedBigInteger('created_by')->nullable(); // thêm

            $table->integer('priority')->default(1);
            $table->integer('status')->default(1);

            $table->timestamp('completed_at')->nullable(); // thêm

            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
