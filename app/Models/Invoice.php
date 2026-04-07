<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'contract_id', 'customer_id', 'department_id',
        'issue_date', 'due_date', 'subtotal', 'vat_rate',
        'vat_amount', 'total_amount', 'paid_amount',
        'status', 'payment_method', 'bank_info', 'notes', 'created_by'
    ];

    // Các quan hệ để Trung Tính đổ dữ liệu trang Client
    public function contract(): BelongsTo {
        return $this->belongsTo(Contract::class);
    }

    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class);
    }

    public function department(): BelongsTo {
        return $this->belongsTo(Department::class);
    }

    public function creator(): BelongsTo {
        return $this->belongsTo(User::class, 'created_by');
    }
}
