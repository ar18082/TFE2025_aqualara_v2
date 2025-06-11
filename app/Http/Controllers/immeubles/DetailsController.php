<?php

namespace App\Http\Controllers\immeubles;

use App\Http\Controllers\Controller;
use App\Models\Appartement;
use App\Models\Client;
use App\Models\Clichauf;
use App\Models\RelChaufApp;
use App\Models\RelEauApp;
use App\Models\RelElecApp;
use App\Models\RelGazApp;
use App\Helpers\AppartementHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DetailsController extends Controller
{
    private function getCompteursData($appartement)
    {

        // consulter si il y a des compteurs avec le Codecli et le RefAppTR 
        $relChaufApps = RelChaufApp::where('Codecli', $appartement->Codecli)
            ->where('RefAppTR', $appartement->RefAppTR)
            ->orderBy('datRel', 'desc')
            ->first();

        $relEauApps = RelEauApp::where('Codecli', $appartement->Codecli)
            ->where('RefAppTR', $appartement->RefAppTR)
            ->orderBy('datRel', 'desc')
            ->first();

        $relElecApps = RelElecApp::where('Codecli', $appartement->Codecli)
            ->where('RefAppTR', $appartement->RefAppTR)
            ->orderBy('datRel', 'desc')
            ->first();

        $relGazApps = RelGazApp::where('Codecli', $appartement->Codecli)
            ->where('RefAppTR', $appartement->RefAppTR)
            ->orderBy('datRel', 'desc')
            ->first();

        $compteurs = [
            'chauffage' => [
                'value' => $relChaufApps ? $relChaufApps->NbRad : 0,
                'icon' => 'fa-temperature-half',
                'label' => 'Radiateurs',
                'bg' => 'bg-warning',
                'text' => 'text-dark'
            ],
            'eau_chaude' => [
                'value' => $relEauApps ? $relEauApps->NbCptChaud : 0,
                'icon' => 'fa-droplet-degree',
                'label' => 'Eau chaude',
                'bg' => 'bg-danger',
                'text' => 'text-white'
            ],
            'eau_froide' => [
                'value' => $relEauApps ? $relEauApps->NbCptFroid : 0,
                'icon' => 'fa-droplet',
                'label' => 'Eau froide',
                'bg' => 'bg-info',
                'text' => 'text-white'
            ],
            'electricite' => [
                'value' => $relElecApps ? $relElecApps->NbCpt : 0,
                'icon' => 'fa-bolt',
                'label' => 'Électricité',
                'bg' => 'bg-primary',
                'text' => 'text-white'
            ],
            'gaz' => [
                'value' => $relGazApps ? $relGazApps->nbCpt : 0,
                'icon' => 'fa-fire-flame-simple',
                'label' => 'Gaz',
                'bg' => 'bg-success',
                'text' => 'text-white'
            ]
        ];

        return array_filter($compteurs, function($compteur) {
            return $compteur['value'] > 0;
        });
    }

    private function getReleveTypes($client)
    {
        $types = [
            'chauffage' => [
                'icon' => 'fa-temperature-high',
                'type' => $client->clichaufs->first()->TypRlv ?? null,
                'label' => 'Chauffage'
            ],
            'eau' => [
                'icon' => 'fa-droplet',
                'type' => $client->cliEaus->first()->TypRlv ?? null,
                'label' => 'Eau'
            ],
            'gaz' => [
                'icon' => 'fa-fire',
                'type' => $client->cliGazs->first()->TypRlv ?? null,
                'label' => 'Gaz'
            ],
            'electricite' => [
                'icon' => 'fa-bolt',
                'type' => $client->cliElecs->first()->TypRlv ?? null,
                'label' => 'Électricité'
            ]
        ];

        
        $releveTypes = [];
        foreach ($types as $key => $data) {
            if ($data['type']) {
                $icon = match($data['type']) {
                    'VISU' => 'fa-eye',
                    'GPRS' => 'fa-wifi',
                    'RADIO' => 'fa-walkie-talkie',
                    default => $data['icon']
                };
                
                $releveTypes[] = [
                    'type' => $data['type'],
                    'label' => $data['label'],
                    'icon' => $icon
                ];
            }
        }

        return $releveTypes;
    }

    private function getClientWithRelations($codecli, $relations = [])
    {
        $defaultRelations = ['codePostelbs', 'gerantImms.contacts'];
        $relations = array_merge($defaultRelations, $relations);
       
        $client = Client::where('Codecli', $codecli)
            ->with($relations)
            ->firstOrFail();

           
          
        return $client;
    }

    private function getAppartementsWithAbsent($codecli)
    {
        $appartements = Appartement::where('Codecli', $codecli)
            ->with('Absent')
            ->get();

            
        $nbImmAbsent = 0;
        foreach ($appartements as $appartement) {
            if ($appartement->Absent->count() > 0 && $appartement->Absent->first()->is_absent) {
                $nbImmAbsent++;
            }
            $appartement->compteurs = $this->getCompteursData($appartement);
        }

        return compact('appartements', 'nbImmAbsent');
    }

    private function handleView($codecli, $content, $relations = [], $errorMessage = null)
    {
        try {
            
            $client = $this->getClientWithRelations($codecli, $relations);
           
            if ($errorMessage && !$client->{$relations[count($relations) - 1]}->count()) {
                return view('immeubles.details.index', [
                    'client' => $client,
                    'nbImmAbsent' => 0,
                    'content' => $content,
                    'error' => $errorMessage
                ]);
            }

            $data = $this->getAppartementsWithAbsent($codecli);
            $data['client'] = $client;
            $data['content'] = $content;
            $data['releveTypes'] = $this->getReleveTypes($client);

            return view('immeubles.details.index', $data);
        } catch (\Exception $e) {
            Log::error('Erreur dans ' . $content . ': ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la récupération des données.');
        }
    }

    public function getAppartements($codecli)
    {
        return $this->handleView($codecli, 'immeubles.appartements.index', [
            'clichaufs',
            'cliEaus',
            'cliElecs',
            'cliGazs'
        ]);
    }

    public function getDetails($codecli)
    {
        return $this->handleView($codecli, 'immeubles.details.donneesGenerales.Definition', [
            'clichaufs',
            'cliEaus',
            'cliElecs',
            'cliGazs',
            'cliProvisions'
        ]);
    }

    public function getChauffage($codecli)
    {
        $client = $this->getClientWithRelations($codecli, ['clichaufs']);
        
        if (!$client->clichaufs->count()) {
            return view('immeubles.details.index', [
                'client' => $client,
                'nbImmAbsent' => 0,
                'content' => 'immeubles.details.donneesGenerales.DetailChauff',
                'error' => 'Ce client ne dispose pas de données de chauffage.',
                'clichauf' => null
            ]);
        }

        $data = $this->getAppartementsWithAbsent($codecli);
        $data['client'] = $client;
        $data['content'] = 'immeubles.details.donneesGenerales.DetailChauff';
        $data['releveTypes'] = $this->getReleveTypes($client);
        $data['clichauf'] = $client->clichaufs->first();

        return view('immeubles.details.index', $data);
    }

    public function getEau($codecli)
    {
        $client = $this->getClientWithRelations($codecli, ['cliEaus']);
        
        if (!$client->cliEaus->count()) {
            return view('immeubles.details.index', [
                'client' => $client,
                'nbImmAbsent' => 0,
                'content' => 'immeubles.details.donneesGenerales.DetailEau',
                'error' => 'Ce client ne dispose pas de données d\'eau.',
                'cliEaus' => collect([])
            ]);
        }

        $data = $this->getAppartementsWithAbsent($codecli);
        $data['client'] = $client;
        $data['content'] = 'immeubles.details.donneesGenerales.DetailEau';
        $data['releveTypes'] = $this->getReleveTypes($client);
        $data['cliEaus'] = $client->cliEaus;

        return view('immeubles.details.index', $data);
    }

    public function getGaz($codecli)
    {
        $client = $this->getClientWithRelations($codecli, ['cliGazs']);
        
        if (!$client->cliGazs->count()) {
            return view('immeubles.details.index', [
                'client' => $client,
                'nbImmAbsent' => 0,
                'content' => 'immeubles.details.donneesGenerales.DetailGaz',
                'error' => 'Ce client ne dispose pas de données de gaz.',
                'cliGaz' => null,
                'cliGazs' => collect([])
            ]);
        }

        $data = $this->getAppartementsWithAbsent($codecli);
        $data['client'] = $client;
        $data['content'] = 'immeubles.details.donneesGenerales.DetailGaz';
        $data['releveTypes'] = $this->getReleveTypes($client);
        $data['cliGazs'] = $client->cliGazs;
        $data['cliGaz'] = $client->cliGazs->first();

        return view('immeubles.details.index', $data);
    }

    public function getElectricite($codecli)
    {
        $client = $this->getClientWithRelations($codecli, ['cliElecs']);
        
        if (!$client->cliElecs->count()) {
            return view('immeubles.details.index', [
                'client' => $client,
                'nbImmAbsent' => 0,
                'content' => 'immeubles.details.donneesGenerales.DetailElec',
                'error' => 'Ce client ne dispose pas de données d\'électricité.',
                'cliElec' => null,
                'cliElecs' => collect([])
            ]);
        }

        $data = $this->getAppartementsWithAbsent($codecli);
        $data['client'] = $client;
        $data['content'] = 'immeubles.details.donneesGenerales.DetailElec';
        $data['releveTypes'] = $this->getReleveTypes($client);
        $data['cliElecs'] = $client->cliElecs;
        $data['cliElec'] = $client->cliElecs->first();

        return view('immeubles.details.index', $data);
    }

    public function getProvision($codecli)
    {
        $client = $this->getClientWithRelations($codecli, [
            'appartements' => function($query) use ($codecli) {
                $query->where('Codecli', $codecli)
                    ->with([
                        'relChaufApps' => function($q) use ($codecli) {
                            $q->where('Codecli', $codecli)
                              ->whereIn('id', function($subquery) use ($codecli) {
                                  $subquery->selectRaw('MAX(id)')
                                          ->from('rel_chauf_apps')
                                          ->where('Codecli', $codecli)
                                          ->groupBy('RefAppTR');
                              });
                        },
                        'relEauApps' => function($q) use ($codecli) {
                            $q->where('Codecli', $codecli)
                              ->whereIn('id', function($subquery) use ($codecli) {
                                  $subquery->selectRaw('MAX(id)')
                                          ->from('rel_eau_apps')
                                          ->where('Codecli', $codecli)
                                          ->groupBy('RefAppTR');
                              });
                        },
                        'relGazApps' => function($q) use ($codecli) {
                            $q->where('Codecli', $codecli)
                              ->whereIn('id', function($subquery) use ($codecli) {
                                  $subquery->selectRaw('MAX(id)')
                                          ->from('rel_gaz_apps')
                                          ->where('Codecli', $codecli)
                                          ->groupBy('RefAppTR');
                              });
                        },
                        'relElecApps' => function($q) use ($codecli) {
                            $q->where('Codecli', $codecli)
                              ->whereIn('id', function($subquery) use ($codecli) {
                                  $subquery->selectRaw('MAX(id)')
                                          ->from('rel_elec_apps')
                                          ->where('Codecli', $codecli)
                                          ->groupBy('RefAppTR');
                              });
                        }
                    ]);
            }
        ]);

        $data = $this->getAppartementsWithAbsent($codecli);
        $data['client'] = $client;
        $data['content'] = 'immeubles.details.donneesGenerales.DetailProvision';

        return view('immeubles.details.index', $data);
    }

    public function getInfoAppart($codecli)
    {
        return $this->handleView($codecli, 'immeubles.details.donneesGenerales.InfoAppart');
    }

    public function getGraphiques($codecli)
    {
        return $this->handleView($codecli, 'immeubles.details.donneesGenerales.DetailChart');
    }

    public function uploadCsv(Request $request, string $codeCli)
    {
        $client = Client::where('Codecli', $codeCli)->first();
        
        if (!$client) {
            return redirect()->back()->with('error', 'Client non trouvé');
        }

        if (!$request->hasFile('csvFile')) {
            return redirect()->back()->with('error', 'Aucun fichier sélectionné');
        }

        $file = $request->file('csvFile');
        
        if ($file->getClientOriginalExtension() !== 'csv') {
            return redirect()->back()->with('error', 'Le fichier doit être au format CSV');
        }

        try {
            // Stocker le fichier
            $path = $file->storeAs('csv', $codeCli . '_' . time() . '.csv');

            // Lire le fichier CSV
            $handle = fopen(storage_path('app/' . $path), 'r');
            if (!$handle) {
                throw new \Exception('Impossible d\'ouvrir le fichier CSV');
            }

            // Lire l'en-tête
            $header = fgetcsv($handle);
            $requiredColumns = ['Codecli', 'RefAppTR', 'RefAppCli', 'proprietaire', 'datefin', 'bloc'];
            
            // Vérifier que toutes les colonnes requises sont présentes
            $missingColumns = array_diff($requiredColumns, $header);
            if (!empty($missingColumns)) {
                fclose($handle);
                throw new \Exception('Colonnes manquantes dans le fichier CSV: ' . implode(', ', $missingColumns));
            }

            // Récupérer les indices des colonnes
            $columnIndices = array_flip($header);

            // Récupérer les appartements existants
            $existingAppartements = $client->appartements->keyBy('RefAppTR');

            // Lire les données
            while (($row = fgetcsv($handle)) !== false) {
                $data = array_combine($header, $row);

                // Vérifier que c'est bien le bon client
                if ($data['Codecli'] !== $codeCli) {
                    continue;
                }

                // Créer ou mettre à jour l'appartement
                $appartement = $existingAppartements->get($data['RefAppTR']) ?? new Appartement();
                $appartement->RefAppTR = $data['RefAppTR'];
                $appartement->RefAppCli = $data['RefAppCli'];
                $appartement->proprietaire = $data['proprietaire'];
                $appartement->datefin = $data['datefin'] ? \Carbon\Carbon::createFromFormat('d-m-Y', $data['datefin']) : null;
                $appartement->bloc = $data['bloc'];
                $appartement->Codecli = $codeCli;
                $appartement->save();
            }

            fclose($handle);
            return redirect()->back()->with('success', 'Fichier CSV traité avec succès');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors du traitement du fichier: ' . $e->getMessage());
        }
    }
} 