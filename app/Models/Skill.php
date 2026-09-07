<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    public const CATEGORIES = ['Backend', 'Frontend', 'Tools'];

    protected $fillable = ['name', 'category', 'proficiency', 'sort_order'];

    protected function casts(): array
    {
        return [
            'proficiency' => 'integer',
            'sort_order' => 'integer',
        ];
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
