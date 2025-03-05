<?php

namespace Database\Factories;

use App\Models\Emprunt;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmpruntFactory extends Factory
{
    protected $model = Emprunt::class;

    public function definition(): array
    {
        return [
            'user_id' => 1, // Remplace par une logique dynamique si nécessaire
            'livre_id' => 1,
            'date_emprunt' => now(),
            'date_retour' => null,
            'statut' => 'en_cours',
        ];
    }
}
