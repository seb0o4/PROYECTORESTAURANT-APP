<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Factura;
use App\Models\Pedido;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function clientes()
    {
        try {
            // Obtener todos los clientes (usuarios que no son admin)
            $clientes = User::where('role', '!=', 'admin')
                          ->orWhereNull('role')
                          ->orderBy('created_at', 'desc')
                          ->paginate(15);

            // Estadísticas
            $totalClientes = User::where('role', '!=', 'admin')->orWhereNull('role')->count();
            $clientesActivos = User::where('role', '!=', 'admin')
                                 ->where('estado', 'activo')
                                 ->orWhereNull('estado')
                                 ->count();

            return view('admin.clientes', compact('clientes', 'totalClientes', 'clientesActivos'));
            
        } catch (\Exception $e) {
            return view('admin.clientes', [
                'clientes' => [],
                'totalClientes' => 0,
                'clientesActivos' => 0
            ]);
        }
    }

    public function verCliente($id)
    {
        try {
            $cliente = User::with(['facturas', 'pedidos', 'reservas'])->findOrFail($id);
            
            // Estadísticas del cliente
            $totalFacturas = $cliente->facturas->count();
            $totalPedidos = $cliente->pedidos->count();
            $totalReservas = $cliente->reservas->count();
            $totalGastado = $cliente->facturas->where('estado', 'pagada')->sum('total');

            return view('admin.cliente-detalles', compact(
                'cliente', 
                'totalFacturas', 
                'totalPedidos', 
                'totalReservas', 
                'totalGastado'
            ));
            
        } catch (\Exception $e) {
            return redirect()->route('admin.clientes')->with('error', 'Cliente no encontrado');
        }
    }

    public function eliminarCliente($id)
    {
        try {
            $cliente = User::findOrFail($id);
            
            // No permitir eliminar el usuario admin actual
            if ($cliente->id === auth()->id()) {
                return redirect()->route('admin.clientes')->with('error', 'No puedes eliminar tu propia cuenta');
            }

            $cliente->delete();

            return redirect()->route('admin.clientes')->with('success', 'Cliente eliminado correctamente');
            
        } catch (\Exception $e) {
            return redirect()->route('admin.clientes')->with('error', 'Error al eliminar el cliente');
        }
    }

    public function actualizarCliente(Request $request, $id)
    {
        try {
            $cliente = User::findOrFail($id);
            
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'phone' => 'nullable|string|max:20',
                'estado' => 'required|in:activo,inactivo'
            ]);

            $cliente->update($validated);

            return redirect()->route('admin.ver-cliente', $id)->with('success', 'Cliente actualizado correctamente');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar el cliente');
        }
    }

    public function crearCliente(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8',
                'phone' => 'nullable|string|max:20'
            ]);

            $cliente = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'phone' => $validated['phone'],
                'role' => 'cliente',
                'estado' => 'activo'
            ]);

            return redirect()->route('admin.clientes')->with('success', 'Cliente creado correctamente');
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al crear el cliente');
        }
    }
}