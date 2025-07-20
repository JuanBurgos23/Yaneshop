<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Fitrium Fitness - Club</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/jvectormap/jquery-jvectormap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/flag-icon-css/css/flag-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/owl-carousel-2/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/owl-carousel-2/owl.theme.default.min.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('inicio/images/11 (3).jpg') }}" />


</head>

<body class="{{ $bodyClass }}">

    <div class="container-scroller">


        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
                <a class="sidebar-brand brand-logo" href="{{ route('home') }}">
                    <p style="font-size: 28px; color: black; font-weight: bold; margin-top: 10px; font-family: 'Times New Roman', Times, serif;">YANE SHOP</p>
                </a>

                <a class="sidebar-brand brand-logo-mini" href="{{ route('home') }}">
                    <p style="font-size: 28px; color: black; font-weight: bold; margin-top: 10px; font-family: 'Times New Roman', Times, serif;">YS</p>
                </a>
            </div>
            <ul class="nav">
                <li class="nav-item profile">
                    <div class="profile-desc">
                        <div class="profile-pic">
                            <div class="count-indicator">
                                <img class="img-xs rounded-circle " src="{{ auth::user()->imagen ? asset('storage/'.auth::user()->imagen) : asset('inicio/images/avatar.jpg') }}" alt="">
                                <span class="count bg-success"></span>
                            </div>
                            <div class="profile-name">
                                <h5 class="mb-0 font-weight-normal">{{ auth::user()->name }}</h5>

                            </div>
                        </div>


                    </div>
                </li>
                @php
                $registrosRoutes = [
                'mostrar_cliente',
                'mostrar_inscripcion',
                'historial_inscripciones',
                'historial_cliente',
                'historial_recibos_cliente',
                'mostrar_paquete',
                'mostrar_casillero',
                'mostrar_empleado',
                ];

                $productosRoutes = [
                'productos',
                'mostrar_categoria',
                'productos.masivo',
                ];
                @endphp
                <li class="nav-item nav-category">
                    <span class="nav-link">Modulos</span>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" href="{{ route('home') }}">
                        <span class="menu-icon">
                            <i class="mdi mdi-speedometer"></i>
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic"
                        aria-expanded="{{ in_array(Route::currentRouteName(), $registrosRoutes) ? 'true' : 'false' }}"
                        aria-controls="ui-basic">
                        <span class="menu-icon">
                            <i class="mdi mdi-laptop"></i>
                        </span>
                        <span class="menu-title">Registros</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse {{ in_array(Route::currentRouteName(), $registrosRoutes) ? 'show' : '' }}"
                        id="ui-basic">
                        <ul class="nav flex-column sub-menu">

                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('mostrar_cliente') ? 'active' : '' }}" href="{{ route('mostrar_cliente') }}">
                                    Cliente
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
                <li class="nav-item menu-items">
                    <a class="nav-link" data-bs-toggle="collapse" href="#collapseVentas"
                        aria-expanded="{{ in_array(Route::currentRouteName(), $productosRoutes) ? 'true' : 'false' }}"
                        aria-controls="collapseVentas">
                        <span class="menu-icon">
                            <i class="mdi mdi-laptop"></i>
                        </span>
                        <span class="menu-title">Productos</span>
                        <i class="menu-arrow"></i>
                    </a>
                    <div class="collapse {{ in_array(Route::currentRouteName(), $productosRoutes) ? 'show' : '' }}"
                        id="collapseVentas">
                        <ul class="nav flex-column sub-menu">

                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('mostrar_categoria') ? 'active' : '' }}" href="{{ route('mostrar_categoria') }}">
                                    Registrar Categoria
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ Route::is('productos') ? 'active' : '' }}" href="{{ route('productos') }}">
                                    Registrar un Producto
                                </a>
                            </li>



                        </ul>
                    </div>
                </li>



            </ul>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_navbar.html -->
            <nav class="navbar p-0 fixed-top d-flex flex-row">
                <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
                    <a class="navbar-brand brand-logo-mini" href="#"><img src="{{ asset('inicio/images/11 (2).jpg') }}" alt="logo" /></a>
                </div>
                <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                        <span class="mdi mdi-menu"></span>
                    </button>

                    <ul class="navbar-nav navbar-nav-right">
                        <!--<li class="nav-item dropdown border-left">
                            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
                                <i class="mdi mdi-bell"></i>
                                <span class="count bg-danger"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                                <h6 class="p-3 mb-0">Notifications</h6>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-calendar text-success"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">Event today</p>
                                        <p class="text-muted ellipsis mb-0"> Just a reminder that you have an event today </p>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-cog text-danger"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">Settings</p>
                                        <p class="text-muted ellipsis mb-0"> Update dashboard </p>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-link-variant text-warning"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">Launch Admin</p>
                                        <p class="text-muted ellipsis mb-0"> New admin wow! </p>
                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <p class="p-3 mb-0 text-center">See all notifications</p>
                            </div>
                        </li>-->
                        <li class="nav-item dropdown">
                            <a class="nav-link" id="profileDropdown" href="#" data-toggle="dropdown">
                                <div class="navbar-profile">
                                    <img class="img-xs rounded-circle" src="{{ auth::user()->imagen ? asset('storage/'.auth::user()->imagen) : asset('inicio/images/avatar.jpg') }}" alt="">
                                    <p class="mb-0 d-none d-sm-block navbar-profile-name">{{ auth::user()->name }}</p>
                                    <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                                <h6 class="p-3 mb-0">Perfil</h6>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item" href="{{ route('mostrar_perfil') }}">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-cog text-success"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1">Configuracion</p>

                                    </div>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item preview-item">
                                    <div class="preview-thumbnail">
                                        <div class="preview-icon bg-dark rounded-circle">
                                            <i class="mdi mdi-logout text-danger"></i>
                                        </div>
                                    </div>
                                    <div class="preview-item-content">
                                        <p class="preview-subject mb-1" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Cerrar Session</p>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </a>
                            </div>
                        </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                        <span class="mdi mdi-format-line-spacing"></span>
                    </button>
                </div>
            </nav>
            <!-- partial -->
            <div class="main-panel content-wrapper">


                {{ $slot }}

                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->

                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script>
        const toggleModeBtn = document.getElementById('toggleModeBtn');
        const body = document.body;
        const containerScroller = document.querySelector('.container-scroller');
        const contentWrapper = document.querySelector('.content-wrapper');

        // Verificar el modo actual al cargar la página (usando LocalStorage)
        if (localStorage.getItem('mode') === 'dark') {
            body.classList.add('dark-mode');
            containerScroller.classList.add('dark-mode');
            contentWrapper.classList.add('dark-mode');
            toggleModeBtn.textContent = 'Cambiar a Modo Claro'; // Cambiar el texto del botón
        } else {
            body.classList.add('light-mode');
            containerScroller.classList.add('light-mode');
            contentWrapper.classList.add('light-mode');
            toggleModeBtn.textContent = 'Cambiar a Modo Oscuro'; // Cambiar el texto del botón
        }

        // Agregar evento al botón para alternar entre modos
        toggleModeBtn.addEventListener('click', () => {
            if (body.classList.contains('light-mode')) {
                // Cambiar a modo oscuro
                body.classList.remove('light-mode');
                containerScroller.classList.remove('light-mode');
                contentWrapper.classList.remove('light-mode');
                body.classList.add('dark-mode');
                containerScroller.classList.add('dark-mode');
                contentWrapper.classList.add('dark-mode');
                toggleModeBtn.textContent = 'Cambiar a Modo Claro';
                localStorage.setItem('mode', 'dark'); // Guardar la preferencia en LocalStorage
            } else {
                // Cambiar a modo claro
                body.classList.remove('dark-mode');
                containerScroller.classList.remove('dark-mode');
                contentWrapper.classList.remove('dark-mode');
                body.classList.add('light-mode');
                containerScroller.classList.add('light-mode');
                contentWrapper.classList.add('light-mode');
                toggleModeBtn.textContent = 'Cambiar a Modo Oscuro';
                localStorage.setItem('mode', 'light'); // Guardar la preferencia en LocalStorage
            }
        });
    </script>
    <script src="{{asset('assets/vendors/js/vendor.bundle.base.js')}}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{asset('assets/vendors/chart.js/chart.umd.js')}}"></script>
    <script src="{{asset('assets/vendors/progressbar.js/progressbar.min.js')}}"></script>
    <script src="{{asset('assets/vendors/jvectormap/jquery-jvectormap.min.js')}}"></script>
    <script src="{{asset('assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
    <script src="{{asset('assets/vendors/owl-carousel-2/owl.carousel.min.js')}}"></script>
    <script src="{{asset('assets/js/jquery.cookie.js')}}" type="text/javascript"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{asset('assets/js/off-canvas.js')}}"></script>
    <script src="{{asset('assets/js/misc.js')}}"></script>
    <script src="{{asset('assets/js/settings.js')}}"></script>
    <script src="{{asset('assets/js/todolist.js')}}"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="{{asset('assets/js/proBanner.js')}}"></script>
    <script src="{{asset('assets/js/dashboard.js')}}"></script>
    <!-- End custom js for this page -->
    <script src="{{asset('vendorsAdmin/scripts/core.js')}}"></script>
    <script src="{{asset('vendorsAdmin/scripts/script.min.js')}}"></script>
    <script src="{{asset('vendorsAdmin/scripts/process.js')}}"></script>
    <script src="{{asset('vendorsAdmin/scripts/layout-settings.js')}}"></script>
    <script src="{{asset('src/plugins/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{asset('src/plugins/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('src/plugins/datatables/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('src/plugins/datatables/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('src/plugins/datatables/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('vendorsAdmin/scripts/dashboard.js')}}"></script>
    <script src="{{asset('src/plugins/jquery-steps/jquery.steps.js')}}"></script>
    <script src="{{asset('vendorsAdmin/scripts/steps-setting.js')}}"></script>

    <!-- buttons for Export datatable -->
    <script src="{{asset('src/plugins/datatables/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('src/plugins/datatables/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('src/plugins/datatables/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('src/plugins/datatables/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('src/plugins/datatables/js/buttons.flash.min.js')}}"></script>
    <script src="{{asset('src/plugins/datatables/js/pdfmake.min.js')}}"></script>


    <script src="{{asset('src\plugins\datatables')}}"></script>

    <!-- buttons for Export datatable -->
    <!-- plugins:js -->
    <script src="{{ asset('assets/vendorsAdmin/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="{{ asset('assets/vendorsAdmin/chart.js/chart.umd.js') }}"></script>
    <!-- End plugin js for this page -->

    <!-- Custom js for this page -->
    <script src="{{ asset('assets/js/chart.js') }}"></script>
    <!-- End custom js for this page -->

    <!-- Datatable Setting js -->
    <script src="{{ asset('vendorsAdmin/scripts/datatable-setting.js') }}"></script>
    @stack('js')
</body>

</html>