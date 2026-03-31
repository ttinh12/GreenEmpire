<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id(); // Sẽ tạo bigint cho bảng ticket
            $table->string('title');
            $table->text('content');

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('assign_id')->nullable()->constrained('users')->onDelete('set null');

            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->enum('status', ['open', 'processing', 'done'])->default('open');
            $table->timestamps();
        }); 
    }
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};