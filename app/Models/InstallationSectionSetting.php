<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Concerns\HasContentTranslations;
use Illuminate\Database\Eloquent\Model;

class InstallationSectionSetting extends Model
{
    use HasFactory, HasContentTranslations;

    protected $fillable = [
        'section',
        'title',
        'subtitle',
    ];
}
