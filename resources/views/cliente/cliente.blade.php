<!-- resources/views/clientes.blade.php -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<x-layout bodyClass="g-sidenav-show bg-gray-200">
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
            @if(session('error'))
            <div class="alert alert-danger" id="errorMessage">
                {{ session('error') }}
            </div>
            <script>
                // Después de 3 segundos (3000 ms), eliminar el mensaje
                setTimeout(function() {
                    const errorMessage = document.getElementById('errorMessage');
                    if (errorMessage) {
                        errorMessage.style.display = 'none';
                    }
                }, 3000);
            </script>
            @endif
            @if(session('noEmpresa') || isset($noEmpresa))
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Atención',
                    text: 'Debe registrar su empresa primero para ver los clientes.',
                    confirmButtonText: 'OK'
                });
            </script>
            @endif
            <div class="col-12">

                <div class="card my-4">

                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <h2>Listado de Clientes</h2>
                    </div>

                    <div class="me-3 my-3 text-end">
                        <!-- Contenedor principal con flexbox -->
                        <div class="d-flex align-items-center">
                            <!-- Formulario de búsqueda con el input y botón en una fila -->
                            <form method="GET" action="{{ route('mostrar_cliente') }}" class="mb-0 d-flex align-items-center me-2 w-100">
                                <input type="text" class="form-control flex-grow-1" id="searchInput" name="search" placeholder="Buscar por CI o Apellido Paterno" value="{{ request()->search }}" style="max-width: 250px;">
                                <button class="btn btn-outline-secondary" type="submit">
                                    <i class="fas fa-search"></i> Buscar
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre Completo</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">CI</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Teléfono</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Correo</th>

                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($clientes as $cliente)
                                    <tr>
                                        <td class="align-middle text-center">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $cliente->nombre_completo }}</h6>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $cliente->ci }}</h6>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $cliente->telefono }}</h6>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $cliente->correo }}</h6>
                                            </div>
                                        </td>

                                        <td class="align-middle text-center">
                                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal" data-id="{{ $cliente->id }}">
                                                <i class="fas fa-edit"></i> Editar
                                            </button>
                                            <!-- Botón Eliminar -->
                                            <form action="{{ route('cliente.destroy', $cliente->id) }}" method="POST" style="display: inline-block;" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger delete-button">
                                                    <i class="fas fa-trash"></i> Eliminar
                                                </button>
                                            </form>

                                            <script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    const deleteButtons = document.querySelectorAll('.delete-button');
                                                    deleteButtons.forEach(button => {
                                                        button.addEventListener('click', function() {
                                                            const form = this.closest('.delete-form');
                                                            Swal.fire({
                                                                title: '¿Estás seguro?',
                                                                text: "¡No podrás revertir esto!",
                                                                icon: 'warning',
                                                                showCancelButton: true,
                                                                confirmButtonColor: '#3085d6',
                                                                cancelButtonColor: '#d33',
                                                                confirmButtonText: 'Sí, eliminar',
                                                                cancelButtonText: 'Cancelar'
                                                            }).then((result) => {
                                                                if (result.isConfirmed) {
                                                                    form.submit();
                                                                }
                                                            });
                                                        });
                                                    });
                                                });
                                            </script>
                                        </td>

                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No hay clientes registrados.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <!-- Paginación -->
                            {{ $clientes->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Agregar Cliente -->
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Agregar Nuevo Cliente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulario de agregar cliente -->
                        <form action="/cliente-register" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nombre_completo" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre_completo" class="form-label">Paterno</label>
                                <input type="text" class="form-control" id="paterno" name="paterno" required>
                            </div>
                            <div class="mb-3">
                                <label for="nombre_completo" class="form-label">Materno</label>
                                <input type="text" class="form-control" id="materno" name="materno" required>
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Telefono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono">
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">C.I</label>
                                <input type="text" class="form-control" id="ci" name="ci">
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Correo</label>
                                <input type="text" class="form-control" id="correo" name="correo">
                            </div>


                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Agregar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de Editar Cliente -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Editar Cliente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulario de editar cliente -->
                        <form action="" method="POST" id="editForm">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="edit_nombre_completo" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="edit_nombre" name="nombre" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_nombre_completo" class="form-label">Paterno</label>
                                <input type="text" class="form-control" id="edit_paterno" name="paterno" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_nombre_completo" class="form-label">Materno</label>
                                <input type="text" class="form-control" id="edit_materno" name="materno" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_telefono" class="form-label">Telefono</label>
                                <input type="text" class="form-control" id="edit_telefono" name="telefono">
                            </div>
                            <div class="mb-3">
                                <label for="edit_telefono" class="form-label">C.I</label>
                                <input type="text" class="form-control" id="edit_ci" name="ci">
                            </div>
                            <div class="mb-3">
                                <label for="edit_telefono" class="form-label">Correo</label>
                                <input type="text" class="form-control" id="edit_correo" name="correo">
                            </div>


                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts -->
        <script>
            // Llama a la función para mostrar la alerta de licencia expirada si corresponde
            // Llenar el formulario de editar con los datos del cliente
            const editModal = document.getElementById('editModal');
            editModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget; // El botón que activó el modal
                const id = button.getAttribute('data-id'); // Obtener el ID del cliente desde el atributo 'data-id'
                const form = document.getElementById('editForm');
                form.action = '/cliente-update/' + id; // Establecer la acción del formulario con la ruta correcta

                // Hacer la solicitud Fetch para obtener los datos del cliente
                fetch(`/cliente/edit/${id}`)
                    .then(response => response.json())
                    .then(cliente => {
                        // Llenar los campos del formulario con los datos obtenidos
                        document.getElementById('edit_nombre').value = cliente.nombre;
                        document.getElementById('edit_paterno').value = cliente.paterno;
                        document.getElementById('edit_materno').value = cliente.materno;
                        document.getElementById('edit_telefono').value = cliente.telefono;
                        document.getElementById('edit_ci').value = cliente.ci;
                        document.getElementById('edit_correo').value = cliente.correo;
                    })
                    .catch(error => {
                        console.error('Error al obtener los datos del cliente:', error);
                    });
            });



            // Función para realizar la búsqueda en tiempo real
            document.getElementById('searchInput').addEventListener('input', function() {
                const query = this.value;

                // Realiza una solicitud AJAX para obtener los resultados de búsqueda
                fetch(`/clientes/search?query=${query}`)
                    .then(response => response.json())
                    .then(data => {
                        // Actualiza la tabla con los nuevos resultados
                        const tableBody = document.querySelector('table tbody');
                        tableBody.innerHTML = '';

                        // Si hay resultados, los añadimos a la tabla
                        if (data.length > 0) {
                            data.forEach(cliente => {
                                const row = document.createElement('tr');
                                row.innerHTML = `
                            <td class="text-center">${cliente.nombre_completo}</td>
                            <td class="text-center">${cliente.ci}</td>
                            <td class="text-center">${cliente.telefono}</td>
                            <td class="text-center">${cliente.correo}</td>
                            <td class="text-center">
                                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal" data-id="${cliente.id}">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                            </td>
                        `;
                                tableBody.appendChild(row);
                            });
                        } else {
                            // Si no hay resultados, mostramos un mensaje
                            tableBody.innerHTML = '<tr><td colspan="5" class="text-center">No hay clientes encontrados.</td></tr>';
                        }
                    })
                    .catch(error => {
                        console.error('Error al buscar clientes:', error);
                    });
            });
        </script>


    </main>
</x-layout>