<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use UnexpectedValueException;

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

    protected function content(): Attribute
    {
        return Attribute::make(
            get: function (?string $value): ?string {
                if ($value === null || $this->getConnection()->getDriverName() !== 'pgsql') {
                    return $value;
                }

                if (! str_starts_with($value, '\\x')) {
                    throw new UnexpectedValueException('PostgreSQL bytea content is not in hex format.');
                }

                $content = hex2bin(substr($value, 2));

                if ($content === false) {
                    throw new UnexpectedValueException('PostgreSQL bytea content contains invalid hexadecimal data.');
                }

                return $content;
            },
            set: fn (?string $value): ?string => $value !== null && $this->getConnection()->getDriverName() === 'pgsql'
                ? '\\x'.bin2hex($value)
                : $value,
        );
    }

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
