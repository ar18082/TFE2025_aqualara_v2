<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="API Documentation AquaLara",
 *     description="Documentation de l'API AquaLara",
 *     @OA\Contact(
 *         email="support@aqualara.com"
 *     )
 * )
 */
class ClientController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/clients",
     *     summary="Liste des clients",
     *     description="Récupère la liste de tous les clients",
     *     operationId="getClientsList",
     *     tags={"Clients"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des clients récupérée avec succès",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="Codecli", type="string"),
     *                 @OA\Property(property="nom", type="string"),
     *                 @OA\Property(property="adresse", type="string"),
     *                 @OA\Property(property="created_at", type="string", format="date-time"),
     *                 @OA\Property(property="updated_at", type="string", format="date-time")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Non authentifié"
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        $clients = Client::all();
        return response()->json($clients);
    }

    /**
     * @OA\Get(
     *     path="/api/clients/{id}",
     *     summary="Détails d'un client",
     *     description="Récupère les détails d'un client spécifique",
     *     operationId="getClientDetails",
     *     tags={"Clients"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du client",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Détails du client récupérés avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="Codecli", type="string"),
     *             @OA\Property(property="nom", type="string"),
     *             @OA\Property(property="adresse", type="string"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Client non trouvé"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Non authentifié"
     *     )
     * )
     */
    public function show(int $id): JsonResponse
    {
        $client = Client::findOrFail($id);
        return response()->json($client);
    }

    /**
     * @OA\Post(
     *     path="/api/clients",
     *     summary="Créer un client",
     *     description="Crée un nouveau client",
     *     operationId="createClient",
     *     tags={"Clients"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"Codecli","nom","adresse"},
     *             @OA\Property(property="Codecli", type="string"),
     *             @OA\Property(property="nom", type="string"),
     *             @OA\Property(property="adresse", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Client créé avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="Codecli", type="string"),
     *             @OA\Property(property="nom", type="string"),
     *             @OA\Property(property="adresse", type="string"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Non authentifié"
     *     )
     * )
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'Codecli' => 'required|string|unique:clients',
            'nom' => 'required|string',
            'adresse' => 'required|string'
        ]);

        $client = Client::create($validated);
        return response()->json($client, 201);
    }

    /**
     * @OA\Put(
     *     path="/api/clients/{id}",
     *     summary="Mettre à jour un client",
     *     description="Met à jour les informations d'un client existant",
     *     operationId="updateClient",
     *     tags={"Clients"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du client",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nom", type="string"),
     *             @OA\Property(property="adresse", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Client mis à jour avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="Codecli", type="string"),
     *             @OA\Property(property="nom", type="string"),
     *             @OA\Property(property="adresse", type="string"),
     *             @OA\Property(property="created_at", type="string", format="date-time"),
     *             @OA\Property(property="updated_at", type="string", format="date-time")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Client non trouvé"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erreur de validation"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Non authentifié"
     *     )
     * )
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $client = Client::findOrFail($id);
        
        $validated = $request->validate([
            'nom' => 'sometimes|string',
            'adresse' => 'sometimes|string'
        ]);

        $client->update($validated);
        return response()->json($client);
    }

    /**
     * @OA\Delete(
     *     path="/api/clients/{id}",
     *     summary="Supprimer un client",
     *     description="Supprime un client existant",
     *     operationId="deleteClient",
     *     tags={"Clients"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID du client",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Client supprimé avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Client non trouvé"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Non authentifié"
     *     )
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $client = Client::findOrFail($id);
        $client->delete();
        return response()->json(null, 204);
    }
} 