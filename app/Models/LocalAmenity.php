<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Concerns\HasContentTranslations;
use Illuminate\Database\Eloquent\Model;

class LocalAmenity extends Model
{
    use HasFactory, HasContentTranslations;

    public const CONTEXT_HOME = 'home';
    public const CONTEXT_RESTAURANT = 'restaurant';
    public const CONTEXT_POOL = 'pool';

    protected $fillable = [
        'small_title',
        'title',
        'description',
        'image_path',
        'link_url',
        'display_context',
        'sort_order',
        'is_published',
    ];

    public function scopeForDisplayContext($query, string $context)
    {
        return $query->where('display_context', $context);
    }
}
