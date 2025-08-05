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
    </style>
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
                            <div class="select-categorias-wrapper">
                                <form method="GET" action="{{ route('productos') }}" class="mx-3 my-2 d-flex align-items-center">
                                    <label for="categorias" class="me-2">Filtrar por Categorías:</label>
                                    <select name="categorias[]" id="categorias" class="form-select select2" multiple></select>
                                    <button type="submit" class="btn btn-primary ms-2"><i class="fa fa-search"></i> Filtrar</button>
                                    <a href="{{ route('productos') }}" class="btn btn-secondary ms-2">
                                        <i class="fa fa-list"></i> Mostrar Todos
                                    </a>
                                    <a href="{{ route('productos.exportar', ['categorias' => request()->input('categorias', [])]) }}" class="btn btn-success ms-2">
                                        <i class="fas fa-file-pdf"></i> Exportar PDF
                                    </a>

                                </form>
                            </div>
                            <style>
                                /* Select2 Bootstrap-5 compacto SOLO para #categorias */
                                #categorias+.select2-container--bootstrap-5 .select2-selection {
                                    min-height: 32px !important;
                                    padding: 0.25rem 0.5rem !important;
                                    font-size: 0.875rem !important;
                                    line-height: 1.2 !important;
                                }

                                #categorias+.select2-container--bootstrap-5 .select2-selection__rendered {
                                    padding-right: 1.5rem !important;
                                    font-size: 0.875rem !important;
                                }

                                #categorias+.select2-container--bootstrap-5 .select2-selection__clear {
                                    font-size: 0.875rem;
                                    right: 0.75rem;
                                }

                                #categorias~.select2-container--bootstrap-5 {
                                    width: 350px !important;
                                    /* o el ancho que prefieras */
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

                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center">Categoría / Subcategoría</th>
                                        <th class="text-center">Producto</th>
                                        <th class="text-center">Precio (Bs.)</th>
                                        <th class="text-center">Precio Oferta(Bs.)</th>
                                        <th class="text-center">Descripción</th>
                                        <th class="text-center">Stock</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($productos as $producto)
                                    <tr>
                                        <td class="text-center">
                                            {{ $producto->categoria->nombre ?? 'Sin categoría' }} /
                                            {{ $producto->categoria->subcategorias->first()->nombre ?? 'Sin subcategoría' }}
                                        </td>
                                        <td class="text-center">{{ $producto->nombre }}</td>
                                        <td class="text-center">{{ $producto->precio }}</td>
                                        <td class="text-center">{{ $producto->precio_oferta }}</td>
                                        <td class="text-center">{{ $producto->descripcion }}</td>
                                        <td class="text-center">{{ $producto->cantidad }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal" data-id="{{ $producto->id }}">
                                                <i class="fa fa-edit"></i> Editar
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No hay productos registrados.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>

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
                                        <label for="precio" class="form-label">Precio Oferta(Bs.) Opcional</label>
                                        <input type="number" step="0.01" class="form-control" id="precioOferta" name="precio_oferta">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="descripcion" class="form-label">Descripción</label>
                                        <textarea class="form-control" id="descripcion" name="descripcion" ></textarea>
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
                                    <input type="text" class="form-control" id="edit_precio" name="precio" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_precio" class="form-label">Precio Oferta (Bs.) Opcional</label>
                                    <input type="text" class="form-control" id="edit_precioOferta" name="precio_oferta" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_descripcion" class="form-label">Descripción</label>
                                    <input type="text" class="form-control" id="edit_descripcion" name="descripcion" required>
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

                            // 🖼️ Cargar imágenes actuales
                            const contenedor = document.getElementById('imagenes-actuales');
                            contenedor.innerHTML = '';
                            producto.imagenes.forEach((img) => {
                                const wrapper = document.createElement('div');
                                wrapper.className = 'position-relative';

                                let media;
                                const esVideo = img.url.endsWith('.mp4') || img.url.endsWith('.webm') || img.url.endsWith('.ogg');

                                if (esVideo) {
                                    media = document.createElement('video');
                                    media.src = img.url;
                                    media.controls = true;
                                } else {
                                    media = document.createElement('img');
                                    media.src = img.url;
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
                                        visorVideo.src = img.url;
                                        visorVideo.style.display = 'block';
                                        visorVideo.load();
                                    } else {
                                        visorVideo.pause();
                                        visorVideo.style.display = 'none';
                                        visorImg.src = img.url;
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