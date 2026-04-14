<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Department;
use App\Models\Invoice;
use App\Models\Task;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'code',
        'name',
        'type',
        'address',
        'province',
        'tax_code',
        'website',
        'email',
        'phone',
        'fax',
        'department_id',
        'account_manager_id',
        'source',
        'status',
        'notes',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
         'type' => 'integer',
        'status' => 'integer',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function accountManager()
    {
        return $this->belongsTo(User::class, 'account_manager_id');
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    // public function notes()
    // {
    //     return $this->hasMany(CustomerNote::class);
    // }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
