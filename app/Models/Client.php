<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Client extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'logo', 'website_url', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /** Public URL for the uploaded logo, or null when none was set. */
    public function logoUrl(): ?string
    {
        return filled($this->logo) ? Storage::disk('public')->url($this->logo) : null;
    }

    /** Up to two uppercase initials from the company name — the logo fallback. */
    public function initials(): string
    {
        $words = preg_split('/\s+/', trim((string) $this->name)) ?: [];
        $letters = array_map(fn ($w) => mb_substr($w, 0, 1), array_slice(array_filter($words), 0, 2));

        return mb_strtoupper(implode('', $letters));
    }
}
