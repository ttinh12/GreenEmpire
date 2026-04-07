<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contract extends Model
{
    use HasFactory;

    // Các cột có thể fill data hàng loạt
    protected $fillable = [
        'code',
        'customer_id',
        'department_id',
        'title',
        'description',
        'value',
        'vat_rate',
        'vat_amount',
        'total_value',
        'start_date',
        'end_date',
        'signed_date',
        'status',
        'payment_terms',
        'warranty_months',
        'file_url',
        'created_by',
        'updated_by',
    ];

    // Ép kiểu dữ liệu khi lấy ra từ DB
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'signed_date' => 'date',
        'value' => 'decimal:2',
        'total_value' => 'decimal:2',
        'status' => 'integer',
    ];

    // Định nghĩa các hằng số trạng thái (Đúng ý nhóm bạn muốn dùng số)
    const STATUS_DRAFT     = 1;
    const STATUS_ACTIVE    = 2;
    const STATUS_COMPLETED = 3;
    const STATUS_OVERDUE   = 4;
    const STATUS_CANCELLED = 5;

    /**
     * Lấy tên trạng thái để hiển thị ra View
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_DRAFT     => 'Nháp',
            self::STATUS_ACTIVE    => 'Đang hoạt động',
            self::STATUS_COMPLETED => 'Đã hoàn thành',
            self::STATUS_OVERDUE   => 'Quá hạn',
            self::STATUS_CANCELLED => 'Đã hủy',
            default                => 'Không xác định',
        };
    }

    /* -------------------------------------------------------------------------- */
    /* RELATIONSHIPS                               */
    /* -------------------------------------------------------------------------- */

    /** Khách hàng của hợp đồng */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /** Phòng ban quản lý hợp đồng */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /** Người tạo hợp đồng */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /** Các hạng mục chi tiết trong hợp đồng */
    public function items(): HasMany
    {
        return $this->hasMany(ContractItem::class);
    }

    /** Các hóa đơn liên quan đến hợp đồng này */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}