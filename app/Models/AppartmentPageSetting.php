<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Concerns\HasContentTranslations;
use Illuminate\Database\Eloquent\Model;

class AppartmentPageSetting extends Model
{
    use HasFactory, HasContentTranslations;

    protected $fillable = [
        'page',
        'title',
        'subtitle',
        'header_image',
    ];
}
