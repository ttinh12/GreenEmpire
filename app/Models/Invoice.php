<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Enums\InvoiceStatus;
use App\Enums\PaymentMethod;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'contract_id',
        'customer_id',
        'department_id',
        'issue_date',
        'due_date',
        'subtotal',
        'vat_rate',
        'vat_amount',
        'total_amount',
        'paid_amount',
        'status',
        'payment_method',
        'bank_info',
        'notes',
        'created_by'
    ];

    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
        'subtotal' => 'decimal:2',
        'vat_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'status' => InvoiceStatus::class,
        'payment_method' => PaymentMethod::class,
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Contract
    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    // Customer
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    // Department
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    // Creator
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Invoice Items
    public function invoiceItems(): HasMany
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Helper
    |--------------------------------------------------------------------------
    */

    // Tiền còn lại
    public function getRemainingAttribute()
    {
        return ($this->total_amount ?? 0) - ($this->paid_amount ?? 0);
    }

    // Format tổng tiền
    public function getFormattedTotalAttribute()
    {
        return number_format($this->total_amount ?? 0, 0, ',', '.') . ' VNĐ';
    }

    // Format đã thanh toán
    public function getFormattedPaidAttribute()
    {
        return number_format($this->paid_amount ?? 0, 0, ',', '.') . ' VNĐ';
    }

    // Format còn lại
    public function getFormattedRemainingAttribute()
    {
        return number_format($this->remaining ?? 0, 0, ',', '.') . ' VNĐ';
    }
}
