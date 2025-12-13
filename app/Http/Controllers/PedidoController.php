<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('pedidos.index', compact('user'));
    }

    public function historial()
    {
        $user = Auth::user();
        return view('pedidos.historial', compact('user'));
    }

    public function store(Request $request)
    {
        // Lógica para guardar pedidos
        return redirect()->route('pedidos')->with('success', 'Pedido realizado correctamente');
    }
}