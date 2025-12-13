<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú - Restaurante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #2e7d32 0%, #4caf50 25%, #81c784 50%, #a5d6a7 75%, #c8e6c9 100%);
            background-attachment: fixed;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .menu-card {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
            border: none;
        }
        
        .producto-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .producto-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        
        .categoria-section {
            margin-bottom: 3rem;
        }
        
        .categoria-title {
            color: #2e7d32;
            border-bottom: 3px solid #4caf50;
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
        }
        
        .btn-success {
            background: linear-gradient(135deg, #2e7d32, #4caf50);
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 125, 50, 0.4);
        }
        
        .carrito-flotante {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }
        
        .badge-carrito {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ff4444;
            color: white;
            border-radius: 50%;
            padding: 5px 10px;
            font-size: 0.8rem;
        }
        
        .producto-imagen {
            font-size: 3rem;
            text-align: center;
            margin: 1rem 0;
        }
        
        .precio {
            color: #2e7d32;
            font-weight: bold;
            font-size: 1.2rem;
        }
        
        .contador {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 10px 0;
        }
        
        .btn-contador {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="/dashboard">
                <span style="font-size: 1.5rem;">🍽️</span> Restaurante App
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">Hola, {{ Auth::user()->name }}</span>
                <a href="{{ route('pedidos') }}" class="btn btn-outline-light btn-sm me-2">
                    <i class="fas fa-shopping-cart"></i> Mis Pedidos
                </a>
                <a href="{{ route('facturas') }}" class="btn btn-outline-light btn-sm me-2">
                    <i class="fas fa-file-invoice"></i> Mis Facturas
                </a>
                <a href="{{ route('dashboard') }}" class="btn btn-outline-light btn-sm me-2">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="menu-card">
                    <div class="card-header text-center" style="background: linear-gradient(135deg, #2e7d32, #4caf50); color: white; border-radius: 20px 20px 0 0;">
                        <h2><i class="fas fa-utensils"></i> Nuestro Menú</h2>
                        <p class="mb-0">Selecciona los platos para tu pedido - Se generará factura automáticamente</p>
                    </div>
                    <div class="card-body p-4">
                        <!-- Carrito Flotante -->
                        <div class="carrito-flotante">
                            <button class="btn btn-success btn-lg rounded-circle shadow" data-bs-toggle="modal" data-bs-target="#modalCarrito">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="badge-carrito" id="contador-carrito">0</span>
                            </button>
                        </div>

                        @foreach($categorias as $categoriaKey => $categoria)
                        <div class="categoria-section">
                            <h3 class="categoria-title">{{ $categoria['nombre'] }}</h3>
                            <div class="row">
                                @foreach($categoria['productos'] as $producto)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card producto-card h-100">
                                        <div class="card-body">
                                            <div class="producto-imagen">
                                                {{ $producto['imagen'] }}
                                            </div>
                                            <h5 class="card-title">{{ $producto['nombre'] }}</h5>
                                            <p class="card-text text-muted small">{{ $producto['descripcion'] }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="precio">S/ {{ number_format($producto['precio'], 2) }}</span>
                                            </div>
                                            <div class="contador">
                                                <button class="btn btn-outline-secondary btn-sm btn-contador" 
                                                        onclick="cambiarCantidad({{ $producto['id'] }}, -1)">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <span id="cantidad-{{ $producto['id'] }}" class="fw-bold">0</span>
                                                <button class="btn btn-outline-success btn-sm btn-contador" 
                                                        onclick="cambiarCantidad({{ $producto['id'] }}, 1)">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                            <button class="btn btn-success w-100" 
                                                    onclick="agregarAlCarrito({{ $producto['id'] }})">
                                                <i class="fas fa-cart-plus"></i> Agregar al Pedido
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal del Carrito -->
    <div class="modal fade" id="modalCarrito" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="fas fa-shopping-cart"></i> Mi Pedido - Se generará factura automáticamente</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="carrito-vacio" class="text-center py-4">
                        <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Tu carrito está vacío</p>
                    </div>
                    <div id="carrito-contenido" style="display: none;">
                        <div id="lista-carrito"></div>
                        
                        <!-- Campo de notas agregado -->
                        <div class="mb-3 mt-3">
                            <label for="notas-pedido" class="form-label">
                                <i class="fas fa-sticky-note"></i> Notas para el pedido (opcional)
                            </label>
                            <textarea class="form-control" id="notas-pedido" rows="2" 
                                      placeholder="Especificaciones especiales, alergias, instrucciones de preparación, etc."></textarea>
                        </div>

                        <div class="row mt-3">
                            <div class="col-6">
                                <strong>Subtotal:</strong>
                            </div>
                            <div class="col-6 text-end">
                                <strong id="subtotal">S/ 0.00</strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <strong>IGV (18%):</strong>
                            </div>
                            <div class="col-6 text-end">
                                <strong id="igv">S/ 0.00</strong>
                            </div>
                        </div>
                        <div class="row border-top pt-2">
                            <div class="col-6">
                                <h5>Total:</h5>
                            </div>
                            <div class="col-6 text-end">
                                <h5 id="total">S/ 0.00</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Seguir Comprando</button>
                    <button type="button" class="btn btn-success" id="btn-realizar-pedido" onclick="realizarPedido()" disabled>
                        <i class="fas fa-check"></i> Realizar Pedido y Generar Factura
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Carrito de compras
        let carrito = [];
        const productos = {
            @foreach($categorias as $categoria)
                @foreach($categoria['productos'] as $producto)
                    {{ $producto['id'] }}: {
                        id: {{ $producto['id'] }},
                        nombre: "{{ $producto['nombre'] }}",
                        precio: {{ $producto['precio'] }},
                        imagen: "{{ $producto['imagen'] }}"
                    },
                @endforeach
            @endforeach
        };

        function cambiarCantidad(productoId, cambio) {
            const cantidadElement = document.getElementById(`cantidad-${productoId}`);
            let cantidad = parseInt(cantidadElement.textContent) + cambio;
            cantidad = Math.max(0, cantidad);
            cantidadElement.textContent = cantidad;
        }

        function agregarAlCarrito(productoId) {
            const cantidad = parseInt(document.getElementById(`cantidad-${productoId}`).textContent);
            
            if (cantidad === 0) {
                alert('Por favor selecciona al menos 1 unidad');
                return;
            }

            const producto = productos[productoId];
            const itemExistente = carrito.find(item => item.id === productoId);

            if (itemExistente) {
                itemExistente.cantidad += cantidad;
            } else {
                carrito.push({
                    ...producto,
                    cantidad: cantidad
                });
            }

            // Resetear contador
            document.getElementById(`cantidad-${productoId}`).textContent = '0';
            
            actualizarCarrito();
            alert(`✅ ${cantidad} ${producto.nombre} agregado(s) al pedido`);
        }

        function actualizarCarrito() {
            const contador = document.getElementById('contador-carrito');
            const carritoVacio = document.getElementById('carrito-vacio');
            const carritoContenido = document.getElementById('carrito-contenido');
            const listaCarrito = document.getElementById('lista-carrito');
            const btnRealizarPedido = document.getElementById('btn-realizar-pedido');

            // Actualizar contador
            const totalItems = carrito.reduce((sum, item) => sum + item.cantidad, 0);
            contador.textContent = totalItems;

            if (carrito.length === 0) {
                carritoVacio.style.display = 'block';
                carritoContenido.style.display = 'none';
                btnRealizarPedido.disabled = true;
            } else {
                carritoVacio.style.display = 'none';
                carritoContenido.style.display = 'block';
                btnRealizarPedido.disabled = false;

                // Actualizar lista
                listaCarrito.innerHTML = '';
                let subtotal = 0;

                carrito.forEach(item => {
                    const itemTotal = item.precio * item.cantidad;
                    subtotal += itemTotal;

                    listaCarrito.innerHTML += `
                        <div class="row align-items-center mb-2 border-bottom pb-2">
                            <div class="col-2 text-center">${item.imagen}</div>
                            <div class="col-5">
                                <strong>${item.nombre}</strong>
                                <br>
                                <small>S/ ${item.precio.toFixed(2)} c/u</small>
                            </div>
                            <div class="col-3">
                                <div class="input-group input-group-sm">
                                    <button class="btn btn-outline-secondary" onclick="modificarCantidad(${item.id}, -1)">-</button>
                                    <input type="text" class="form-control text-center" value="${item.cantidad}" readonly>
                                    <button class="btn btn-outline-success" onclick="modificarCantidad(${item.id}, 1)">+</button>
                                </div>
                            </div>
                            <div class="col-2 text-end">
                                <strong>S/ ${itemTotal.toFixed(2)}</strong>
                                <br>
                                <button class="btn btn-sm btn-outline-danger mt-1" onclick="eliminarDelCarrito(${item.id})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    `;
                });

                const igv = subtotal * 0.18;
                const total = subtotal + igv;

                document.getElementById('subtotal').textContent = `S/ ${subtotal.toFixed(2)}`;
                document.getElementById('igv').textContent = `S/ ${igv.toFixed(2)}`;
                document.getElementById('total').textContent = `S/ ${total.toFixed(2)}`;
            }
        }

        function modificarCantidad(productoId, cambio) {
            const item = carrito.find(item => item.id === productoId);
            if (item) {
                item.cantidad += cambio;
                if (item.cantidad <= 0) {
                    eliminarDelCarrito(productoId);
                } else {
                    actualizarCarrito();
                }
            }
        }

        function eliminarDelCarrito(productoId) {
            carrito = carrito.filter(item => item.id !== productoId);
            actualizarCarrito();
        }

        function realizarPedido() {
            if (carrito.length === 0) {
                alert('El carrito está vacío');
                return;
            }

            const subtotal = carrito.reduce((sum, item) => sum + (item.precio * item.cantidad), 0);
            const igv = subtotal * 0.18;
            const total = subtotal + igv;
            
            // Preparar datos para enviar al servidor
            const pedidoData = {
                items: carrito.map(item => ({
                    id: item.id,
                    nombre: item.nombre,
                    precio: item.precio,
                    cantidad: item.cantidad
                })),
                notas: document.getElementById('notas-pedido')?.value || ''
            };

            if (confirm(`¿Confirmar pedido por S/ ${total.toFixed(2)}?\n\n✅ Se generará una factura automáticamente`)) {
                // Mostrar loading
                const btn = document.getElementById('btn-realizar-pedido');
                const originalText = btn.innerHTML;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
                btn.disabled = true;

                // Enviar pedido al servidor
                fetch('{{ route("menu.procesar-pedido") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(pedidoData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Mostrar mensaje de éxito con opción de ver factura
                        if (confirm('✅ ' + data.message + '\n\n¿Deseas ver la factura ahora?')) {
                            window.location.href = '/facturas/' + data.factura_id + '/detalles';
                        } else {
                            window.location.href = '/facturas';
                        }
                        
                        // Limpiar carrito
                        carrito = [];
                        actualizarCarrito();
                    } else {
                        alert('❌ ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('❌ Error al procesar el pedido. Por favor intenta nuevamente.');
                })
                .finally(() => {
                    // Restaurar botón
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                    
                    // Cerrar modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('modalCarrito'));
                    modal.hide();
                });
            }
        }

        // Inicializar carrito
        document.addEventListener('DOMContentLoaded', function() {
            actualizarCarrito();
        });
    </script>
</body>
</html>