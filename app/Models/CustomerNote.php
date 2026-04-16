<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Customer;
use App\Models\User;    
class CustomerNote extends Model
{
    use HasFactory;
    protected $table = 'customer_notes';

    protected $fillable = [
        'customer_id',
        'user_id',
        'type',
        'title',
        'content',
        'note_date',
    ];

    protected $casts = [
        'note_date' => 'datetime', 
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
