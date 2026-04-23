<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Xóa foreign key cũ
            $table->dropForeign(['invoice_id']);

            // Tạo lại với cascade
            $table->foreign('invoice_id')
                ->references('id')
                ->on('invoices')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // rollback lại nếu cần
            $table->dropForeign(['invoice_id']);

            $table->foreign('invoice_id')
                ->references('id')
                ->on('invoices');
        });
    }
};
