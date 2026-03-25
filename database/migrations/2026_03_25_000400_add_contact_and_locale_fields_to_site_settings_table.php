<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->boolean('use_site_email_for_contact')->default(true)->after('email');
            $table->string('contact_recipient_email')->nullable()->after('use_site_email_for_contact');
            $table->string('default_locale', 10)->default(config('app.locale', 'fr'))->after('twitter_url');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'use_site_email_for_contact',
                'contact_recipient_email',
                'default_locale',
            ]);
        });
    }
};