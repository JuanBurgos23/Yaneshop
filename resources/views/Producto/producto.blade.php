<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Estilo general del contenedor del select2 */
        .select2-container--bootstrap-5 .select2-selection {
            background-color: #fff !important;
            border: 1px solid #ced4da !important;
            border-radius: 0.375rem !important;
            min-height: 38px;
            padding: 0.375rem 0.75rem !important;
            font-size: 1rem;
            display: flex !important;
            align-items: center;
        }

        /* Texto seleccionado */
        .select2-container--bootstrap-5 .select2-selection__rendered {
            color: #212529 !important;
            line-height: normal !important;
            padding-right: 2rem !important;
            /* Espacio para la X */
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Botón de limpiar (la "X") */
        .select2-container--bootstrap-5 .select2-selection__clear {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1rem;
            color: #dc3545;
            cursor: pointer;
        }

        /* Opciones del dropdown */
        .select2-container--bootstrap-5 .select2-results__option {
            color: #212529 !important;
        }

        /* Evitar que el texto se desborde */
        .select2-container--bootstrap-5 .select2-selection__rendered {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Soluciona el ancho completo del select2 dentro de Bootstrap grid */
        .select2-container {
            width: 100% !important;
        }

        /*modal agregar producto*/
        #preview .img-preview,
        #preview-nuevas-imagenes .img-preview {
            position: relative;
            animation: fadeIn 0.5s ease-in-out;
        }

        #preview .img-preview img,
        #preview-nuevas-imagenes .img-preview img {
            max-width: 120px;
            max-height: 120px;
            border-radius: 8px;
            object-fit: cover;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }

        #preview .img-preview button,
        #preview-nuevas-imagenes .img-preview button {
            position: absolute;
            top: 2px;
            right: 2px;
            background-color: rgba(0, 0, 0, 0.6);
            border: none;
            color: white;
            font-size: 0.8rem;
            padding: 2px 6px;
            border-radius: 50%;
            cursor: pointer;
        }


        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        /*inpiut imganes*/
        input[type="file"]::file-selector-button {
            background-color: #0d6efd;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            cursor: pointer;
        }

        input[type="file"]:hover::file-selector-button {
            background-color: #0b5ed7;
        }

        input[type="file"] {
            color: rgb(226, 231, 236) !important;
        }

        #tituloProductoModal {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .descripcion {
            width: 810px;
            min-height: 20px;
            field-sizing: content;
        }

        .descripcionEdit {

            field-sizing: content;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @extends('layouts.suscripcionAviso')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl">
            <!-- Navbar content -->
        </nav>
        <div class="container-fluid py-4" style="margin-top: 40px;"> <!-- Se añade un margen superior aquí -->
            @if(session('success'))
            <div class="alert alert-success" id="successMessage">
                {{ session('success') }}
            </div>
            <script>
                // Después de 3 segundos (3000 ms), eliminar el mensaje
                setTimeout(function() {
                    const successMessage = document.getElementById('successMessage');
                    if (successMessage) {
                        successMessage.style.display = 'none';
                    }
                }, 3000);
            </script>
            @endif

            <div class="col-12">

                <div class="card my-4">

                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <h2>Listado de Productos</h2>
                    </div>

                    <div class="me-3 my-3 text-end">
                        <!-- Contenedor principal con flexbox -->
                        <div class="d-flex align-items-center">

                            <!-- Botón Agregar Cliente al mismo nivel que el formulario, con margen izquierdo -->
                            <button class="btn btn-primary ms-3" style="margin-left: 20px;" data-bs-toggle="modal" data-bs-target="#addModal">
                                <i class="fa fa-plus"></i> Agregar Producto
                            </button>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <div class="select-categorias-wrapper p-2">
                                <form method="GET" action="{{ route('productos') }}" class="d-flex flex-wrap align-items-center gap-2">
                                    <label for="categorias" class="me-2 flex-shrink-0">Filtrar por Categorías:</label>
                                    <select name="categorias[]" id="categorias" class="form-select select2 flex-grow-1" multiple></select>

                                    <div class="d-flex flex-wrap gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-search"></i> Filtrar
                                        </button>
                                        <a href="{{ route('productos') }}" class="btn btn-secondary">
                                            <i class="fa fa-list"></i> Mostrar Todos
                                        </a>
                                        <a href="{{ route('productos.exportar', ['categorias' => request()->input('categorias', [])]) }}" class="btn btn-success">
                                            <i class="fas fa-file-pdf"></i> Exportar PDF
                                        </a>
                                    </div>
                                </form>
                            </div>
                            <style>
                                /* Ajustes Select2 Bootstrap 5 */
                                #categorias+.select2-container--bootstrap-5 .select2-selection {
                                    min-height: 36px !important;
                                    padding: 0.25rem 0.5rem !important;
                                    font-size: 0.875rem !important;
                                }

                                #categorias+.select2-container--bootstrap-5 .select2-selection__rendered {
                                    padding-right: 1.5rem !important;
                                    font-size: 0.875rem !important;
                                }

                                #categorias+.select2-container--bootstrap-5 .select2-selection__clear {
                                    font-size: 0.875rem;
                                    right: 0.75rem;
                                }

                                /* Responsive: ancho completo en móviles */
                                @media (max-width: 768px) {
                                    #categorias~.select2-container--bootstrap-5 {
                                        width: 100% !important;
                                    }

                                    .select-categorias-wrapper form .d-flex.flex-wrap {
                                        flex-direction: column;
                                        align-items: stretch;
                                        gap: 0.5rem;
                                    }

                                    .select-categorias-wrapper form .d-flex.flex-wrap .d-flex.flex-wrap.gap-2 {
                                        justify-content: flex-start;
                                        flex-wrap: wrap;
                                    }

                                    .select-categorias-wrapper form .btn {
                                        width: 100%;
                                    }
                                }
                            </style>
                            <script>
                                const categoriasSeleccionadas = @json($categoriasSeleccionadas ?? []); // desde el controlador
                                const todasLasCategorias = @json($todasLasCategorias ?? []);

                                // Pre-cargar las seleccionadas en Select2
                                categoriasSeleccionadas.forEach(id => {
                                    const categoria = todasLasCategorias.find(c => c.id == id);
                                    if (categoria) {
                                        const option = new Option(`${categoria.nombre} - ${categoria.descripcion}`, categoria.id, true, true);
                                        $('#categorias').append(option).trigger('change');
                                    }
                                });
                            </script>

                            <div class="table-responsive">
                                <table class="table align-items-center mb-0 table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="text-center">Categoría / Subcategoría</th>
                                            <th class="text-center">Producto</th>
                                            <th class="text-center">Precio (Bs.)</th>
                                            <th class="text-center">Precio Oferta (Bs.)</th>
                                            <th class="text-center">Descripción</th>
                                            <th class="text-center">Stock</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($productos as $producto)
                                        <tr>
                                            <td class="text-center">
                                                {{ $producto->categoria->nombre ?? 'Sin categoría' }} /
                                                {{ $producto->subcategoria->nombre ?? 'Sin subcategoría' }}
                                            </td>
                                            <td class="text-center">{{ $producto->nombre }}</td>
                                            <td class="text-center">{{ number_format($producto->precio, 2) }}</td>
                                            <td class="text-center">{{ number_format($producto->precio_oferta, 2) }}</td>
                                            <td class="text-center text-truncate" style="max-width: 200px;" title="{{ $producto->descripcion }}">
                                                {{ $producto->descripcion }}
                                            </td>
                                            <td class="text-center">{{ $producto->cantidad }}</td>
                                            <td class="text-center">
                                                @if($producto->estado === 'activo')
                                                <span class="badge bg-success">Activo</span>
                                                @else
                                                <span class="badge bg-danger">Inactivo</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal" data-id="{{ $producto->id }}">
                                                    <i class="fa fa-edit"></i> Editar
                                                </button>

                                                <form action="{{ route('productos.eliminar', $producto->id) }}" method="POST" class="d-inline" onsubmit="return confirmarEliminacion(event)">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fa fa-trash"></i> Eliminar
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No hay productos registrados.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>


                            <div class="d-flex justify-content-center mt-4">
                                {{ $productos->links('pagination::bootstrap-4') }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal de Agregar producto -->
            <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content shadow-lg rounded-3">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="addModalLabel">Agregar Nuevo Producto</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <form action="/producto-register" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="nombre" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="precio" class="form-label">Precio (Bs.)</label>
                                        <input type="number" step="0.01" class="form-control" id="precio" name="precio" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="precioOferta" class="form-label">Precio Oferta (Bs.) Opcional</label>
                                        <input type="number" step="0.01" class="form-control" id="precioOferta" name="precio_oferta">
                                        <div id="precioOfertaError" class="text-danger mt-1" style="display:none;">El precio de oferta debe ser menor que el precio normal.</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="oferta_tipo" class="form-label">Tipo de Oferta (Opcional)</label>
                                        <div style="display:flex; gap:4px; align-items:center;">
                                            <input type="number" min="1" class="form-control oferta-num" id="oferta_num1" placeholder="2">
                                            <span style="font-weight:bold;">X</span>
                                            <input type="number" min="1" class="form-control oferta-num" id="oferta_num2" placeholder="1">
                                        </div>
                                        <!-- input oculto que se enviará al backend -->
                                        <input type="hidden" name="oferta_tipo" id="oferta_tipo">
                                        <small class="text-muted">Formato permitido: número X número (ej: 2 X 1)</small>
                                    </div>
                                    <div class="col-md-6" id="precio_oferta_tipo_container" style="display:none; opacity:0; transition: all 0.3s ease;">
                                        <label for="precio_oferta_tipo" class="form-label">Precio Oferta de Cantidad (Bs.)</label>
                                        <input type="number" step="0.01" class="form-control" id="precio_oferta_tipo" name="precio_oferta_tipo" placeholder="Precio total para la oferta">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="descripcion" class="form-label">Descripción</label>
                                        <textarea class="form-control descripcion" id="descripcion" name="descripcion"></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="cantidad" class="form-label">Cantidad</label>
                                        <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="categoria" class="form-label">Categoría</label>
                                        <div style="display: flex; gap: 0.5rem; align-items: center;">
                                            <select id="categoria" name="categoria_id" class="select2 w-100" required>
                                                <!-- Opciones dinámicas -->
                                            </select>
                                            <button type="button" class="btn btn-success btn-sm"
                                                title="Agregar Categoría"
                                                onclick="window.location.href='/categoria'">
                                                +</i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="subcategoria" class="form-label">Subcategoría</label>
                                        <select id="subcategoria" name="subcategoria_id" class="select2 w-100" required>
                                            <!-- Las opciones se cargarán dinámicamente -->
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="archivos" class="form-label">Archivos del producto (imágenes o videos)</label>
                                        <input type="file" class="form-control" id="archivos" name="archivos[]" multiple accept="image/*,video/*">
                                        <div id="preview" class="d-flex flex-wrap gap-3 mt-2"></div>
                                    </div>
                                </div>
                                <div class="modal-footer mt-4">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-success">Agregar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal de Editar prooducto -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="editModalLabel">Editar Producto</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Formulario de editar producto -->
                            <form action="" method="POST" id="editForm" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="edit_nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="edit_nombre" name="nombre" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_precio" class="form-label">Precio (Bs.)</label>
                                    <input type="number" step="0.01" class="form-control" id="edit_precio" name="precio" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_precioOferta" class="form-label">Precio Oferta (Bs.) Opcional</label>
                                    <input type="number" step="0.01" class="form-control" id="edit_precioOferta" name="precio_oferta">
                                    <div id="edit_precioOfertaError" class="text-danger mt-1" style="display:none;">
                                        El precio de oferta debe ser menor que el precio normal.
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_oferta_tipo" class="form-label">Tipo de Oferta (Opcional)</label>
                                    <div style="display:flex; gap:4px; align-items:center;">
                                        <input type="number" min="1" class="form-control oferta-num" id="edit_oferta_num1" placeholder="2">
                                        <span style="font-weight:bold;">X</span>
                                        <input type="number" min="1" class="form-control oferta-num" id="edit_oferta_num2" placeholder="1">
                                    </div>
                                    <!-- input oculto que se enviará al backend -->
                                    <input type="hidden" name="oferta_tipo" id="edit_oferta_tipo">
                                    <small class="text-muted">Formato permitido: número X número (ej: 2 X 1)</small>
                                </div>
                                <div class="mb-3" id="edit_precio_oferta_tipo_container" style="display:none; opacity:0; transition: all 0.3s ease;">
                                    <label for="edit_precio_oferta_tipo" class="form-label">Precio Oferta de Cantidad (Bs.)</label>
                                    <input type="number" step="0.01" class="form-control" id="edit_precio_oferta_tipo" name="precio_oferta_tipo" placeholder="Precio total para la oferta">
                                </div>
                                <div class="mb-3">
                                    <label for="edit_descripcion" class="form-label">Descripción</label>
                                    <textarea class="form-control descripcionEdit" id="edit_descripcion" name="descripcion"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_cantidad" class="form-label">Cantidad</label>
                                    <input type="number" class="form-control" id="edit_cantidad" name="cantidad" required>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_categoria" class="form-label">Categoría</label>
                                    <select id="edit_categoria" name="categoria_id" class="form-select select2" style="width: 100%" required>
                                        <!-- Las opciones se agregarán dinámicamente -->
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_subcategoria" class="form-label">Subcategoría</label>
                                    <select id="edit_subcategoria" name="subcategoria_id" class="form-select select2" style="width: 100%" required>
                                        <!-- Las opciones se agregarán dinámicamente -->
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="estado" class="form-label">Estado</label>
                                    <select id="estado" name="estado" class="form-control" required>
                                        <option value="activo">Activo</option>
                                        <option value="inactivo">Inactivo</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_nuevas_imagenes" class="form-label">Agregar nuevas imágenes</label>
                                    <input type="file" name="imagenes[]" id="edit_nuevas_imagenes" class="form-control" multiple accept="image/*,video/*">
                                </div>
                                <div id="preview-nuevas-imagenes" class="d-flex flex-wrap gap-2 mt-2"></div>
                                <div class="mb-3">
                                    <label class="form-label">Imágenes actuales</label>
                                    <div id="imagenes-actuales" class="d-flex flex-wrap gap-2"></div>
                                </div>
                                <!-- Aquí puedes agregar más campos según sea necesario -->

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Actualizar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal para ver imagen ampliada -->
            <div class="modal fade" id="visorImagenModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width: 600px;">
                    <div class="modal-content border border-light rounded-3 overflow-hidden">

                        <!-- Barra superior con fondo gris y botón "X" -->
                        <div class="d-flex justify-content-end align-items-center bg-light p-2" style="border-bottom: 1px solid #ccc;">
                            <div class="flex-grow-1 text-center fw-semibold text-dark" id="tituloProductoModal" style="margin-right: 2rem;">
                                <!-- Aquí irá el nombre del producto -->
                            </div>
                            <button type="button"
                                class="btn-close"
                                data-bs-dismiss="modal"
                                aria-label="Cerrar">
                            </button>
                        </div>

                        <!-- Imagen con borde inferior redondeado -->
                        <div class="bg-dark d-flex justify-content-center align-items-center p-3">
                            <img id="imagenGrande"
                                src=""
                                alt="Vista previa"
                                class="img-fluid rounded"
                                style="max-height: 80vh; object-fit: contain; display: none;">

                            <video id="videoGrande"
                                controls
                                class="rounded"
                                style="max-height: 80vh; display: none;">
                                <source src="" type="video/mp4">
                                Tu navegador no soporta videos HTML5.
                            </video>
                        </div>

                    </div>
                </div>
            </div>


            <!-- Select2 CSS -->
            <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
            <!-- Select2 Bootstrap 5 Theme -->
            <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

            <!-- jQuery (antes de Select2) -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <!-- Select2 JS -->
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <!-- Scripts -->
            <script>
                const editPrecioInput = document.getElementById('edit_precio');
                const editPrecioOfertaInput = document.getElementById('edit_precioOferta');
                const editErrorDiv = document.getElementById('edit_precioOfertaError');

                function validarEditPrecioOferta() {
                    const precio = parseFloat(editPrecioInput.value) || 0;
                    const precioOferta = parseFloat(editPrecioOfertaInput.value) || 0;

                    if (precioOferta > 0 && precioOferta >= precio) {
                        // Mostrar error y evitar enviar
                        editErrorDiv.style.display = 'block';
                        editPrecioOfertaInput.setCustomValidity('El precio de oferta debe ser menor que el precio normal.');
                    } else {
                        editErrorDiv.style.display = 'none';
                        editPrecioOfertaInput.setCustomValidity('');
                    }
                }

                // Validar en tiempo real al cambiar los valores
                editPrecioInput.addEventListener('input', validarEditPrecioOferta);
                editPrecioOfertaInput.addEventListener('input', validarEditPrecioOferta);
            </script>
            <script>
                const precioInput = document.getElementById('precio');
                const precioOfertaInput = document.getElementById('precioOferta');
                const errorDiv = document.getElementById('precioOfertaError');

                function validarPrecioOferta() {
                    const precio = parseFloat(precioInput.value) || 0;
                    const precioOferta = parseFloat(precioOfertaInput.value) || 0;

                    if (precioOferta > 0 && precioOferta >= precio) {
                        // Mostrar error y deshabilitar botón enviar
                        errorDiv.style.display = 'block';
                        precioOfertaInput.setCustomValidity('El precio de oferta debe ser menor que el precio normal.');
                    } else {
                        // Todo bien
                        errorDiv.style.display = 'none';
                        precioOfertaInput.setCustomValidity('');
                    }
                }

                // Validar en tiempo real al escribir
                precioInput.addEventListener('input', validarPrecioOferta);
                precioOfertaInput.addEventListener('input', validarPrecioOferta);
            </script>
            <script>
                const num1 = document.getElementById('oferta_num1');
                const num2 = document.getElementById('oferta_num2');
                const precioContainer = document.getElementById('precio_oferta_tipo_container');
                const precioInput = document.getElementById('precio_oferta_tipo');
                const ofertaHidden = document.getElementById('oferta_tipo');

                function actualizarOferta() {
                    const val1 = parseInt(num1.value);
                    const val2 = parseInt(num2.value);

                    if (val1 > 0 && val2 > 0) {
                        // Mostrar con animación suave
                        precioContainer.style.display = 'block';
                        setTimeout(() => precioContainer.style.opacity = 1, 10);

                        // Actualizar el input oculto
                        ofertaHidden.value = `${val1}x${val2}`;
                    } else {
                        // Ocultar suavemente
                        precioContainer.style.opacity = 0;
                        setTimeout(() => {
                            precioContainer.style.display = 'none';
                            precioInput.value = '';
                            ofertaHidden.value = '';
                        }, 300);
                    }
                }

                // Escuchar cambios en ambos inputs
                num1.addEventListener('input', actualizarOferta);
                num2.addEventListener('input', actualizarOferta);

                function confirmarEliminacion(event) {
                    event.preventDefault();
                    const form = event.target;

                    Swal.fire({
                        title: '¿Eliminar producto?',
                        text: 'El estado del producto cambiará a Eliminado.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });

                    return false;
                }
            </script>
            <script>
                function cargarOfertaEdicion(producto) {
                    const oferta_tipo = producto.oferta_tipo || '';
                    const precio_oferta_tipo = producto.precio_oferta_tipo || '';

                    const container = document.getElementById('edit_precio_oferta_tipo_container');
                    const inputPrecio = document.getElementById('edit_precio_oferta_tipo');
                    const inputHidden = document.getElementById('edit_oferta_tipo');

                    const inputNum1 = document.getElementById('edit_oferta_num1');
                    const inputNum2 = document.getElementById('edit_oferta_num2');

                    if (oferta_tipo && oferta_tipo.includes('x')) {
                        const partes = oferta_tipo.split('x');
                        inputNum1.value = partes[0] || '';
                        inputNum2.value = partes[1] || '';

                        // Mostrar precio de oferta con animación
                        container.style.display = 'block';
                        setTimeout(() => container.style.opacity = 1, 10);

                        inputPrecio.value = precio_oferta_tipo;
                    } else {
                        container.style.opacity = 0;
                        setTimeout(() => container.style.display = 'none', 300);
                        inputNum1.value = '';
                        inputNum2.value = '';
                        inputPrecio.value = '';
                    }

                    // Actualizar input oculto
                    inputHidden.value = oferta_tipo;

                    // Escuchar cambios en los inputs numéricos
                    [inputNum1, inputNum2].forEach(input => {
                        input.addEventListener('input', () => {
                            const val1 = inputNum1.value || '';
                            const val2 = inputNum2.value || '';
                            if (val1 && val2) {
                                inputHidden.value = `${val1}x${val2}`;
                                // Mostrar precio de oferta si no visible
                                if (container.style.display === 'none') {
                                    container.style.display = 'block';
                                    setTimeout(() => container.style.opacity = 1, 10);
                                }
                            } else {
                                inputHidden.value = '';
                                container.style.opacity = 0;
                                setTimeout(() => container.style.display = 'none', 300);
                                inputPrecio.value = '';
                            }
                        });
                    });
                }
                const editModal = document.getElementById('editModal');
                editModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const id = button.getAttribute('data-id');
                    const form = document.getElementById('editForm');
                    form.action = '/producto-update/' + id;

                    fetch(`/producto/edit/${id}`)
                        .then(response => response.json())
                        .then(producto => {
                            $('#edit_nombre').val(producto.nombre);
                            $('#edit_precio').val(producto.precio);
                            $('#edit_precioOferta').val(producto.precio_oferta);
                            $('#edit_descripcion').val(producto.descripcion);
                            $('#edit_cantidad').val(producto.cantidad);
                            $('#edit_codigo_barras').val(producto.codigo_barras);
                            $('#estado').val(producto.estado);
                            cargarOfertaEdicion(producto);
                            const $categoria = $('#edit_categoria');
                            const $subcategoria = $('#edit_subcategoria');

                            // Vaciar y destruir select2 si ya está activo
                            if ($categoria.hasClass('select2-hidden-accessible')) $categoria.select2('destroy');
                            if ($subcategoria.hasClass('select2-hidden-accessible')) $subcategoria.select2('destroy');

                            $categoria.empty();
                            $subcategoria.empty();

                            // ⚡ 1. Cargar categorías primero
                            fetch('/categorias/buscar')
                                .then(res => res.json())
                                .then(categorias => {
                                    if ($categoria.hasClass('select2-hidden-accessible')) {
                                        $categoria.select2('destroy');
                                    }
                                    $categoria.empty();

                                    categorias.forEach(cat => {
                                        const isSelected = String(cat.id) === String(producto.categoria_id);
                                        const option = new Option(cat.nombre, cat.id, isSelected, isSelected);
                                        $categoria.append(option);
                                        // Llamar a cargar subcategorías con selección correcta
                                        cargarSubcategorias(producto.categoria_id, producto.subcategoria_id);
                                    });

                                    $categoria.select2({
                                        dropdownParent: $('#editModal'),
                                        theme: 'bootstrap-5',
                                        allowClear: true,
                                        width: 'resolve'
                                    });


                                });

                            // Evento para cambio de categoría (sin subcategoriaSeleccionada)
                            $categoria.off('change').on('change', function() {
                                const categoriaId = $(this).val();
                                cargarSubcategorias(categoriaId); // no pasamos subcategoriaSeleccionada
                            });

                            function cargarSubcategorias(categoriaId, subcategoriaSeleccionada = null) {
                                $.ajax({
                                    url: '/subcategorias/por-categoria',
                                    data: {
                                        categoria_id: categoriaId
                                    },
                                    success: function(data) {
                                        $subcategoria.empty();

                                        data.forEach(sub => {
                                            const isSelected = String(sub.id) === String(subcategoriaSeleccionada);
                                            const option = new Option(sub.text, sub.id, isSelected, isSelected);
                                            $subcategoria.append(option);
                                        });

                                        $subcategoria.select2({
                                            dropdownParent: $('#editModal'),
                                            theme: 'bootstrap-5',
                                            allowClear: true
                                        });
                                    },
                                    error: function() {
                                        console.error('Error cargando subcategorías');
                                    }
                                });
                            }

                            const contenedor = document.getElementById('imagenes-actuales');
                            contenedor.innerHTML = '';

                            producto.imagenes.forEach((img) => {
                                if (!img.url) return;

                                const wrapper = document.createElement('div');
                                wrapper.className = 'position-relative';

                                // ⚡ Detectar si es URL externa
                                let imageUrl;
                                if (/^https?:\/\//i.test(img.url)) {
                                    imageUrl = img.url; // URL externa, no tocar
                                    console.log('URL externa detectada:', imageUrl);
                                } else {
                                    imageUrl = `/storage/${img.url}`; // Ruta local
                                    console.log('URL local detectada:', imageUrl);
                                }

                                const esVideo = imageUrl.endsWith('.mp4') || imageUrl.endsWith('.webm') || imageUrl.endsWith('.ogg');
                                let media;

                                if (esVideo) {
                                    media = document.createElement('video');
                                    media.src = imageUrl;
                                    media.controls = true;
                                } else {
                                    media = document.createElement('img');
                                    media.src = imageUrl;
                                    media.alt = 'Imagen producto';
                                }

                                media.style = 'width: 100px; height: 100px; object-fit: cover; border-radius: 5px; cursor: pointer;';
                                media.addEventListener('click', () => {
                                    const visorImg = document.getElementById('imagenGrande');
                                    const visorVideo = document.getElementById('videoGrande');
                                    const modal = new bootstrap.Modal(document.getElementById('visorImagenModal'));

                                    document.getElementById('tituloProductoModal').textContent = producto.nombre ?? 'Producto';

                                    if (esVideo) {
                                        visorImg.style.display = 'none';
                                        visorVideo.src = imageUrl;
                                        visorVideo.style.display = 'block';
                                        visorVideo.load();
                                    } else {
                                        visorVideo.pause();
                                        visorVideo.style.display = 'none';
                                        visorImg.src = imageUrl;
                                        visorImg.style.display = 'block';
                                    }

                                    modal.show();
                                });

                                const btnDelete = document.createElement('button');
                                btnDelete.innerHTML = '&times;';
                                btnDelete.className = 'btn btn-danger btn-sm position-absolute top-0 end-0';
                                btnDelete.type = 'button';
                                btnDelete.onclick = () => eliminarImagen(img.id, img.url, wrapper);

                                wrapper.appendChild(media);
                                wrapper.appendChild(btnDelete);
                                contenedor.appendChild(wrapper);
                            });
                        })
                        .catch(error => {
                            console.error('Error al obtener los datos del producto:', error);
                        });
                });


                // Inicializa el select2 de subcategoría con mensaje por defecto
                $('#subcategoria').select2({
                    dropdownParent: $('#addModal'),
                    theme: 'bootstrap-5',
                    placeholder: "Primero seleccione una categoría",
                    allowClear: true
                });

                $('#categoria').select2({
                    dropdownParent: $('#addModal'),
                    theme: 'bootstrap-5',
                    placeholder: "Seleccione una categoría",
                    allowClear: true,
                    ajax: {
                        url: '{{ route("categorias.buscar") }}',
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                q: params.term
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data.map(cat => ({
                                    id: cat.id,
                                    text: `${cat.nombre} - ${cat.descripcion}`
                                }))
                            };
                        },
                        cache: true
                    }
                }).on('change', function() {
                    const categoriaId = $(this).val();
                    const $subcategoria = $('#subcategoria');

                    // Limpia el select2 y opciones previas
                    $subcategoria.val(null).empty().trigger('change');

                    if (categoriaId) {
                        $.ajax({
                            url: '{{ route("subcategorias.porCategoria") }}',
                            data: {
                                categoria_id: categoriaId
                            },
                            success: function(data) {
                                // Destruye select2 solo si ya está inicializado
                                if ($.fn.select2 && $subcategoria.hasClass("select2-hidden-accessible")) {
                                    $subcategoria.select2('destroy');
                                }

                                // Agrega opciones
                                let options = '<option></option>'; // para el placeholder
                                data.forEach(sub => {
                                    options += `<option value="${sub.id}">${sub.text}</option>`;
                                });
                                $subcategoria.html(options);

                                // Inicializa nuevamente con opciones
                                $subcategoria.select2({
                                    dropdownParent: $('#addModal'),
                                    theme: 'bootstrap-5',
                                    placeholder: "Seleccione una subcategoría",
                                    allowClear: true
                                });
                            },
                            error: function(xhr) {
                                console.error('Error cargando subcategorías:', xhr.responseText);
                            }
                        });
                    } else {
                        // Si no hay categoría seleccionada, reinicia subcategoría con placeholder original
                        if ($.fn.select2 && $subcategoria.hasClass("select2-hidden-accessible")) {
                            $subcategoria.select2('destroy');
                        }

                        $subcategoria.html('<option></option>'); // para el placeholder
                        $subcategoria.select2({
                            dropdownParent: $('#addModal'),
                            theme: 'bootstrap-5',
                            placeholder: "Primero seleccione una categoría",
                            allowClear: true
                        });
                    }
                });

                // categorias para filtrar en la vista:
                $('#categorias').select2({
                    theme: 'bootstrap-5',
                    placeholder: 'Selecciona una o más categorías',
                    allowClear: true,
                    ajax: {
                        url: '{{ route("categorias.buscar") }}', // la misma ruta que usás en el modal
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                q: params.term
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data.map(cat => ({
                                    id: cat.id,
                                    text: `${cat.nombre} - ${cat.descripcion}`
                                }))
                            };
                        },
                        cache: true
                    }
                });
                console.log('Categoría selects:', $('#categoria').length);
                console.log('Subcategoría selects:', $('#subcategoria').length);

                // Manejar la subida de imágenes y la vista previa
                document.getElementById('archivos').addEventListener('change', function(event) {
                    const files = Array.from(event.target.files);
                    const preview = document.getElementById('preview');
                    preview.innerHTML = '';

                    files.forEach((file, index) => {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const container = document.createElement('div');
                            container.classList.add('img-preview');

                            let mediaElement;
                            const fileURL = URL.createObjectURL(file);
                            if (file.type.startsWith('image/')) {
                                mediaElement = document.createElement('img');
                                mediaElement.src = e.target.result;
                                mediaElement.style = 'width: 100px; height: 100px; object-fit: cover;';
                            } else if (file.type.startsWith('video/')) {
                                mediaElement = document.createElement('video');
                                mediaElement.src = e.target.result;
                                mediaElement.controls = true;
                                mediaElement.style = 'width: 100px; height: 100px; object-fit: cover;';
                            }

                            const btn = document.createElement('button');
                            btn.innerHTML = '×';
                            btn.onclick = function() {
                                files.splice(index, 1);
                                removeImage(index);
                            };

                            container.appendChild(mediaElement);
                            container.appendChild(btn);
                            preview.appendChild(container);
                        };
                        reader.readAsDataURL(file);
                    });

                    function removeImage(index) {
                        const dt = new DataTransfer();
                        files.forEach((file, i) => {
                            if (i !== index) dt.items.add(file);
                        });
                        document.getElementById('imagenes').files = dt.files;
                        document.getElementById('imagenes').dispatchEvent(new Event('change'));
                    }
                });
                (() => {
                    const inputEditar = document.getElementById('edit_nuevas_imagenes');
                    const previewEditar = document.getElementById('preview-nuevas-imagenes');

                    let dt = new DataTransfer();

                    inputEditar.addEventListener('change', (e) => {
                        for (const file of e.target.files) {
                            dt.items.add(file);
                        }
                        inputEditar.files = dt.files;
                        actualizarPreviewEditar();
                    });

                    function actualizarPreviewEditar() {
                        previewEditar.innerHTML = '';
                        Array.from(dt.files).forEach((file, index) => {
                            const reader = new FileReader();
                            reader.onload = (e) => {
                                const container = document.createElement('div');
                                container.classList.add('img-preview'); // aquí reutilizas estilo igual que agregar

                                let mediaElement;
                                const fileURL = URL.createObjectURL(file);
                                if (file.type.startsWith('image/')) {
                                    mediaElement = document.createElement('img');
                                    mediaElement.src = e.target.result;
                                    mediaElement.style = 'width: 100px; height: 100px; object-fit: cover;';
                                } else if (file.type.startsWith('video/')) {
                                    mediaElement = document.createElement('video');
                                    mediaElement.src = e.target.result;
                                    mediaElement.controls = true;
                                    mediaElement.style = 'width: 100px; height: 100px; object-fit: cover;';
                                }
                                const btnDelete = document.createElement('button');
                                btnDelete.textContent = '×';
                                btnDelete.type = 'button';
                                btnDelete.onclick = () => eliminarArchivoEditar(index);

                                container.appendChild(mediaElement);
                                container.appendChild(btnDelete);
                                previewEditar.appendChild(container);
                            };
                            reader.readAsDataURL(file);
                        });
                    }

                    function eliminarArchivoEditar(index) {
                        dt.items.remove(index);
                        inputEditar.files = dt.files;
                        actualizarPreviewEditar();
                    }
                })();


                //editar categoria e imagenes

                $(document).ready(function() {
                    // Inicializar Select2
                    $('#categoria').select2({
                        width: '100%'
                    });
                    $('#subcategoria').select2({
                        placeholder: 'Seleccione una subcategoría',
                        allowClear: true,
                        ajax: {
                            url: '/subcategorias/por-categoria',
                            data: function() {
                                return {
                                    categoria_id: $('#categoria').val()
                                };
                            },
                            processResults: function(data) {
                                return {
                                    results: data
                                };
                            }
                        }
                    });

                    // Cuando cambia la categoría, limpiamos el select de subcategoría
                    $('#categoria').on('change', function() {
                        $('#subcategoria').val(null).trigger('change');
                    });
                });

                async function eliminarImagen(id, url, wrapper) {
                    const confirmacion = await Swal.fire({
                        title: '¿Estás seguro?',
                        text: "No podrás deshacer esta acción",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    });

                    // Solo continuar si el usuario confirmó
                    if (!confirmacion.isConfirmed) return;

                    fetch(`/producto/imagen/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    }).then(resp => {
                        if (resp.ok) {
                            wrapper.remove();
                            Swal.fire({
                                icon: 'success',
                                title: 'Eliminado',
                                text: 'La imagen fue eliminada correctamente.'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error al eliminar la imagen.'
                            });
                        }
                    });
                }
            </script>
    </main>
</x-layout>