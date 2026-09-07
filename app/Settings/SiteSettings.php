<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class SiteSettings extends Settings
{
    /** Full name shown in the hero + navbar. */
    public string $name;

    /** Translatable hero tagline, keyed by locale: ['en' => '...', 'ckb' => '...']. */
    public array $hero_tagline;

    /** Rotating hero phrases, keyed by locale, each an array of strings. */
    public array $hero_phrases;

    /** Translatable "About Me" body (HTML), keyed by locale. */
    public array $about_me;

    /** Short CV/resume summary (HTML), keyed by locale. */
    public array $resume_summary;

    /** Social / contact links: [['platform' => 'github', 'label' => 'GitHub', 'url' => '...'], ...]. */
    public array $social_links;

    /** Public contact email displayed on the site. */
    public ?string $contact_email;

    /** Location string, keyed by locale. */
    public array $location;

    /** Relative path (on the public disk) to the profile headshot. */
    public ?string $profile_photo;

    /** Relative path (on the public disk) to the framed hero screenshot. */
    public ?string $hero_artifact;

    /** Optional window title-bar label for the hero screenshot; falls back to $name. */
    public ?string $hero_artifact_label;

    /** Relative paths (on the public disk) to the CV PDFs. */
    public ?string $cv_en;

    public ?string $cv_ckb;

    public static function group(): string
    {
        return 'site';
    }

    /** Public URL for an uploaded asset path, or null. */
    public function assetUrl(?string $path): ?string
    {
        return filled($path) ? \Illuminate\Support\Facades\Storage::disk('public')->url($path) : null;
    }

    /** Value of a translatable field for the active locale, falling back to English. */
    public function trans(string $property, ?string $locale = null): mixed
    {
        $locale ??= app()->getLocale();
        $value = $this->{$property} ?? [];

        return $value[$locale] ?? $value['en'] ?? (is_array($value) ? reset($value) : $value) ?: null;
    }
}
