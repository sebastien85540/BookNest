<?php

namespace App\Http\Controllers;

use App\Models\Emprunt;
use Illuminate\Http\Request;

class EmpruntController extends Controller
{

    public function index()
    {
        $emprunts = Emprunt::all();

        return response()->json($emprunts, 200);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'livre_id' => 'required|integer',
            'date_emprunt' => 'required|date',
            'date_retour' => 'nullable|date',
            'statut' => 'required|in:en_cours,retourne,en_retard',
        ]);

        $emprunt = Emprunt::create($validated);

        return response()->json($emprunt, 201);
    }


    public function show($id)
    {
        $emprunt = Emprunt::findOrFail($id);

        return response()->json($emprunt, 200);
    }


    public function update(Request $request, $id)
    {
        $emprunt = Emprunt::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'sometimes|integer',
            'livre_id' => 'sometimes|integer',
            'date_emprunt' => 'sometimes|date',
            'date_retour' => 'nullable|date',
            'statut' => 'sometimes|in:en_cours,retourne,en_retard',
        ]);

        $emprunt->update($validated);

        return response()->json($emprunt, 200);
    }

    public function destroy($id)
    {
        $emprunt = Emprunt::findOrFail($id);

        $emprunt->delete();

        return response()->json(null, 204);
    }
}
