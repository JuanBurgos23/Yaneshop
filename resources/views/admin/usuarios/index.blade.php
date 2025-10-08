<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-3 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                            <h2 class="mb-2 mb-md-0">Gestión de Usuarios y Empresas</h2>
                            <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-md-auto">
                                <input type="text" id="search" class="form-control" placeholder="Buscar usuario, empresa, CI...">
                                <select id="per-page" class="form-select">
                                    <option value="10" selected>10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                </select>
                            </div>
                            <button class="btn btn-primary mb-3" onclick="openCreateUserModal()">Registrar Usuario</button>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Usuario</th>
                                            <th>CI</th>
                                            <th>Empresa</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="usuarios-table">
                                        <!-- filas dinámicas -->
                                    </tbody>
                                </table>
                            </div>
                            <div id="pagination" class="mt-3 d-flex flex-wrap justify-content-center gap-1"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

   <!-- Modal Crear Empresa -->
<div class="modal fade" id="createEmpresaModal" tabindex="-1" aria-labelledby="createEmpresaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="createEmpresaForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar Empresa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="modal_user_id">

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre Empresa</label>
                        <input type="text" class="form-control" name="nombre" required>
                    </div>

                    <div class="mb-3">
                        <label for="tipo_suscripcion" class="form-label">Tipo de Suscripción</label>
                        <select class="form-select" id="tipo_suscripcion" name="tipo_suscripcion" required>
                            <option value="mensual">Mensual</option>
                            <option value="semestral">Semestral</option>
                            <option value="anual">Anual</option>
                            <option value="personalizado">Personalizado</option>
                        </select>
                    </div>

                    <div class="mb-3 d-none" id="mesesInput">
                        <label for="cantidad_meses" class="form-label">Cantidad de meses</label>
                        <input type="number" class="form-control" name="cantidad_meses" min="1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal Crear Usuario -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="createUserForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre completo</label>
                        <input type="text" class="form-control" name="name" placeholder="Nombre completo" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" name="email" placeholder="email@dominio.com" required>
                    </div>

                    <div class="mb-3 position-relative">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" name="password" id="passwordInput" placeholder="Contraseña" required>
                        <button type="button" class="btn btn-sm btn-outline-secondary position-absolute top-50 end-0 translate-middle-y me-2" 
                                onclick="togglePassword()">
                            <i class="bi bi-eye" id="passwordIcon"></i>
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </form>
    </div>
</div>

    <script>
    let currentPage = 1;

    async function cargarUsuarios(page = 1) {
        const query = document.getElementById('search').value;
        const perPage = document.getElementById('per-page').value;

        const res = await fetch(`/admin/usuarios/buscar?query=${query}&page=${page}&per_page=${perPage}`);
        const data = await res.json();

        let tbody = document.getElementById('usuarios-table');
        tbody.innerHTML = '';

        if (data.data.length === 0) {
            tbody.innerHTML = `<tr><td colspan="4" class="text-center">No se encontraron resultados</td></tr>`;
        } else {
            data.data.forEach(usuario => {
                let acciones = '';

                // si no tiene empresa -> mostrar botón crear empresa
                if (!usuario.empresa) {
                    acciones += `
                        <button class="btn btn-sm btn-success mb-1 mb-sm-0 me-1" onclick="openCreateModal(${usuario.id})">
                            Crear Empresa
                        </button>
                    `;
                }

                // siempre botón eliminar
                acciones += `
                    <button class="btn btn-sm btn-danger" onclick="eliminarUsuario(${usuario.id})">
                        Eliminar
                    </button>
                `;

                tbody.innerHTML += `
                    <tr>
                        <td>${usuario.name ?? ''} ${usuario.paterno ?? ''} ${usuario.materno ?? ''}</td>
                        <td>${usuario.ci ?? ''}</td>
                        <td>
                            ${usuario.empresa ? usuario.empresa.nombre : '<span class="badge bg-danger">Sin empresa</span>'}
                        </td>
                        <td class="d-flex flex-column flex-sm-row gap-1">${acciones}</td>
                    </tr>
                `;
            });
        }

        // Paginación
        let pagination = document.getElementById('pagination');
        pagination.innerHTML = '';

        if (data.last_page > 1) {
            for (let i = 1; i <= data.last_page; i++) {
                pagination.innerHTML += `
                    <button class="btn btn-sm ${i === data.current_page ? 'btn-primary' : 'btn-outline-primary'} mx-1 mb-1"
                            onclick="cargarUsuarios(${i})">
                        ${i}
                    </button>
                `;
            }
        }
    }

    // Eventos
    document.getElementById('search').addEventListener('keyup', () => cargarUsuarios(1));
    document.getElementById('per-page').addEventListener('change', () => cargarUsuarios(1));

    // Cargar al inicio
    cargarUsuarios();
</script>
    <script>
    // 🔹 Abrir modal con id_user
    // Abrir modal con id_user
function openCreateModal(userId) {
    document.getElementById('modal_user_id').value = userId;
    let modal = new bootstrap.Modal(document.getElementById('createEmpresaModal'));
    modal.show();
}

// Mostrar input de meses si es personalizado
document.getElementById('tipo_suscripcion').addEventListener('change', function() {
    let mesesInput = document.getElementById('mesesInput');
    if (this.value === 'personalizado') {
        mesesInput.classList.remove('d-none');
    } else {
        mesesInput.classList.add('d-none');
    }
});

// Enviar formulario con fetch
document.getElementById('createEmpresaForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const userId = document.getElementById('modal_user_id').value;
    const form = this;

    const formData = new FormData(form);

    try {
        const res = await fetch(`/admin/usuarios/${userId}/empresa`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        });

        // Revisar si hubo error de respuesta
        if (!res.ok) {
            throw new Error('HTTP status ' + res.status);
        }

        const data = await res.json();

        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            });

            let modalEl = document.getElementById('createEmpresaModal');
            let modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();

            cargarUsuarios(); // recargar tabla
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'No se pudo registrar la empresa'
            });
        }
    } catch (err) {
        console.error(err);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ocurrió un error inesperado, revisa consola'
        });
    }
});
</script>
<script>
    // Abrir modal
    function openCreateUserModal() {
        let modal = new bootstrap.Modal(document.getElementById('createUserModal'));
        modal.show();
    }

    // Mostrar/ocultar contraseña
    function togglePassword() {
        const passwordInput = document.getElementById('passwordInput');
        const icon = document.getElementById('passwordIcon');
        if(passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            passwordInput.type = "password";
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }

    // Por ahora solo prevenimos el submit para luego agregar fetch
    document.getElementById('createUserForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    try {
        const res = await fetch("{{ route('admin.usuarios.crear') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        });

        const data = await res.json();

        if(data.success) {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: data.message,
                confirmButtonText: 'Aceptar'
            });

            // Cerrar modal
            let modalEl = document.getElementById('createUserModal');
            let modal = bootstrap.Modal.getInstance(modalEl);
            modal.hide();

            // Limpiar formulario
            this.reset();

            // Recargar tabla de usuarios si existe la función
            if(typeof cargarUsuarios === "function") {
                cargarUsuarios();
            }

        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error al registrar el usuario'
            });
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Ocurrió un error inesperado'
        });
        console.error(error);
    }
});
</script>
</x-layout>
