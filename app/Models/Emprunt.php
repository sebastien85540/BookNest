<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Emprunt",
 *     title="Emprunt",
 *     description="Modèle d'emprunt",
 *     @OA\Property(property="id", type="integer", description="ID de l'emprunt"),
 *     @OA\Property(property="user_id", type="integer", description="ID de l'utilisateur"),
 *     @OA\Property(property="livre_id", type="integer", description="ID du livre"),
 *     @OA\Property(property="date_emprunt", type="string", format="date", description="Date de l'emprunt"),
 *     @OA\Property(property="date_retour", type="string", format="date", description="Date de retour prévue"),
 *     @OA\Property(property="statut", type="string", enum={"dispo","en_cours","retourne","en_retard"}, description="Statut de l'emprunt")
 * )
 */
class Emprunt extends Model
{
    use HasFactory;

    protected $table = 'emprunts';

    protected $fillable = [
        'user_id',
        'livre_id',
        'date_emprunt',
        'date_retour',
        'statut',
    ];
}
