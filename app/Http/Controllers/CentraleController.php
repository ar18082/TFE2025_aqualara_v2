<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client as GuzzleHttp;

class CentraleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $clients = Client::with('clichaufs')
            ->whereHas('clichaufs', function ($query) {
                $query->where('TypRlv', 'GPRS');
            })
            ->get();


        return view('centrale.index', ['clients' => $clients]);
    }

    public function centrale($id)
    {



    }

    public function detail($id)
    {
        $client = new GuzzleHttp();

        $gateways = [];
        $paramStart = 0;

        $response = $client->request('GET', 'https://sonexa.ch/api/device/v1.0/product/list?start='.$paramStart, [
            'headers' => [
                'accept' => 'application/json',
                'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJkZjJkMmE0Zi0yZGJmLTQwYjMtODljZi05MWRlYzI3ZTViZDkifQ.eyJpYXQiOjE2OTUyNDQ5NDgsImp0aSI6IjhjNjUyYjYyLTFmMmEtNGRmMy1hODNiLTUzN2U5N2M4OTQ4NCIsImlzcyI6Imh0dHBzOi8vc3NvLmV4Y2hhbmdlLXBsYXRmb3JtLmFwcC9hdXRoL3JlYWxtcy9zb25leGEiLCJhdWQiOiJodHRwczovL3Nzby5leGNoYW5nZS1wbGF0Zm9ybS5hcHAvYXV0aC9yZWFsbXMvc29uZXhhIiwic3ViIjoiNWM1ZTNiNGYtNWY4OC00MzI4LWE3ZWItZTYwNTNiMDU3ZDg5IiwidHlwIjoiT2ZmbGluZSIsImF6cCI6Im5naW54LWFwaSIsInNlc3Npb25fc3RhdGUiOiI4MjRlOWFkMy1jNDliLTQ0OWYtYWJjNC01YjQzNDNhMDA4N2YiLCJzY29wZSI6ImVtYWlsIHByb2ZpbGUgb2ZmbGluZV9hY2Nlc3MiLCJzaWQiOiI4MjRlOWFkMy1jNDliLTQ0OWYtYWJjNC01YjQzNDNhMDA4N2YifQ.fQzhGLDzdwfFBwIwJYpxZDxoBtyCxuT2Uor7FRqeMZE',
            ],
        ]);
        $body = $response->getBody()->getContents();
        $datas = json_decode($body, true);


        $totalProducts = $datas['totalProducts'];

        while ($paramStart < $totalProducts) {
            // Faites la requête avec le nouveau $paramStart
            $response = $client->request('GET', 'https://sonexa.ch/api/device/v1.0/product/list?start='.$paramStart, [
                'headers' => [
                    'accept' => 'application/json',
                    'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICJkZjJkMmE0Zi0yZGJmLTQwYjMtODljZi05MWRlYzI3ZTViZDkifQ.eyJpYXQiOjE2OTUyNDQ5NDgsImp0aSI6IjhjNjUyYjYyLTFmMmEtNGRmMy1hODNiLTUzN2U5N2M4OTQ4NCIsImlzcyI6Imh0dHBzOi8vc3NvLmV4Y2hhbmdlLXBsYXRmb3JtLmFwcC9hdXRoL3JlYWxtcy9zb25leGEiLCJhdWQiOiJodHRwczovL3Nzby5leGNoYW5nZS1wbGF0Zm9ybS5hcHAvYXV0aC9yZWFsbXMvc29uZXhhIiwic3ViIjoiNWM1ZTNiNGYtNWY4OC00MzI4LWE3ZWItZTYwNTNiMDU3ZDg5IiwidHlwIjoiT2ZmbGluZSIsImF6cCI6Im5naW54LWFwaSIsInNlc3Npb25fc3RhdGUiOiI4MjRlOWFkMy1jNDliLTQ0OWYtYWJjNC01YjQzNDNhMDA4N2YiLCJzY29wZSI6ImVtYWlsIHByb2ZpbGUgb2ZmbGluZV9hY2Nlc3MiLCJzaWQiOiI4MjRlOWFkMy1jNDliLTQ0OWYtYWJjNC01YjQzNDNhMDA4N2YifQ.fQzhGLDzdwfFBwIwJYpxZDxoBtyCxuT2Uor7FRqeMZE',
                ],
            ]);

            // Obtenez le contenu de la réponse
            $body = $response->getBody()->getContents();

            // Décodez le contenu JSON en un tableau associatif
            $datas = json_decode($body, true);

            // Vérifiez si la conversion JSON a réussi
            if ($datas === null) {
                // Gestion des erreurs si la conversion a échoué
                echo "Erreur lors de la conversion JSON.";
                break; // Sortez de la boucle
            }

          // dd($datas['devices']);

            // Parcourez les gateways et ajoutez-les au tableau $gateways
            foreach ($datas['gateways'] as $gateway) {
                // Vérifiez si la gateway n'existe pas déjà dans le tableau
                if (!in_array($gateway, $gateways)) {
                    // Si la gateway n'existe pas déjà, ajoutez-la au tableau
                    $gateways[] = $gateway;
                }
            }

            // Incrémentez $paramStart pour obtenir la prochaine tranche de données
            $paramStart += 10000;
        }



        //dd($gateways[0]);


        return view('centrale.detail', ['gateways' =>$gateways]);


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
