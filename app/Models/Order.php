<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'merchant_id',
        'buyer_name',
        'buyer_phone',
        'dorm_location',
        'order_items',
        'total_price',
        'notes',
        'ordered_at',
    ];

    protected function casts(): array
    {
        return [
            'total_price' => 'integer',
            'ordered_at' => 'datetime',
        ];
    }

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }
}
