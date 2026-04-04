<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            
            // Thông tin dịch vụ
            $table->string('name', 200); // Tên dịch vụ (VD: Bảo trì hệ thống, Cung cấp gạo sạch)
            $table->string('slug')->unique(); // Đường dẫn thân thiện (VD: bao-tri-he-thong)
            $table->text('description')->nullable(); // Mô tả chi tiết dịch vụ
            
            // Giá cả và Đơn vị
            $table->decimal('base_price', 15, 2)->default(0); // Giá cơ bản
            $table->string('unit', 50)->default('gói'); // Đơn vị tính (gói, tháng, kg, giờ...)
            
            // Trạng thái (Sử dụng Enum cho chuyên nghiệp)
            $table->tinyInteger('status')->default(1); // 0: Inactive, 1: Active
            
            // Phân loại (Nếu bạn có bảng Categories thì dùng foreignId)
            // $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            
            // Hình ảnh đại diện cho dịch vụ
            $table->string('image_url')->nullable();

            // Người quản lý/tạo dịch vụ này
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            
            // Index để tìm kiếm nhanh theo tên và trạng thái
            $table->index(['name', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};