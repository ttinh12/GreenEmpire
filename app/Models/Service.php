<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory;

    // 1. Cho phép các trường này được thêm/sửa hàng loạt (Mass Assignment)
    protected $fillable = [
        'name',
        'slug',
        'description',
        'base_price',
        'unit',
        'status',
        'image_url',
        'created_by',
    ];

    // 2. Ép kiểu dữ liệu để khi lấy ra dùng không bị lỗi định dạng
    protected $casts = [
        'base_price' => 'decimal:2',
        'status' => 'string', // Hoặc dùng Enum nếu bạn đã tạo ServiceStatus
    ];

    // 3. Boot method: Tự động tạo slug từ tên dịch vụ khi bạn lưu
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($service) {
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->name);
            }
        });
    }

    // 4. Quan hệ: Một dịch vụ được tạo bởi một User
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // 5. Helper: Định dạng giá tiền cho đẹp (VD: 1.000.000đ)
    public function getFormattedPriceAttribute()
{
    // Ép kiểu về float để number_format không báo lỗi
    return number_format((float) $this->base_price, 0, ',', '.') . ' VNĐ';
}
}