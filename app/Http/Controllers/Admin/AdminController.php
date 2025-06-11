<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appareil;
use App\Models\Client;
use App\Models\Contact;
//use App\Models\ContactType;
//use App\Models\Property;
use App\Models\RelChauf;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {

        return view('admin.index');
    }

    public function quickRegen()
    {

        $message_count = '';

        if (User::where('email', 'cau@esi-informatique.com')->count() == 0) {
            User::create([
                'name' => 'Cedric A',
                'email' => 'cau@esi-informatique.com',
                'password' => bcrypt('123456a.'),
            ]);
            $message_count .= 'Utilisateur cau@.. créé. ';
        }

        // if ContactType count is 0, create 3 ContactTypes
        if (ContactType::count() == 0) {
            ContactType::create([
                'name' => 'Propriétaire',
                'sentences' => 1,
                'slug' => 'owner',
                'icon' => 'fas fa-user',
                'color' => 'blue',
            ]);
            ContactType::create([
                'name' => 'Locataire',
                'sentences' => 2,
                'slug' => 'tenant',
                'icon' => 'fas fa-user',
                'color' => 'green',
            ]);
            ContactType::create([
                'name' => 'Contact',
                'sentences' => 3,
                'slug' => 'contact',
                'icon' => 'fas fa-user',
                'color' => 'red',
            ]);
            $message_count .= '3 types de contacts créés. ';
        }

        if (Contact::count() == 0) {
            Contact::create([
                'firstname' => 'John',
                'lastname' => 'Doe',
                'contact_type_id' => 1,
            ]);
            Contact::create([
                'firstname' => 'Jane',
                'lastname' => 'Doe',
                'contact_type_id' => 2,
            ]);
            Contact::create([
                'firstname' => 'John',
                'lastname' => 'Smith',
                'contact_type_id' => 3,
            ]);
            Contact::create([
                'firstname' => 'Jane',
                'lastname' => 'Smith',
                'contact_type_id' => 3,
            ]);
            Contact::create([
                'firstname' => 'Bernard',
                'lastname' => 'Martin',
                'contact_type_id' => 1,
            ]);
            Contact::create([
                'firstname' => 'Rodrigo',
                'lastname' => 'Gonzalez',
                'contact_type_id' => 2,
            ]);
            Contact::create([
                'firstname' => 'Jean',
                'lastname' => 'Dupont',
                'contact_type_id' => 3,
            ]);
            Contact::create([
                'firstname' => 'Jeanne',
                'lastname' => 'Doucet',
                'contact_type_id' => 1,
            ]);
            Contact::create([
                'firstname' => 'Jean',
                'lastname' => 'Dupuis',
                'contact_type_id' => 2,
            ]);
            Contact::create([
                'firstname' => 'Jeanne',
                'lastname' => 'François',
                'contact_type_id' => 1,
            ]);
            $message_count .= '10 contacts créés. ';
        }

        if (Property::count() == 0) {
            Property::create([
                'ref' => 'A001',
                'street' => 'Rue de la Paix',
                'street2' => '1',
                'city' => 'Bruxelles',
                'postal_code' => '1000',
                'country' => 'Belgique',
                'owner_id' => 1,
                'contacts' => [3, 4],
            ]);
            Property::create([
                'ref' => 'A002',
                'street' => 'Rue de la Liberté',
                'street2' => '2',
                'city' => 'Bruxelles',
                'postal_code' => '1000',
                'country' => 'Belgique',
                'owner_id' => 2,
                'contacts' => [5, 6],
            ]);
            Property::create([
                'ref' => 'A003',
                'street' => 'Rue de la Justice',
                'street2' => '3',
                'city' => 'Bruxelles',
                'postal_code' => '1000',
                'country' => 'Belgique',
                'owner_id' => 3,
                'contacts' => [7, 8],
            ]);
            Property::create([
                'ref' => 'A004',
                'street' => 'Rue de la Vérité',
                'street2' => '4',
                'city' => 'Bruxelles',
                'postal_code' => '1000',
                'country' => 'Belgique',
                'owner_id' => 4,
                'contacts' => [9, 10],
            ]);
            Property::create([
                'ref' => 'A005',
                'street' => 'Rue de la Foi',
                'street2' => '5',
                'city' => 'Bruxelles',
                'postal_code' => '1000',
                'country' => 'Belgique',
                'owner_id' => 5,
                'contacts' => [3, 4],
            ]);
            Property::create([
                'ref' => 'A006',
                'street' => 'Rue de la Charité',
                'street2' => '6',
                'city' => 'Bruxelles',
                'postal_code' => '1000',
                'country' => 'Belgique',
                'owner_id' => 6,
                'contacts' => [5, 6],
            ]);
            $message_count .= '6 propriétés créées. ';
        }

        return back()->with('success', 'Regénération effectuée avec succès. '.$message_count);
    }

    public function migrationRelChaufToReleve()
    {
        /*$relChaufs = RelChauf::select('Codecli', 'RefAppTR', 'NumRad', 'NumCal', 'coef', 'Sit', 'TypCal')->get();
        //dd($relChaufs);

        foreach ($relChaufs as $relChauf){
            $codeCli = $relChauf->Codecli;
            $refAppTR = $relChauf->RefAppTR;
            $numero = $relChauf-> NumRad;
            $numSerie = $relChauf->NumCal;
            $coef = $relChauf -> coef;
            $sit = $relChauf -> Sit;
            $typeReleve = 'VISU_CH';
            $typCal = $relChauf->TypCal;

            $appareil = new Appareil();
            $appareil->codeCli =$codeCli;
            $appareil->RefAppTR =$refAppTR;
            $appareil->numSerie = $numSerie;
            $appareil->TypeReleve= $typeReleve;
            $appareil->coef = $coef;
            $appareil->sit = $sit;
            $appareil->numero=$numero;
            $appareil->typeApp = $typCal;
            $appareil->save();



        }*/

        RelChauf::select('Codecli', 'RefAppTR', 'NumRad', 'NumCal', 'coef', 'Sit', 'TypCal')
            ->where('id', '>=', 507975)
            ->chunk(10000, function ($relChaufs) {
                foreach ($relChaufs as $relChauf) {

                    $codeCli = $relChauf->Codecli;
                    $refAppTR = $relChauf->RefAppTR;
                    $numero = $relChauf->NumRad;
                    $numSerie = $relChauf->NumCal;
                    $coef = $relChauf->coef;
                    $sit = $relChauf->Sit;
                    $typeReleve = 'VISU_CH';
                    $typCal = $relChauf->TypCal;


                    $appareil = new Appareil();
                    $appareil->codeCli = $codeCli;
                    $appareil->RefAppTR = $refAppTR;
                    $appareil->numSerie = $numSerie;
                    $appareil->TypeReleve = $typeReleve;
                    $appareil->coef = $coef;
                    $appareil->sit = $sit;
                    $appareil->numero = $numero;
                    $appareil->typeApp = $typCal;
                    $appareil->save();
                }
            });




        $message = __('la migration est un succès.');

        return redirect()->route('admin.index')->with('success', $message);



        //return view('admin.index');
    }

}

