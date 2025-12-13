<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Pedido;
use App\Models\Factura;

class MenuController extends Controller
{
    public function index()
    {
        // Categorías de productos
        $categorias = [
            'entradas' => [
                'nombre' => '🍤 Entradas',
                'productos' => [
                    [
                        'id' => 1,
                        'nombre' => 'Ceviche Mixto',
                        'descripcion' => 'Pescado, mariscos, cebolla, cilantro, limón',
                        'precio' => 25.00,
                        'imagen' => '🥗'
                    ],
                    [
                        'id' => 2,
                        'nombre' => 'Tequeños',
                        'descripcion' => '12 unidades con salsa de ajo',
                        'precio' => 18.00,
                        'imagen' => '🥟'
                    ],
                    [
                        'id' => 3,
                        'nombre' => 'Choros a la Chalaca',
                        'descripcion' => 'Con cebolla, tomate y maíz',
                        'precio' => 22.00,
                        'imagen' => '🐚'
                    ]
                ]
            ],
            'platos_principales' => [
                'nombre' => '🍛 Platos Principales',
                'productos' => [
                    [
                        'id' => 4,
                        'nombre' => 'Lomo Saltado',
                        'descripcion' => 'Trozos de lomo, cebolla, tomate, papas fritas',
                        'precio' => 35.00,
                        'imagen' => '🥩'
                    ],
                    [
                        'id' => 5,
                        'nombre' => 'Arroz con Mariscos',
                        'descripcion' => 'Arroz con mix de mariscos y ají amarillo',
                        'precio' => 32.00,
                        'imagen' => '🍤'
                    ],
                    [
                        'id' => 6,
                        'nombre' => 'Aji de Gallina',
                        'descripcion' => 'Pollo desmenuzado en salsa de ají amarillo',
                        'precio' => 28.00,
                        'imagen' => '🍗'
                    ],
                    [
                        'id' => 7,
                        'nombre' => 'Parrillada Mixta',
                        'descripcion' => 'Carne, pollo, chorizo y verduras a la parrilla',
                        'precio' => 45.00,
                        'imagen' => '🔥'
                    ]
                ]
            ],
            'bebidas' => [
                'nombre' => '🥤 Bebidas',
                'productos' => [
                    [
                        'id' => 8,
                        'nombre' => 'Chicha Morada',
                        'descripcion' => 'Refrescante bebida de maíz morado',
                        'precio' => 8.00,
                        'imagen' => '🍇'
                    ],
                    [
                        'id' => 9,
                        'nombre' => 'Inca Kola',
                        'descripcion' => 'Bebida gaseosa peruana',
                        'precio' => 6.00,
                        'imagen' => '🥤'
                    ],
                    [
                        'id' => 10,
                        'nombre' => 'Pisco Sour',
                        'descripcion' => 'Coctel tradicional peruano',
                        'precio' => 15.00,
                        'imagen' => '🍸'
                    ]
                ]
            ],
            'postres' => [
                'nombre' => '🍰 Postres',
                'productos' => [
                    [
                        'id' => 11,
                        'nombre' => 'Mazamorra Morada',
                        'descripcion' => 'Dulce tradicional con maíz morado',
                        'precio' => 12.00,
                        'imagen' => '🍮'
                    ],
                    [
                        'id' => 12,
                        'nombre' => 'Suspiro a la Limeña',
                        'descripcion' => 'Manjar blanco con merengue',
                        'precio' => 14.00,
                        'imagen' => '🍯'
                    ]
                ]
            ]
        ];

        return view('menu.index', compact('categorias'));
    }

    public function show($id)
    {
        // Para vista individual de producto (puedes expandir esto)
        return view('menu.show', ['productoId' => $id]);
    }

    /**
     * Procesar pedido desde el menú y generar factura automáticamente
     */
    public function procesarPedido(Request $request)
    {
        $user = auth()->user();
        
        // Validar los datos del pedido
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|integer',
            'items.*.nombre' => 'required|string',
            'items.*.precio' => 'required|numeric',
            'items.*.cantidad' => 'required|integer|min:1'
        ]);

        // Calcular totales
        $subtotal = 0;
        $itemsPedido = [];

        foreach ($request->items as $item) {
            $itemTotal = $item['precio'] * $item['cantidad'];
            $subtotal += $itemTotal;
            
            $itemsPedido[] = [
                'id' => $item['id'],
                'nombre' => $item['nombre'],
                'precio' => $item['precio'],
                'cantidad' => $item['cantidad'],
                'total' => $itemTotal
            ];
        }

        $impuestos = $subtotal * 0.18; // 18% IGV
        $total = $subtotal + $impuestos;

        try {
            // Crear el pedido
            $pedido = Pedido::create([
                'user_id' => $user->id,
                'total' => $total,
                'estado' => 'confirmado',
                'items' => json_encode($itemsPedido),
                'notas' => $request->notas ?? ''
            ]);

            // Crear la factura automáticamente
            $factura = Factura::create([
                'numero' => 'FAC-' . date('Ymd') . '-' . str_pad(Factura::count() + 1, 4, '0', STR_PAD_LEFT),
                'user_id' => $user->id,
                'pedido_id' => $pedido->id,
                'subtotal' => $subtotal,
                'impuestos' => $impuestos,
                'total' => $total,
                'estado' => 'pendiente',
                'fecha_emision' => now(),
                'fecha_vencimiento' => now()->addDays(7),
                'concepto' => 'Pedido #' . $pedido->id . ' - ' . count($itemsPedido) . ' items',
                'items' => json_encode($itemsPedido)
            ]);

            return response()->json([
                'success' => true,
                'message' => '✅ Pedido realizado exitosamente! Factura #' . $factura->numero . ' generada.',
                'factura_id' => $factura->id,
                'pedido_id' => $pedido->id,
                'factura_numero' => $factura->numero,
                'total' => $total
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '❌ Error al procesar el pedido: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mostrar detalles de un pedido específico
     */
    public function verPedido($id)
    {
        $pedido = Pedido::where('id', $id)
                       ->where('user_id', auth()->id())
                       ->firstOrFail();

        return view('menu.ver-pedido', compact('pedido'));
    }
}