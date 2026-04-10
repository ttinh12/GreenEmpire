<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    // Quan hệ contract
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }

    // Quan hệ customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Quan hệ department
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Người tạo hóa đơn
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
