<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class Merchant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'phone',
        'qris_image',
        'description',
        'keywords',
        'location',
        'is_open',
        'schedule',
    ];

    protected function casts(): array
    {
        return [
            'is_open' => 'boolean',
            'schedule' => 'array',
        ];
    }

    /**
     * Evaluate current operational status using WIB (Asia/Jakarta).
     * Returns ['open' => bool, 'label' => string, 'hint' => ?string]
     */
    public function operationalStatus(?CarbonInterface $now = null): array
    {
        if (! $this->is_open) {
            return [
                'open' => false,
                'label' => 'Tutup',
                'hint' => 'Dinonaktifkan penjual',
            ];
        }

        $sessions = collect($this->schedule ?? [])
            ->filter(fn ($s) => is_array($s) && ! empty($s['start']) && ! empty($s['end']))
            ->sortBy('start')
            ->values();

        if ($sessions->isEmpty()) {
            return [
                'open' => true,
                'label' => 'Buka',
                'hint' => null,
            ];
        }

        $wibTime = ($now ?? now())->copy()->timezone('Asia/Jakarta')->format('H:i');

        foreach ($sessions as $session) {
            if ($wibTime >= $session['start'] && $wibTime <= $session['end']) {
                return [
                    'open' => true,
                    'label' => 'Buka',
                    'hint' => "s.d. {$session['end']} WIB",
                ];
            }
        }

        $nextSession = $sessions->first(fn ($s) => $s['start'] > $wibTime) ?? $sessions->first();

        return [
            'open' => false,
            'label' => 'Tutup Sementara',
            'hint' => "Buka lagi {$nextSession['start']} WIB",
        ];
    }

    public function formattedSchedule(): string
    {
        $sessions = collect($this->schedule ?? [])
            ->filter(fn ($s) => is_array($s) && ! empty($s['start']) && ! empty($s['end']))
            ->sortBy('start')
            ->map(fn ($s) => "{$s['start']}-{$s['end']}")
            ->values();

        return $sessions->implode(', ');
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        $term = trim((string) $term);
        if ($term === '') {
            return $query;
        }

        $like = '%'.$term.'%';

        return $query->where(function (Builder $q) use ($like) {
            $q->whereLike('name', $like)
                ->orWhereLike('description', $like)
                ->orWhereLike('keywords', $like)
                ->orWhereLike('location', $like)
                ->orWhereHas('user', function (Builder $uq) use ($like) {
                    $uq->whereLike('name', $like);
                })
                ->orWhereHas('products', function (Builder $pq) use ($like) {
                    $pq->where('is_available', true)
                        ->where(function (Builder $inner) use ($like) {
                            $inner->whereLike('name', $like)
                                ->orWhereLike('description', $like);
                        });
                });
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function qrisImageBlob(): HasOne
    {
        return $this->hasOne(ImageBlob::class);
    }

    public function qrisImageUrl(): ?string
    {
        $imageBlob = $this->relationLoaded('qrisImageBlob')
            ? $this->getRelation('qrisImageBlob')
            : $this->qrisImageBlob()->first(['id', 'merchant_id', 'content_hash']);

        if ($imageBlob) {
            return $imageBlob->url();
        }

        if (! $this->qris_image) {
            return null;
        }

        if (str_starts_with($this->qris_image, 'http://') || str_starts_with($this->qris_image, 'https://')) {
            return $this->qris_image;
        }

        return Storage::disk('public')->url($this->qris_image);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
