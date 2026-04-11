<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    public const STATUS_INACTIVE = 0;
    public const STATUS_ACTIVE = 1;

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

    protected $casts = [
        'base_price' => 'decimal:2',
        'status' => 'integer', 
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($service) {
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->name);
            }

            if (empty($service->status)) {
                $service->status = self::STATUS_ACTIVE;
            }
        });
    }

    // Người tạo service
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Quan hệ invoice items
    public function invoiceItems(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public static function statusLabels(): array
    {
        return [
            self::STATUS_INACTIVE => 'Tạm ngưng',
            self::STATUS_ACTIVE => 'Đang hoạt động',
        ];
    }

    public function getFormattedPriceAttribute()
    {
        return number_format((float) $this->base_price, 0, ',', '.') . ' VNĐ';
    }
}
