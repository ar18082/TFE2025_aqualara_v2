<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AjaxController extends Controller
{
    public function getFormMaterielType($type)
    {
        switch ($type) {
            case 'Compteur_eau':
                return view('admin.materiel.compteurEau.FormCaracteristiqueCompteur')->render();

            case 'Calorimetre':
                // Retourne la vue pour Calorimetre

            case 'Integrateur':
                return view('admin.materiel.integrateur.FormMarqueIntegrateur')->render();

            default:
                return '';
        }
    }
    public function getFormMaterielGenre($genre)
    {

        switch ($genre) {
            case 'modulaire':
                return view('admin.materiel.compteurEau.formCommuModulaire')->render();

            case 'digital':
                return view('admin.materiel.compteurEau.formCommuDigital')->render();


            default:
                return '';
        }
    }

    public function getFormModel()
    {
        return view('admin.materiel.integrateur.formSontex')->render();

    }

    public function getFormCommuSontex()
    {
       return view('admin.materiel.integrateur.formCommuSontex')->render();
    }

    public function getFormCommuSontex2()
    {
        return view('admin.materiel.integrateur.formCommuSontex2')->render();
    }

    public function getFormMaterielCommu($commu)
    {

        switch ($commu) {
            case 'Visuel':
                return view('admin.materiel.compteurEau.formCommuModulaire')->render();
            case 'Lora':
                return view('admin.materiel.compteurEau.formCommuDigital')->render();
            case 'WM-Bus':
                return view('admin.materiel.compteurEau.formCommuDigital')->render();
            case 'Radio-Sontex':
                return view('admin.materiel.compteurEau.formCommuDigital')->render();
            case 'supercal_5':
                return view('admin.materiel.compteurEau.formCommuModulaire')->render();
            case 'supercal_531':
                return view('admin.materiel.compteurEau.formCommuDigital')->render();
            default:
                return '';
        }
    }

    public function getFormDimension() {

        return view('admin.materiel.integrateur.SelectDimensionIntegrateur')->render();
    }


}
