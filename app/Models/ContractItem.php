<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContractItem extends Model
{
    use HasFactory;

    // Bảng này không có timestamps (created_at/updated_at) trong migration của bạn
    public $timestamps = false;

    protected $fillable = [
        'contract_id', 'item_order', 'description', 
        'unit', 'quantity', 'unit_price', 'notes'
    ];

    // Quan hệ: Một chi tiết hạng mục phải thuộc về một hợp đồng
    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }
}