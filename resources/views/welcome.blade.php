<!DOCTYPE html>
<html lang="en">

<head>
    <title>Yane Shop</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/icons/favicon.png') }}" />

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

    <style>
        /* Estilos para los dots (miniaturas) */
        .wrap-slick3-dots ul.slick3-dots {
            display: flex !important;
            justify-content: start;
            padding: 10px 0;
            gap: 10px;
            flex-wrap: wrap;
        }

        .wrap-slick3-dots li {
            position: relative;
            width: 60px;
            height: 60px;
            border-radius: 4px;
            overflow: hidden;
            cursor: pointer;
            list-style: none;
        }

        /* Ocultamos el botón de slick (innecesario) */
        .wrap-slick3-dots li button {
            display: none !important;
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

        /* Overlay */
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

        /* Borde activo */
        .wrap-slick3-dots li.slick-active .slick3-dot-overlay {
            border: 2px solid #007bff;
        }

        /* Resaltar imagen activa */
        .wrap-slick3-dots li.slick-active img {
            border: 2px solid #0d6efd;
        }

        /* Espaciado entre previews */
        .wrap-slick3-dots li {
            margin: 4px;
            display: inline-block;
            cursor: pointer;
        }

        /* Personalizar flechas */
        .arrow-slick3 {
            background: none;
            border: none;
            font-size: 24px;
            color: #333;
            cursor: pointer;
        }

        .block1.wrap-pic-w {
            position: relative;
            overflow: hidden;
            border-radius: 5px;
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
                    <a href="#" class="logo">
                        <img src="{{ asset('images/yane/yane2.png') }}" alt="IMG-LOGO">
                    </a>

                    <!-- Menu desktop -->
                    <div class="menu-desktop">
                        <ul class="main-menu">
                            <li>
                                <a href="{{ url('/') }}">Inicio</a>
                            </li>

                            <li>
                                <a href="{{ route('product.index') }}">Comprar</a>
                            </li>

                            <li>
                                <a href="about.html">Sobre nosotros</a>
                            </li>

                            <li>
                                <a href="contact.html">Contacto</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Icon header -->
                    <div class="wrap-icon-header flex-w flex-r-m h-full">
                        <div class="flex-c-m h-full p-r-25 bor6">
                            <div class="icon-header-item cl0 hov-cl1 trans-04 p-lr-11 icon-header-noti js-show-cart" data-notify="2">
                                <i class="zmdi zmdi-shopping-cart"></i>
                            </div>
                        </div>

                        <div class="flex-c-m h-full p-lr-19">
                            <div class="icon-header-item cl0 hov-cl1 trans-04 p-lr-11 js-show-sidebar">
                                <i class="zmdi zmdi-menu"></i>
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
                <a href="{{ url('/') }}"><img src="{{ asset('images/yane/yane2.png') }}" alt="IMG-LOGO"></a>
            </div>

            <!-- Icon header -->
            <div class="wrap-icon-header flex-w flex-r-m h-full m-r-15">
                <div class="flex-c-m h-full p-r-5">
                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-lr-11 icon-header-noti js-show-cart" data-notify="2">
                        <i class="zmdi zmdi-shopping-cart"></i>
                    </div>
                </div>
            </div>

            <!-- Button show menu -->
            <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </div>
        </div>


        <!-- Menu Mobile -->
        <div class="menu-mobile">
            <ul class="main-menu-m">
                <li>
                    <a href="{{ url('/') }}">Inicio</a>
                    <span class="arrow-main-menu-m">
                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                    </span>
                </li>

                <li>
                    <a href="{{ route('product.index') }}">Shop</a>
                </li>


                <li>
                    <a href="about.html">Sobre nosotros</a>
                </li>

                <li>
                    <a href="contact.html">Contacto</a>
                </li>
            </ul>
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
    <aside class="wrap-sidebar js-sidebar">
        <div class="s-full js-hide-sidebar"></div>

        <div class="sidebar flex-col-l p-t-22 p-b-25">
            <div class="flex-r w-full p-b-30 p-r-27">
                <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-sidebar">
                    <i class="zmdi zmdi-close"></i>
                </div>
            </div>

            <div class="sidebar-content flex-w w-full p-lr-65 js-pscroll">
                <ul class="sidebar-link w-full">
                    <li class="p-b-13">
                        <a href="index.html" class="stext-102 cl2 hov-cl1 trans-04">
                            Home
                        </a>
                    </li>

                    <li class="p-b-13">
                        <a href="#" class="stext-102 cl2 hov-cl1 trans-04">
                            My Wishlist
                        </a>
                    </li>

                    <li class="p-b-13">
                        <a href="#" class="stext-102 cl2 hov-cl1 trans-04">
                            My Account
                        </a>
                    </li>

                    <li class="p-b-13">
                        <a href="#" class="stext-102 cl2 hov-cl1 trans-04">
                            Track Oder
                        </a>
                    </li>

                    <li class="p-b-13">
                        <a href="#" class="stext-102 cl2 hov-cl1 trans-04">
                            Refunds
                        </a>
                    </li>

                    <li class="p-b-13">
                        <a href="#" class="stext-102 cl2 hov-cl1 trans-04">
                            Help & FAQs
                        </a>
                    </li>
                </ul>

                <div class="sidebar-gallery w-full p-tb-30">


                    <div class="flex-w flex-sb p-t-36 gallery-lb">
                        <!-- item gallery sidebar -->
                        <div class="wrap-item-gallery m-b-10">
                            <a class="item-gallery bg-img1" href="images/gallery-01.jpg" data-lightbox="gallery"
                                style="background-image: url('images/gallery-01.jpg');"></a>
                        </div>

                        <!-- item gallery sidebar -->
                        <div class="wrap-item-gallery m-b-10">
                            <a class="item-gallery bg-img1" href="images/gallery-02.jpg" data-lightbox="gallery"
                                style="background-image: url('images/gallery-02.jpg');"></a>
                        </div>

                        <!-- item gallery sidebar -->
                        <div class="wrap-item-gallery m-b-10">
                            <a class="item-gallery bg-img1" href="images/gallery-03.jpg" data-lightbox="gallery"
                                style="background-image: url('images/gallery-03.jpg');"></a>
                        </div>

                        <!-- item gallery sidebar -->
                        <div class="wrap-item-gallery m-b-10">
                            <a class="item-gallery bg-img1" href="images/gallery-04.jpg" data-lightbox="gallery"
                                style="background-image: url('images/gallery-04.jpg');"></a>
                        </div>

                        <!-- item gallery sidebar -->
                        <div class="wrap-item-gallery m-b-10">
                            <a class="item-gallery bg-img1" href="images/gallery-05.jpg" data-lightbox="gallery"
                                style="background-image: url('images/gallery-05.jpg');"></a>
                        </div>

                        <!-- item gallery sidebar -->
                        <div class="wrap-item-gallery m-b-10">
                            <a class="item-gallery bg-img1" href="images/gallery-06.jpg" data-lightbox="gallery"
                                style="background-image: url('images/gallery-06.jpg');"></a>
                        </div>

                        <!-- item gallery sidebar -->
                        <div class="wrap-item-gallery m-b-10">
                            <a class="item-gallery bg-img1" href="images/gallery-07.jpg" data-lightbox="gallery"
                                style="background-image: url('images/gallery-07.jpg');"></a>
                        </div>

                        <!-- item gallery sidebar -->
                        <div class="wrap-item-gallery m-b-10">
                            <a class="item-gallery bg-img1" href="images/gallery-08.jpg" data-lightbox="gallery"
                                style="background-image: url('images/gallery-08.jpg');"></a>
                        </div>

                        <!-- item gallery sidebar -->
                        <div class="wrap-item-gallery m-b-10">
                            <a class="item-gallery bg-img1" href="images/gallery-09.jpg" data-lightbox="gallery"
                                style="background-image: url('images/gallery-09.jpg');"></a>
                        </div>
                    </div>
                </div>

                <div class="sidebar-gallery w-full">
                    <span class="mtext-101 cl5">
                        About Us
                    </span>

                    <p class="stext-108 cl6 p-t-27">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur maximus vulputate hendrerit. Praesent faucibus erat vitae rutrum gravida. Vestibulum tempus mi enim, in molestie sem fermentum quis.
                    </p>
                </div>
            </div>
        </div>
    </aside>


    <!-- Cart -->
    <div class="wrap-header-cart js-panel-cart">
        <div class="s-full js-hide-cart"></div>

        <div class="header-cart flex-col-l p-l-65 p-r-25">
            <div class="header-cart-title flex-w flex-sb-m p-b-8">
                <span class="mtext-103 cl2">
                    Your Cart
                </span>

                <div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
                    <i class="zmdi zmdi-close"></i>
                </div>
            </div>

            <div class="header-cart-content flex-w js-pscroll">
                <ul class="header-cart-wrapitem w-full">
                    <li class="header-cart-item flex-w flex-t m-b-12">
                        <div class="header-cart-item-img">
                            <img src="images/item-cart-01.jpg" alt="IMG">
                        </div>

                        <div class="header-cart-item-txt p-t-8">
                            <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                White Shirt Pleat
                            </a>

                            <span class="header-cart-item-info">
                                1 x $19.00
                            </span>
                        </div>
                    </li>

                    <li class="header-cart-item flex-w flex-t m-b-12">
                        <div class="header-cart-item-img">
                            <img src="images/item-cart-02.jpg" alt="IMG">
                        </div>

                        <div class="header-cart-item-txt p-t-8">
                            <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                Converse All Star
                            </a>

                            <span class="header-cart-item-info">
                                1 x $39.00
                            </span>
                        </div>
                    </li>

                    <li class="header-cart-item flex-w flex-t m-b-12">
                        <div class="header-cart-item-img">
                            <img src="images/item-cart-03.jpg" alt="IMG">
                        </div>

                        <div class="header-cart-item-txt p-t-8">
                            <a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
                                Nixon Porter Leather
                            </a>

                            <span class="header-cart-item-info">
                                1 x $17.00
                            </span>
                        </div>
                    </li>
                </ul>

                <div class="w-full">
                    <div class="header-cart-total w-full p-tb-40">
                        Total: $75.00
                    </div>

                    <div class="header-cart-buttons flex-w w-full">
                        <a href="shoping-cart.html" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
                            View Cart
                        </a>

                        <a href="shoping-cart.html" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
                            Check Out
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Slider -->
    <section class="section-slide">
        <div class="wrap-slick1 rs2-slick1">
            <div class="slick1">
                @foreach ($productos->take(3) as $producto)
                @php
                $categoria = $producto->categoria;
                $imagen = $producto->imagenes->first();
                $backgroundImage = $imagen ? asset('storage/' . $imagen->ruta) : asset('images/default.jpg');
                @endphp

                <div class="item-slick1 bg-overlay1" style="background-image: url('{{ $backgroundImage }}');"
                    data-thumb="{{ $backgroundImage }}"
                    data-caption="{{ $categoria->nombre ?? 'Categoría' }}">
                    <div class="container">
                        <div class="flex-col-c-m">
                            <div class="layer-slick1 animated visible-false" data-appear="fadeInDown" data-delay="0">
                                <span class="ltext-202 txt-center cl0 respon2">
                                    {{ $categoria->nombre ?? 'Categoría' }}
                                </span>
                            </div>

                            <div class="layer-slick1 animated visible-false" data-appear="fadeInUp" data-delay="800">
                                <h2 class="ltext-104 txt-center cl0 p-t-22 p-b-40 respon1">
                                    {{ $producto->nombre }}
                                </h2>
                            </div>

                            <!--<div class="layer-slick1 animated visible-false" data-appear="zoomIn" data-delay="1600">
                                <a href="{{ route('product.index', ['categoria' => $categoria->id]) }}"
                                    class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn2 p-lr-15 trans-04">
                                    Comprar Ahora
                                </a>
                            </div>-->
                        </div>
                    </div>
                </div>

                @endforeach
            </div>

            <div class="wrap-slick1-dots p-lr-10"></div>
        </div>
    </section>




    <!-- Banner -->
    <!-- Banner dinámico -->
    <div class="sec-banner bg0 p-t-80 p-b-50">
        <div class="container">
            <div class="row">
                @foreach ($categorias->take(5) as $i => $categoria)
                @php
                $productoConImagen = $categoria->productos->firstWhere('imagenes.0', '!=', null);
                if (!$productoConImagen) {
                $productoConImagen = $categoria->productos->first();
                }
                $imagen = ($productoConImagen && $productoConImagen->imagenes->first())
                ? asset('storage/' . $productoConImagen->imagenes->first()->ruta)
                : asset('images/default.jpg');
                @endphp

                <div class="{{ $i < 2 ? 'col-md-6 col-xl-6' : 'col-md-6 col-xl-4' }} p-b-30 m-lr-auto">
                    <div class="block1 wrap-pic-w">
                        <img src="{{ $imagen }}" alt="{{ $productoConImagen->nombre ?? 'Producto' }}">

                        <div class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
                            <div class="block1-txt-child1 flex-col-l">
                                <span class="block1-name ltext-102 trans-04 p-b-8">
                                    {{ $categoria->nombre }}
                                </span>
                                <span class="block1-info stext-102 trans-04">
                                    {{ $productoConImagen->nombre ?? 'Explora nuestros productos' }}
                                </span>
                            </div>

                            <!--<div class="block1-txt-child2 p-b-4 trans-05">
                                <div class="block1-link stext-101 cl0 trans-09">
                                    Comprar ahora
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Product -->
    <section class="bg0 p-t-23 p-b-130">
        <div class="container">
            <div class="p-b-10">
                <h3 class="ltext-103 cl5">
                    Productos
                </h3>
            </div>
            @if($promociones->count())
            <section class="p-t-30 p-b-20">
                <h4 class="text-center m-b-20">🔥 Promociones</h4>
                @include('catalogo.catalogoNuevos', ['productos' => $promociones])
            </section>
            @endif

            @if($nuevos->count())
            <section class="p-t-30 p-b-20">
                <h4 class="text-center m-b-20">🆕 Nuevos</h4>
                @include('catalogo.catalogoNuevos', ['productos' => $nuevos])
            </section>
            @endif
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
                                Price
                            </div>

                            <ul>
                                <li class="p-b-6">
                                    <a href="#" class="filter-link stext-106 trans-04 filter-link-active filter-price" data-min="0" data-max="10000">
                                        All
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a href="#" class="filter-link stext-106 trans-04 filter-price" data-min="0" data-max="50">
                                        $0.00 - $50.00
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a href="#" class="filter-link stext-106 trans-04 filter-price" data-min="50" data-max="100">
                                        $50.00 - $100.00
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a href="#" class="filter-link stext-106 trans-04 filter-price" data-min="100" data-max="150">
                                        $100.00 - $150.00
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a href="#" class="filter-link stext-106 trans-04 filter-price" data-min="150" data-max="200">
                                        $150.00 - $200.00
                                    </a>
                                </li>

                                <li class="p-b-6">
                                    <a href="#" class="filter-link stext-106 trans-04 filter-price" data-min="200" data-max="100000">
                                        $200.00+
                                    </a>
                                </li>
                            </ul>

                        </div>

                    </div>
                </div>
            </div>

            <div class="row isotope-grid">
                @foreach($productos as $producto)
                <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item {{ strtolower(Str::slug($producto->categoria->nombre ?? '')) }}" data-precio="{{ $producto->precio }}">
                    <div class="block2">
                        @php
                        $imagen = $producto->imagenes->first();
                        $esNuevo = \Carbon\Carbon::parse($producto->created_at)->gt(now()->subDays(5));
                        @endphp

                        <div class="block2-pic hov-img0 {{ $esNuevo ? 'label-new' : '' }}" data-label="{{ $esNuevo ? 'New' : '' }}">
                            <img class="img-fluid" src="{{ $imagen ? asset('storage/' . $imagen->ruta) : asset('images/default.jpg') }}"
                                alt="IMG-PRODUCT"
                                style="object-fit: cover; width: 100%; height: 330px;">

                            <a href="#"
                                class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1"
                                data-product="{{ $producto->id }}">
                                Ver Producto
                            </a>
                        </div>

                        <div class="block2-txt flex-w flex-t p-t-14">
                            <div class="block2-txt-child1 flex-col-l ">
                                <a href="#" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                    {{ $producto->nombre }}
                                </a>

                                <span class="stext-105 cl3">
                                    Bs. {{ number_format($producto->precio, 2) }}
                                </span>
                            </div>

                            <div class="block2-txt-child2 flex-r p-t-3">
                                <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                    <img class="icon-heart1 dis-block trans-04" src="{{ asset('images/icons/icon-heart-01.png') }}" alt="ICON">
                                    <img class="icon-heart2 dis-block trans-04 ab-t-l" src="{{ asset('images/icons/icon-heart-02.png') }}" alt="ICON">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>


        </div>

        <!-- Pagination -->
        @php
        $totalPages = $productos->lastPage();
        $currentPage = $productos->currentPage();
        @endphp

        <div class="flex-c-m flex-w w-full p-t-38">
            @for ($i = 1; $i <= $totalPages; $i++)
                <a href="{{ $productos->url($i) }}"
                class="flex-c-m how-pagination1 trans-04 m-all-7 {{ $currentPage == $i ? 'active-pagination1' : '' }}">
                {{ $i }}
                </a>
                @endfor
        </div>
        </div>
    </section>


    <!-- Footer -->
    <footer class="bg3 p-t-75 p-b-32">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl0 p-b-30">
                        Categories
                    </h4>

                    <ul>
                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                Women
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                Men
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                Shoes
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                Watches
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl0 p-b-30">
                        Help
                    </h4>

                    <ul>
                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                Track Order
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                Returns
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                Shipping
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                FAQs
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl0 p-b-30">
                        GET IN TOUCH
                    </h4>

                    <p class="stext-107 cl7 size-201">
                        Any questions? Let us know in store at 8th floor, 379 Hudson St, New York, NY 10018 or call us on (+1) 96 716 6879
                    </p>

                    <div class="p-t-27">
                        <a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                            <i class="fa fa-facebook"></i>
                        </a>

                        <a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                            <i class="fa fa-instagram"></i>
                        </a>

                        <a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                            <i class="fa fa-pinterest-p"></i>
                        </a>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl0 p-b-30">
                        Newsletter
                    </h4>

                    <form>
                        <div class="wrap-input1 w-full p-b-4">
                            <input class="input1 bg-none plh1 stext-107 cl7" type="text" name="email" placeholder="email@example.com">
                            <div class="focus-input1 trans-04"></div>
                        </div>

                        <div class="p-t-18">
                            <button class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04">
                                Subscribe
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="p-t-40">
                <div class="flex-c-m flex-w p-b-18">
                    <a href="#" class="m-all-1">
                        <img src="images/icons/icon-pay-01.png" alt="ICON-PAY">
                    </a>

                    <a href="#" class="m-all-1">
                        <img src="images/icons/icon-pay-02.png" alt="ICON-PAY">
                    </a>

                    <a href="#" class="m-all-1">
                        <img src="images/icons/icon-pay-03.png" alt="ICON-PAY">
                    </a>

                    <a href="#" class="m-all-1">
                        <img src="images/icons/icon-pay-04.png" alt="ICON-PAY">
                    </a>

                    <a href="#" class="m-all-1">
                        <img src="images/icons/icon-pay-05.png" alt="ICON-PAY">
                    </a>
                </div>

                <p class="stext-107 cl6 txt-center">
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    Copyright &copy;<script>
                        document.write(new Date().getFullYear());
                    </script> All rights reserved | Made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a> &amp; distributed by <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->

                </p>
            </div>
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

                            <!-- Más detalles aquí si querés (tallas, colores, botones) -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--===============================================================================================-->
    <script src="{{ asset('vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('vendor/animsition/js/animsition.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('vendor/select2/select2.min.js') }}"></script>
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
    <script>
        $('.js-addwish-b2').on('click', function(e) {
            e.preventDefault();
        });

        $('.js-addwish-b2').each(function() {
            var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
            $(this).on('click', function() {
                swal(nameProduct, "is added to wishlist !", "success");

                $(this).addClass('js-addedwish-b2');
                $(this).off('click');
            });
        });

        $('.js-addwish-detail').each(function() {
            var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

            $(this).on('click', function() {
                swal(nameProduct, "is added to wishlist !", "success");

                $(this).addClass('js-addedwish-detail');
                $(this).off('click');
            });
        });

        /*---------------------------------------------*/

        $('.js-addcart-detail').each(function() {
            var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
            $(this).on('click', function() {
                swal(nameProduct, "is added to cart !", "success");
            });
        });
    </script>
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

            $('.js-show-modal1').on('click', function(e) {
                e.preventDefault();

                const productoId = $(this).data('product');
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
                        $('.js-name-detail').text(data.nombre);
                        $('.js-price-detail').text('Bs. ' + data.precio);
                        $('.js-desc-detail').text(data.descripcion);

                        let contenidoSlider = '';

                        if (data.imagenes && data.imagenes.length > 0) {
                            data.imagenes.forEach(function(item) {
                                console.log(item.ruta);

                                if (item.ruta.match(/\.(mp4|webm|ogg)$/i)) {
                                    // Si es video
                                    contenidoSlider += `
                                        <div class="item-slick3" data-thumb="${item.ruta}">
                                            <div class="wrap-pic-w pos-relative">
                                                <video class="w-100" controls style="max-height: 500px; object-fit: contain; margin: 0 auto; display: block;">
                                                    <source src="${item.ruta}" type="video/mp4">
                                                    Tu navegador no soporta el video.
                                                </video>
                                                <a class="video-expand-btn" onclick="expandVideo('${item.ruta}')" style="position:absolute; top:10px; right:10px;">
                                                    <i class="fa fa-expand"></i>
                                                </a>
                                            </div>
                                        </div>`;
                                } else {
                                    // Si es imagen
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
            var $grid = $('.isotope-grid').isotope({
                itemSelector: '.isotope-item',
                layoutMode: 'fitRows'
            });

            // Variables para filtros activos
            let precioFiltro = {
                min: 0,
                max: Infinity
            };
            let textoBusqueda = '';

            // Función para combinar filtros de precio y búsqueda
            function filtrarProductos() {
                $grid.isotope({
                    filter: function() {
                        let precio = parseFloat($(this).attr('data-precio'));
                        let nombre = $(this).find('.js-name-b2').text().toLowerCase();

                        // Filtrar por precio
                        let cumplePrecio = precio >= precioFiltro.min && precio <= precioFiltro.max;

                        // Filtrar por texto
                        let cumpleTexto = nombre.includes(textoBusqueda.toLowerCase());

                        return cumplePrecio && cumpleTexto;
                    }
                });
            }

            // Evento filtro precio
            $('.filter-price').on('click', function(e) {
                e.preventDefault();
                $('.filter-price').removeClass('filter-link-active');
                $(this).addClass('filter-link-active');

                precioFiltro.min = parseFloat($(this).data('min'));
                precioFiltro.max = parseFloat($(this).data('max'));

                filtrarProductos();
            });

            // Evento búsqueda en input
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
    </script>
</body>

</html>