<?php

namespace App\Http\Controllers;

use App\Models\Emprunt;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     title="API de Gestion des Emprunts",
 *     version="1.0.0"
 * )
 */
class EmpruntController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/emprunts",
     *     summary="Liste tous les emprunts",
     *     tags={"Emprunts"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des emprunts récupérée avec succès",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Emprunt"))
     *     )
     * )
     */
    public function index()
    {
        $emprunts = Emprunt::all();

        return response()->json($emprunts, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/emprunts",
     *     summary="Créer un nouvel emprunt",
     *     tags={"Emprunts"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Emprunt")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Emprunt créé avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Emprunt")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'livre_id' => 'required|integer',
            'date_emprunt' => 'nullable|date',
            'date_retour' => 'nullable|date',
            'statut' => 'required|in:dispo,en_cours,retourne,en_retard',
        ]);

        $emprunt = Emprunt::create($validated);

        return response()->json($emprunt, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/emprunts/{id}",
     *     summary="Affiche un emprunt spécifique",
     *     tags={"Emprunts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'emprunt",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Emprunt trouvé",
     *         @OA\JsonContent(ref="#/components/schemas/Emprunt")
     *     )
     * )
     */
    public function show($id)
    {
        $emprunt = Emprunt::findOrFail($id);

        return response()->json($emprunt, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/emprunts/{id}",
     *     summary="Mettre à jour un emprunt",
     *     tags={"Emprunts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'emprunt",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="user_id", type="integer"),
     *             @OA\Property(property="livre_id", type="integer"),
     *             @OA\Property(property="date_emprunt", type="string", format="date"),
     *             @OA\Property(property="date_retour", type="string", format="date"),
     *             @OA\Property(property="statut", type="string", enum={"dispo","en_cours","retourne","en_retard"})
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Emprunt mis à jour avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Emprunt")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Emprunt non trouvé"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $emprunt = Emprunt::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'sometimes|integer',
            'livre_id' => 'sometimes|integer',
            'date_emprunt' => 'sometimes|date',
            'date_retour' => 'sometimes|date',
            'statut' => 'sometimes|in:dispo,en_cours,retourne,en_retard',
        ]);

        $emprunt->update($validated);

        return response()->json($emprunt, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/emprunts/{id}",
     *     summary="Supprimer un emprunt",
     *     tags={"Emprunts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'emprunt",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Emprunt supprimé avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Emprunt non trouvé"
     *     )
     * )
     */
    public function destroy($id)
    {
        $emprunt = Emprunt::findOrFail($id);

        $emprunt->delete();

        return response()->json(null, 204);
    }
}
