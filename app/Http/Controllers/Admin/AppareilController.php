<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appareil;
use App\Models\AppareilsErreur;
use App\Models\Materiel;

use App\Models\RelChauf;
use App\Models\RelEauC;
use App\Models\RelEauF;
use App\Models\RelRadChf;
use App\Models\RelRadEau;
use App\Models\typeErreur;
use Illuminate\Http\Request;

class AppareilController extends Controller
{


    public function index()
    {


        $appareils = Appareil::with('materiel')->orderBy('codeCli')->paginate(25);

        //dd($appareils);
        return view('admin.appareil.index', [
            'appareils' => $appareils,
        ]);
    }

    public function create()
    {
        $appareil = new Appareil();

        return view('admin.appareil.form', [
            'appareil' => $appareil,
        ]);
    }

    public function store(Request $request)
    {
        $datas = $request->all();


        $appareil = new Appareil();
        $appareil->codeCli = $datas['codeCli'];
        $appareil->RefAppTR = $datas['RefAppTR'];
        $appareil->numSerie = $datas['numSerie'];
        $appareil->TypeReleve = $datas['TypeReleve'];
        $appareil->coef = $datas['coef'];
        $appareil->sit = $datas['sit'];
        $appareil->numero = $datas['numero'];
        $appareil->materiel_id = $datas['materiel'];
        $appareil->actif = $datas['actif'] == 'on' ? 1 : 0;

        $appareil->save();

        $message = __('L\'appareil a été créé avec succès.');

        return redirect()->route('admin.appareil.index')->with('success', $message);
    }

    public function edit($id)
    {
        $appareil = Appareil::findOrFail($id);

        return view('admin.appareil.form', [
            'appareil' => $appareil,
        ]);
    }

    public function update(Request $request, $id)
    {

        $datas = $request->all();

        $appareil = Appareil::findOrFail($id);
//        dd($appareil);
        $appareil->codeCli = $datas['codeCli'];
        $appareil->RefAppTR = $datas['refAppTR'];
        $appareil->numSerie = $datas['numSerie'];
        $appareil->TypeReleve = $datas['TypeReleve'];
        $appareil->coef = $datas['coef'];
        $appareil->sit = $datas['sit'];
        $appareil->numero = $datas['numero'];
        $appareil->materiel_id = $datas['materiel_id'];



        $appareil->save();

        $message = __('L\'appareil a été modifié avec succès.');

        return redirect()->back()->with('success', $message);
    }

    public function destroy($id)
    {
        $appareil = Appareil::findOrFail($id);
        $appareil->delete();

        $message = __('L\'appareil a été supprimé avec succès.');

        return redirect()->route('admin.appareil.index')->with('success', $message);
    }


    public function appareilTypeErreur(Request $request)
    {
        $typeAppareil = $request->input('prefix');
        $numSerie = $request->input('suffix');
        $typeErreurId = $request->input('selectedOption');
        $codecli = $request->input('appartement_Codecli');
        $refAppTR = $request->input('appartement_RefAppTR');

        $appareil = Appareil::where('numSerie', $numSerie)
            ->where('TypeReleve', $typeAppareil)
            ->first();

        $appareilErreur = AppareilsErreur::where('appareil_id', $appareil->id)
            ->get();



        if($appareilErreur->count() > 0){
            $appareilErreur[0]->type_erreur_id = $typeErreurId;
            $appareilErreur[0]->save();
        }else{
            $appareilErreur = new AppareilsErreur();
            $appareilErreur->appareil_id = $appareil->id;
            $appareilErreur->type_erreur_id = $typeErreurId;
            $appareilErreur->save();

        }


        return response()->json(['message' => 'Une erreur a été enregistrée']);

    }

