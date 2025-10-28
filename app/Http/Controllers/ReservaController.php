<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reserva;

class ReservaController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('reservas.index', compact('user'));
    }

    public function store(Request $request)
    {
        // Validar los datos de la reserva
        $request->validate([
            'fecha' => 'required|date|after_or_equal:today',
            'hora' => 'required',
            'personas' => 'required|integer|min:1|max:20',
            'telefono' => 'required|string|max:15',
            'notas' => 'nullable|string|max:500'
        ]);

        // Crear la reserva
        Reserva::create([
            'user_id' => Auth::id(),
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'personas' => $request->personas,
            'telefono' => $request->telefono,
            'notas' => $request->notas,
            'estado' => 'pendiente'
        ]);

        return redirect()->route('reservas.historial')->with('success', '✅ Reserva realizada correctamente. Te contactaremos para confirmar.');
    }

    public function historial()
    {
        $user = Auth::user();
        $reservas = Reserva::where('user_id', $user->id)
                          ->orderBy('fecha', 'desc')
                          ->orderBy('hora', 'desc')
                          ->get();

        return view('reservas.historial', compact('user', 'reservas'));
    }
}
