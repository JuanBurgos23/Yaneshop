<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <style>
            .custom-file-input {
                display: none;
                /* Oculta el input original */
            }

            .custom-file-label {
                background-color: #007bff;
                color: white;
                /* Cambia el color del texto */
                padding: 10px 15px;
                border-radius: 5px;
                cursor: pointer;
                display: inline-block;
            }

            .custom-file-label:hover {
                background-color: #0056b3;
            }

            .btn-close {
                filter: invert(40%) sepia(100%) saturate(500%) hue-rotate(200deg);
                /* Cambia el color */
                opacity: 1;
                /* Asegura que sea visible */
            }

            .btn-close:hover {
                filter: invert(20%) sepia(100%) saturate(800%) hue-rotate(190deg);
            }
        </style>
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl">
            <!-- Navbar content -->
        </nav>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
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

                <div class="container mt-5">
                    <div class="card shadow-lg p-4">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <img id="profileImage" src="{{ $user->imagen ? asset('storage/'.$user->imagen) : asset('inicio/images/avatar.jpg') }}"
                                    class="rounded-circle shadow-sm" width="150" height="150">
                                <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#editPhotoModal">Cambiar Foto</button>
                            </div>
                            <div class="col-md-8">
                                <h4 class="mb-4">Perfil de Usuario</h4>
                                <form method="POST" action="{{ route('user.perfilUpdate') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Nombre</label>
                                        <input type="text" name="name" class="form-control" value="{{ $user->name }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Paterno</label>
                                        <input type="text" name="paterno" class="form-control" value="{{ $user->paterno ?? 'N/A'}}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Materno</label>
                                        <input type="text" name="materno" class="form-control" value="{{ $user->materno ?? 'N/A'}}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">C.I</label>
                                        <input type="text" name="ci" class="form-control" value="{{ $user->ci ?? 'N/A'}}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Correo Electrónico</label>
                                        <input type="email" name="email" class="form-control" value="{{ $user->email }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="password">Nueva Contraseña</label>
                                        <input type="password" name="password" class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Celular</label>
                                        <input type="text" name="telefono" class="form-control" value="{{ $user->telefono ?? 'N/A' }}">
                                    </div>
                                    <button type="submit" class="btn btn-success">Actualizar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal para cambiar la foto de perfil -->
                <div class="modal fade" id="editPhotoModal" tabindex="-1" aria-labelledby="editPhotoModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Cambiar Foto de Perfil</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body text-center">
                                <img id="previewImage" src="{{ $user->imagen ? asset('storage/'.$user->imagen) : asset('inicio/images/avatar.jpg') }}"
                                    class="rounded-circle shadow-sm mb-3" width="150" height="150">
                                <form method="POST" action="{{ route('user.updateAvatar', $user->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('POST')
                                    <label for="avatar" class="custom-file-label">Seleccionar archivo</label>
                                    <input type="file" name="avatar" id="avatar" class="custom-file-input" accept="image/*" onchange="previewFile(this)">
                                    <button type="submit" class="btn btn-primary ">Actualizar Foto</button>
                                </form>

                                <!-- Formulario para restaurar imagen por defecto -->
                                <form method="POST" action="{{ route('user.deleteAvatar', $user->id) }}">
                                    @csrf
                                    @method('DELETE') <!-- Esto indica que estamos usando el método DELETE -->
                                    <button type="submit" class="btn btn-danger mt-3">Restaurar Imagen por Defecto</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    function previewFile(input) {
                        let file = input.files[0];
                        if (file) {
                            let reader = new FileReader();
                            reader.onload = function(e) {
                                document.getElementById('previewImage').src = e.target.result;
                            }
                            reader.readAsDataURL(file);
                        }
                    }
                </script>

            </div>
        </div>
    </main>

</x-layout>