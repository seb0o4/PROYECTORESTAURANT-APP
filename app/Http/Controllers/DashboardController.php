<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Datos temporales para que funcione
        $pedidosActivos = 0;
        $reservasActivas = 0;
        $totalGastado = 0;
        $facturasRecientes = collect([]); // Colección vacía

        // Si los modelos existen, usar los datos reales
        if (class_exists('App\Models\Pedido')) {
            try {
                $pedidosActivos = \App\Models\Pedido::where('user_id', $user->id)
                    ->whereIn('estado', ['pendiente', 'confirmado', 'preparando'])
                    ->count();
            } catch (\Exception $e) {
                $pedidosActivos = 0;
            }
        }

        if (class_exists('App\Models\Factura')) {
            try {
                $totalGastado = \App\Models\Factura::where('user_id', $user->id)
                    ->where('estado', 'pagada')
                    ->sum('total');
                    
                $facturasRecientes = \App\Models\Factura::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();
            } catch (\Exception $e) {
                $totalGastado = 0;
                $facturasRecientes = collect([]);
            }
        }

        return view('dashboard', compact(
            'user', 
            'pedidosActivos', 
            'reservasActivas', 
            'totalGastado',
            'facturasRecientes'
        ));
    }
}