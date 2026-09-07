<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Project extends Model implements HasMedia
{
    use HasTranslations;
    use InteractsWithMedia;

    protected $fillable = [
        'title', 'slug', 'problem', 'what_i_built', 'key_features', 'tech_stack',
        'my_role', 'live_demo_url', 'github_url', 'outcome',
        'is_public_github', 'featured', 'sort_order',
    ];

    /** Fields stored as JSON translations via spatie/laravel-translatable. */
    public array $translatable = [
        'title', 'problem', 'what_i_built', 'key_features', 'my_role', 'outcome',
    ];

    protected function casts(): array
    {
        return [
            'tech_stack' => 'array',
            'is_public_github' => 'boolean',
            'featured' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('featured', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderByDesc('id');
    }

    /** Bullet strings for the active locale (falls back to EN). */
    public function keyFeaturesList(): array
    {
        $value = $this->getTranslation('key_features', app()->getLocale(), false)
            ?: $this->getTranslation('key_features', 'en', false);

        return array_values(array_filter((array) $value, fn ($v) => filled($v)));
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('screenshots')
            ->useDisk('public');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->fit(Fit::Crop, 640, 400)
            ->nonQueued();

        $this->addMediaConversion('web')
            ->fit(Fit::Max, 1600, 1200)
            ->nonQueued();
    }
}
