<?php
namespace App\Imports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class ClientsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Traitement des données
            Client::create([
                'nom' => $row['nom'],
                'rue' => $row['rue'],
                'codepost' => $row['code_postal'],
                'localite' => $row['localite'],
            ]);
        }
    }
}

