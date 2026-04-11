<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceItem extends Model
{
    use HasFactory;

    // Bảng này không có created_at/updated_at nên cần tắt timestamps
    public $timestamps = false;

    protected $fillable = [
        'invoice_id',
        'service_id',
        'item_order',
        'description',
        'unit',
        'quantity',
        'unit_price',
        'vat_rate'
    ];

    // Quan hệ: Một dòng chi tiết thuộc về một hóa đơn
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
