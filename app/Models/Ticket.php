<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\TicketStatus;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'assign_id',
        'priority',
        'status'
    ];

    /**
     * Liên kết tới người tạo phiếu (Khóa ngoại user_id)
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Liên kết tới người được giao xử lý (Khóa ngoại assign_id)
     */
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assign_id');
    }
    protected $casts = [
        'status' => TicketStatus::class,
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}