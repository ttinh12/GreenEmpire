<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'user_id', 'type', 'title', 
        'content', 'note_date', 'follow_up_date', 'is_pinned'
    ];

    // Ghi chú này thuộc về khách hàng nào
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    // Ai là người tạo ghi chú này
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}