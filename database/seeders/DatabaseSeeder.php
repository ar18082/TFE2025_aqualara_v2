<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Appareil;
use App\Models\Client;
use App\Models\RelChauf;
use App\Models\RelEauC;
use App\Models\RelEauF;
use App\Models\RelRadChf;
use App\Models\RelRadEau;
use Illuminate\Database\Seeder;
use function Webmozart\Assert\Tests\StaticAnalysis\null;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $relChaufs = RelChauf::select('Codecli', 'RefAppTR', 'NumCal', 'Coef', 'Sit', 'NumRad')
            ->distinct('NumCal')
            ->get();

        $relEauCs = RelEauC::select('Codecli', 'RefAppTR', 'NoCpt', 'Sit')
            ->distinct('NoCpt')
            ->get();
        $relEauFs = RelEauF::select('Codecli', 'RefAppTR', 'NoCpt', 'Sit')
            ->distinct('NoCpt')
            ->get();
        $relRadChfs = RelRadChf::select('Codecli', 'RefAppTR', 'Numcal', 'Coef')
            ->distinct('Numcal')
            ->get();
        $relRadEaus = RelRadEau::select('Codecli', 'RefAppTR', 'Numcal')
            ->distinct('Numcal')
            ->get();

        foreach ($relChaufs as $relChauf) {
            if (Client::where('id', $relChauf->Codecli)->exists()) {
                Appareil::factory()->create([
                    'codeCli' => $relChauf->Codecli,
                    'RefAppTR' => $relChauf->RefAppTR,
                    'numSerie' => $relChauf->NumCal,
                    'TypeReleve' => 'VISU_CH',
                    'coef' => $relChauf->Coef,
                    'sit' => $relChauf->Sit,
                    'numero' => $relChauf->NumRad,
                    'materiel_id' => null,
                ]);
            }
        }


        foreach ($relEauCs as $relEauC) {
            if (Client::where('id', $relEauC->Codecli)->exists()) {
                Appareil::factory()->create([
                    'codeCli' => $relEauC->Codecli,
                    'RefAppTR' => $relEauC->RefAppTR,
                    'numSerie' => $relEauC->NoCpt,
                    'TypeReleve' => 'VISU_EAUC',
                    'coef' => null,
                    'sit' => $relEauC->Sit ?? null,
                    'numero' => null,
                    'materiel_id' => null,
                ]);
            }
        }

        foreach ($relEauFs as $relEauF) {
            if (Client::where('id', $relEauF->Codecli)->exists()) {
                Appareil::factory()->create([
                    'codeCli' => $relEauF->Codecli,
                    'RefAppTR' => $relEauF->RefAppTR,
                    'numSerie' => $relEauF->NoCpt,
                    'TypeReleve' => 'VISU_EAUF',
                    'coef' => null,
                    'sit' => $relEauF->Sit ?? null,
                    'numero' => null,
                    'materiel_id' => null,
                ]);
            }
        }

        foreach ($relRadChfs as $relRadChf) {
            if (Client::where('id', $relRadChf->Codecli)->exists()) {
                Appareil::factory()->create([
                    'codeCli' => $relRadChf->Codecli,
                    'RefAppTR' => $relRadChf->RefAppTR,
                    'numSerie' => $relRadChf->Numcal,
                    'TypeReleve' => 'RADIO_CH',
                    'coef' => $relRadChf->Coef,
                    'sit' => null,
                    'numero' => null,
                    'materiel_id' => null,
                ]);
            }
        }

        foreach ($relRadEaus as $relRadEau) {
            if (Client::where('id', $relRadEau->Codecli)->exists()) {
                Appareil::factory()->create([
                    'codeCli' => $relRadEau->Codecli,
                    'RefAppTR' => $relRadEau->RefAppTR,
                    'numSerie' => $relRadEau->Numcal,
                    'TypeReleve' => 'RADIO_EAU',
                    'coef' => null,
                    'sit' => null,
                    'numero' => null,
                    'materiel_id' => null,
                ]);
            }
        }
    }
}
