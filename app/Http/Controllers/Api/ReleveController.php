<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReleveController extends Controller
{
    /**
     * Récupérer les radiateurs pour un appartement
     */
    public function getCompteursChauffage($codeCli, $refAppTR, $dateReleve)
    {
        try {
            $radiateurs = DB::table('radiateurs')
                ->where('CodeCli', $codeCli)
                ->where('RefAppTR', $refAppTR)
                ->select([
                    'id',
                    'numero',
                    'piece',
                    'ancien_index as ancienIndex'
                ])
                ->get();

            return response()->json([
                'radiateurs' => $radiateurs
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la récupération des radiateurs'
            ], 500);
        }
    }

    /**
     * Récupérer l'historique des relevés de chauffage
     */
    public function getHistoriqueChauffage($radiateurId)
    {
        try {
            $historique = DB::table('releves_chauffage')
                ->where('radiateur_id', $radiateurId)
                ->orderBy('date_releve', 'desc')
                ->limit(5)
                ->select([
                    'date_releve as date',
                    'index'
                ])
                ->get()
                ->map(function ($item) {
                    $item->date = Carbon::parse($item->date)->format('d/m/Y');
                    return $item;
                });

            return response()->json([
                'history' => $historique
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la récupération de l\'historique'
            ], 500);
        }
    }

    /**
     * Sauvegarder un relevé de chauffage
     */
    public function saveReleveChauffage(Request $request)
    {
        try {
            $data = $request->validate([
                'radiateur_id' => 'required|integer',
                'index' => 'required|numeric',
                'date_releve' => 'required|date'
            ]);

            DB::table('releves_chauffage')->insert([
                'radiateur_id' => $data['radiateur_id'],
                'index' => $data['index'],
                'date_releve' => $data['date_releve'],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'message' => 'Relevé de chauffage sauvegardé avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la sauvegarde du relevé de chauffage'
            ], 500);
        }
    }

    /**
     * Récupérer les compteurs d'eau pour un appartement
     */
    public function getCompteursEau($codeCli, $refAppTR, $dateReleve)
    {
        try {
            $compteurs = DB::table('compteurs_eau')
                ->where('CodeCli', $codeCli)
                ->where('RefAppTR', $refAppTR)
                ->select([
                    'id',
                    'numero',
                    'situation',
                    'ancien_index_froid as ancienIndexFroid',
                    'ancien_index_chaud as ancienIndexChaud'
                ])
                ->get();

            return response()->json([
                'compteurs' => $compteurs
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la récupération des compteurs d\'eau'
            ], 500);
        }
    }

    /**
     * Récupérer les compteurs de gaz pour un appartement
     */
    public function getCompteursGaz($codeCli, $refAppTR, $dateReleve)
    {
        try {
            $compteurs = DB::table('compteurs_gaz')
                ->where('CodeCli', $codeCli)
                ->where('RefAppTR', $refAppTR)
                ->select([
                    'id',
                    'numero',
                    'situation',
                    'ancien_index as ancienIndex'
                ])
                ->get();

            return response()->json([
                'compteurs' => $compteurs
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la récupération des compteurs de gaz'
            ], 500);
        }
    }

    /**
     * Récupérer les compteurs électriques pour un appartement
     */
    public function getCompteursElec($codeCli, $refAppTR, $dateReleve)
    {
        try {
            $compteurs = DB::table('compteurs_elec')
                ->where('CodeCli', $codeCli)
                ->where('RefAppTR', $refAppTR)
                ->select([
                    'id',
                    'numero',
                    'situation',
                    'ancien_index_hp as ancienIndexHP',
                    'ancien_index_hc as ancienIndexHC'
                ])
                ->get();

            return response()->json([
                'compteurs' => $compteurs
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la récupération des compteurs électriques'
            ], 500);
        }
    }

    /**
     * Récupérer l'historique des relevés d'eau
     */
    public function getHistoriqueEau($compteurId)
    {
        try {
            $historique = DB::table('releves_eau')
                ->where('compteur_id', $compteurId)
                ->orderBy('date_releve', 'desc')
                ->limit(5)
                ->select([
                    'date_releve as date',
                    'index_froid as indexFroid',
                    'index_chaud as indexChaud'
                ])
                ->get()
                ->map(function ($item) {
                    $item->date = Carbon::parse($item->date)->format('d/m/Y');
                    return $item;
                });

            return response()->json([
                'history' => $historique
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la récupération de l\'historique'
            ], 500);
        }
    }

    /**
     * Récupérer l'historique des relevés de gaz
     */
    public function getHistoriqueGaz($compteurId)
    {
        try {
            $historique = DB::table('releves_gaz')
                ->where('compteur_id', $compteurId)
                ->orderBy('date_releve', 'desc')
                ->limit(5)
                ->select([
                    'date_releve as date',
                    'index as index'
                ])
                ->get()
                ->map(function ($item) {
                    $item->date = Carbon::parse($item->date)->format('d/m/Y');
                    return $item;
                });

            return response()->json([
                'history' => $historique
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la récupération de l\'historique'
            ], 500);
        }
    }

    /**
     * Récupérer l'historique des relevés électriques
     */
    public function getHistoriqueElec($compteurId)
    {
        try {
            $historique = DB::table('releves_elec')
                ->where('compteur_id', $compteurId)
                ->orderBy('date_releve', 'desc')
                ->limit(5)
                ->select([
                    'date_releve as date',
                    'index_hp as indexHP',
                    'index_hc as indexHC'
                ])
                ->get()
                ->map(function ($item) {
                    $item->date = Carbon::parse($item->date)->format('d/m/Y');
                    return $item;
                });

            return response()->json([
                'history' => $historique
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la récupération de l\'historique'
            ], 500);
        }
    }

    /**
     * Sauvegarder un relevé d'eau
     */
    public function saveReleveEau(Request $request)
    {
        try {
            $data = $request->validate([
                'compteur_id' => 'required|integer',
                'index_froid' => 'required|numeric',
                'index_chaud' => 'required|numeric',
                'date_releve' => 'required|date'
            ]);

            DB::table('releves_eau')->insert([
                'compteur_id' => $data['compteur_id'],
                'index_froid' => $data['index_froid'],
                'index_chaud' => $data['index_chaud'],
                'date_releve' => $data['date_releve'],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'message' => 'Relevé d\'eau sauvegardé avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la sauvegarde du relevé d\'eau'
            ], 500);
        }
    }

    /**
     * Sauvegarder un relevé de gaz
     */
    public function saveReleveGaz(Request $request)
    {
        try {
            $data = $request->validate([
                'compteur_id' => 'required|integer',
                'index' => 'required|numeric',
                'date_releve' => 'required|date'
            ]);

            DB::table('releves_gaz')->insert([
                'compteur_id' => $data['compteur_id'],
                'index' => $data['index'],
                'date_releve' => $data['date_releve'],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'message' => 'Relevé de gaz sauvegardé avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la sauvegarde du relevé de gaz'
            ], 500);
        }
    }

    /**
     * Sauvegarder un relevé électrique
     */
    public function saveReleveElec(Request $request)
    {
        try {
            $data = $request->validate([
                'compteur_id' => 'required|integer',
                'index_hp' => 'required|numeric',
                'index_hc' => 'required|numeric',
                'date_releve' => 'required|date'
            ]);

            DB::table('releves_elec')->insert([
                'compteur_id' => $data['compteur_id'],
                'index_hp' => $data['index_hp'],
                'index_hc' => $data['index_hc'],
                'date_releve' => $data['date_releve'],
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'message' => 'Relevé électrique sauvegardé avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la sauvegarde du relevé électrique'
            ], 500);
        }
    }
} 