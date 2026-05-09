<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('about_section_settings')) {
            return;
        }

        $now = now();

        DB::table('about_section_settings')->updateOrInsert(
            ['section' => 'activites_about'],
            [
                'small_title'   => 'Détente & Loisirs',
                'title'         => 'À propos de nos activités',
                'description'   => "Profitez d'une large gamme d'activités soigneusement sélectionnées pour vous offrir détente, découverte et plaisir tout au long de votre séjour à la résidence. Que vous soyez en famille, en couple ou entre amis, nos espaces sont pensés pour tous.\n\nDes moments de relaxation au bord de la piscine aux excursions organisées dans les environs, en passant par nos animations intérieures, chaque instant est une invitation à profiter pleinement de votre séjour.",
                'main_image'    => '',
                'overlay_image' => '',
                'third_image'   => '',
                'updated_at'    => $now,
                'created_at'    => $now,
            ]
        );

        DB::table('about_section_settings')->updateOrInsert(
            ['section' => 'activites_gallery'],
            [
                'small_title' => 'Espace Loisirs',
                'title'       => 'Galerie des Activités',
                'updated_at'  => $now,
                'created_at'  => $now,
            ]
        );
    }

    public function down(): void
    {
        if (Schema::hasTable('about_section_settings')) {
            DB::table('about_section_settings')
                ->whereIn('section', ['activites_about', 'activites_gallery'])
                ->delete();
        }
    }
};
