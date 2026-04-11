<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable = [
        'customer_id',
        'contract_id',
        'assignee_id',
        'creator_id',
        'title',
        'description',
        'due_date',
        'priority',
        'status',
        'position',
        'sort',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'due_date'     => 'date',
        'started_at'   => 'datetime',
        'completed_at' => 'datetime',
        'sort'         => 'decimal:10',
        'status'       => 'integer',
        'priority'     => 'integer',
    ];

    // ──────────────── CONSTANTS ────────────────
    const STATUS_TODO        = 1;
    const STATUS_IN_PROGRESS = 2;
    const STATUS_REVIEW      = 3;
    const STATUS_DONE        = 4;

    const PRIORITY_LOW    = 1;
    const PRIORITY_MEDIUM = 2;
    const PRIORITY_HIGH   = 3;
    const PRIORITY_URGENT = 4;

    public static function statusLabels(): array
    {
        return [
            self::STATUS_TODO        => 'To Do',
            self::STATUS_IN_PROGRESS => 'In Progress',
            self::STATUS_REVIEW      => 'Review',
            self::STATUS_DONE        => 'Done',
        ];
    }

    public static function priorityLabels(): array
    {
        return [
            self::PRIORITY_LOW    => 'Thấp',
            self::PRIORITY_MEDIUM => 'Trung bình',
            self::PRIORITY_HIGH   => 'Cao',
            self::PRIORITY_URGENT => 'Khẩn cấp',
        ];
    }

    // ──────────────── RELATIONSHIPS ────────────────
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

   

    // ──────────────── HELPERS ────────────────
    public function getStatusLabelAttribute(): string
    {
        return self::statusLabels()[$this->status] ?? 'Unknown';
    }

    public function getPriorityLabelAttribute(): string
    {
        return self::priorityLabels()[$this->priority] ?? 'Unknown';
    }

    public function getDurationAttribute(): ?string
    {
        if (!$this->started_at) return null;
        $end = $this->completed_at ?? now();
        $minutes = $this->started_at->diffInMinutes($end);
        $hours = intdiv($minutes, 60);
        $mins  = $minutes % 60;
        return "{$hours}h {$mins}m";
    }
}
