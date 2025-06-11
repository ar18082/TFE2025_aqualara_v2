<?php

namespace App\Http\Controllers\Decompte;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf;

class WordDocumentController extends Controller
{
    public function upload()
    {
        return view('decompte.word.upload');
    }

    public function process(Request $request)
    {
        $request->validate([
            'template' => 'required|string'
        ]);

        // Récupérer les données du formulaire
        $data = $request->except('_token', 'template');
        
        // Générer la vue HTML
        $html = View::make('decompte.word.templates.' . $request->template, $data)->render();
        
        // Stocker temporairement le HTML
        session(['document_html' => $html]);

        return view('decompte.word.preview', [
            'html' => $html
        ]);
    }

    public function update(Request $request)
    {
        $html = session('document_html');
        if (!$html) {
            return redirect()->back()->with('error', 'Document non trouvé');
        }

        // Mettre à jour les données
        $data = $request->except('_token');
        $html = View::make('decompte.word.templates.' . $request->template, $data)->render();
        
        // Mettre à jour la session
        session(['document_html' => $html]);

        return view('decompte.word.preview', [
            'html' => $html
        ]);
    }

    public function convertToPdf(Request $request)
    {
        $html = session('document_html');
        if (!$html) {
            return redirect()->back()->with('error', 'Document non trouvé');
        }

        // Générer le PDF
        $pdf = PDF::loadHTML($html);
        
        // Télécharger le PDF
        return $pdf->download('document.pdf');
    }
} 