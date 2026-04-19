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

    // ── Relationships ──────────────────────────────────────────────

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function invoiceItems(): HasMany
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'invoice_id');
    }

    // ── Helpers ────────────────────────────────────────────────────

    public function getRemainingAttribute()
    {
        return ($this->total_amount ?? 0) - ($this->paid_amount ?? 0);
    }

    public function getFormattedTotalAttribute()
    {
        return number_format($this->total_amount ?? 0, 0, ',', '.') . ' VNĐ';
    }

    public function getFormattedPaidAttribute()
    {
        return number_format($this->paid_amount ?? 0, 0, ',', '.') . ' VNĐ';
    }

    public function getFormattedRemainingAttribute()
    {
        return number_format($this->remaining ?? 0, 0, ',', '.') . ' VNĐ';
    }
}