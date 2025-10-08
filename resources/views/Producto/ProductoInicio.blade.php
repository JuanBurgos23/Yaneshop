<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $empresa->nombre }}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ Storage::url($empresa->logo) }}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/iconic/css/material-design-iconic-font.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('fonts/linearicons-v1.0.0/icon-font.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/animate/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/css-hamburgers/hamburgers.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/animsition/css/animsition.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/slick/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/MagnificPopup/magnific-popup.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .wrap-slick3-dots ul.slick3-dots {
            display: flex !important;
            justify-content: start;
            padding: 10px 0;
            gap: 10px;
            flex-wrap: wrap;
        }

        /* Imagen o video miniatura */
        .wrap-slick3-dots img,
        .wrap-slick3-dots video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            border-radius: 4px;
            pointer-events: none;
        }

        .slick3-dot-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 2px solid transparent;
            border-radius: 4px;
            box-sizing: border-box;
            transition: border 0.2s ease;
        }

        .wrap-slick3 {
            position: relative;
        }

        /*---------------------------------------------*/
        .wrap-slick3-arrows {
            position: absolute;
            z-index: 100;
            width: 83.333333%;
            right: 0;
            top: calc(50% - 20px);
        }

        .arrow-slick3 {
            font-size: 25px;
            color: #fff;

            position: absolute;
            top: 0;
            width: 40px;
            height: 40px;
            background-color: rgba(0, 0, 0, 0.5);

            -webkit-transition: all 0.4s;
            -o-transition: all 0.4s;
            -moz-transition: all 0.4s;
            transition: all 0.4s;
        }

        .arrow-slick3:hover {
            background-color: rgba(0, 0, 0, 0.9);
        }

        .prev-slick3 {
            left: 0px;
        }

        .next-slick3 {
            right: 0px;
        }

        /*---------------------------------------------*/
        .wrap-slick3-dots {
            width: 11.111111%;
        }

        .slick3 {
            width: 83.333333%;
        }

        .slick3-dots li {
            display: block;
            position: relative;
            width: 100%;
            margin-bottom: 27px;
        }

        .slick3-dots li img {
            width: 100%;
        }



        .slick3-dot-overlay:hover {
            border-color: #ccc;
        }

        .slick3-dots .slick-active .slick3-dot-overlay {
            border-color: #ccc;
        }



        .block1.wrap-pic-w img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* recorta si es necesario para llenar el contenedor */
            transition: transform 0.3s ease;
        }

        /* Contenedor para imágenes grandes (primeras 2) */
        .col-xl-6 .block1.wrap-pic-w {
            height: 400px;
            /* altura fija */
        }

        .col-xl-6 .block1.wrap-pic-w img {
            object-fit: contain;
            /* muestra la imagen completa sin recortar */
            width: 100%;
            height: 100%;
            background-color: #f5f5f5;
            /* opcional, para que el fondo no sea vacío */
        }

        /* Contenedor para imágenes pequeñas (últimas 3) */
        .col-xl-4 .block1.wrap-pic-w {
            height: 280px;
        }

        .col-xl-4 .block1.wrap-pic-w img {
            object-fit: cover;
            /* llena el espacio recortando si es necesario */
            width: 100%;
            height: 100%;
        }

        .block1.wrap-pic-w:hover img {
            transform: scale(1.05);
        }

        .item-slick1 {
            height: 450px;
            /* altura controlada del slider */
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .item-slick1 .container {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin-top: -30px;
            /* 🔼 Esto realmente lo sube */
            padding-bottom: 20px;
            gap: 15px;
        }


        .flex-col-c-m {
            text-align: center;
        }

        .layer-slick1 {
            margin-bottom: 20px;
            color: #fff;
        }

        /* responsive */
        @media (max-width: 768px) {
            .item-slick1 {
                height: 300px;
            }

            .layer-slick1 h2 {
                font-size: 24px;
            }
        }

        .swal2-container {
            z-index: 99999 !important;
        }

        /** header */
        /* Header general */
        .header-v3 .wrap-menu-desktop {
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .header-v3 .main-menu>li>a {
            color: #222 !important;
            font-weight: 600;
            padding: 20px 15px;
            transition: color 0.3s;
        }

        .header-v3 .main-menu>li>a:hover {
            color: #007bff !important;
            /* azul elegante al pasar el mouse */
        }

        .icon-header-item {
            color: #000 !important;
            /* Negro arriba */
            transition: color 0.3s;
        }

        .icon-header-item:hover {
            color: #007bff !important;
        }

        /* Mobile header background */
        .wrap-header-mobile {
            background-color: #fff;
            border-bottom: 1px solid #e5e5e5;
        }

        .logo-mobile img {
            max-height: 55px;
        }

        .menu-mobile {
            background-color: #fff;
        }

        .menu-mobile .main-menu-m li a {
            color: #333 !important;
            font-weight: 500;
        }

        .menu-mobile .main-menu-m li a:hover {
            color: #007bff !important;
        }

        .hamburger-inner,
        .hamburger-inner::before,
        .hamburger-inner::after {
            background-color: #333 !important;
        }

        /* Mejoras en botones/cart */
        .icon-header-noti::after {
            background-color: red;
            color: white;
            font-size: 12px;
        }

        /* Espaciado en íconos mobile */
        .wrap-icon-header .icon-header-item {
            font-size: 20px;
        }

        @media (max-width: 768px) {
            .main-menu>li>a {
                font-size: 14px;
            }

            .icon-header-item {
                font-size: 18px;
            }
        }

        /* Efecto al hacer scroll */
        .container-menu-desktop {
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .container-menu-desktop.scrolled {
            background-color: #222 !important;
            /* negro elegante */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .container-menu-desktop.scrolled .main-menu>li>a,
        .container-menu-desktop.scrolled .icon-header-item {
            color: #fff !important;
            /* letras blancas cuando está scrolleado */
        }

        .container-menu-desktop.scrolled .icon-header-item:hover {
            color: #007bff !important;
            /* azul si deseas al pasar mouse */
        }

        .empresa-nombre {
            font-size: 28px;
            font-weight: bold;
            text-align: center;
            color: black;
            white-space: nowrap;
            overflow: hidden;
            border-right: 3px solid;
            text-transform: uppercase;
            animation: blink 0.7s step-end infinite;
        }

        /* Pantallas pequeñas */
        @media (max-width: 768px) {
            .empresa-nombre {
                white-space: normal;
                /* 🔥 permite salto de línea */
                font-size: 20px;
            }
        }

        @media (max-width: 480px) {
            .empresa-nombre {
                font-size: 16px;
                /* 🔥 aún más chico */
            }
        }

        /* parpadeo del cursor */
        @keyframes blink {
            50% {
                border-color: transparent;
            }
        }

        .empresa-nombre {
            animation: blink 0.7s step-end infinite;
        }

        /* Cambia a blanco cuando el header esté con fondo negro */
        .header-scroll .empresa-nombre {
            color: white;
        }

        .limiter-menu-desktop {
            position: relative;
            /* importante para posicionar el título */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .menu-desktop {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }

        /* MOBILE: Estado inicial */
        .wrap-header-mobile .icon-header-item {
            color: #000 !important;
            /* Negro arriba */
        }

        /* MOBILE: Cuando se hace scroll */
        .wrap-header-mobile.scrolled .icon-header-item {
            color: #fff !important;
            /* Blanco al bajar */
        }

        .icon-header-item {
            color: #000 !important;
            /* Negro arriba */
            transition: color 0.3s ease;
        }

        /* Hover */
        .icon-header-item:hover {
            color: #007bff !important;
            /* Azul en hover */
        }

        /* Escritorio: scroll */
        .container-menu-desktop.scrolled .icon-header-item {
            color: #fff !important;
            /* Blanco al bajar */
        }

        /* Móvil: scroll */
        .wrap-header-mobile.scrolled .icon-header-item {
            color: #fff !important;
            /* Blanco al bajar */
        }

        /* Fondo del header móvil arriba */
        .wrap-header-mobile {
            background-color: transparent;
            transition: background-color 0.3s ease;
        }

        /* Fondo del header móvil al hacer scroll */
        .wrap-header-mobile.scrolled {
            background-color: rgba(0, 0, 0, 0.8);
            /* Fondo oscuro */
        }
        /* Botón flotante - estilo corporativo */
.btn-carrito-flotante {
    display: none;
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 60px;
    height: 60px;
    background: #007bff;
    color: #fff;
    border: none;
    border-radius: 50%;
    font-size: 26px;
    cursor: pointer;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    opacity: 0;
    transform: scale(0);
    transition: opacity 0.3s ease, transform 0.3s ease;
}

/* Contador */
.btn-carrito-flotante span {
    position: absolute;
    top: 5px;
    right: 5px;
    background: #dc3545;
    color: #fff;
    font-size: 13px;
    font-weight: bold;
    padding: 3px 7px;
    border-radius: 50%;
    display: none;
}

/* Animación cuando aparece */
.btn-carrito-flotante.show {
    opacity: 1;
    transform: scale(1);
}

/* Animación burbuja al agregar */
.btn-carrito-flotante.pop {
    animation: pop 0.4s ease;
}

@keyframes pop {
    0% { transform: scale(1); }
    40% { transform: scale(1.4); }
    70% { transform: scale(0.9); }
    100% { transform: scale(1); }
}

/* Mostrar solo en móvil */
@media (max-width: 768px) {
    .btn-carrito-flotante {
        display: flex;
    }
}

    </style>
</head>

<body class="animsition">

    <!-- Header -->
    <header class="header-v3">
        <!-- Header desktop -->
        <div class="container-menu-desktop trans-03">
            <div class="wrap-menu-desktop">
                <nav class="limiter-menu-desktop p-l-45">
                    <!-- Logo desktop -->
                    <a href="{{ url($empresa->slug) }}" class="logo">
                        <img src="{{ Storage::url($empresa->logo) }}" alt="IMG-LOGO">
                    </a>
                    <!-- Menu desktop -->
                    <div class="menu-desktop">
                        <h1 class="empresa-nombre" id="empresaNombre" data-text="{{ $empresa->nombre }}">
                            {{ $empresa->nombre }}
                        </h1>
                    </div>
                    <input type="number" name="empresa_id" hidden value="{{ $empresa->id }}" id="empresaId">
                    <!-- Icon header -->
                    <div class="wrap-icon-header flex-w flex-r-m h-full">
                        <div class="flex-c-m h-full p-r-25 bor6">
                            <div class="icon-header-item cl0 hov-cl1 trans-04 p-lr-11 icon-header-noti js-show-cart" data-notify>
                                <i class="zmdi zmdi-shopping-cart"></i>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
        <!-- Header Mobile -->
        <div class="wrap-header-mobile">
            <!-- Logo moblie -->
            <div class="logo-mobile">
                <a href="{{ url($empresa->slug) }}" class="logo">
                    <img src="{{ Storage::url($empresa->logo) }}" alt="IMG-LOGO">
                </a>
            </div>
            <h1 class="empresa-nombre" id="empresaNombre" data-text="{{ $empresa->nombre }}">
                {{ $empresa->nombre }}
            </h1>
            <!-- Icon header -->
            <div class="wrap-icon-header flex-w flex-r-m h-full m-r-15">
                <div class="flex-c-m h-full p-r-5">
                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 icon-header-noti js-show-cart" data-notify>
                        <i class="zmdi zmdi-shopping-cart"></i>
                    </div>
                </div>
            </div>
            <!-- Button show menu -->
            <!-- <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </div>-->
        </div>
        <!-- Menu Mobile -->
        <div class="menu-mobile">

        </div>
        <!-- Modal Search -->
        <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
            <button class="flex-c-m btn-hide-modal-search trans-04">
                <i class="zmdi zmdi-close"></i>
            </button>

            <form class="container-search-header">
                <div class="wrap-search-header">
                    <input class="plh0" type="text" name="search" placeholder="Search...">

                    <button class="flex-c-m trans-04">
                        <i class="zmdi zmdi-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </header>


    <!-- Sidebar -->

    <!-- Cart -->
    <div class="wrap-header-cart js-panel-cart">
        <div class="s-full js-hide-cart"></div>

        <div class="header-cart flex-col-l p-l-65 p-r-25">
            <div class="header-cart-title flex-w flex-sb-m p-b-8">
                <span class="mtext-103 cl2">
                    Carrito de compras
                </span>
                <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
                    <i class="zmdi zmdi-close"></i>
                </div>
            </div>

            <!-- CONTENIDO DEL CARRITO -->
            <div id="carrito-content" class="header-cart-content flex-w js-pscroll">
                <ul class="header-cart-wrapitem w-full">
                    <!-- Se rellena con JS -->
                </ul>

                <div class="w-full">
                    <div class="header-cart-total w-full p-tb-40">
                        Total: Bs. 0.00
                    </div>

                    <div class="header-cart-buttons flex-w w-full">
                        <button id="btn-whatsapp" class="flex-c-m stext-101 cl0 size-107 bg-success bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
                            Consultar por WhatsApp
                        </button>
                    </div>
                </div>
            </div>

            <!-- FORMULARIO DE REGISTRO -->
            <div id="registro-content" class="header-cart-content flex-w js-pscroll" style="display:none;">
                <div class="w-full p-t-20">
                    <h4 class="mtext-105 cl2 p-b-14">Datos para la consulta</h4>

                    <!-- Campo CI primero -->
                    <div class="m-b-12">
                        <input id="reg-telefono" type="text" class="size-114 bor4 stext-111 p-lr-15" placeholder="Teléfono">
                        <small id="telefono-status" class="stext-111"></small>
                    </div>

                    <div class="m-b-12">
                        <input id="reg-nombre" type="text" class="size-114 bor4 stext-111 p-lr-15" placeholder="Nombre completo">
                    </div>
                    <div class="m-b-12">
                        <input id="reg-direccion" type="text" class="size-114 bor4 stext-111 p-lr-15" placeholder="Dirección">
                    </div>
                    <div class="m-b-12">
                        <input id="reg-ciudad" type="text" class="size-114 bor4 stext-111 p-lr-15" placeholder="Ciudad">
                    </div>

                    <div class="flex-w m-t-20">
                        <button id="guardar-registro" class="flex-c-m stext-101 cl0 size-121 bg-success bor2 hov-btn3 p-lr-15 trans-04 m-r-8">
                            Registrar y Consultar
                        </button>
                        <button id="volver-carrito" class="flex-c-m stext-101 cl0 size-121 bg2 bor2 hov-btn2 p-lr-15 trans-04">
                            Volver
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Slider -->

    <!-- Banner -->
    <!-- Banner dinámico -->

    <!-- Product -->
    <section class="bg0 p-t-23 p-b-130">
        <div class="container">
            <div class="p-b-10">
                <h3 class="ltext-103 cl5">
                    Productos
                </h3>
            </div>

            <div class="flex-w flex-sb-m p-b-52">
                <div class="flex-w flex-l-m filter-tope-group m-tb-10 align-items-center">
                    <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1" data-filter="*">
                        Todos
                    </button>

                    {{-- Mostrar primeras 5 categorías como botones --}}
                    @foreach ($categorias->take(5) as $categoria)
                    <button
                        class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5"
                        data-filter=".{{ strtolower(Str::slug($categoria->nombre)) }}">
                        {{ $categoria->nombre }}
                    </button>
                    @endforeach

                    {{-- Si hay más de 5 categorías, mostrar select --}}
                    @if ($categorias->count() > 5)
                    <div id="select-categorias-wrapper" class="m-r-32 m-tb-5">
                        <select id="select-categorias" class="stext-106 cl6 bor3 trans-04 p-lr-10" style="height: 38px; border: 1px solid #ccc;">
                            <option value="">Más categorías</option>
                            @foreach ($categorias->skip(5) as $categoria)
                            <option value=".{{ strtolower(Str::slug($categoria->nombre)) }}">{{ $categoria->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                </div>



                <div class="flex-w flex-c-m m-tb-10">
                    <div class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
                        <i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
                        <i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                        Filter
                    </div>

                    <div class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-search">
                        <i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
                        <i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                        Buscar
                    </div>
                </div>

                <!-- Search product -->
                <div class="dis-none panel-search w-full p-t-10 p-b-15">
                    <div class="bor8 dis-flex p-l-15">
                        <button class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
                            <i class="zmdi zmdi-search"></i>
                        </button>

                        <input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="search-product" placeholder="Buscar producto">
                    </div>
                </div>

                <!-- Filter -->
                <div class="dis-none panel-filter w-full p-t-10">
                    <div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm">
                        <div class="filter-col2 p-r-15 p-b-27">
                            <div class="mtext-102 cl2 p-b-15">
                                Precios
                            </div>

                            <ul>
                                <li class="p-b-6">
                                    <a href="#" class="filter-link stext-106 trans-04 filter-link-active filter-price" data-min="0" data-max="10000">
                                        Todos
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a href="#" class="filter-link stext-106 trans-04 filter-price" data-min="0" data-max="50">
                                        Bs.0.00 - Bs.50.00
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a href="#" class="filter-link stext-106 trans-04 filter-price" data-min="50" data-max="100">
                                        Bs.50.00 - Bs.100.00
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a href="#" class="filter-link stext-106 trans-04 filter-price" data-min="100" data-max="150">
                                        Bs.100.00 - Bs.150.00
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a href="#" class="filter-link stext-106 trans-04 filter-price" data-min="150" data-max="200">
                                        Bs.150.00 - Bs.200.00
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a href="#" class="filter-link stext-106 trans-04 filter-price" data-min="200" data-max="100000">
                                        Bs.200.00+
                                    </a>
                                </li>
                            </ul>

                        </div>

                    </div>
                </div>
            </div>
            @if($promociones->count())
            <section class="p-t-30 p-b-20">
                <h4 class="text-center m-b-20">🔥 Promociones</h4>
                <div id="contenedorPromociones">
                    @include('catalogo.catalogoNuevos', ['productos' => $promociones])
                </div>

            </section>
            @endif

            @if($nuevos->count())
            <section class="p-t-30 p-b-20">
                <h4 class="text-center m-b-20">🆕 Nuevos</h4>
                <div id="contenedorNuevos">
                    @include('catalogo.catalogoNuevos', ['productos' => $nuevos])
                </div>

            </section>
            @endif

            @if($productos->count())
            <section class="p-t-30 p-b-20">
                <h4 class="text-center m-b-20">📦 Productos</h4>
                <div id="contenedorProductosNormales" class="row isotope-grid">
                    @foreach($productos as $producto)
                    <div class="col-6 col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item {{ strtolower(Str::slug($producto->categoria->nombre ?? '')) }}" data-precio="{{ $producto->precio }}">
                        <div class="block2">
                            @php
                            $imagen = $producto->imagenes->first();
                            $esNuevo = \Carbon\Carbon::parse($producto->created_at)->gt(now()->subDays(5));
                            @endphp
                            <div class="block2-pic hov-img0 {{ $esNuevo ? 'label-new' : '' }}" data-label="{{ $esNuevo ? 'New' : '' }}">
                                <img class="img-fluid" src="{{ $imagen ? asset('storage/' . $imagen->ruta) : asset('images/default.jpg') }}"
                                    alt="IMG-PRODUCT" style="object-fit: cover; width: 100%; height: 330px;">

                                <a href="#"
                                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1"
                                    data-product="{{ $producto->id }}">
                                    Ver Producto
                                </a>
                            </div>
                            <div class="block2-txt flex-w flex-t p-t-14">
                                <div class="block2-txt-child1 flex-col-l ">
                                    <div class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                        {{ $producto->nombre }}
                                    </div>
                                    <div class="js-extra-busqueda" style="display:none;">
                                        {{ $producto->descripcion }} {{ $producto->categoria->nombre ?? '' }}
                                    </div>
                                    <span class="stext-105 cl3">
                                        Bs. {{ number_format($producto->precio, 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

            </section>
            @endif

        </div>


    </section>


    <!-- Footer -->
    <footer>
        <div class="p-t-40">
            <p class="stext-107 cl6 txt-center">
                &copy; {{ date('Y') }} Sistema de <strong>TUXON</strong>

            </p>
        </div>

    </footer>


    <!-- Back to top -->
    <div class="btn-back-to-top" id="myBtn">
        <span class="symbol-btn-back-to-top">
            <i class="zmdi zmdi-chevron-up"></i>
        </span>
    </div>

    <!-- Modal1 -->
    <div class="wrap-modal1 js-modal1 p-t-60 p-b-20" style="display:none;">
        <div class="overlay-modal1 js-hide-modal1"></div>

        <div class="container">
            <div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
                <button class="how-pos3 hov3 trans-04 js-hide-modal1">
                    <img src="{{ asset('images/icons/icon-close.png') }}" alt="CLOSE">
                </button>

                <div class="row">
                    <div class="col-md-6 col-lg-7 p-b-30">
                        <div class="p-l-25 p-r-30 p-lr-0-lg">
                            <div class="wrap-slick3 flex-sb flex-w">
                                <div class="wrap-slick3-dots"></div>
                                <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

                                <div class="slick3 gallery-lb">
                                    <!-- Aquí cargaremos imágenes y videos dinámicamente -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-5 p-b-30">
                        <div class="p-r-50 p-t-5 p-lr-0-lg">
                            <h4 class="mtext-105 cl2 js-name-detail p-b-14"></h4>
                            <span class="mtext-106 cl2 js-price-detail"></span>
                            <p class="stext-102 cl3 p-t-23 js-desc-detail"></p>

                            <!-- Botones debajo de la descripción -->
                            <div class="p-t-25 flex-w">
                                <button id="mi-btn-add-to-cart"
                                    class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 m-r-10">
                                    <i class="zmdi zmdi-plus-circle-o m-r-5"></i> Agregar
                                </button>

                                <button id="btn-ver-carrito"
                                    class="btn-ver-carrito-wrapper flex-c-m stext-101 cl0 size-101 bg3 bor1 hov-btn3 p-lr-15 trans-04"
                                    style="position: relative;">
                                    <i class="zmdi zmdi-shopping-cart m-r-5"></i> Ver carrito
                                    <span id="contador-ver-carrito" style="
                                    background:red;
                                    color:white;
                                    border-radius:50%;
                                    padding:2px 6px;
                                    font-size:12px;
                                    position:absolute;
                                    top:-8px;
                                    right:-8px;
                                    display:none;
                                ">0</span>
                                </button>
                            </div>
                            <!-- Fin botones -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Botón flotante carrito (solo móvil) -->
<button id="btn-carrito-flotante" class="btn-carrito-flotante">
    <i class="fa fa-shopping-cart"></i> <span id="contador-flotante">0</span>
</button>

    <!--===============================================================================================-->
    <script src="{{ asset('vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('vendor/animsition/js/animsition.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(".js-select2").each(function() {
            $(this).select2({
                minimumResultsForSearch: 20,
                dropdownParent: $(this).next('.dropDownSelect2')
            });
        })
    </script>
    <!--===============================================================================================-->
    <script src="{{ asset('vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('vendor/daterangepicker/daterangepicker.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('vendor/slick/slick.min.js') }}"></script>
    <script src="{{ asset('js/slick-custom.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('vendor/parallax100/parallax100.js') }}"></script>
    <script>
        $('.parallax100').parallax100();
    </script>
    <!--===============================================================================================-->
    <script src="{{ asset('vendor/MagnificPopup/jquery.magnific-popup.min.js') }}"></script>
    <script>
        $('.gallery-lb').each(function() { // the containers for all your galleries
            $(this).magnificPopup({
                delegate: 'a', // the selector for gallery item
                type: 'image',
                gallery: {
                    enabled: true
                },
                mainClass: 'mfp-fade'
            });
        });
    </script>
    <!--===============================================================================================-->
    <script src="{{ asset('vendor/isotope/isotope.pkgd.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('vendor/sweetalert/sweetalert.min.js') }}"></script>

    <!--===============================================================================================-->
    <script src="{{ asset('vendor/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script>
        $('.js-pscroll').each(function() {
            $(this).css('position', 'relative');
            $(this).css('overflow', 'hidden');
            var ps = new PerfectScrollbar(this, {
                wheelSpeed: 1,
                scrollingThreshold: 1000,
                wheelPropagation: false,
            });

            $(window).on('resize', function() {
                ps.update();
            })
        });
    </script>
    <!--===============================================================================================-->
    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        $(document).ready(function() {
            function initSlick() {
                $('.wrap-slick3').each(function() {
                    const $wrap = $(this);
                    const $gallery = $wrap.find('.slick3');
                    const $dotsContainer = $wrap.find('.wrap-slick3-dots');

                    $gallery.slick({
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        fade: true,
                        infinite: true,
                        autoplay: false,
                        arrows: true,
                        appendArrows: $wrap.find('.wrap-slick3-arrows'),
                        prevArrow: '<button class="arrow-slick3 prev-slick3 slick-arrow" style=""><i class="fa fa-angle-left" aria-hidden="true"></i></button>',
                        nextArrow: '<button class="arrow-slick3 next-slick3 slick-arrow" style=""><i class="fa fa-angle-right" aria-hidden="true"></i></button>',
                        dots: true,
                        appendDots: $dotsContainer,
                        dotsClass: 'slick3-dots',
                        customPaging: function(slider, i) {
                            const thumb = $(slider.$slides[i]).data('thumb') || '';
                            const isVideo = thumb.toLowerCase().endsWith('.mp4');

                            return `
                            <li role="presentation">
                                ${isVideo
                                    ? `<video src="${thumb}" muted playsinline></video>`
                                    : `<img src="${thumb}" alt="thumb" />`
                                }
                                <div class="slick3-dot-overlay"></div>
                            </li>`;
                        }
                    });

                    // ✅ Actualiza manualmente el active luego del render
                    setTimeout(() => {
                        const $dots = $dotsContainer.find('li');
                        const currentIndex = $gallery.slick('slickCurrentSlide');
                        $dots.removeClass('slick-active');
                        $dots.eq(currentIndex).addClass('slick-active');
                    }, 100);

                    // ✅ Cambio de slide actualiza activo
                    $gallery.on('afterChange', function(event, slick, currentSlide) {
                        const $dots = $dotsContainer.find('li');
                        $dots.removeClass('slick-active');
                        $dots.eq(currentSlide).addClass('slick-active');
                    });

                    // ✅ Click manual en thumbnails
                    $dotsContainer.on('click', 'li', function() {
                        const index = $(this).index();
                        $gallery.slick('slickGoTo', index);
                    });
                });
            }

            $(document).on('click', '.js-show-modal1', function(e) {
                e.preventDefault();

                const productoId = $(this).data('product');
                console.log('Producto ID:', productoId);

                if (!productoId) return alert('No se encontró el ID del producto.');

                if ($('.wrap-modal1 .slick3').hasClass('slick-initialized')) {
                    $('.wrap-modal1 .slick3').slick('unslick');
                }
                $('.wrap-modal1 .slick3').empty();
                $('.js-name-detail').text('');
                $('.js-price-detail').text('');
                $('.js-desc-detail').text('');

                $('.wrap-modal1').fadeIn();

                $.ajax({
                    url: '/api/producto/' + productoId + '/detalles',
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log('Respuesta AJAX:', data);

                        $('.js-name-detail').text(data.nombre);
                        if (data.precio_oferta && data.precio_oferta > 0) {
                            $('.js-price-detail').html(
                                `<span class="js-price-normal" style="text-decoration: line-through; color: #888;">Bs. ${parseFloat(data.precio).toFixed(2)}</span> 
         <span class="js-price-promo" style="color: red; font-weight: bold;">Bs. ${parseFloat(data.precio_oferta).toFixed(2)}</span>`
                            );
                        } else {
                            $('.js-price-detail').html(
                                `<span class="js-price-normal">Bs. ${parseFloat(data.precio).toFixed(2)}</span>`
                            );
                        }

                        $('.js-desc-detail').text(data.descripcion);

                        let contenidoSlider = '';

                        if (data.imagenes && data.imagenes.length > 0) {
                            data.imagenes.forEach(function(item) {
                                console.log('Imagen/video:', item.ruta);

                                if (item.ruta.match(/\.(mp4|webm|ogg)$/i)) {
                                    contenidoSlider += `
                            <div class="item-slick3" data-thumb="${item.ruta}">
                                <div class="wrap-pic-w pos-relative">
                                    <video class="w-100" controls style="max-height: 500px; object-fit: contain; margin: 0 auto; display: block;">
                                        <source src="${item.ruta}" type="video/mp4">
                                        Tu navegador no soporta el video.
                                    </video>
                                    
                                </div>
                            </div>`;
                                } else {
                                    contenidoSlider += `
                            <div class="item-slick3" data-thumb="${item.ruta}">
                                <div class="wrap-pic-w pos-relative">
                                    <img class="img w-100" src="${item.ruta}" alt="IMG-PRODUCT" style="max-height: 500px; object-fit: contain; margin: 0 auto; display: block;">
                                    <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="${item.ruta}">
                                        <i class="fa fa-expand"></i>
                                    </a>
                                </div>
                            </div>`;
                                }
                            });

                            $('.wrap-modal1 .slick3').html(contenidoSlider);
                        } else {
                            $('.wrap-modal1 .slick3').html('<p>No hay imágenes ni videos disponibles.</p>');
                        }

                        // Si initSlick() falla, comenta esta línea para probar
                        initSlick();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error AJAX:', status, error, xhr.responseText);
                        alert('Error al cargar detalles del producto');
                        $('.wrap-modal1').fadeOut();
                    }
                });
            });


            $('.js-hide-modal1').on('click', function() {
                $('.wrap-modal1').fadeOut();
                if ($('.wrap-modal1 .slick3').hasClass('slick-initialized')) {
                    $('.wrap-modal1 .slick3').slick('unslick');
                }
                $('.wrap-modal1 .slick3').empty();
            });
        });

        // Expande video en pantalla completa
        function expandVideo(ruta) {
            const video = document.createElement('video');
            video.src = ruta;
            video.controls = true;
            video.style.display = 'none';
            document.body.appendChild(video);
            video.requestFullscreen();
            video.play();
            video.onfullscreenchange = () => {
                if (!document.fullscreenElement) {
                    video.pause();
                    video.remove();
                }
            };
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar Isotope
            var $grid = $('.isotope-grid').isotope({
                itemSelector: '.isotope-item',
                layoutMode: 'fitRows'
            });

            // Evento al hacer clic en filtro de precio
            $('.filter-price').on('click', function(e) {
                e.preventDefault();

                $('.filter-price').removeClass('filter-link-active');
                $(this).addClass('filter-link-active');

                let min = parseFloat($(this).data('min'));
                let max = parseFloat($(this).data('max'));

                $grid.isotope({
                    filter: function() {
                        let precio = parseFloat($(this).attr('data-precio'));
                        return precio >= min && precio <= max;
                    }
                });
            });
        });

        //buscar product
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar Isotope en todas las grillas que haya
            var $grid = $('.isotope-grid').isotope({
                itemSelector: '.isotope-item',
                layoutMode: 'fitRows'
            });

            let precioFiltro = {
                min: 0,
                max: Infinity
            };
            let textoBusqueda = '';

            function filtrarProductos() {
                $grid.isotope({
                    filter: function() {
                        let precio = parseFloat($(this).attr('data-precio')) || 0;

                        // Texto del nombre
                        let nombre = $(this).find('.js-name-b2').text().toLowerCase();

                        // Texto extra (si lo tienes en algún span oculto)
                        let extra = $(this).find('.js-extra-busqueda').text().toLowerCase();

                        let textoCompleto = nombre + ' ' + extra;

                        let cumplePrecio = precio >= precioFiltro.min && precio <= precioFiltro.max;
                        let cumpleTexto = textoCompleto.includes(textoBusqueda.toLowerCase());

                        return cumplePrecio && cumpleTexto;
                    }
                });
            }

            // Filtro por precio
            $('.filter-price').on('click', function(e) {
                e.preventDefault();
                $('.filter-price').removeClass('filter-link-active');
                $(this).addClass('filter-link-active');

                precioFiltro.min = parseFloat($(this).data('min'));
                precioFiltro.max = parseFloat($(this).data('max'));

                filtrarProductos();
            });

            // Búsqueda por texto
            $('input[name="search-product"]').on('input', function() {
                textoBusqueda = $(this).val();
                filtrarProductos();
            });



            // Mostrar/ocultar panel de búsqueda y filtro (tu lógica si quieres)
            $('.js-show-search').on('click', function() {
                $('.panel-search').toggleClass('dis-none');
                $('.panel-filter').addClass('dis-none');
            });

            $('.js-show-filter').on('click', function() {
                $('.panel-filter').toggleClass('dis-none');
                $('.panel-search').addClass('dis-none');
            });
        });

        //filtrar por categorias
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializa Isotope (solo una vez)
            var $grid = $('.isotope-grid').isotope({
                itemSelector: '.isotope-item',
                layoutMode: 'fitRows'
            });

            // Filtrar al seleccionar del select de categorías
            document.getElementById('select-categorias')?.addEventListener('change', function() {
                const filter = this.value;

                // Activar filtro en Isotope
                $grid.isotope({
                    filter: filter
                });

                // Quitar clase activa de botones
                document.querySelectorAll('.filter-tope-group button').forEach(btn => {
                    btn.classList.remove('how-active1');
                });

                // Activar botón "Todos" si se elige "*"
                const btnTodos = document.querySelector('[data-filter="*"]');
                if (filter === '*' && btnTodos) {
                    btnTodos.classList.add('how-active1');
                }
            });
        });

        //agregar al carrito
        let carrito = [];
        let totalCarrito = 0;

        // Variable para evitar doble click rápido
        let agregando = false;

        function agregarAlCarrito(producto) {
            let existente = carrito.find(p => p.nombre === producto.nombre);
            if (existente) {
                existente.cantidad += producto.cantidad;
            } else {
                carrito.push(producto);
            }
            actualizarCarrito();
        }

        function eliminarDelCarrito(index) {
            carrito.splice(index, 1);
            actualizarCarrito();
        }

        function cambiarCantidad(index, cantidad) {
            if (cantidad < 1) cantidad = 1;
            carrito[index].cantidad = cantidad;
            actualizarCarrito();
        }

        function actualizarCarrito() {
            const cartWrap = document.querySelector(".header-cart-wrapitem");
            const totalElement = document.querySelector(".header-cart-total");

            cartWrap.innerHTML = "";
            totalCarrito = 0;

            carrito.forEach((item, i) => {
                totalCarrito += item.precio * item.cantidad;

                cartWrap.innerHTML += `
        <li class="header-cart-item flex-w flex-t m-b-12" style="align-items:center;">
            <div class="header-cart-item-img">
                <img src="${item.imagen}" alt="${item.nombre}" style="border-radius:8px;">
            </div>
            <div class="header-cart-item-txt p-t-8" style="flex:1">
                <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04" style="font-weight:bold;">
                    ${item.nombre} ${item.esPromocion ? '<span style="color:red; font-weight:bold;">(Promo)</span>' : ''}
                </a>
                <div class="flex-w m-b-10" style="gap:5px;align-items:center;">
                    <button class="btn-cantidad" onclick="cambiarCantidad(${i}, ${item.cantidad - 1})" 
                        style="border:none;background:#f44336;color:white;width:28px;height:28px;border-radius:50%;cursor:pointer;">-</button>
                    <input type="number" value="${item.cantidad}"
                           onchange="cambiarCantidad(${i}, this.value)" 
                           style="width:50px;text-align:center;border:1px solid #ccc;border-radius:5px;">
                    <button class="btn-cantidad" onclick="cambiarCantidad(${i}, ${item.cantidad + 1})" 
                        style="border:none;background:#4CAF50;color:white;width:28px;height:28px;border-radius:50%;cursor:pointer;">+</button>
                </div>
                <span style="color:#555;">Bs. ${item.precio.toFixed(2)}</span>
            </div>
            <button onclick="eliminarDelCarrito(${i})" 
                style="border:none;background:#e0e0e0;border-radius:5px;padding:5px 8px;cursor:pointer;">
                <i class="zmdi zmdi-delete" style="color:red;font-size:18px;"></i>
            </button>
        </li>
        `;
            });

            totalElement.textContent = `Total: Bs. ${totalCarrito.toFixed(2)}`;

            // 🔹 Actualiza el contador en todos los íconos de carrito (PC + móvil)
            document.querySelectorAll(".icon-header-noti").forEach(icon => {
                icon.setAttribute("data-notify", carrito.length);
            });
            const contadorVerCarrito = document.getElementById("contador-ver-carrito");
            if (contadorVerCarrito) {
                if (carrito.length > 0) {
                    contadorVerCarrito.textContent = carrito.length;
                    contadorVerCarrito.style.display = "inline-block";
                } else {
                    contadorVerCarrito.style.display = "none";
                }
            }
            actualizarBotonFlotante();
        }
        document.addEventListener("click", function(e) {
            // Botón agregar al carrito
            const btnAdd = e.target.closest("#mi-btn-add-to-cart")
            if (btnAdd) {
                e.preventDefault();
                e.stopPropagation();

                if (agregando) return; // evitar doble click rápido
                agregando = true;

                const nombre = document.querySelector(".js-name-detail").textContent.trim();
                // Aquí intenta obtener precio promoción, si no existe usar precio normal
                const precioPromoEl = document.querySelector(".js-price-promo");
                let precio;

                if (precioPromoEl && precioPromoEl.textContent.trim() !== '') {
                    // Usar precio promoción, quitar "Bs." y parsear
                    precio = parseFloat(precioPromoEl.textContent.replace("Bs.", "").trim());
                } else {
                    // Precio normal
                    precio = parseFloat(document.querySelector(".js-price-detail").textContent.replace("Bs.", "").trim());
                }

                const imagen = document.querySelector(".gallery-lb img")?.src || "{{ asset('images/default.jpg') }}";

                agregarAlCarrito({
                    nombre,
                    precio,
                    cantidad: 1,
                    imagen,
                    esPromocion: precioPromoEl && precioPromoEl.textContent.trim() !== ''
                });

                Swal.fire({
                    icon: 'success',
                    title: 'Producto agregado',
                    text: `${nombre} fue agregado al carrito.`,
                    timer: 1500,
                    showConfirmButton: false
                });

                // Permitir otro click después de 300ms
                setTimeout(() => {
                    agregando = false;
                }, 300);

                return;
            }

            // Botón ver carrito
            const btnVer = e.target.closest("#btn-ver-carrito");
            if (btnVer) {
                e.preventDefault();
                e.stopPropagation();

                document.querySelector(".wrap-modal1").style.display = "none";
                document.querySelector(".overlay-modal1").classList.remove("show-modal1");

                document.querySelector(".js-panel-cart").classList.add("show-header-cart");
                return;
            }
        });


        //consultar al whatpsap

        let usuarioRegistrado = false;
        let datosUsuario = {};

        // Detectar escritura o pérdida de foco en el CI
        document.addEventListener("input", function(e) {
            if (e.target && e.target.id === "reg-telefono") {
                let ci = e.target.value.trim();
                if (ci.length > 0) {
                    verificarTelefono(ci);
                } else {
                    limpiarCamposRegistro();
                    document.getElementById("telefono-status").textContent = "";
                }
            }
        });

        document.addEventListener("click", function(e) {
            // Agregar al carrito
            if (e.target && e.target.id === "btn-add-to-cart") {
                const nombre = document.querySelector(".js-name-detail").textContent.trim();
                const precio = parseFloat(document.querySelector(".js-price-detail").textContent.replace("Bs.", "").trim());
                const imagen = document.querySelector(".gallery-lb img")?.src || "{{ asset('images/default.jpg') }}";

                agregarAlCarrito({
                    nombre,
                    precio,
                    cantidad: 1,
                    imagen
                });

                Swal.fire({
                    icon: 'success',
                    title: nombre,
                    text: '¡Se agregó al carrito!',
                    showConfirmButton: false,
                    timer: 1500
                });
            }

            // Botón WhatsApp → mostrar formulario si no está registrado
            if (e.target && e.target.id === "btn-whatsapp") {
                if (!usuarioRegistrado) {
                    document.getElementById("carrito-content").style.display = "none";
                    document.getElementById("registro-content").style.display = "block";
                    return;
                }
                enviarWhatsApp();
            }

            // Guardar registro
            if (e.target && e.target.id === "guardar-registro") {
                let telefono = document.getElementById("reg-telefono").value.trim();
                let nombre = document.getElementById("reg-nombre").value.trim();
                let direccion = document.getElementById("reg-direccion").value.trim();
                let ciudad = document.getElementById("reg-ciudad").value.trim();
                let empresaId = document.getElementById("empresaId").value;

                if (!telefono || !nombre || !direccion || !ciudad) {
                    Swal.fire('Error', 'Por favor completa todos los campos', 'error');
                    return;
                }
                datosUsuario = {
                    telefono,
                    nombre,
                    direccion,
                    ciudad,
                    id_empresa: empresaId // coincide con el nombre de columna en DB
                };
                //console.log('Datos del usuario: ', datosUsuario);
                Swal.fire({
                    title: 'Confirmar registro',
                    text: '¿Deseas registrarte y consultar por WhatsApp?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, continuar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        registrarCliente(datosUsuario);
                    }
                });
            }
            // Volver al carrito
            if (e.target && e.target.id === "volver-carrito") {
                document.getElementById("registro-content").style.display = "none";
                document.getElementById("carrito-content").style.display = "block";
            }
        });

        // Verificar CI en Laravel
        function verificarTelefono(telefono) {
            const empresaId = document.getElementById("empresaId").value; // tu input oculto
            fetch(`/clientes/buscar-telefono/${telefono}?empresa_id=${empresaId}`)
                .then(res => res.json())
                .then(data => {
                    if (data.encontrado) {
                        document.getElementById("telefono-status").innerHTML = `<strong style="color:green">Cliente encontrado</strong>`;
                        document.getElementById("reg-nombre").value = data.cliente.nombre;
                        document.getElementById("reg-direccion").value = data.cliente.direccion;
                        document.getElementById("reg-ciudad").value = data.cliente.ciudad;
                        usuarioRegistrado = true;
                        datosUsuario = data.cliente;
                    } else {
                        document.getElementById("telefono-status").innerHTML = `<strong style="color:red">Cliente no registrado</strong>`;
                        limpiarCamposRegistro();
                        usuarioRegistrado = false;
                    }
                });
        }
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        // Registrar cliente en Laravel
        function registrarCliente(datos) {
            //console.log('Datos a registrar: ', datos);
            fetch(`/clientes/registrar`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken
                    },
                    body: JSON.stringify(datos)
                })
                .then(res => {
                    if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
                    return res.json();
                })
                .then(data => {
                    if (data.success) {
                        usuarioRegistrado = true;
                        enviarWhatsApp();
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        Swal.fire('Error', data.message || 'No se pudo registrar', 'error');
                    }
                })
                .catch(error => {
                    console.error("Fetch error:", error);
                    Swal.fire('Error', 'Ocurrió un error en el servidor', 'error');
                });
        }

        // Enviar mensaje a WhatsApp
        function enviarWhatsApp() {
            let telefono = "{{ $empresa->telefono_whatsapp ?? '0000000' }}";
            console.log('telefono del usuario: ', telefono)
            let mensaje = `Hola, quiero consultar los siguientes productos:\n\n`;

            carrito.forEach(p => {
                mensaje += `- ${p.nombre} (${p.cantidad} x Bs. ${p.precio.toFixed(2)})\n`;
            });
            mensaje += `\nTotal: Bs. ${totalCarrito.toFixed(2)}`;
            mensaje += `\n\nMis datos:\nNombre: ${datosUsuario.nombre}\nDirección: ${datosUsuario.direccion}\nCiudad: ${datosUsuario.ciudad}`;

            let url = `https://wa.me/${telefono}?text=${encodeURIComponent(mensaje)}`;
            window.open(url, "_blank");
        }

        function limpiarCamposRegistro() {
            document.getElementById("reg-nombre").value = "";
            document.getElementById("reg-direccion").value = "";
            document.getElementById("reg-ciudad").value = "";
        }

        //header
        document.addEventListener("DOMContentLoaded", function() {
            const headers = document.querySelectorAll('.empresa-nombre');
            const texto = headers[0]?.getAttribute('data-text') || '';
            let i = 0;
            let borrando = false;

            function escribir() {
                if (!borrando && i <= texto.length) {
                    headers.forEach(h => h.textContent = texto.substring(0, i));
                    i++;
                } else if (borrando && i >= 0) {
                    headers.forEach(h => h.textContent = texto.substring(0, i));
                    i--;
                }

                if (i > texto.length) {
                    borrando = true;
                    setTimeout(escribir, 1000); // pausa antes de borrar
                    return;
                } else if (i < 0) {
                    borrando = false;
                }
                setTimeout(escribir, borrando ? 100 : 150); // velocidad
            }

            escribir();

            // cambio de color con scroll (desktop y mobile)
            window.addEventListener('scroll', () => {
                const desktopHeader = document.querySelector(".container-menu-desktop");
                const mobileHeader = document.querySelector(".wrap-header-mobile");
                if (window.scrollY > 50) {
                    desktopHeader?.classList.add("header-scroll", "scrolled");
                    mobileHeader?.classList.add("scrolled");
                } else {
                    desktopHeader?.classList.remove("header-scroll", "scrolled");
                    mobileHeader?.classList.remove("scrolled");
                }
            });
        });
        //cargar mas 8 productos
        document.addEventListener('DOMContentLoaded', function() {
            const btnPromos = document.getElementById('btnVerMasPromociones');
            const btnNuevos = document.getElementById('btnVerMasNuevos');

            if (btnPromos) {
                btnPromos.addEventListener('click', function() {
                    console.log('Clic en botón promociones');
                    const offset = parseInt(this.dataset.offset);
                    const empresaId = this.dataset.empresa;

                    fetch(`/ajax/load-more-promociones?offset=${offset}&empresa_id=${empresaId}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data.html) {
                                document.getElementById('contenedorPromociones').insertAdjacentHTML('beforeend', data.html);
                                const nuevosOffset = offset + 8;
                                this.dataset.offset = nuevosOffset;
                                if (data.total < 8) this.remove();
                            } else {
                                this.remove();
                            }
                        });
                });
            }

            if (btnNuevos) {
                btnNuevos.addEventListener('click', function() {
                    const offset = parseInt(this.dataset.offset);
                    const empresaId = this.dataset.empresa;

                    fetch(`/ajax/load-more-nuevos?offset=${offset}&empresa_id=${empresaId}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data.html) {
                                document.getElementById('contenedorNuevos').insertAdjacentHTML('beforeend', data.html);
                                const nuevosOffset = offset + 8;
                                this.dataset.offset = nuevosOffset;
                                if (data.total < 8) this.remove();
                            } else {
                                this.remove();
                            }
                        });
                });
            }
            const btnProductos = document.getElementById('btnVerMasProductos');
            if (btnProductos) {
                btnProductos.addEventListener('click', function() {
                    const offset = parseInt(this.dataset.offset);
                    const empresaId = this.dataset.empresa;

                    fetch(`/ajax/load-more-productos?offset=${offset}&empresa_id=${empresaId}`)
                        .then(res => res.json())
                        .then(data => {
                            if (data.html) {
                                document.getElementById('contenedorProductosNormales').insertAdjacentHTML('beforeend', data.html);
                                const nuevosOffset = offset + 8;
                                this.dataset.offset = nuevosOffset;
                                if (data.total < 8) this.remove();
                            } else {
                                this.remove();
                            }
                        });
                });
            }
        });
   const btnCarritoFlotante = document.getElementById("btn-carrito-flotante");
