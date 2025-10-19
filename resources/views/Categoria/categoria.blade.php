<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <style>
            /* Estilo del cuadro select visible */
            .select2-container--default .select2-selection--single {
                background-color: #fff !important;
                color: #212529 !important;
                font-weight: 600 !important;
                font-size: 1rem !important;
                border: 1px solid #ced4da !important;
                height: 38px !important;
                padding: 5px 12px !important;
                display: flex;
                align-items: center;
            }

            /* Estilo del texto en las opciones desplegadas */
            .select2-container--default .select2-results__option {
                font-size: 1rem;
                font-weight: 500;
                color: #000;
            }

            /* Placeholder más visible */
            .select2-container--default .select2-selection__placeholder {
                color: #6c757d;
                font-weight: 500;
            }

            /* Icono de flecha más oscuro */
            .select2-container--default .select2-selection__arrow b {
                border-color: #343a40 transparent transparent transparent;
            }
        </style>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
        <div class="container-fluid py-4">
            <div class="row mt-5">
                @if(session('success'))
                <div class="alert alert-success" id="successMessage">
                    {{ session('success') }}
                </div>
                <script>
                    setTimeout(() => {
                        document.getElementById('successMessage')?.remove();
                    }, 3000);
                </script>
                @endif
                {{-- Card Categoría --}}
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h5>Registrar Categoría</h5>
                        </div>
                        <div class="card-body">
                            <form id="formCategoria" method="POST" action="{{ route('categoria.store') }}">
                                @csrf
                                <input type="hidden" id="categoria_id" name="id">
                                <input type="hidden" id="modoCategoria" value="crear">
                                <input type="hidden" name="_method" id="categoria_method" value="POST">
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="nombre" id="categoria_nombre" placeholder="Nombre" required>
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="descripcion" id="categoria_descripcion" placeholder="Descripción">
                                </div>
                                <div class="text-end" id="btnsCategoria">
                                    <button type="submit" class="btn btn-success" id="btnAgregarCategoria"><i class="fa fa-plus"></i> Agregar</button>
                                    <button type="submit" class="btn btn-primary d-none" id="btnModificarCategoria"><i class="fa fa-edit"></i> Modificar</button>
                                    <button type="button" class="btn btn-secondary d-none" onclick="resetCategoria()" id="btnLimpiarCategoria"><i class="fas fa-broom"></i> Limpiar</button>
                                </div>

                            </form>
                        </div>

                        <div class="card-footer">
                            <h6>Listado de Categorías</h6>
                            <div class="table-responsive">
                                <table class="table table-striped align-middle">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($categorias as $categoria)
                                        <tr id="categoria-{{ $categoria->id }}">
                                            <td>{{ $categoria->nombre }}</td>
                                            <td class="text-center text-truncate" style="max-width: 200px;" title="{{ $categoria->descripcion }}">
                                                {{ $categoria->descripcion }}
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-warning btn-sm"
                                                    onclick='editarCategoria(@json($categoria))'>
                                                    <i class="fa fa-edit"></i> Editar
                                                </button>

                                                <button class="btn btn-danger btn-sm" onclick="eliminarCategoria({{ $categoria->id }})">
                                                    <i class="fa fa-trash"></i> Eliminar
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card SubCategoría --}}
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <h5>Registrar Subcategoría</h5>
                        </div>
                        <div class="card-body">
                            <form id="formSubcategoria" method="POST" action="{{ route('subcategoria.store') }}">
                                @csrf
                                <input type="hidden" id="subcategoria_id" name="id">
                                <input type="hidden" id="modoSubcategoria" value="crear">
                                <input type="hidden" name="_method" id="subcategoria_method" value="POST">
                                <div class="mb-3">
                                    <select class="form-select select2" id="categoria_select" name="id_categoria" required>
                                        <option value="">Seleccione una categoría</option>
                                        @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="nombre" id="subcategoria_nombre" placeholder="Nombre de subcategoría" required>
                                </div>
                                <div class="text-end" id="btnsSubcategoria">
                                    <button type="submit" class="btn btn-success" id="btnAgregarSubcategoria"><i class="fa fa-plus"></i> Agregar</button>
                                    <button type="submit" class="btn btn-primary d-none" id="btnModificarSubcategoria"><i class="fa fa-edit"></i> Modificar</button>
                                    <button type="button" class="btn btn-secondary d-none" onclick="resetSubcategoria()" id="btnLimpiarSubcategoria"><i class="fas fa-broom" aria-hidden="true"></i> Limpiar</button>
                                </div>

                            </form>
                        </div>

                        <div class="card-footer">
                            <h6>Listado de Subcategorías</h6>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Categoría</th>
                                            <th>Nombre</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($subcategorias as $subcategoria)
                                        <tr id="subcategoria-{{ $subcategoria->id }}">
                                            <td>{{ $subcategoria->categoria->nombre }}</td>
                                            <td>{{ $subcategoria->nombre }}</td>
                                            <td class="text-center">
                                                <button class="btn btn-warning btn-sm"
                                                    onclick='editarSubcategoria(@json([
                                                        "id" => $subcategoria->id,
                                                        "nombre" => $subcategoria->nombre,
                                                        "id_categoria" => $subcategoria->id_categoria
                                                    ]))'>
                                                    <i class="fa fa-edit"></i> Editar
                                                </button>

                                                <button class="btn btn-danger btn-sm" onclick="eliminarSubcategoria({{ $subcategoria->id }})">
                                                    <i class="fa fa-trash"></i> Eliminar
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Scripts --}}
        <script>
            async function eliminarCategoria(id) {
                const confirm = await Swal.fire({
                    title: '¿Eliminar categoría?',
                    text: 'Se marcará como eliminada junto con sus subcategorías relacionadas.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6'
                });

                if (confirm.isConfirmed) {
                    try {
                        const res = await fetch(`/categorias/${id}/eliminar`, {
                            method: 'PUT',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });

                        const data = await res.json();

                        if (data.success) {
                            Swal.fire({
                                title: 'Eliminada',
                                text: data.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });

                            // Eliminar visualmente la fila
                            document.querySelector(`#categoria-${id}`)?.remove();
                        } else {
                            Swal.fire('Error', 'No se pudo eliminar la categoría.', 'error');
                        }
                    } catch (error) {
                        Swal.fire('Error', 'Ocurrió un error inesperado.', 'error');
                        console.error(error);
                    }
                }
            }
        </script>
        <script>
            async function eliminarSubcategoria(id) {
                const confirm = await Swal.fire({
                    title: '¿Eliminar subcategoría?',
                    text: 'Se marcará como eliminada y no se mostrará más en la lista.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6'
                });

                if (confirm.isConfirmed) {
                    try {
                        const res = await fetch(`/subcategorias/${id}/eliminar`, {
                            method: 'PUT',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });

                        const data = await res.json();

                        if (data.success) {
                            Swal.fire({
                                title: 'Eliminada',
                                text: data.message,
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            });

                            // Eliminar fila visualmente sin recargar
                            document.querySelector(`#subcategoria-${id}`)?.remove();
                        } else {
                            Swal.fire('Error', 'Ocurrió un problema al eliminar.', 'error');
                        }
                    } catch (error) {
                        Swal.fire('Error', 'Ocurrió un error inesperado.', 'error');
                        console.error(error);
                    }
                }
            }
        </script>
        <script>
            //categoria
            function editarCategoria(categoria) {
                document.getElementById('formCategoria').action = `/categoria-update/${categoria.id}`;
                document.getElementById('categoria_id').value = categoria.id;
                document.getElementById('categoria_nombre').value = categoria.nombre;
                document.getElementById('categoria_descripcion').value = categoria.descripcion;
                document.getElementById('categoria_method').value = 'PUT';

                // Mostrar botones de edición
                document.getElementById('modoCategoria').value = 'editar';
                document.getElementById('btnAgregarCategoria').classList.add('d-none');
                document.getElementById('btnModificarCategoria').classList.remove('d-none');
                document.getElementById('btnLimpiarCategoria').classList.remove('d-none');
            }

            function resetCategoria() {
                document.getElementById('formCategoria').action = `{{ route('categoria.store') }}`;
                document.getElementById('categoria_id').value = '';
                document.getElementById('categoria_nombre').value = '';
                document.getElementById('categoria_descripcion').value = '';
                document.getElementById('categoria_method').value = 'POST';

                // Volver a modo crear
                document.getElementById('modoCategoria').value = 'crear';
                document.getElementById('btnAgregarCategoria').classList.remove('d-none');
                document.getElementById('btnModificarCategoria').classList.add('d-none');
                document.getElementById('btnLimpiarCategoria').classList.add('d-none');
            }
            //subcategoria
            function editarSubcategoria(subcategoria) {
                document.getElementById('formSubcategoria').action = `/subcategoria-update/${subcategoria.id}`;
                document.getElementById('subcategoria_id').value = subcategoria.id;
                document.getElementById('subcategoria_nombre').value = subcategoria.nombre;
                document.getElementById('subcategoria_method').value = 'PUT';

                // Mostrar botones de edición
                document.getElementById('modoSubcategoria').value = 'editar';
                document.getElementById('btnAgregarSubcategoria').classList.add('d-none');
                document.getElementById('btnModificarSubcategoria').classList.remove('d-none');
                document.getElementById('btnLimpiarSubcategoria').classList.remove('d-none');

                // Mostrar categoría seleccionada
                $('#categoria_select').val(subcategoria.id_categoria).trigger('change');
            }

            function resetSubcategoria() {
                document.getElementById('formSubcategoria').action = `{{ route('subcategoria.store') }}`;
                document.getElementById('subcategoria_id').value = '';
                document.getElementById('subcategoria_nombre').value = '';
                document.getElementById('subcategoria_method').value = 'POST';

                document.getElementById('modoSubcategoria').value = 'crear';
                document.getElementById('btnAgregarSubcategoria').classList.remove('d-none');
                document.getElementById('btnModificarSubcategoria').classList.add('d-none');
                document.getElementById('btnLimpiarSubcategoria').classList.add('d-none');

                $('#categoria_select').val('').trigger('change');
            }


            $(document).ready(function() {
                $('.select2').select2({
                    width: '100%',
                    placeholder: "Buscar categoría..."
                });
            });
        </script>
    </main>
</x-layout>