    public function addIndex (Request $request, $Codecli_id, $appartement_id)
    {
        $inputs = $request->all();

        foreach ($inputs as $key => $value) {
            if (strpos($key, 'table') !== false ) {
                $serialNumber = explode('-', $key)[1];

                switch ($value){
                    case 'rel_chaufs' :
                        $ancIdx = RelChauf::where('Codecli', $Codecli_id)
                            ->where('RefAppTR', $appartement_id)
                            ->where('NumRad', $inputs['NumRad-'. $serialNumber])
                            ->latest('DatRel')
                            ->first();
                        $ancIdx = $ancIdx->NvIdx;

                        $relChauf = new RelChauf();
                        $relChauf->Codecli = $Codecli_id;
                        $relChauf->RefAppTR = $appartement_id;
                        $relChauf->DatRel = now()->format('Y-m-d');
                        $relChauf->NumRad = $inputs['NumRad-'. $serialNumber];
                        $relChauf->NumCal = $inputs['NumCal-'. $serialNumber];
                        $relChauf->AncIdx = $ancIdx;
                        $relChauf->NvIdx = $inputs['index-'. $serialNumber];
                        $relChauf->Coef = $inputs['Coef-'. $serialNumber];
                        $relChauf->Sit = $inputs['Sit-'. $serialNumber];
                        $relChauf->NvIdx2 = $inputs['index-'. $serialNumber];
                        $relChauf->TypCal = '';
                        $relChauf->Statut = '';
                        $relChauf->NumImp = 0;
                        $relChauf->DatImp = null;
                        $relChauf->hh_imp = 0;
                        $relChauf->mm_imp = 0;
                        $relChauf->Ok_Site = 0;
//                        $relChauf->save();
                        break;
                    case 'rel_eau_c_s' :
                        $ancIdx = RelEauC::where('Codecli', $Codecli_id)
                            ->where('RefAppTR', $appartement_id)
                            ->where('NoCpt', $inputs['NoCpt-'. $serialNumber])
                            ->latest('DatRel')
                            ->first();
                        $ancIdx = $ancIdx->NvIdx;

                        $relEauC = new RelEauC();
                        $relEauC->Codecli = $Codecli_id;
                        $relEauC->RefAppTR = $appartement_id;
                        $relEauC->DatRel = now()->format('Y-m-d');
                        $relEauC->NumCpt = $inputs['NumCpt-'. $serialNumber];
                        $relEauC->NoCpt = $inputs['NoCpt-'. $serialNumber];
                        $relEauC->AncIdx = $ancIdx;
                        $relEauC->NvIdx = $inputs['index-'. $serialNumber];
                        $relEauC->Sit = '';
                        $relEauC->NvIdx2 = $inputs['index-'. $serialNumber];
                        $relEauC->TypCal = null;
                        $relEauC->Statut = '';
                        $relEauC->Envers = 0;
                        $relEauC->NumImp = 0;
                        $relEauC->DatImp = null;
                        $relEauC->hh_imp = 0;
                        $relEauC->mm_imp = 0;
                        $relEauC->Ok_Site = 0;
//                        $relEauC->save();
                        break;
                    case 'rel_eau_f_s' :
//                        dd($inputs);
                        $ancIdx = RelEauF::where('Codecli', $Codecli_id)
                            ->where('RefAppTR', $appartement_id)
                            ->where('NumCpt', $inputs['NumCpt-'. $serialNumber])
                            ->latest('DatRel')
                            ->first();



                        $ancIdx = $ancIdx->NvIdx ;

                        $relEauF = new RelEauF();
                        $relEauF->Codecli = $Codecli_id;
                        $relEauF->RefAppTR = $appartement_id;
                        $relEauF->DatRel = now()->format('Y-m-d');
                        $relEauF->NumCpt = $inputs['NumCpt-'. $serialNumber];
                        $relEauF->NoCpt = $inputs['NoCpt-'. $serialNumber];
                        $relEauF->AncIdx = $ancIdx;
                        $relEauF->NvIdx = $inputs['index-'. $serialNumber];
                        $relEauF->Sit = '';
                        $relEauF->NvIdx2 = $inputs['index-'. $serialNumber];
                        $relEauF->TypCal = null;
                        $relEauF->Statut = '';
                        $relEauF->Envers = 0;
                        $relEauF->NumImp = 0;
                        $relEauF->DatImp = null;
                        $relEauF->hh_imp = 0;
                        $relEauF->mm_imp = 0;
                        $relEauF->Ok_Site = 0;
//                        $relEauF->save();
                        break;
                }

            }
        }

        $message = __('Les index ont été ajoutés avec succès.');
        return redirect()->route('immeubles.showAppartement', ['Codecli_id' => 1, 'appartement_id' => 1])->with('success', $message);
    }



}
