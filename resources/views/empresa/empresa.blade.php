<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @extends('layouts.suscripcionAviso')
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <div class="container-fluid py-4">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 d-flex justify-content-between align-items-center">
                        <h2 class="text-primary">Mi Empresa</h2>
                        @if(!auth()->user()->empresa)
                        <!-- Si el usuario NO tiene empresa, mostramos el botón -->
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalRegistro">
                            <i class="fas fa-plus"></i> Nueva Empresa
                        </button>
                        @endif
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0 text-center">
                                <thead>
                                    <tr>
                                        <th>Logotipo</th>
                                        <th>Nombre</th>
                                        <th>Teléfono WhatsApp</th>
                                        <th>Dirección</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($empresas as $empresa)
                                    <tr>
                                        <td>
                                            @if($empresa->logo)
                                            <img src="{{ asset('storage/'.$empresa->logo) }}" class="logo-thumb" style="width:50px;height:50px;cursor:pointer">
                                            @else
                                            <span class="text-muted">Sin logo</span>
                                            @endif
                                        </td>
                                        <td>{{ $empresa->nombre }}</td>
                                        <td>{{ $empresa->telefono_whatsapp }}</td>
                                        <td>{{ $empresa->direccion }}</td>
                                        <td>
                                            <button class="btn btn-warning btn-sm btn-editar" data-id="{{ $empresa->id }}">
                                                <i class="fas fa-edit"></i> Editar
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-muted">No tienes empresas registradas</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Registro -->
        <div class="modal fade" id="modalRegistro" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="formRegistro" action="{{ route('empresa.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Registrar Empresa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Nombre</label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Teléfono WhatsApp</label>
                                <input type="text" name="telefono_whatsapp" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Dirección</label>
                                <input type="text" name="direccion" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label>Tipo de Suscripción</label>
                                <select name="tipo_suscripcion" id="tipoSuscripcion" class="form-control" required>
                                    <option value="mes">Mensual</option>
                                    <option value="trimestre">Trimestral</option>
                                    <option value="semestre">Semestral</option>
                                    <option value="anual">Anual</option>
                                    <option value="opcional">Opcional</option>
                                </select>
                            </div>

                            <div class="mb-3" id="opcionalMesesWrapper" style="display:none; transition: all 0.3s ease;">
                                <label>Cantidad de Meses</label>
                                <input type="number" name="cantidad_meses" id="cantidadMeses" class="form-control" min="1">
                            </div>
                            <div class="mb-3">
                                <label>Logotipo</label>
                                <input type="file" name="logo" class="form-control" id="inputLogo" accept="image/*">
                                <div class="mt-2" id="previewLogo" style="display:none;">
                                    <img src="" id="logoPreviewImg" style="width:100px;height:auto;cursor:pointer">
                                    <button type="button" class="btn btn-danger btn-sm mt-2" id="btnQuitarLogo">Quitar</button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Edición (se llenará por JS) -->
        <div class="modal fade" id="modalEditar" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="formEditar" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="editId">
                        <div class="modal-header">
                            <h5 class="modal-title">Editar Empresa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label>Nombre</label>
                                <input type="text" name="nombre" id="editNombre" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Teléfono WhatsApp</label>
                                <input type="text" name="telefono_whatsapp" id="editTelefono" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Dirección</label>
                                <input type="text" name="direccion" id="editDireccion" class="form-control">
                            </div>
                           
                                <div class="mb-3" @unlessrole('admin') style="display:none;" @endunlessrole>
                                    <label>Tipo de Suscripción</label>
                                    <select name="tipo_suscripcion" id="editTipoSuscripcion" class="form-control">
                                        <option value="mes">Mensual</option>
                                        <option value="trimestre">Trimestral</option>
                                        <option value="semestre">Semestral</option>
                                        <option value="anual">Anual</option>
                                        <option value="opcional">Opcional</option>
                                    </select>
                                </div>

                                <div class="mb-3" id="editOpcionalMesesWrapper" style="display:none; transition: all 0.3s ease;">
                                    <label>Cantidad de Meses</label>
                                    <input type="number" name="cantidad_meses" id="editCantidadMeses" class="form-control" min="1">
                                </div>
                           
                            <div class="mb-3">
                                <label>Logotipo</label>
                                <input type="file" name="logo" id="editLogoInput" class="form-control" accept="image/*">
                                <div class="mt-2" id="editPreviewLogo" style="display:none;">
                                    <img src="" id="editLogoPreviewImg" style="width:100px;height:auto;cursor:pointer">
                                    <button type="button" class="btn btn-danger btn-sm mt-2" id="btnQuitarLogoEdit">Quitar</button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.getElementById('editTipoSuscripcion').addEventListener('change', function () {
        const wrapper = document.getElementById('editOpcionalMesesWrapper');
        if (this.value === 'opcional') {
            wrapper.style.display = 'block';
        } else {
            wrapper.style.display = 'none';
            document.getElementById('editCantidadMeses').value = '';
        }
    });
    </script>
    <script>
        // Previsualizar logo en registro
        document.getElementById('inputLogo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                document.getElementById('previewLogo').style.display = 'block';
                document.getElementById('logoPreviewImg').src = URL.createObjectURL(file);
            }
        });
        document.getElementById('btnQuitarLogo').addEventListener('click', function() {
            document.getElementById('inputLogo').value = '';
            document.getElementById('previewLogo').style.display = 'none';
        });

        // Abrir imagen en grande
        document.getElementById('logoPreviewImg').addEventListener('click', function() {
            Swal.fire({
                imageUrl: this.src,
                imageAlt: 'Logo',
                showConfirmButton: false
            });
        });

        // Abrir modal de edición con datos
        document.querySelectorAll('.btn-editar').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                fetch(`/empresa/${id}/edit`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('editId').value = data.id;
                    document.getElementById('editNombre').value = data.nombre;
                    document.getElementById('editTelefono').value = data.telefono_whatsapp;
                    document.getElementById('editDireccion').value = data.direccion;

                    // 👇 Suscripción
                    document.getElementById('editTipoSuscripcion').value = data.tipo_suscripcion || 'mes';
                    if (data.tipo_suscripcion === 'opcional') {
                        document.getElementById('editOpcionalMesesWrapper').style.display = 'block';
                        // calcular diferencia entre fechas (meses) y asignar
                        if (data.fecha_inicio_suscripcion && data.fecha_fin_suscripcion) {
                            const start = new Date(data.fecha_inicio_suscripcion);
                            const end = new Date(data.fecha_fin_suscripcion);
                            const diff = (end.getFullYear() - start.getFullYear()) * 12 + (end.getMonth() - start.getMonth());
                            document.getElementById('editCantidadMeses').value = diff;
                        }
                    } else {
                        document.getElementById('editOpcionalMesesWrapper').style.display = 'none';
                    }

                    // Logo
                    if (data.logo) {
                        document.getElementById('editPreviewLogo').style.display = 'block';
                        document.getElementById('editLogoPreviewImg').src = `/storage/${data.logo}`;
                    } else {
                        document.getElementById('editPreviewLogo').style.display = 'none';
                    }

                    new bootstrap.Modal(document.getElementById('modalEditar')).show();
                });
            });
        });

        // Quitar logo en edición
        document.getElementById('btnQuitarLogoEdit').addEventListener('click', function() {
            document.getElementById('editLogoInput').value = '';
            document.getElementById('editPreviewLogo').style.display = 'none';
        });

        // Ver imagen grande en edición
        document.getElementById('editLogoPreviewImg').addEventListener('click', function() {
            Swal.fire({
                imageUrl: this.src,
                imageAlt: 'Logo',
                showConfirmButton: false
            });
        });

        // Actualizar empresa
        document.getElementById('formEditar').addEventListener('submit', function(e) {
            e.preventDefault();

            const id = document.getElementById('editId').value;
            const formData = new FormData(this);
            formData.append('_method', 'PUT'); // Forzar método PUT

            console.log("Enviando formulario para empresa ID:", id);
            for (const [key, value] of formData.entries()) {
                console.log(key, value);
            }

            fetch(`/empresa/${id}`, {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                })
                .then(async res => {
                    let data;
                    try {
                        data = await res.json();
                    } catch (e) {
                        throw new Error('Respuesta no es JSON válido');
                    }

                    if (!res.ok || !data.success) {
                        throw new Error(data.message || 'No se pudo actualizar la empresa');
                    }

                    return data;
                })
                .then(data => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Actualizado',
                        text: data.message || 'La empresa fue actualizada correctamente'
                    }).then(() => location.reload());
                })
                .catch(err => {
                    console.error(err);
                    Swal.fire('Error', err.message || 'Hubo un problema en el servidor', 'error');
                });
        });
        
    </script>
<script>
    document.getElementById('tipoSuscripcion').addEventListener('change', function () {
        const wrapper = document.getElementById('opcionalMesesWrapper');
        if (this.value === 'opcional') {
            wrapper.style.display = 'block';
        } else {
            wrapper.style.display = 'none';
            document.getElementById('cantidadMeses').value = '';
        }
    });
</script>
</x-layout>