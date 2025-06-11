<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventTechnicien;
use App\Models\Technicien;
use App\Models\User;
use Illuminate\Http\Request;

class CartographyController extends Controller
{
    public function index()
    {
        $techniciens = Technicien::with('colorTechnicien')->get();
        return view('cartography.index', compact('techniciens'));
    }

    public function getEventsCartography(Request $request)
    {
        $date = $request['date'];
        $events = Event::where('start', 'LIKE', '%'. $date .'%')
            ->whereHas('typeEvent', function($query) {
                $query->where('abreviation', '!=', 'Malade')
                    ->where('abreviation', '!=', 'Congé');
            })
            ->with('client', 'techniciens.colorTechnicien', 'typeEvent')
            ->get();
        return response()->json($events);
    }

    public function getEventTimeline(Request $request)
    {
        $events = Event::where('start', 'LIKE', '%'. $request['date'] .'%')
            ->whereHas('typeEvent', function($query) {
                $query->where('abreviation', '!=', 'Malade')
                    ->where('abreviation', '!=', 'Congé');
            })
            ->whereHas('techniciens', function($query) use ($request) {
                $query->where('technicien_id', $request['technicien_id']);
            })
            ->with('client', 'techniciens.colorTechnicien', 'typeEvent')
            ->get();
        return response()->json($events);
    }

    public function cartographyTechnicien()
    {
    // Retrieve the technician related to the authenticated user
    $technicien = Technicien::where('id', auth()->user()->technicien_id)->first();

    return view('cartography.mapTechnicien', compact('technicien'));
    }



}
