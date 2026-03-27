<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Amenity;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $updates = [
            'King Size Bed' => 'Lit King Size',
            'Safety Box' => 'Coffre-fort',
            'Balcony' => 'Balcon',
            '32 Inch TV' => 'TV 32 pouces',
            'Disable Access' => 'Accès PMR',
            'Pet Allowed' => 'Animaux acceptés',
            'Welcome Bottle' => 'Bouteille d\'accueil',
            'Wifi / Netflix access' => 'Wifi / Netflix',
            'Air Dryer' => 'Sèche-cheveux',
            'Air Condition' => 'Climatisation',
            'Loundry Service' => 'Service de blanchisserie',
            'Serviette' => 'Serviettes',
        ];

        foreach ($updates as $old => $new) {
            Amenity::where('title', $old)->update(['title' => $new]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $reverts = [
            'Lit King Size' => 'King Size Bed',
            'Coffre-fort' => 'Safety Box',
            'Balcon' => 'Balcony',
            'TV 32 pouces' => '32 Inch TV',
            'Accès PMR' => 'Disable Access',
            'Animaux acceptés' => 'Pet Allowed',
            'Bouteille d\'accueil' => 'Welcome Bottle',
            'Wifi / Netflix' => 'Wifi / Netflix access',
            'Sèche-cheveux' => 'Air Dryer',
            'Climatisation' => 'Air Condition',
            'Service de blanchisserie' => 'Loundry Service',
            'Serviettes' => 'Serviette',
        ];

        foreach ($reverts as $old => $new) {
            Amenity::where('title', $old)->update(['title' => $new]);
        }
    }
};
