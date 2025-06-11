<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

class ListeSDCController extends Controller
{
    public function index()
    {
        return view('documents.listeSDC.index');

    }

    public function showListeSDC($id)
    {
        $document = Document::where('id', $id)->first();


        if (Storage::exists($document->link)) {
            return response()->file(storage_path('app/' . $document->link));
        } else {
            return redirect()->back()->with('error', 'Le fichier n\'existe pas');
        }
    }

    public function printListeSDC($id)
    {
        $document = Document::where('id', $id)->first();

        if ($document && Storage::exists($document->link)) {
            return response()->download(storage_path('app/' . $document->link));
        } else {
            return redirect()->back()->with('error', 'Le fichier n\'existe pas');
        }

    }

    public function store(Request $request)
    {
        $month = $request['month'];
        $year = Carbon::now()->year;

        $documents = Document::where('type', 'Liste SDC')
            ->whereRaw('MONTH(send_at) = ?', [$month])
            ->whereRaw('YEAR(send_at) = ?', [$year])
            ->get();
        if($documents->count() == 0){
            downloadPDFListeSDC($month);
            $documents = Document::where('type', 'Liste SDC')
                ->whereRaw('MONTH(send_at) = ?', [$month])
                ->get();
        }



        return view('documents.listeSDC.index', [
            'success' => 'Les données ont été importées avec succès',
            'documents' => $documents,
        ]);

    }
}
