<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{
    public function index()
    {
        // Obtenemos todos los tickets
        $tickets = Ticket::all();

        // Validar si hay tickets
        if ($tickets->isEmpty()) {
            return response()->json(['message' => 'No hay tickets'], 200);
        }

        $data = [
            'message' => 'Lista de tickets',
            'data' => $tickets
        ];

        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        // Validar los datos de la petición
        $validator = Validator::make($request->all(), [
            'event_id' => 'required|exists:events,id',
            'customer_id' => 'required|exists:customers,id',
        ]);

        // Validar si hay errores en la validación
        if ($validator->fails()) {
            $data = [
                'message' => 'Error de validación',
                'data' => $validator->errors()
            ];
            return response()->json($data, 400);
        }

        // Crear el ticket
        $ticket = Ticket::create([
            'event_id' => $request->event_id,
            'customer_id' => $request->customer_id,
        ]);

        if (!$ticket) {
            $data = [
                'message' => 'Error al crear el ticket',
                'data' => null
            ];
            return response()->json($data, 500);
        }

        // Crear la orden
        $order = Order::create([
            'ticket_id' => $ticket->id,
            'status' => 'completed',
        ]);

        if (!$order) {
            $data = [
                'message' => 'Error al crear la orden',
                'data' => null
            ];
            return response()->json($data, 500);
        }

        $data = [
            'message' => 'Compra realizada',
            'data' => $order
        ];

        return response()->json($data, 201);
    }

    public function getOrdersByCustomer(Request $request)
    {
        // Validar los datos de la petición
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|exists:customers,id',
        ]);

        // Validar si hay errores en la validación
        if ($validator->fails()) {
            $data = [
                'message' => 'Error de validación',
                'data' => $validator->errors()
            ];
            return response()->json($data, 400);
        }

        // Obtener todos los tickets del cliente
        $tickets = Ticket::where('customer_id', $request->customer_id)->get();

        // Obtener todos los órdenes asociadas a esos tickets
        $orders = Order::whereIn('ticket_id', $tickets->pluck('id'))->get();

        if ($orders->isEmpty()) {
            $data = [
                'message' => 'No hay órdenes para este cliente',
                'data' => []
            ];
            return response()->json($data, 200);
        }

        $data = [
            'message' => 'Órdenes encontradas',
            'data' => $orders
        ];

        return response()->json($data, 200);
    }
}
