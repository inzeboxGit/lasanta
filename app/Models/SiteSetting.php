<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Concerns\HasContentTranslations;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory, HasContentTranslations;

    protected $fillable = [
        'setting_key',
        'site_name',
        'address',
        'email',
        'use_site_email_for_contact',
        'contact_recipient_email',
        'phone_primary',
        'phone_secondary',
        'facebook_url',
        'instagram_url',
        'whatsapp_url',
        'twitter_url',
        'default_locale',
        'maintenance_enabled',
        'maintenance_message',
        'custom_head_scripts',
        'footer_background_image',
    ];

    protected $casts = [
        'use_site_email_for_contact' => 'boolean',
        'maintenance_enabled' => 'boolean',
    ];
}
