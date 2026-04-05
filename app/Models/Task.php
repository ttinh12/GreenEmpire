<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'contract_id', 'assignee_id', 'creator_id',
        'title', 'description', 'due_date', 'priority', 'status', 'completed_at'
    ];

    // Ép kiểu ngày tháng để Laravel tự convert thành Carbon object
    protected $casts = [
        'due_date' => 'date',
        'completed_at' => 'datetime',
    ];

    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class);
    }

    public function contract(): BelongsTo {
        return $this->belongsTo(Contract::class);
    }

    public function assignee(): BelongsTo {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function creator(): BelongsTo {
        return $this->belongsTo(User::class, 'creator_id');
    }
}