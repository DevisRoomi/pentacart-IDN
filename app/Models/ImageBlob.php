<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class ImageBlob extends Model
{
    protected $fillable = [
        'merchant_id',
        'product_id',
        'mime_type',
        'content_hash',
        'content',
    ];

    protected $hidden = [
        'content',
    ];

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function url(): string
    {
        return route('images.show', [
            'imageBlob' => $this->getKey(),
            'v' => $this->content_hash,
        ]);
    }
}