const contadorFlotante = document.getElementById("contador-flotante");

// 🔹 Actualiza contador y animación al agregar
function actualizarBotonFlotante() {
    if (carrito.length > 0) {
        contadorFlotante.textContent = carrito.length;
        contadorFlotante.style.display = 'inline-block';

        // Animación "pop" cada vez que se actualiza
        btnCarritoFlotante.classList.remove("pop");
        void btnCarritoFlotante.offsetWidth; // truco para reiniciar animación
        btnCarritoFlotante.classList.add("pop");
    } else {
        contadorFlotante.style.display = 'none';
    }
}

// 🔹 Mostrar botón solo en scroll
window.addEventListener("scroll", () => {
    if (window.innerWidth <= 768) {
        if (window.scrollY > 200 && carrito.length > 0) {
            btnCarritoFlotante.classList.add("show");
        } else {
            btnCarritoFlotante.classList.remove("show");
        }
    }
});

// 🔹 Clic en botón flotante → cierra modal y abre carrito
btnCarritoFlotante.addEventListener("click", () => {
    // Si hay un modal abierto lo cierra
    const modal = document.querySelector(".wrap-modal1.js-modal1");
    if (modal && modal.style.display !== "none") {
        modal.style.display = "none";
        document.querySelector(".overlay-modal1").classList.remove("show-modal1");
    }

    // Abre carrito
    const panelCart = document.querySelector(".js-panel-cart");
    panelCart.classList.add("show-header-cart");
});

// 🔹 Ocultar botón cuando se abre el carrito
document.querySelectorAll(".js-hide-cart").forEach(btn => {
    btn.addEventListener("click", () => {
        btnCarritoFlotante.classList.add("show");
    });
});
document.querySelector(".js-panel-cart").addEventListener("transitionstart", () => {
    btnCarritoFlotante.classList.remove("show");
});
    </script>
</body>

</html>