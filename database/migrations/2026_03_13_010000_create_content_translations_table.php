<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('content_translations', function (Blueprint $table) {
            $table->id();
            $table->string('translatable_type');
            $table->unsignedBigInteger('translatable_id');
            $table->string('locale', 5);
            $table->string('field');
            $table->longText('value')->nullable();
            $table->timestamps();

            $table->index(['translatable_type', 'translatable_id'], 'ct_type_id_idx');
            $table->unique(['translatable_type', 'translatable_id', 'locale', 'field'], 'ct_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_translations');
    }
};
