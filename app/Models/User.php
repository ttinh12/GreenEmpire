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
use Filament\Models\Contracts\HasAvatar;
class User extends Authenticatable implements FilamentUser, HasAvatar
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

    public function createdService(): HasMany
    {
        return $this->hasMany(Service::class, 'created_by', 'id');
    }

    public function Ticket(): HasMany
    {
        return $this->hasMany(Ticket::class, 'user_id');
    }

    // Task mà user được ASSIGN thực hiện
    public function assignedTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'assignee_id', 'id');
    }

    // Task mà user đã TẠO
    public function createdTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'creator_id', 'id');
    }

    
   
    public function canAccessPanel(Panel $panel): bool
    {
          return true;
    }
    public function getFilamentAvatarUrl(): ?string
    {
        // Kiểm tra nếu có ảnh thì trả về link, không thì null
        // asset('storage/...') sẽ tạo ra link: http://localhost:8000/storage/đường-dẫn-ảnh
        return $this->avatar_url 
            ? asset('storage/' . $this->avatar_url) 
            : null;
    }


    public function customers()
{
    return $this->hasMany(Customer::class, 'account_manager_id');
}

}

