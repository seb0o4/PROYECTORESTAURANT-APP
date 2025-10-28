<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura #{{ $factura->numero }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg">
            <!-- Header -->
            <div class="bg-blue-600 text-white p-6 rounded-t-lg">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold">FACTURA</h1>
                        <p class="text-blue-100">Número: {{ $factura->numero }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-lg">Restaurant App</p>
                        <p class="text-blue-100">Sistema de Gestión</p>
                    </div>
                </div>
            </div>

            <!-- Información de la factura -->
            <div class="p-6 border-b">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <h3 class="font-semibold text-gray-700">Información del Cliente</h3>
                        <p class="text-gray-600">Cliente: {{ $factura->user->name ?? 'N/A' }}</p>
                        <p class="text-gray-600">Email: {{ $factura->user->email ?? 'N/A' }}</p>
                        <p class="text-gray-600">ID Usuario: {{ $factura->user_id }}</p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-700">Detalles de Factura</h3>
                        <p class="text-gray-600">Fecha Emisión: {{ $factura->fecha_emision->format('d/m/Y H:i') }}</p>
                        <p class="text-gray-600">Fecha Vencimiento: {{ $factura->fecha_vencimiento->format('d/m/Y H:i') }}</p>
                        <p class="text-gray-600">Estado: 
                            <span class="px-2 py-1 rounded-full text-xs font-semibold 
                                {{ $factura->estado == 'pagada' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($factura->estado) }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Concepto -->
            <div class="p-6 border-b">
                <h3 class="font-semibold text-gray-700 mb-2">Concepto</h3>
                <p class="text-gray-600">{{ $factura->concepto }}</p>
            </div>

            <!-- Items -->
            <div class="p-6 border-b">
                <h3 class="font-semibold text-gray-700 mb-4">Detalles del Pedido</h3>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-2 text-left">Producto</th>
                                <th class="px-4 py-2 text-center">Cantidad</th>
                                <th class="px-4 py-2 text-right">Precio Unitario</th>
                                <th class="px-4 py-2 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $index => $item)
                            <tr class="border-b">
                                <td class="px-4 py-3">{{ $item['nombre'] ?? 'Producto ' . ($index + 1) }}</td>
                                <td class="px-4 py-3 text-center">{{ $item['cantidad'] ?? 1 }}</td>
                                <td class="px-4 py-3 text-right">${{ number_format($item['precio'] ?? 0, 2) }}</td>
                                <td class="px-4 py-3 text-right">${{ number_format($item['total'] ?? 0, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Totales -->
            <div class="p-6">
                <div class="flex justify-end">
                    <div class="w-64">
                        <div class="flex justify-between py-2">
                            <span class="font-semibold">Subtotal:</span>
                            <span>${{ number_format($factura->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="font-semibold">Impuestos:</span>
                            <span>${{ number_format($factura->impuestos, 2) }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-t border-gray-300">
                            <span class="font-semibold text-lg">Total:</span>
                            <span class="font-bold text-lg">${{ number_format($factura->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 p-6 rounded-b-lg">
                <div class="text-center text-gray-600">
                    <p>Gracias por su compra</p>
                    <p class="text-sm">Para consultas, contacte a soporte@restaurantapp.com</p>
                </div>
                <div class="mt-4 flex justify-center space-x-4">
                    <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Imprimir Factura
                    </button>
                    <a href="/facturas" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                        Volver a Facturas
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>