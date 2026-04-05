<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id', 'amount', 'payment_date', 'method', 
        'reference', 'notes', 'attachment', 'recorded_by'
    ];

    protected $casts = [
        'payment_date' => 'date',
    ];

    // Thanh toán này thuộc về hóa đơn nào
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    // Ai là người ghi nhận thanh toán này
    public function recorder(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}