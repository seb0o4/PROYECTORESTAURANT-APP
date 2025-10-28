<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Pedido;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FacturaController extends Controller
{
    public function index()
    {
        try {
            // Obtener estadísticas de facturas del usuario actual
            $userId = auth()->id();
            
            $totalFacturas = Factura::where('user_id', $userId)->count();
            $facturasPendientes = Factura::where('user_id', $userId)
                                        ->where('estado', 'pendiente')
                                        ->count();
            $totalIngresos = Factura::where('user_id', $userId)
                                   ->where('estado', 'pagada')
                                   ->sum('total');

            // Obtener las facturas recientes del usuario
            $facturasRecientes = Factura::where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

            return view('facturas.index', compact(
                'totalFacturas',
                'facturasPendientes', 
                'totalIngresos',
                'facturasRecientes'
            ));
            
        } catch (\Exception $e) {
            // En caso de error, usar valores por defecto
            return view('facturas.index', [
                'totalFacturas' => 0,
                'facturasPendientes' => 0,
                'totalIngresos' => 0,
                'facturasRecientes' => collect()
            ]);
        }
    }

    public function historial()
    {
        try {
            $userId = auth()->id();
            $facturas = Factura::where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->paginate(15);

            return view('facturas.historial', compact('facturas'));
            
        } catch (\Exception $e) {
            return view('facturas.historial', ['facturas' => []]);
        }
    }

    public function generarPrueba()
    {
        try {
            $userId = auth()->id();
            
            // Generar número de factura único
            $numeroFactura = 'FAC-' . date('Ymd') . '-' . str_pad(Factura::count() + 1, 4, '0', STR_PAD_LEFT);
            
            // Crear factura de prueba
            $factura = new Factura();
            $factura->numero = $numeroFactura;
            $factura->user_id = $userId;
            $factura->pedido_id = 1; // ID de pedido de prueba
            $factura->subtotal = 75.00;
            $factura->impuestos = 13.50;
            $factura->total = 88.50;
            $factura->estado = 'pendiente';
            $factura->fecha_emision = Carbon::now();
            $factura->fecha_vencimiento = Carbon::now()->addDays(7);
            $factura->concepto = 'Pedido de prueba - Ceviche Mixto (3 unidades)';
            $factura->items = json_encode([
                [
                    'id' => 1, 
                    'nombre' => 'Ceviche Mixto', 
                    'precio' => 25.00, 
                    'cantidad' => 3, 
                    'total' => 75.00
                ]
            ]);
            $factura->save();

            return redirect()->route('facturas')->with('success', 'Comprobante de prueba generado correctamente');
            
        } catch (\Exception $e) {
            return redirect()->route('facturas')->with('error', 'Error al generar comprobante: ' . $e->getMessage());
        }
    }

    public function mostrarDetalles($id)
    {
        try {
            $userId = auth()->id();
            
            // Obtener la factura del usuario actual
            $factura = Factura::where('user_id', $userId)
                            ->with(['user', 'pedido'])
                            ->findOrFail($id);

            // Decodificar los items JSON
            $items = json_decode($factura->items, true) ?? [];

            return view('facturas.detalles', compact('factura', 'items'));
            
        } catch (\Exception $e) {
            return back()->with('error', 'Comprobante no encontrado: ' . $e->getMessage());
        }
    }

    public function descargarPDF($id)
    {
        try {
            $userId = auth()->id();
            $factura = Factura::where('user_id', $userId)->findOrFail($id);
            $items = json_decode($factura->items, true) ?? [];
            
            // Por ahora retornamos la vista normal
            // En el futuro puedes implementar generación de PDF aquí
            return view('facturas.detalles', compact('factura', 'items'));
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error al generar PDF: ' . $e->getMessage());
        }
    }

    public function pagar($id)
    {
        try {
            $userId = auth()->id();
            $factura = Factura::where('user_id', $userId)->findOrFail($id);
            
            if ($factura->estado == 'pendiente') {
                $factura->estado = 'pagada';
                $factura->save();
                
                return redirect()->route('facturas')->with('success', 'Comprobante pagado correctamente');
            }
            
            return redirect()->route('facturas')->with('error', 'El comprobante ya está pagado');
            
        } catch (\Exception $e) {
            return redirect()->route('facturas')->with('error', 'Error al procesar el pago');
        }
    }

    public function getDetalles($id)
    {
        try {
            $userId = auth()->id();
            $factura = Factura::where('user_id', $userId)
                            ->with(['user', 'pedido'])
                            ->findOrFail($id);

            $items = json_decode($factura->items, true) ?? [];

            // Retornar JSON para peticiones AJAX
            return response()->json([
                'success' => true,
                'factura' => $factura,
                'items' => $items
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Comprobante no encontrado'
            ], 404);
        }
    }
}