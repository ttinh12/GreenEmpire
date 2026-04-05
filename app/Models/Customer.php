<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'name', 'type', 'address', 'province', 'tax_code',
        'website', 'email', 'phone', 'fax', 'department_id',
        'account_manager_id', 'source', 'status', 'notes'
    ];

    // Quan hệ: Khách hàng thuộc về một phòng ban quản lý
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    // Quan hệ: Khách hàng được quản lý bởi một nhân viên (User)
    public function accountManager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'account_manager_id');
    }

    // Quan hệ: Một khách hàng có thể có nhiều hợp đồng
    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }
}