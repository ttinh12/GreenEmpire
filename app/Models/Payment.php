<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'amount',
        'payment_date',
        'method',
        'reference',
        'notes',
        'attachment',
        'recorded_by',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
        'method' => 'integer',
    ];

    // Định nghĩa hằng số cho phương thức thanh toán (Method)
    const METHOD_BANK_TRANSFER = 1;
    const METHOD_CASH          = 2;
    const METHOD_CHECK         = 3;
    const METHOD_OTHER         = 4;

    /**
     * Lấy nhãn hiển thị cho phương thức thanh toán
     */
    public function getMethodLabelAttribute(): string
    {
        return match ($this->method) {
            self::METHOD_BANK_TRANSFER => 'Chuyển khoản',
            self::METHOD_CASH          => 'Tiền mặt',
            self::METHOD_CHECK         => 'Séc',
            self::METHOD_OTHER         => 'Khác',
            default                    => 'Không xác định',
        };
    }

    /* -------------------------------------------------------------------------- */
    /* RELATIONSHIPS                                                              */
    /* -------------------------------------------------------------------------- */

    /** Thanh toán này thuộc về hóa đơn nào */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    /** Nhân viên ghi nhận thanh toán này */
    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}