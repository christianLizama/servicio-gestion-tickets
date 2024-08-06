<?php

namespace App\Http\Controllers;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        // Obtenemos todos los eventos
        $events = Event::all();
        
        // Validar si hay eventos
        if($events->isEmpty()){
            return response()->json(['message' => 'No hay eventos'], 200);
        }

        $data = [
            'message' => 'Lista de eventos',
            'data' => $events
        ];

        return response()->json($data, 200);
    }
    public function show($id)
    {
        // Buscamos el evento por id
        $event = Event::find($id);

        // Validar si existe el evento
        if(!$event){
            return response()->json(['message' => 'Evento no encontrado'], 404);
        }

        $data = [
            'message' => 'Evento encontrado',
            'data' => $event
        ];

        return response()->json($data, 200);
    }
}
