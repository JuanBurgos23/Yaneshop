<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl">
            <!-- Navbar content -->
        </nav>
        <style>
            /* Fila con error */
            .fila-error {
                border: 2px solid #dc3545 !important;
                background-color: rgba(255, 0, 0, 0.05) !important;
                /* rojo claro pero visible en dark mode */
            }

            /* Celda con error */
            .celda-error {
                border: 2px solid #dc3545 !important;
                background-color: rgba(255, 0, 0, 0.2) !important;
            }

            .celda-ok {
                border: 2px solid #198754 !important;
                /* verde */
                background-color: rgba(0, 255, 0, 0.05) !important;
                color: #fff;
            }

            /* Estilo editable compatible con dark mode */
            td[contenteditable="true"] {
                cursor: text;
                transition: background-color 0.2s ease;
                color: inherit;
                /* respeta color del tema */
            }

            td[contenteditable="true"]:focus {
                background-color: rgba(255, 255, 255, 0.1);
                /* gris claro compatible con fondo oscuro */
                color: inherit;
                outline: none;
            }

            #tablaProductosPreview thead th,
            #tablaProductosPreview tbody td {
                color: white !important;
            }

            select.form-select {
                color: white;
                background-color: #1e1e1e;
                /* opcional para que combine con dark mode */
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
        </style>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

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
                        <h2>Registro masivo de Productos</h2>
                    </div>
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>

                        <h4><i class="fas fa-exclamation" aria-hidden="true"></i> Bienvenido al registro masivo de productos</h4>
                        <p>
                            Aquí puedes registrar todos tus productos de una sola vez subiendo un archivo Excel en el formato establecido,
                            para descargar nuestro formato <a href="{{ route('productos.plantilla') }}" class="btn btn-sm btn-success">¡Clic aquí!</a>
                        </p>
                        <p>
                            Una vez cargado tu archivo con tus productos, estos se visualizarán en la tabla inferior.
                            Una vez valides tus productos puedes guardarlos para poder realizar ventas.
                        </p>
                    </div>


                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="categoria_id" class="form-label">Categoría</label>
                            <div class="input-group">
                                <select id="categoria_id" class="form-select">
                                    <option value="">Selecciona una categoría</option>
                                    @foreach($todasLasCategorias as $categoria)
                                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                    @endforeach
                                </select>
                                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalNuevaCategoria">
                                    +
                                </button>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="subcategoria_id" class="form-label">Subcategoría</label>
                            <div class="input-group">
                                <select id="subcategoria_id" class="form-select" disabled>
                                    <option value="">Selecciona una subcategoría</option>
                                </select>
                                <button class="btn btn-success" id="btnAgregarSubcategoria" disabled data-bs-toggle="modal" data-bs-target="#modalNuevaSubcategoria">
                                    +
                                </button>
                            </div>
                        </div>
                        <form id="formCargarExcel" enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="card my-4">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="archivo_excel" class="form-label">Subir archivo Excel (.xlsx)</label>
                                        <input type="file" name="archivo_excel" id="archivo_excel" class="form-control bg-dark text-white" accept=".xlsx" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Cargar productos</button>
                                    <button id="btnLimpiarTabla" class="btn btn-light d-none">
                                        <i class="fas fa-broom"></i> Limpiar tabla
                                    </button>


                                </div>
                            </div>
                        </form>

                        <div id="tablaPreview" class="card d-none">
                            <div class="card-body">
                                <h5 class="mb-3">Vista previa de productos cargados</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="tablaProductosPreview">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Precio</th>
                                                <th>Descripción</th>
                                                <th>Código de Barras</th>
                                                <th>Imagen</th> <!-- 👈 agregado -->
                                                <th>Errores</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                                <button id="btnGuardarProductos" class="btn btn-success mt-3">Guardar productos</button>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- Modal Crear Categoría -->
                <div class="modal fade" id="modalNuevaCategoria" tabindex="-1" aria-labelledby="modalNuevaCategoriaLabel" aria-hidden="true">

                    <div class="modal-dialog">
                        <form id="formNuevaCategoria">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="modalNuevaCategoriaLabel">Nueva Categoría</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body">
                                    <label>Nombre de la categoría</label>
                                    <input type="text" class="form-control" name="nombre" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Modal Crear Subcategoría -->
                <div class="modal fade" id="modalNuevaSubcategoria" tabindex="-1" aria-labelledby="modalNuevaSubcategoriaLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="formNuevaSubcategoria">
                            @csrf
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="modalNuevaSubcategoriaLabel">Nueva Subcategoría</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                </div>
                                <div class="modal-body">
                                    <label>Nombre de la subcategoría</label>
                                    <input type="text" class="form-control" name="nombre" required>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <!-- Scripts -->
                <script>
                    document.getElementById('categoria_id').addEventListener('change', function() {
                        const categoriaId = this.value;
                        const subcategoriaSelect = document.getElementById('subcategoria_id');
                        const botonAgregarSub = document.getElementById('btnAgregarSubcategoria');

                        subcategoriaSelect.innerHTML = '<option value="">Cargando...</option>';
                        subcategoriaSelect.disabled = true;
                        botonAgregarSub.disabled = true;

                        if (!categoriaId) {
                            subcategoriaSelect.innerHTML = '<option value="">Selecciona una subcategoría</option>';
                            return;
                        }

                        fetch(`/subcategorias/${categoriaId}`)
                            .then(response => response.json())
                            .then(data => {
                                subcategoriaSelect.innerHTML = '<option value="">Selecciona una subcategoría</option>';
                                data.forEach(sub => {
                                    const option = document.createElement('option');
                                    option.value = sub.id;
                                    option.textContent = sub.nombre;
                                    subcategoriaSelect.appendChild(option);
                                });
                                subcategoriaSelect.disabled = false;
                                botonAgregarSub.disabled = false;
                            })
                            .catch(error => {
                                console.error('Error al cargar subcategorías:', error);
                            });
                    });
                    document.getElementById('formNuevaCategoria').addEventListener('submit', function(e) {
                        Swal.fire({
                            title: 'Crear nueva categoría',
                            text: 'Asegúrate de que la categoría no exista ya.',
                            icon: 'info',
                            confirmButtonText: 'Continuar'
                        }).then(() => {
                            // Si el usuario confirma, se procede a enviar el formulario
                            Swal.fire('Categoría creada', '', 'success', {
                                icon: 'success',
                                title: 'Categoría creada exitosamente',
                                confirmButtonText: 'Aceptar'
                            }).then(() => {
                                // Aquí puedes agregar lógica adicional si es necesario
                                this.submit();
                            });
                        });
                        e.preventDefault();
                        const formData = new FormData(this);

                        fetch('/categoria-register', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': formData.get('_token')
                                },
                                body: formData
                            })
                            .then(res => res.json())
                            .then(data => {
                                // Agregar nueva categoría al select
                                const select = document.getElementById('categoria_id');
                                const option = new Option(data.nombre, data.id, true, true);
                                select.add(option);
                                select.dispatchEvent(new Event('change'));
                                // Cerrar modal
                                $('#modalNuevaCategoria').modal('hide');
                            });
                    });

                    document.getElementById('formNuevaSubcategoria').addEventListener('submit', function(e) {
                        Swal.fire({
                            title: 'Crear nueva subcategoría',
                            text: 'Asegúrate de que la categoría esté seleccionada.',
                            icon: 'info',
                            confirmButtonText: 'Continuar'
                        }).then(() => {
                            // Si el usuario confirma, se procede a enviar el formulario
                            Swal.fire('Subcategoría creada', '', 'success', {
                                icon: 'success',
                                title: 'Subcategoría creada exitosamente',
                                confirmButtonText: 'Aceptar'
                            }).then(() => {
                                this.submit();
                            });

                        });
                        e.preventDefault();
                        const formData = new FormData(this);
                        const categoriaId = document.getElementById('categoria_id').value;
                        formData.append('id_categoria', categoriaId);

                        fetch('/subcategoria-register', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': formData.get('_token')
                                },
                                body: formData
                            })
                            .then(res => res.json())
                            .then(data => {
                                const select = document.getElementById('subcategoria_id');
                                const option = new Option(data.nombre, data.id, true, true);
                                select.add(option);
                                select.dispatchEvent(new Event('change'));
                                $('#modalNuevaSubcategoria').modal('hide');
                            });
                    });
                    document.getElementById('btnGuardarProductos').addEventListener('click', function() {
                        Swal.fire({
                            title: '¿Deseas guardar estos productos?',
                            text: 'Una vez guardados podrás realizar ventas con ellos.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Sí, guardar',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // ✅ Actualizamos los productos desde la tabla
                                const productos = recolectarProductosDesdeTabla().map(p => ({
                                    ...p,
                                    codigo_barras: p.codigo_barras?.toString() ?? ''
                                }));

                                const categoriaId = document.getElementById('categoria_id').value;
                                const subcategoriaId = document.getElementById('subcategoria_id').value;
                                const hayErrores = document.querySelectorAll('.fila-error').length > 0;
                                if (hayErrores) {
                                    Swal.fire('Error', 'Corrige todos los errores antes de guardar.', 'error');
                                    return;
                                }
                                fetch('/producto-register-masivo', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                                        },
                                        body: JSON.stringify({
                                            productos,
                                            categoria_id: categoriaId,
                                            subcategoria_id: subcategoriaId
                                        })
                                    })
                                    .then(res => res.json())
                                    .then(data => {
                                        if (data.success) {
                                            Swal.fire('Guardado', data.message, 'success');
                                            document.getElementById('tablaPreview').classList.add('d-none');
                                        } else {
                                            Swal.fire('Error', data.message, 'error');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error al guardar:', error);
                                        Swal.fire('Error', 'Ocurrió un error al guardar los productos.', 'error');
                                    });
                            }
                        });
                    });
                    //subir archivo excel al sistema
                    document.getElementById('formCargarExcel').addEventListener('submit', function(e) {
                        e.preventDefault();

                        const form = e.target;
                        const formData = new FormData(form);
                        const categoriaId = document.getElementById('categoria_id').value;
                        const subcategoriaId = document.getElementById('subcategoria_id').value;

                        if (!categoriaId || !subcategoriaId) {
                            Swal.fire('Error', 'Selecciona una categoría y subcategoría primero.', 'error');
                            return;
                        }

                        formData.append('categoria_id', categoriaId);
                        formData.append('subcategoria_id', subcategoriaId);

                        fetch('/productos/cargar-excel', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': formData.get('_token')
                                },
                                body: formData
                            })
                            .then(res => res.json())
                            .then(data => {

                                if (data.success) {
                                    const tbody = document.querySelector('#tablaProductosPreview tbody');
                                    tbody.innerHTML = '';

                                    data.productos.forEach(producto => {
                                        const errores = producto.errores || [];
                                        const camposConErrores = new Set();

                                        // Detectar campos con errores específicos
                                        errores.forEach(error => {
                                            if (error.toLowerCase().includes('nombre')) camposConErrores.add('nombre');
                                            //if (error.toLowerCase().includes('precio')) camposConErrores.add('precio');
                                            if (error.toLowerCase().includes('código de barras') || error.toLowerCase().includes('código')) camposConErrores.add('codigo_barras');
                                        });

                                        const fila = document.createElement('tr');
                                        if (errores.length > 0) {
                                            fila.classList.add('fila-error');
                                        }

                                        fila.innerHTML = `
                                            <td contenteditable="true" class="${camposConErrores.has('nombre') ? 'celda-error' : ''}">${producto.nombre}</td>
                                            <td contenteditable="true">${producto.precio ?? 0}</td>
                                            <td contenteditable="true">${producto.descripcion ?? ''}</td>
                                            <td contenteditable="true" class="${camposConErrores.has('codigo_barras') ? 'celda-error' : ''}">${producto.codigo_barras ?? ''}</td>

                                            <td>
                                                ${producto.imagen_url 
                                                    ? `<img src="${producto.imagen_url}" alt="Vista previa" style="width:60px; height:60px; object-fit:cover; border-radius:8px;">`
                                                    : '<span class="text-muted small">Sin imagen</span>'
                                                }
                                            </td>

                                            <td>
                                                ${errores.length > 0 
                                                    ? errores.map(e => `<div class="text-danger small"><i class="bi bi-exclamation-triangle-fill me-1"></i>${e}</div>`).join('')
                                                    : '<span class="badge bg-success"><i class="bi bi-check-circle"></i> Correcto</span>'
                                                }
                                            </td>
                                        `;

                                        tbody.appendChild(fila);
                                    });

                                    document.getElementById('tablaPreview').classList.remove('d-none')
                                    document.getElementById('btnLimpiarTabla').classList.remove('d-none');
                                    window.productosParaGuardar = data.productos;
                                } else {
                                    Swal.fire('Error', data.message, 'error');
                                }
                            })
                            .catch(error => {
                                console.error('Error al cargar el Excel:', error);
                                Swal.fire('Error', 'No se pudo procesar el archivo.', 'error');
                            });
                    });
                    document.querySelector('#tablaProductosPreview').addEventListener('input', function(e) {
                        const celda = e.target;
                        const columna = celda.cellIndex;
                        const fila = celda.closest('tr');

                        // Nombre de campo según la posición
                        const campos = ['nombre', 'precio', 'descripcion', 'codigo_barras'];
                        const campo = campos[columna];

                        let valor = celda.textContent.trim();
                        let esValido = true;

                        switch (campo) {
                            case 'nombre':
                                esValido = valor.length > 0;
                                break;
                            case 'codigo_barras':
                                esValido = valor.length > 0;
                                break;
                            case 'precio':
                                esValido = true; // ya no marcará error, cualquier cosa es válida (convertible a 0 si está mal)
                                break;
                            default:
                                esValido = true;
                        }

                        if (esValido) {
                            celda.classList.remove('celda-error');
                            celda.classList.add('celda-ok');
                        } else {
                            celda.classList.remove('celda-ok');
                            celda.classList.add('celda-error');
                        }

                        // Verificar si toda la fila está OK
                        const algunaConError = fila.querySelectorAll('.celda-error').length > 0;
                        if (!algunaConError) {
                            fila.classList.remove('fila-error');
                            const estadoCelda = fila.querySelector('td:last-child');
                            estadoCelda.innerHTML = '<span class="badge bg-success"><i class="bi bi-check-circle"></i> Correcto</span>';
                        }
                    });
                    document.getElementById('btnLimpiarTabla').addEventListener('click', function() {
                        Swal.fire({
                            title: '¿Estás seguro?',
                            text: 'Esto eliminará todos los productos cargados en la vista previa.',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Sí, limpiar',
                            cancelButtonText: 'Cancelar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                document.querySelector('#tablaProductosPreview tbody').innerHTML = '';
                                document.getElementById('tablaPreview').classList.add('d-none');
                                window.productosParaGuardar = [];
                                Swal.fire('Limpio', 'La tabla ha sido vaciada.', 'success');
                                document.getElementById('btnLimpiarTabla').classList.add('d-none');
                            }
                        });
                    });
                    //volver a validar los productos al cargar la página
                    function recolectarProductosDesdeTabla() {
                        const filas = document.querySelectorAll('#tablaProductosPreview tbody tr');
                        const productos = [];

                        filas.forEach(fila => {
                            const celdas = fila.querySelectorAll('td');

                            const producto = {
                                nombre: celdas[0].textContent.trim(),
                                precio: convertirAPrecioValido(celdas[1].textContent),
                                precio: parseFloat(celdas[1].textContent.trim()),
                                descripcion: celdas[2].textContent.trim(),
                                codigo_barras: celdas[3].textContent.trim(), // ← esta es la posición correcta
                                imagen_url: celdas[4].querySelector('img')?.src ?? null // <-- capturamos la URL
                            };

                            productos.push(producto);
                            console.log(productos);
                        });
                        return productos;
                    }

                    function convertirAPrecioValido(valor) {
                        if (!valor) return 0;

                        // Quitar letras, símbolos y espacios, dejar solo números, punto y coma
                        valor = valor.replace(/[^\d.,-]/g, '').replace(',', '.');

                        const numero = parseFloat(valor);
                        return isNaN(numero) ? 0 : numero;
                    }
                </script>
    </main>
</x-layout>