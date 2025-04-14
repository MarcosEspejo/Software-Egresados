<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event; // Asegúrate de tener un modelo Event

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all(); // O cualquier lógica para obtener los eventos
        return view('events.index', compact('events'));
    }
}
