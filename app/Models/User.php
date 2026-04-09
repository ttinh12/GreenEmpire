<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Department;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Filament\Panel;
use Filament\Models\Contracts\FilamentUser;
use Spatie\Permission\Traits\HasRoles;
use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasPanelShield; // ← thêm 2 trait

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
        'avatar_url',
        'is_active',
        'last_login_at',
        'department_id', // BẮT BUỘC: Thêm dòng này để Seeder có thể gán phòng ban
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime', // Nên cast để dễ xử lý thời gian
        ];
    }

    /**
     * Thiết lập mối quan hệ với bảng Departments
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function Ticket(): HasMany
    {
        return $this->hasMany(Ticket::class, 'user_id');
    }

    // Task mà user được ASSIGN thực hiện
    public function assignedTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'assignee_id');
    }

    // Task mà user đã TẠO
    public function createdTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'creator_id');
    }
   
    public function canAccessPanel(Panel $panel): bool
    {
          return true;
    }
}
