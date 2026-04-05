<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_code', 'department_id', 'category_id', 'type',
        'contract_id', 'invoice_id', 'amount', 'transaction_date',
        'description', 'reference_doc', 'attachment', 
        'created_by', 'approved_by', 'approved_at'
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'approved_at' => 'datetime',
    ];

    public function category(): BelongsTo {
        return $this->belongsTo(TransactionCategory::class, 'category_id');
    }

    public function department(): BelongsTo {
        return $this->belongsTo(Department::class);
    }

    public function contract(): BelongsTo {
        return $this->belongsTo(Contract::class);
    }

    public function invoice(): BelongsTo {
        return $this->belongsTo(Invoice::class);
    }

    public function creator(): BelongsTo {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver(): BelongsTo {
        return $this->belongsTo(User::class, 'approved_by');
    }
}