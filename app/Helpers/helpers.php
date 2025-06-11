<?php

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\RequestException;

if(!function_exists('geocodeAddress')) {
    function geocodeAddress($address) {
        // Clé API Google Maps Geocoding
        $apiKey = env('VITE_GOOGLE_MAPS_API_KEY');

        // URL de l'API Geocoding avec l'adresse à géocoder et la clé API
        $url = 'https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&key=' . $apiKey;

        // Créer un nouveau client Guzzle
        $client = new GuzzleClient();

        try {
            // Effectuer une demande à l'API Geocoding
            $response = $client->request('GET', $url);

            // Convertir la réponse JSON en tableau associatif
            $geocodingData = json_decode($response->getBody(), true);

            // Vérifier si la réponse est valide et contient des résultats
            if (isset($geocodingData['results']) && count($geocodingData['results']) > 0) {
                // Extraire les coordonnées géographiques de la première réponse
                $latitude = $geocodingData['results'][0]['geometry']['location']['lat'];
                $longitude = $geocodingData['results'][0]['geometry']['location']['lng'];

                // Renvoyer les coordonnées géographiques
                return ['latitude' => $latitude, 'longitude' => $longitude];
            } else {
                // Si aucune réponse valide n'a été obtenue, renvoyer null
                return null;
            }
        } catch (RequestException $e) {
            // Gérer l'erreur de requête
            return ['error' => 'Une erreur s\'est produite lors de la géocodage de l\'adresse.'];

        }
    }

}

if (!function_exists('insertSlash')) {
    function insertSlash($string) {
        if (strlen($string) == 4) {
            return substr($string, 0, 2) . '/' . substr($string, 2);
        }
        return $string;
    }
}

