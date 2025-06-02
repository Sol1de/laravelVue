<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ApiKeyController extends Controller
{
    /**
     * Afficher la liste des clés API de l'utilisateur.
     */
    public function index()
    {
        return Inertia::render('ApiKeys/Index', [
            'apiKeys' => Auth::user()->apiKeys
        ]);
    }

    /**
     * Afficher le formulaire de création.
     */
    public function create()
    {
        return Inertia::render('ApiKeys/Create', [
            'apiKeys' => Auth::user()->apiKeys
        ]);
    }

    /**
     * Stocker une nouvelle clé API.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $apiKey = Auth::user()->apiKeys()->create([
            'name' => $request->name,
        ]);

        return redirect()->route('api-keys.index');
    }

    /**
     * Supprimer la clé API spécifiée.
     */
    public function destroy(ApiKey $apiKey)
    {
        if ($apiKey->user_id !== Auth::id()) {
            abort(403, 'Action non autorisée');
        }

        $apiKey->delete();

        return redirect()->route('api-keys.index')
            ->with('success', 'Clé API supprimée avec succès!');
    }
}
