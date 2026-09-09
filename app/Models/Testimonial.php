<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Testimonial extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'role', 'company', 'body', 'avatar', 'rating', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'rating' => 'integer',
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
        return $query->orderBy('sort_order')->orderByDesc('id');
    }

    /** Public URL for the uploaded avatar, or null when none was set. */
    public function avatarUrl(): ?string
    {
        return filled($this->avatar) ? Storage::disk('public')->url($this->avatar) : null;
    }

    /** Up to two uppercase initials from the person's name — the avatar fallback. */
    public function initials(): string
    {
        $words = preg_split('/\s+/', trim((string) $this->name)) ?: [];
        $letters = array_map(fn ($w) => mb_substr($w, 0, 1), array_slice(array_filter($words), 0, 2));

        return mb_strtoupper(implode('', $letters));
    }
}
