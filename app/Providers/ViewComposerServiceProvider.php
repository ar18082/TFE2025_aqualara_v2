<?php

namespace App\Providers;

use App\Models\Client;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewComposerServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        View::composer(['shared.admin_header_immeuble', 'shared.header_immeuble'], function ($view) {
            if (request()->route('codecli')) {
                $client = Client::where('Codecli', request()->route('codecli'))
                    ->with(['clichaufs', 'cliEaus', 'cliElecs', 'cliGazs'])
                    ->first();

                if ($client) {
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

                    $view->with('releveTypes', $releveTypes);
                }
            }
        });
    }
} 