<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventTechnicien;
use App\Models\Technicien;
use App\Models\TypeEvent;
use Carbon\Carbon;
use stdClass;

class CalendarController extends Controller
{
    public function index()
    {
        $techniciensOptions = Technicien::orderBy('nom')->get();
        $typeEventsOptions = TypeEvent::all();
        $events = Event::where('start', null)->get();





        //dd($events);



        return view('calendar.index', [
            'techniciensOptions' => $techniciensOptions,
            'typeEventsOptions' => $typeEventsOptions,
            'events' => $events,
            //'event'=>$event,
        ]);
    }


}
