<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Customer;

class Contact extends Model
{
    use hasFactory;

    protected $table = 'contacts';
    public $timestamps = false;

    protected $fillable = [
        'customer_id',
        'name',
        'position',
        'department',
        'mobile',
        'email',
        'phone',
        'is_primary',
        'notes',

    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
