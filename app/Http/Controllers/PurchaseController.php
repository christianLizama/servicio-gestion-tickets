<?php

namespace App\Http\Controllers;
use App\Models\Ticket;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'event_id' => 'required|exists:events,id',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            $data = [
                'message' => 'Error de validación',
                'data' => $validator->errors()
            ];
            return response()->json($data, 400);
        }

        $ticket = Ticket::create([
            'event_id' => $request->event_id,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
        ]);

        if (!$ticket) {
            $data = [
                'message' => 'Error al crear el ticket',
                'data' => null
            ];
            return response()->json($data, 500);
        }

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
}
