<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Enums\TicketPriority;
use App\Enums\TicketStatus;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_code',
        'title',
        'name',
        'content',
        'status',
        'priority',
        'user_id',
        'assign_id',
        'created_by',
    ];

    protected $casts = [
        'status' => TicketStatus::class,
        'priority' => TicketPriority::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'completed_at' => 'datetime',
    ];



    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assign_id');
    }

    // Helper method to check if ticket is completed
    public function isCompleted(): bool
    {
        return $this->status === TicketStatus::BANNED;
    }

    // Helper method to check if ticket is assigned
    public function isAssigned(): bool
    {
        return $this->assign_id !== null;
    }

    // Auto-set completed_at when status changes to completed and preserve customer name
    protected static function booted()
    {
        static::saving(function ($ticket) {
            if ($ticket->isDirty('status') && $ticket->status === TicketStatus::BANNED) {
                $ticket->completed_at = now();
            }

            if ($ticket->isDirty('user_id') && $ticket->user_id) {
                $ticket->name = User::find($ticket->user_id)?->name;
            }
        });
    }
}
