<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Virtual - {{ $empresa->nombre }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ Storage::url($empresa->logo) }}" />
    <!-- Slick CSS -->


    <!-- Slick JS 
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>-->
    <!-- En el head -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --primary: #3a86ff;
            --primary-dark: #2667cc;
            --secondary: #8338ec;
            --accent: #ff006e;
            --bg: #f8f9fa;
            /* antes era --light */
            --light: #ffffff;
            /* ✅ Añade esto */
            --text: #212529;
            /* antes era --dark */
            --gray: #6c757d;
            --gray-light: #e9ecef;
            --success: #38b000;
            --danger: #d00000;
            --warning: #ffaa00;
            --border-radius: 8px;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        [data-theme="dark"] {
            --bg: #121212;
            /* ✅ coherencia visual */
            --light: #1e1e1e;
            /* ✅ fondo principal oscuro */
            --dark: #f8f9fa;
            --gray-light: #2d2d2d;
            --gray: #a0a0a0;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            /* 🎯 Lo más importante */
            --text: #f1f1f1;
            /* texto normal */
            --text-on-primary: #ffffff;
            /* texto sobre botones o primarios */
            --bg-card: #1e1e1e;
            /* fondo de tarjetas */
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--light);
            color: var(--dark);
            transition: var(--transition);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* Header */
        header {
            background-color: var(--light);
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 100;
            transition: var(--transition);
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo {
            height: 50px;
            width: auto;
            border-radius: var(--border-radius);
        }

        .empresa-nombre {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        .nav-container {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .search-container {
            position: relative;
            width: 300px;
        }

        .search-input {
            width: 100%;
            padding: 10px 15px;
            border-radius: 30px;
            border: 1px solid var(--gray-light);
            background-color: var(--light);
            color: var(--dark);
            transition: var(--transition);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(58, 134, 255, 0.2);
        }

        .search-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--gray);
            cursor: pointer;
        }

        .theme-toggle {
            background: none;
            border: none;
            color: var(--dark);
            cursor: pointer;
            font-size: 1.2rem;
            transition: var(--transition);
        }

        .cart-icon {
            position: relative;
            cursor: pointer;
            font-size: 1.5rem;
            color: var(--dark);
            transition: var(--transition);
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--accent);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: bold;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            color: var(--dark);
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Main Content */
        .main-content {
            display: flex;
            gap: 20px;
            padding: 20px 0;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: var(--light);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 20px;
            transition: var(--transition);
        }

        .sidebar h3 {
            margin-bottom: 15px;
            color: var(--primary);
            border-bottom: 2px solid var(--primary);
            padding-bottom: 5px;
        }

        .category-list {
            display: flex;
            overflow-x: auto;
            gap: 10px;
            padding: 10px 0;
            list-style: none;
            scroll-behavior: smooth;
        }

        /* 🔹 Contenedor principal (horizontal) */
        #categoryList {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-wrap: wrap;
            /* Permite que bajen si hay muchas */
            justify-content: flex-start;
            gap: 6px;
        }

        /* 🔹 Cada ítem de categoría */
        .category-item {
            position: relative;
            border-radius: var(--border-radius);
            overflow: hidden;
            flex: 0 0 auto;
        }

        /* 🔹 Botón de categoría */
        .category-btn {
            padding: 10px 16px;
            font-weight: 500;
            font-size: 0.95rem;
            border: none;
            cursor: pointer;
            border-radius: var(--border-radius);
            background: var(--bg-card);
            color: var(--text);
            /* ✅ visible en dark/light */
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.25s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            white-space: nowrap;
        }

        .category-btn:hover {
            background: var(--primary);
            color: var(--text-on-primary);
            transform: translateY(-1px);
        }

        .category-btn.active {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: var(--text-on-primary);
        }

        /* 🔹 Flecha */
        .arrow-icon {
            transition: transform 0.3s ease;
            font-size: 0.8rem;
            opacity: 0.8;
        }

        .arrow-icon.rotate {
            transform: rotate(90deg);
        }

        /* 🔹 Subcategorías (acordeón interno) */
        .subcategory-list {
            display: none;
            flex-direction: column;
            width: 100%;
            background: var(--bg-card);
            border-radius: var(--border-radius);
            margin-top: 4px;
            padding: 6px;
            box-shadow: inset 0 0 4px rgba(0, 0, 0, 0.08);
            animation: fadeIn 0.25s ease;
        }

        .subcategory-list.show {
            display: flex;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-4px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* 🔹 Botones de subcategorías */
        .subcategory-btn {
            width: 100%;
            text-align: left;
            padding: 6px 10px;
            border: none;
            border-radius: 6px;
            background: transparent;
            color: var(--text);
            cursor: pointer;
            transition: all 0.25s ease;
            font-size: 0.9rem;
        }

        .subcategory-btn:hover {
            background: var(--gray-light);
            color: var(--dark);
        }

        .subcategory-btn.active {
            background: var(--secondary);
            color: #fff;
        }

        /* 🔹 Botón "Ver todo" */
        .ver-todo-btn {
            padding: 10px 16px;
            background: linear-gradient(135deg, var(--secondary), var(--primary));
            color: var(--text-on-primary);
            border: none;
            border-radius: var(--border-radius);
            font-weight: 500;
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            white-space: nowrap;
        }

        .ver-todo-btn:hover {
            filter: brightness(1.1);
            transform: translateY(-1px);
        }

        /* 🔹 Scroll horizontal en móvil */
        @media (max-width: 768px) {
            #categoryList {
                flex-wrap: nowrap;
                overflow-x: auto;
                scrollbar-width: none;
            }

            #categoryList::-webkit-scrollbar {
                display: none;
            }

            .category-item {
                flex: 0 0 auto;
            }

            .category-btn {
                padding: 8px 12px;
                font-size: 0.9rem;
            }
        }

        /* Products Grid */
        .products-section {
            flex: 1;
        }

        .section-title {
            margin-bottom: 20px;
            color: var(--primary);
            position: relative;
            padding-bottom: 10px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background-color: var(--primary);
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .product-card {
            position: relative;
            /* ✅ Esto hace que los stickers se mantengan visibles */
            background-color: var(--light);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            transition: var(--transition);
            animation: fadeIn 0.5s ease;
        }

        /* Contenedor para mantener los stickers arriba a la izquierda */
        .sticker-container {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 5;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        /* Estilos base de sticker */
        .sticker {
            font-size: 0.9rem;
            font-weight: bold;
            color: #fff;
            padding: 6px 14px;
            border-radius: 6px;
            text-transform: uppercase;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.3);
            opacity: 1;
            transform: rotate(-8deg);
        }

        /* Sticker de "Nuevo" */
        .sticker-nuevo {
            background: linear-gradient(135deg, #28a745, #4cd964);
        }

        /* Sticker de "Oferta" */
        .sticker-oferta {
            background: linear-gradient(135deg, #e63946, #ff6b6b);
        }

        /* Sticker de oferta_tipo (2x1, 3x2, etc.) */
        .sticker-oferta-tipo {
            position: absolute;
            top: 10px;
            right: 10px;
            background: linear-gradient(135deg, #ffbe0b, #fb5607);
            /* colores más llamativos */
            color: white;
            font-weight: 900;
            font-size: 1.1rem;
            /* más grande */
            padding: 8px 16px;
            /* más grande y elegante */
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
            text-transform: uppercase;
            transform: rotate(5deg);
            /* ángulo diferente para que destaque */
            z-index: 10;
            animation: stickerBounce 0.7s ease-out;
        }

        /* Animación ligera para hacerlo más llamativo */
        @keyframes stickerBounce {
            0% {
                transform: rotate(5deg) scale(0.8);
            }

            50% {
                transform: rotate(5deg) scale(1.1);
            }

            100% {
                transform: rotate(5deg) scale(1);
            }
        }

        /* Ajuste para que no tapen el borde superior */
        .product-card img.product-image {
            display: block;
            width: 100%;
            border-radius: 10px;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .product-info {
            padding: 15px;
        }

        .product-category {
            font-size: 0.8rem;
            color: var(--gray);
            margin-bottom: 5px;
        }

        .product-name {
            font-weight: 600;
            margin-bottom: 10px;
            overflow: visible;
            height: auto;
            /* Importante */
            white-space: normal;
            /* Permite saltos de línea */
        }

        .product-price {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            flex-wrap: wrap;
            /* Evita que empuje el nombre */
        }

        .current-price {
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--primary);
        }

        .original-price {
            text-decoration: line-through;
            color: var(--gray);
            font-size: 0.9rem;
        }

        .discount-badge {
            background-color: var(--accent);
            color: white;
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .product-actions {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-weight: 600;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            flex: 1;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: transparent;
            color: var(--primary);
            border: 1px solid var(--primary);
        }

        .btn-secondary:hover {
            background-color: var(--primary);
            color: white;
        }

        .btn-add-cart {
            animation: bounce 0.5s;
        }

        @keyframes bounce {

            0%,
            20%,
            60%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-10px);
            }

            80% {
                transform: translateY(-5px);
            }
        }

        /* Floating Cart Button (Mobile) */
        .floating-cart-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            z-index: 90;
            transition: var(--transition);
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .floating-cart-btn:hover {
            background-color: var(--primary-dark);
            transform: scale(1.1);
        }

        /* Cart Sidebar */
        .cart-sidebar {
            position: fixed;
            top: 0;
            right: -400px;
            width: 100%;
            max-width: 400px;
            height: 100vh;
            background-color: var(--light);
            box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: var(--transition);
            display: flex;
            flex-direction: column;
        }

        /* Estado abierto */
        .cart-sidebar.open {
            right: 0;
        }

        /* Header del carrito */
        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid var(--gray-light);
        }

        .cart-title {
            font-size: 1.5rem;
            color: var(--primary);
        }

        .close-cart {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--dark);
            cursor: pointer;
            transition: var(--transition);
        }

        .close-cart:hover {
            color: var(--accent);
            transform: rotate(90deg);
        }



        /* Contenido del carrito */
        .cart-items {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
        }

        /* Item */
        .cart-item {
            display: flex;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid var(--gray-light);
            animation: slideInRight 0.3s ease;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .cart-item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: var(--border-radius);
        }

        .cart-item-details {
            flex: 1;
        }

        .cart-item-name {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .cart-item-price {
            color: var(--primary);
            font-weight: 600;
            margin-bottom: 10px;
        }

        .cart-item-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: none;
            background-color: var(--gray-light);
            color: var(--dark);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .quantity-btn:hover {
            background-color: var(--primary);
            color: white;
        }

        .quantity-display {
            min-width: 30px;
            text-align: center;
            font-weight: 600;
        }

        .remove-item {
            background: none;
            border: none;
            color: var(--danger);
            cursor: pointer;
            transition: var(--transition);
        }

        .remove-item:hover {
            transform: scale(1.2);
        }

        .cart-footer {
            padding: 20px;
            border-top: 1px solid var(--gray-light);
        }

        .cart-total {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 1.2rem;
            font-weight: 700;
        }

        .checkout-form {
            display: none;
            animation: fadeIn 0.5s ease;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .form-input {
            width: 100%;
            padding: 10px;
            border-radius: var(--border-radius);
            border: 1px solid var(--gray-light);
            background-color: var(--light);
            color: var(--dark);
            transition: var(--transition);
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(58, 134, 255, 0.2);
        }

        .btn-whatsapp {
            background-color: #25D366;
            color: white;
            width: 100%;
            padding: 12px;
            font-size: 1.1rem;
            margin-top: 10px;
        }

        .btn-whatsapp:hover {
            background-color: #128C7E;
            transform: translateY(-2px);
        }

        /* Product Modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: var(--transition);
        }

        .modal-overlay.open {
            opacity: 1;
            visibility: visible;
        }

        .product-modal {
            background-color: var(--light);
            border-radius: var(--border-radius);
            width: 90%;
            max-width: 900px;
            max-height: 90vh;
            overflow-y: auto;
            padding: 30px;
            position: relative;
            transform: scale(0.9);
            transition: var(--transition);
        }

        .modal-overlay.open .product-modal {
            transform: scale(1);
        }

        .close-modal {
            position: absolute;
            top: 15px;
            right: 15px;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--dark);
            cursor: pointer;
            transition: var(--transition);
        }

        .close-modal:hover {
            color: var(--accent);
            transform: rotate(90deg);
        }

        .modal-content {
            display: flex;
            gap: 30px;
        }

        /* Contenedor general del modal (por si necesitas scroll interno) */
        .modal-images {
            max-width: 100%;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        /* GRID RESPONSIVO PARA MINIATURAS */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(75px, 1fr));
            gap: 10px;
            width: 100%;
            padding: 5px 0;
            max-height: 250px;
            /* Evita que el modal se rompa */
            overflow-y: auto;
            /* Activa scroll cuando sean muchísimas miniaturas */
        }

        /* Miniaturas */
        .gallery-item {
            width: 100%;
            height: 70px;
            object-fit: cover;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.2s;
        }

        .gallery-item:hover {
            transform: scale(1.05);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        /* Estilo para la imagen/video principal */
        .main-media-wrapper {
            width: 100%;
            position: relative;
        }

        .main-media-container {
            width: 100%;
            text-align: center;
        }

        .main-media {
            width: 100%;
            max-height: 400px;
            object-fit: contain;
        }

        /* flechas */
        .nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.5);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            color: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.2s;
        }

        .nav-left {
            left: 10px;
        }

        .nav-right {
            right: 10px;
        }

        .nav-btn:hover {
            background: rgba(0, 0, 0, 0.8);
        }

        .image-gallery img,
        .image-gallery video {
            border-radius: 6px;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .image-gallery img:hover,
        .image-gallery video:hover {
            transform: scale(1.05);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .gallery-item:hover,
        .gallery-item.active {
            border: 2px solid var(--primary);
        }

        .modal-details {
            flex: 1;
        }

        .modal-category {
            color: var(--gray);
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .modal-title {
            font-size: 1.8rem;
            margin-bottom: 15px;
            color: var(--primary);
        }

        .modal-price {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .modal-description {
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .modal-actions {
            display: flex;
            gap: 15px;
        }

        /* Loading Animation */
        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid var(--gray-light);
            border-top: 4px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Footer */
        footer {
            background-color: var(--text);
            /* ahora se invierte si quieres */
            color: var(--bg);
            /* usa la variable de fondo */
            padding: 40px 0 20px;
            margin-top: 50px;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 30px;
            margin-bottom: 30px;
        }

        .footer-section {
            flex: 1;
            min-width: 250px;
        }

        .footer-title {
            font-size: 1.2rem;
            margin-bottom: 20px;
            color: var(--primary);
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: var(--gray);
            text-decoration: none;
            transition: var(--transition);
        }

        .footer-links a:hover {
            color: white;
            padding-left: 5px;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--gray);
        }

        .tuxon-brand {
            color: var(--primary);
            font-weight: 700;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .main-content {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                margin-bottom: 20px;
            }

            .modal-content {
                flex-direction: column;
            }
        }

        @media (max-width: 768px) {
            .header-content {
                flex-wrap: wrap;
            }

            #checkoutBtn {
                display: block !important;
                width: 100%;
                margin-top: 10px;
                position: relative;
                z-index: 10;
            }

            #checkoutForm {
                display: none;
                /* Oculto hasta que se pulse el botón */
            }

            /* Evitar que quede tapado por el botón flotante del carrito */
            .cart-footer {
                padding-bottom: 80px;
            }

            /* Buscador siempre visible */
            .search-container {
                order: 3;
                width: 100%;
                margin-top: 15px;
                display: flex;
                /* asegurar que se muestre */
            }

            /* Botón de theme toggle siempre visible */
            .theme-toggle {
                display: inline-flex;
                order: 2;
                margin-left: auto;
            }

            .mobile-menu-btn {
                display: block;
            }

            /* Solo ocultar lo que no quieres mostrar */
            .nav-container .cart-icon {
                display: none;
            }

            /* Sidebar del carrito en mobile ocupa toda la pantalla */
            .cart-sidebar {
                right: -100%;
                max-width: 100%;
                background-color: var(--light);
                border-radius: 12px 12px 0 0;
            }

            .cart-sidebar.open {
                right: 0;
                width: 100%;
            }

            .cart-item {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            /* Botón flotante del carrito */
            .floating-cart-btn {
                display: flex;
            }
        }

        @media (max-width: 576px) {
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            }

            .product-actions {
                flex-direction: column;
            }

            .cart-item {
                flex-direction: column;
                text-align: center;
            }

            .cart-item-image {
                width: 100%;
                height: 150px;
            }
        }

        /* Contenedor de botones en línea */
        .filter-options {
            display: flex;
            /* Poner los botones en línea */
            flex-wrap: wrap;
            /* Permite que se ajusten si falta espacio */
            gap: 10px;
            /* Separación entre botones */
            margin-top: 10px;
        }

        /* Botones elegantes */
        .filter-options .btn {
            padding: 8px 16px;
            border-radius: 25px;
            /* Bordes redondeados */
            border: 1px solid var(--primary);
            background-color: var(--primary);
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        /* Hover suave */
        .filter-options .btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }

        /* Botón activo (opcional) */
        .filter-options .btn.active {
            background-color: var(--accent);
            border-color: var(--accent);
        }

        /* Contenedor principal de imagen/video */
        .main-media-wrapper {
            position: relative;
            width: 100%;
            max-height: 400px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Botones dentro del contenedor de medios */
        .nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.4);
            color: #fff;
            border: none;
            padding: 10px 14px;
            border-radius: 50%;
            cursor: pointer;
            z-index: 10;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
        }

        .nav-btn:hover {
            background: rgba(0, 0, 0, 0.6);
            transform: translateY(-50%) scale(1.1);
        }

        .nav-left {
            left: 10px;
        }

        .nav-right {
            right: 10px;
        }

        /* Animación de cambio suave */
        .fade-out {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .fade-in {
            opacity: 1;
            transition: opacity 0.3s ease;
        }

        /* Adaptación modo oscuro */
        [data-theme="dark"] .nav-btn {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
        }

        [data-theme="dark"] .nav-btn:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        /* Ajuste visual del contenedor principal */
        .main-media-container {
            width: 100%;
            max-height: 400px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .main-media {
            max-width: 100%;
            max-height: 400px;
            border-radius: 8px;
            object-fit: contain;
        }

        .price-type-badge {
            display: inline-block;
            margin-left: 6px;
            padding: 4px 10px;
            background: linear-gradient(135deg, #ffbe0b, #fb5607);
            color: #fff;
            font-weight: bold;
            border-radius: 6px;
            font-size: 0.9rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        /* Badge de oferta tipo en el carrito */
        .price-type-badge-cart {
            display: inline-block;
            background: linear-gradient(135deg, #ff6b6b, #ff3d00);
            color: #fff;
            font-weight: bold;
            font-size: 0.85rem;
            padding: 4px 8px;
            border-radius: 6px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.25);
            transform: rotate(-5deg);
            margin-left: 5px;
            text-transform: uppercase;
            transition: transform 0.2s ease;
        }

        .price-type-badge-cart:hover {
            transform: rotate(0deg) scale(1.1);
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo-container">
                    <img src="{{ Storage::url($empresa->logo) }}" alt="IMG-LOGO" class="logo">
                    <h1 class="empresa-nombre" id="empresaNombre">{{ $empresa->nombre }}</h1>
                </div>
                <!-- En el header, después del logo -->
                <input type="hidden" name="empresa_id" id="empresaId" value="{{ $empresa->id }}">
            </div>
            <div class="nav-container">
                <div class="search-container">
                    <input type="text" class="search-input" placeholder="Buscar productos..." id="searchInput">
                    <button class="search-btn"><i class="fas fa-search"></i></button>
                </div>

                <button class="theme-toggle" id="themeToggle">
                    <i class="fas fa-moon"></i>
                </button>

                <div class="cart-icon" id="cartIcon">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count" id="cartCount">0</span>
                </div>
            </div>


        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <div class="main-content">
            <!-- Sidebar -->
            <aside class="sidebar">
                <h3>Categorías</h3>
                <ul class="category-list" id="categoryList">
                    <!-- Las categorías se cargarán dinámicamente -->
                </ul>

                <h3>Filtros</h3>
                <div class="filter-options">
                    <button class="btn btn-secondary" data-filter="nuevos">Nuevos</button>
                    <button class="btn btn-secondary" data-filter="promociones">Promociones</button>
                    <button class="btn" data-filter="ofertas-tipo">Ofertas Especiales</button>
                    <button id="btnVerTodos" class="btn btn-secondary">Ver Todos</button>
                </div>
            </aside>

            <!-- Products Section -->
            <main class="products-section">
                <h2 class="section-title" id="sectionTitle">Todos los productos</h2>

                <div class="products-grid" id="productsGrid">
                    <!-- Los productos se cargarán dinámicamente -->
                </div>

                <div class="loading" id="loadingIndicator" style="display: none;">
                    <div class="spinner"></div>
                </div>
            </main>
        </div>
    </div>

    <!-- Floating Cart Button (Mobile) -->
    <div class="floating-cart-btn" id="floatingCartBtn">
        <i class="fas fa-shopping-cart"></i>
        <span class="cart-count" id="floatingCartCount">0</span>
    </div>

    <!-- Cart Sidebar -->
    <div class="cart-sidebar" id="cartSidebar">
        <div class="cart-header">
            <h2 class="cart-title">Tu Carrito</h2>
            <button class="close-cart" id="closeCart">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="cart-items" id="cartItems">
            <!-- Los items del carrito se cargarán dinámicamente -->
        </div>

        <div class="cart-footer">
            <div class="cart-total">
                <span>Total:</span>
                <span id="cartTotal">Bs. 0.00</span>
            </div>

            <button class="btn btn-primary" id="checkoutBtn">Consultar por WhatsApp</button>

            <div class="checkout-form" id="checkoutForm">
                <div class="form-group">
                    <label class="form-label" for="customerPhone">Teléfono</label>
                    <input type="tel" class="form-input" id="customerPhone" placeholder="Ingresa tu número de teléfono">
                </div>

                <div class="form-group">
                    <label class="form-label" for="customerName">Nombre Completo</label>
                    <input type="text" class="form-input" id="customerName" placeholder="Ingresa tu nombre completo">
                </div>

                <div class="form-group">
                    <label class="form-label" for="customerAddress">Dirección</label>
                    <input type="text" class="form-input" id="customerAddress" placeholder="Ingresa tu dirección">
                </div>

                <div class="form-group">
                    <label class="form-label" for="customerCity">Ciudad</label>
                    <input type="text" class="form-input" id="customerCity" placeholder="Ingresa tu ciudad">
                </div>

                <button class="btn btn-whatsapp" id="whatsappBtn">
                    <i class="fab fa-whatsapp"></i> Enviar por WhatsApp
                </button>
            </div>
        </div>
    </div>

    <!-- Product Modal -->
    <div class="modal-overlay" id="productModal">
        <div class="product-modal">
            <button class="close-modal" id="closeModal">
                <i class="fas fa-times"></i>
            </button>

            <div class="modal-content" id="modalContent">
                <!-- El contenido del modal se cargará dinámicamente -->
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3 class="footer-title">Sobre Nosotros</h3>
                    <p>Somos una empresa dedicada a ofrecer los mejores productos con calidad y servicio excepcional.</p>
                </div>

                <div class="footer-section">
                    <h3 class="footer-title">Enlaces Rápidos</h3>
                    <ul class="footer-links">
                        <li><a href="#">Inicio</a></li>
                        <li><a href="#">Productos</a></li>
                        <li><a href="#">Promociones</a></li>
                        <li><a href="#">Contacto</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h3 class="footer-title">Contacto</h3>
                    <ul class="footer-links">
                        <li><i class="fas fa-map-marker-alt"></i> Santa Cruz - Montero</li>
                        <li><i class="fas fa-phone"></i> Teléfono: +591 78548094</li>
                        <li><i class="fas fa-phone"></i> Teléfono: +591 64455289</li>
                        <!--<li><i class="fas fa-envelope"></i> Email: info@empresa.com</li>-->
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2025 <a href="/" class="tuxon-brand">TUXON</a>. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const slug = window.location.pathname.replace(/^\/+/, '');
        let empresa = {};
        let categorias = [];
        let productos = [];
        let productosFiltrados = [];
        let carrito = [];
        let categoriaActiva = null;
        let subcategoriaActiva = null;
        let filtroActivo = null;
        let terminoBusqueda = '';
        let modoOscuro = localStorage.getItem('modoOscuro') || 'system';

        document.addEventListener('DOMContentLoaded', async function() {
            await cargarDatosEmpresa();
            inicializarEmpresa();
            cargarCategorias();
            cargarProductos();
            inicializarEventos();
            aplicarTema();

            // Botón "Ver Todos"
            const btnVerTodos = document.getElementById('btnVerTodos');
            if (btnVerTodos) {
                btnVerTodos.addEventListener('click', () => {
                    categoriaActiva = null;
                    subcategoriaActiva = null;
                    filtroActivo = null;
                    terminoBusqueda = '';
                    document.getElementById('sectionTitle').textContent = 'Todos los productos';
                    productosFiltrados = [...productos];
                    cargarProductos();
                });
            }
        });

        // Cargar datos desde backend
        async function cargarDatosEmpresa() {
            try {
                const response = await fetch(`/api/empresa/${slug}`);
                if (!response.ok) throw new Error('Error al obtener datos');
                const data = await response.json();

                empresa = data.empresa || {};
                categorias = data.categorias || [];
                productos = data.productos || [];
                productosFiltrados = [...productos];
            } catch (error) {
                console.error('Error cargando datos:', error);
            }
        }

        // Inicializar cabecera
        function inicializarEmpresa() {
            const logoEl = document.getElementById('empresaLogo');
            const nombreEl = document.getElementById('empresaNombre');
            if (nombreEl) nombreEl.textContent = empresa.nombre || 'Sin nombre';
            if (logoEl) logoEl.src = empresa.logo || '/default-logo.png';
        }

        // Cargar categorías con estilo y botón "Ver todo"
        function cargarCategorias() {
            const categoryList = document.getElementById('categoryList');
            categoryList.innerHTML = '';

            categorias.forEach(categoria => {
                const categoryItem = document.createElement('li');
                categoryItem.className = 'category-item';

                const categoryHeader = document.createElement('div');
                categoryHeader.className = 'category-header';

                const categoryBtn = document.createElement('button');
                categoryBtn.className = 'category-btn';
                categoryBtn.innerHTML = `
            <span>${categoria.nombre}</span>
            <i class="fas fa-chevron-right arrow-icon"></i>
        `;

                categoryBtn.addEventListener('click', () => {
                    toggleSubcategorias(categoria.id);
                    filtrarPorCategoria(categoria.id);
                });

                categoryHeader.appendChild(categoryBtn);
                categoryItem.appendChild(categoryHeader);

                // Subcategorías
                const subcategoryList = document.createElement('ul');
                subcategoryList.className = 'subcategory-list';
                subcategoryList.id = `subcategorias-${categoria.id}`;

                categoria.subcategorias.forEach(subcategoria => {
                    const subcategoryItem = document.createElement('li');
                    subcategoryItem.className = 'subcategory-item';
                    subcategoryItem.innerHTML = `
                <button class="subcategory-btn">${subcategoria.nombre}</button>
            `;
                    subcategoryItem
                        .querySelector('.subcategory-btn')
                        .addEventListener('click', () =>
                            filtrarPorSubcategoria(categoria.id, subcategoria.id)
                        );
                    subcategoryList.appendChild(subcategoryItem);
                });

                categoryItem.appendChild(subcategoryList);
                categoryList.appendChild(categoryItem);
            });

            // 🔹 Botón "Ver todo"
            const verTodoItem = document.createElement('li');
            verTodoItem.className = 'category-item ver-todo';
            const verTodoBtn = document.createElement('button');
            verTodoBtn.className = 'category-btn ver-todo-btn';
            verTodoBtn.innerHTML = `<i class="fas fa-th-large"></i> Ver todo`;

            verTodoBtn.addEventListener('click', () => {
                // Restablecer filtros
                categoriaActiva = null;
                subcategoriaActiva = null;
                filtroActivo = null;
                terminoBusqueda = '';

                // Título general
                document.getElementById('sectionTitle').textContent = 'Todos los productos';
                productosFiltrados = [...productos];
                cargarProductos();

                // 🔻 Ocultar subcategorías abiertas y resetear flechas
                document.querySelectorAll('.subcategory-list').forEach(list => {
                    list.classList.remove('show');
                });
                document.querySelectorAll('.arrow-icon').forEach(icon => {
                    icon.classList.remove('rotate');
                });
            });

            verTodoItem.appendChild(verTodoBtn);
            categoryList.appendChild(verTodoItem);
        }

        // Toggle subcategorías
        function toggleSubcategorias(categoriaId) {
            document.querySelectorAll('.subcategory-list').forEach(list => {
                list.classList.remove('show');
            });
            document.querySelectorAll('.arrow-icon').forEach(icon => {
                icon.classList.remove('rotate');
            });

            const subcategoryList = document.getElementById(`subcategorias-${categoriaId}`);
            const arrow = subcategoryList.previousElementSibling.querySelector('.arrow-icon');
            const isOpen = subcategoryList.classList.contains('show');

            if (!isOpen) {
                subcategoryList.classList.add('show');
                arrow.classList.add('rotate');
            }
        }


        // Cargar productos
        function cargarProductos() {
            const productsGrid = document.getElementById('productsGrid');
            productsGrid.innerHTML = '';

            // Evitar duplicados por ID
            const productosUnicos = [];
            const ids = new Set();
            productosFiltrados.forEach(p => {
                if (!ids.has(p.id)) {
                    ids.add(p.id);
                    productosUnicos.push(p);
                }
            });

            if (productosUnicos.length === 0) {
                productsGrid.innerHTML = '<p>No se encontraron productos.</p>';
                return;
            }

            productosUnicos.forEach(producto => {
                const productCard = document.createElement('div');
                productCard.className = 'product-card';

                const tieneDescuento = producto.precio_oferta !== null;
                const porcentajeDescuento = tieneDescuento ? Math.round((1 - producto.precio_oferta / producto.precio) * 100) : 0;

                // Mostrar precio: normal u oferta
                const precioMostrar = tieneDescuento ? producto.precio_oferta : producto.precio;

                const esNuevo = producto.nuevo;
                const esOferta = producto.promocion || tieneDescuento;

                productCard.innerHTML = `
        <div class="sticker-container">
            ${esNuevo ? '<span class="sticker sticker-nuevo">Nuevo</span>' : ''}
            ${esOferta ? '<span class="sticker sticker-oferta">Oferta</span>' : ''}
        </div>
        ${producto.oferta_tipo && producto.precio_oferta_tipo ? `
            <span class="sticker-oferta-tipo">
                ${producto.oferta_tipo.split('x')[0]}x Bs. ${parseFloat(producto.precio_oferta_tipo).toFixed(2)}
            </span>` 
            : ''
        }
        <img src="${producto.imagenes[0]}" alt="${producto.nombre}" class="product-image">
        <div class="product-info">
            <div class="product-category">${producto.categoria} / ${producto.subcategoria}</div>
            <h3 class="product-name">${producto.nombre}</h3>
            <div class="product-price">
                <!-- Precio principal -->
                <span class="current-price">Bs. ${parseFloat(precioMostrar).toFixed(2)}</span>

                <!-- Precio original tachado si hay descuento -->
                ${tieneDescuento ? `<span class="original-price">Bs. ${parseFloat(producto.precio).toFixed(2)}</span>
                                     <span class="discount-badge">-${porcentajeDescuento}%</span>` : ''}

                <!-- Precio de oferta tipo (2x1, 3x2, etc.) -->
                ${producto.precio_oferta_tipo ? `
                    <span class="price-type-badge">
                        ${producto.oferta_tipo ? producto.oferta_tipo.split('x')[0] : ''}x Bs. ${parseFloat(producto.precio_oferta_tipo).toFixed(2)}
                    </span>` 
                    : ''
                }
            </div>
            <div class="product-actions">
                <button class="btn btn-primary btn-add-cart" data-id="${producto.id}">
                    <i class="fas fa-cart-plus"></i> Agregar
                </button>
                <button class="btn btn-secondary btn-view-product" data-id="${producto.id}">
                    <i class="fas fa-eye"></i> Ver
                </button>
            </div>
        </div>
    `;

                productsGrid.appendChild(productCard);
            });

            // Eventos de botones
            document.querySelectorAll('.btn-add-cart').forEach(btn => {
                btn.addEventListener('click', function() {
                    const productId = parseInt(this.getAttribute('data-id'));
                    agregarAlCarrito(productId);
                });
            });

            document.querySelectorAll('.btn-view-product').forEach(btn => {
                btn.addEventListener('click', function() {
                    const productId = parseInt(this.getAttribute('data-id'));
                    mostrarModalProducto(productId);
                });
            });
        }

        // Filtrar por categoría
        function filtrarPorCategoria(categoriaId) {
            categoriaActiva = categoriaId;
            subcategoriaActiva = null;
            const categoria = categorias.find(c => c.id === categoriaId);
            document.getElementById('sectionTitle').textContent = categoria.nombre;

            productosFiltrados = productos.filter(p =>
                p.categoria === categoria.nombre &&
                (filtroActivo ? aplicarFiltroEspecial(p) : true) &&
                (terminoBusqueda ? p.nombre.toLowerCase().includes(terminoBusqueda.toLowerCase()) : true)
            );

            cargarProductos();
        }

        // Filtrar por subcategoría
        function filtrarPorSubcategoria(categoriaId, subcategoriaId) {
            categoriaActiva = categoriaId;
            subcategoriaActiva = subcategoriaId;
            const categoria = categorias.find(c => c.id === categoriaId);
            const subcategoria = categoria.subcategorias.find(s => s.id === subcategoriaId);
            document.getElementById('sectionTitle').textContent = `${categoria.nombre} - ${subcategoria.nombre}`;

            productosFiltrados = productos.filter(p =>
                p.categoria === categoria.nombre &&
                p.subcategoria === subcategoria.nombre &&
                (filtroActivo ? aplicarFiltroEspecial(p) : true) &&
                (terminoBusqueda ? p.nombre.toLowerCase().includes(terminoBusqueda.toLowerCase()) : true)
            );

            cargarProductos();
        }

        // Aplicar filtros especiales
        function aplicarFiltroEspecial(producto) {
            if (filtroActivo === 'nuevos') return producto.nuevo;
            if (filtroActivo === 'promociones') return producto.promocion;
            return true;
        }


        // Inicializar eventos
        function inicializarEventos() {
            // Búsqueda en tiempo real
            document.getElementById('searchInput').addEventListener('input', function() {
                terminoBusqueda = this.value;
                aplicarFiltros();
            });

            // Filtros especiales
            document.querySelectorAll('[data-filter]').forEach(btn => {
                btn.addEventListener('click', function() {
                    const filtro = this.getAttribute('data-filter');

                    if (filtroActivo === filtro) {
                        filtroActivo = null;
                        this.classList.remove('active');
                    } else {
                        filtroActivo = filtro;
                        document.querySelectorAll('[data-filter]').forEach(b => b.classList.remove('active'));
                        this.classList.add('active');
                    }

                    aplicarFiltros();
                });
            });

            // Toggle del tema
            document.getElementById('themeToggle').addEventListener('click', toggleTema);

            // Carrito
            document.getElementById('cartIcon').addEventListener('click', abrirCarrito);
            document.getElementById('floatingCartBtn').addEventListener('click', abrirCarrito);
            document.getElementById('closeCart').addEventListener('click', cerrarCarrito);

            // Checkout
            document.getElementById('checkoutBtn').addEventListener('click', mostrarFormularioCheckout);
            document.getElementById('whatsappBtn').addEventListener('click', enviarWhatsApp);

            // Verificación de cliente existente
            document.getElementById('customerPhone').addEventListener('input', verificarCliente);

            // Cerrar modal
            document.getElementById('closeModal').addEventListener('click', cerrarModal);
            document.getElementById('productModal').addEventListener('click', function(e) {
                if (e.target === this) cerrarModal();
            });

            // Scroll infinito
            window.addEventListener('scroll', manejarScrollInfinito);
        }

        // Aplicar todos los filtros
        function aplicarFiltros() {
            if (categoriaActiva && subcategoriaActiva) {
                filtrarPorSubcategoria(categoriaActiva, subcategoriaActiva);
            } else if (categoriaActiva) {
                filtrarPorCategoria(categoriaActiva);
            } else {
                productosFiltrados = productos.filter(p =>
                    (filtroActivo ? aplicarFiltroEspecial(p) : true) &&
                    (terminoBusqueda ? p.nombre.toLowerCase().includes(terminoBusqueda.toLowerCase()) : true) &&
                    (filtroActivo === 'ofertas-tipo' ? !!p.oferta_tipo : true)
                );

                let titulo = 'Todos los productos';
                if (filtroActivo === 'nuevos') titulo = 'Productos Nuevos';
                if (filtroActivo === 'promociones') titulo = 'Promociones';
                if (filtroActivo === 'ofertas-tipo') titulo = 'Ofertas Especiales';

                document.getElementById('sectionTitle').textContent = titulo;
            }

            cargarProductos();
        }

        // Agregar producto al carrito
        function agregarAlCarrito(productId) {
            const producto = productos.find(p => p.id === productId);
            if (!producto) return;

            const itemExistente = carrito.find(item => item.id === productId);

            // Guardamos precio unitario normal u oferta simple
            const precioUnitario = producto.precio_oferta !== null ? parseFloat(producto.precio_oferta) : parseFloat(producto.precio);

            if (itemExistente) {
                itemExistente.cantidad++;
            } else {
                carrito.push({
                    id: producto.id,
                    nombre: producto.nombre,
                    precio_unitario: precioUnitario,
                    imagen: producto.imagenes[0],
                    cantidad: 1,
                    ofertaTipo: producto.oferta_tipo || null, // ej. "2x1"
                    precioOfertaTipo: producto.precio_oferta_tipo ? parseFloat(producto.precio_oferta_tipo) : null
                });
            }

            actualizarCarrito();
            animarCarrito();
            notificarProducto(producto.nombre);
        }

        // Animación carrito
        function animarCarrito() {
            const cartIcon = document.getElementById('cartIcon');
            cartIcon.classList.add('animate');
            setTimeout(() => cartIcon.classList.remove('animate'), 500);
        }

        // Notificación
        function notificarProducto(nombre) {
            Swal.fire({
                title: '¡Producto agregado!',
                text: `${nombre} se agregó al carrito`,
                icon: 'success',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true
            });
        }

        // Calcular precio con oferta tipo
        function calcularPrecioItem(item) {
            if (!item.ofertaTipo || !item.precioOfertaTipo) {
                return {
                    total: item.precio_unitario * item.cantidad,
                    detalle: null
                };
            }

            const [comprar, pagar] = item.ofertaTipo.split('x').map(Number);
            const fullGroups = Math.floor(item.cantidad / comprar);
            const remainder = item.cantidad % comprar;

            const total = fullGroups * item.precioOfertaTipo + remainder * item.precio_unitario;

            return {
                total,
                detalle: {
                    fullGroups,
                    pagar,
                    remainder
                }
            };
        }

        // Actualizar carrito
        function actualizarCarrito() {
            const cartCount = carrito.reduce((total, item) => total + item.cantidad, 0);
            document.getElementById('cartCount').textContent = cartCount;
            document.getElementById('floatingCartCount').textContent = cartCount;

            const cartItems = document.getElementById('cartItems');
            cartItems.innerHTML = '';

            let totalCarrito = 0;

            carrito.forEach(item => {
                const {
                    total,
                    detalle
                } = calcularPrecioItem(item);
                totalCarrito += total;

                let ofertaTexto = '';
                if (item.ofertaTipo && item.precioOfertaTipo) {
                    const cantidadPromo = item.ofertaTipo.split('x')[0]; // obtiene el "2" de "2x1"
                    const precioPromo = parseFloat(item.precioOfertaTipo);

                    const fullGroups = Math.floor(item.cantidad / cantidadPromo);

                    if (fullGroups > 0) {
                        ofertaTexto = `${cantidadPromo}x Bs. ${precioPromo.toFixed(2)} aplicado x${fullGroups}`;
                    } else {
                        ofertaTexto = `${cantidadPromo}x Bs. ${precioPromo.toFixed(2)}`;
                    }
                }

                const cartItem = document.createElement('div');
                cartItem.className = 'cart-item';
                cartItem.innerHTML = `
            <img src="${item.imagen}" alt="${item.nombre}" class="cart-item-image">
            <div class="cart-item-details">
                <h4 class="cart-item-name">${item.nombre}</h4>
                <div class="cart-item-price">
                    Bs. ${total.toFixed(2)}
                    ${ofertaTexto ? `<span class="price-type-badge-cart">${ofertaTexto}</span>` : ''}
                </div>
                <div class="cart-item-actions">
                    <button class="quantity-btn decrease" data-id="${item.id}">
                        <i class="fas fa-minus"></i>
                    </button>
                    <span class="quantity-display">${item.cantidad}</span>
                    <button class="quantity-btn increase" data-id="${item.id}">
                        <i class="fas fa-plus"></i>
                    </button>
                    <button class="remove-item" data-id="${item.id}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
                cartItems.appendChild(cartItem);
            });

            document.getElementById('cartTotal').textContent = `Bs. ${totalCarrito.toFixed(2)}`;

            // Eventos botones
            document.querySelectorAll('.increase').forEach(btn => {
                btn.addEventListener('click', function() {
                    const productId = parseInt(this.getAttribute('data-id'));
                    const item = carrito.find(i => i.id === productId);
                    if (item) {
                        item.cantidad++;
                        actualizarCarrito();
                    }
                });
            });

            document.querySelectorAll('.decrease').forEach(btn => {
                btn.addEventListener('click', function() {
                    const productId = parseInt(this.getAttribute('data-id'));
                    const item = carrito.find(i => i.id === productId);
                    if (item && item.cantidad > 1) {
                        item.cantidad--;
                        actualizarCarrito();
                    }
                });
            });

            document.querySelectorAll('.remove-item').forEach(btn => {
                btn.addEventListener('click', function() {
                    const productId = parseInt(this.getAttribute('data-id'));
                    carrito = carrito.filter(i => i.id !== productId);
                    actualizarCarrito();

                    Swal.fire({
                        title: 'Producto eliminado',
                        text: 'El producto se eliminó del carrito',
                        icon: 'info',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
            });
        }



        // Abrir carrito
        function abrirCarrito() {
            document.getElementById('cartSidebar').classList.add('open');
        }

        // Cerrar carrito
        function cerrarCarrito() {
            document.getElementById('cartSidebar').classList.remove('open');
        }

        // Mostrar formulario de checkout
        function mostrarFormularioCheckout() {
            if (carrito.length === 0) {
                Swal.fire({
                    title: 'Carrito vacío',
                    text: 'Agrega productos al carrito antes de consultar',
                    icon: 'warning',
                    confirmButtonText: 'Entendido'
                });
                return;
            }

            document.getElementById('checkoutForm').style.display = 'block';
            document.getElementById('checkoutBtn').style.display = 'none';
        }

        // Verificar si el cliente existe
        function verificarCliente() {
            const telefono = document.getElementById('customerPhone').value;
            const empresaId = document.getElementById('empresaId').value;

            if (telefono.length >= 8) {
                fetch(`/clientes/buscar-telefono/${telefono}?empresa_id=${empresaId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.encontrado) {
                            clienteExistente = data.cliente;

                            // Rellenar automáticamente los datos
                            document.getElementById('customerName').value = data.cliente.nombre;
                            document.getElementById('customerAddress').value = data.cliente.direccion;
                            document.getElementById('customerCity').value = data.cliente.ciudad;

                            // Actualizar el estado del usuario
                            usuarioRegistrado = true;
                            datosUsuario = data.cliente;

                            Swal.fire({
                                title: 'Cliente encontrado',
                                text: 'Tus datos se han cargado automáticamente',
                                icon: 'success',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2000
                            });
                        } else {
                            clienteExistente = null;
                            usuarioRegistrado = false;
                            limpiarCamposRegistro();

                            Swal.fire({
                                title: 'Cliente no registrado',
                                text: 'Por favor completa tus datos',
                                icon: 'info',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error al verificar teléfono:', error);
                        clienteExistente = null;
                        usuarioRegistrado = false;
                    });
            } else {
                clienteExistente = null;
                usuarioRegistrado = false;
                limpiarCamposRegistro();
            }
        }
        // Función para limpiar campos del formulario
        function limpiarCamposRegistro() {
            document.getElementById('customerName').value = '';
            document.getElementById('customerAddress').value = '';
            document.getElementById('customerCity').value = '';
        }

        // Enviar mensaje por WhatsApp
        function enviarWhatsApp() {
            const telefono = document.getElementById('customerPhone').value;
            const nombre = document.getElementById('customerName').value;
            const direccion = document.getElementById('customerAddress').value;
            const ciudad = document.getElementById('customerCity').value;

            if (!telefono || !nombre || !direccion || !ciudad) {
                Swal.fire({
                    title: 'Datos incompletos',
                    text: 'Por favor completa todos los campos',
                    icon: 'error',
                    confirmButtonText: 'Entendido'
                });
                return;
            }

            let mensaje = `Hola, quiero consultar los siguientes productos:\n\n`;
            
            carrito.forEach(p => {

                // Precio seguro según lo que venga
                const precioSeguro =
                    parseFloat(p.precio) ||
                    parseFloat(p.precio_unitario) ||
                    parseFloat(p.precioOfertaTipo) ||
                    0;

                mensaje += `- ${p.nombre} (${p.cantidad} x Bs. ${precioSeguro.toFixed(2)})\n`;
            });
            
            const total = carrito.reduce((sum, item) => sum + (item.precio * item.cantidad), 0);
            mensaje += `\nTotal: Bs. ${total.toFixed(2)}`;
            mensaje += `\n\nMis datos:\nNombre: ${nombre}\nDirección: ${direccion}\nCiudad: ${ciudad}`;

            if (!empresa.telefono_whatsapp) {
                Swal.fire({
                    title: 'Número de WhatsApp no disponible',
                    text: 'No se pudo obtener el número de la empresa',
                    icon: 'error'
                });
                return;
            }

            const url = `https://wa.me/${empresa.telefono_whatsapp}?text=${encodeURIComponent(mensaje)}`;
            window.open(url, '_blank');
            // Registrar cliente si no existe
            if (!usuarioRegistrado) {
                const datosCliente = {
                    telefono: telefono,
                    nombre: nombre,
                    direccion: direccion,
                    ciudad: ciudad,
                    empresa_id: document.getElementById('empresaId').value
                };

                registrarCliente(datosCliente);
            }

            // Cerrar carrito y limpiar formulario
            cerrarCarrito();
            document.getElementById('checkoutForm').style.display = 'none';
            document.getElementById('checkoutBtn').style.display = 'block';
            document.getElementById('customerPhone').value = '';
            document.getElementById('customerName').value = '';
            document.getElementById('customerAddress').value = '';
            document.getElementById('customerCity').value = '';

            // Vaciar carrito
            carrito = [];
            actualizarCarrito();
        }
        // Agregar función para cargar detalles del producto desde tu API
        function cargarDetallesProducto(productId) {
            return fetch(`/api/producto/${productId}/detalles`)
                .then(res => {
                    if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
                    return res.json();
                })
                .then(data => {
                    return data.producto;
                })
                .catch(error => {
                    console.error('Error al cargar detalles del producto:', error);
                    return null;
                });
        }
        // Registrar cliente (simulación)
        function registrarCliente(datos) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

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

                        Swal.fire({
                            title: '¡Cliente registrado!',
                            text: 'Tu información ha sido guardada',
                            icon: 'success',
                            confirmButtonText: 'Continuar'
                        });
                    } else {
                        Swal.fire('Error', data.message || 'No se pudo registrar', 'error');
                    }
                })
                .catch(error => {
                    console.error("Fetch error:", error);
                    Swal.fire('Error', 'Ocurrió un error en el servidor', 'error');
                });
        }

        // Mostrar modal del producto
        function mostrarModalProducto(productId) {
            document.getElementById('modalContent').innerHTML = `
                <div class="loading">
                    <div class="spinner"></div>
                    <p>Cargando detalles del producto...</p>
                </div>
            `;
            document.getElementById('productModal').classList.add('open');

            cargarDetallesProducto(productId).then(producto => {
                if (!producto) {
                    document.getElementById('modalContent').innerHTML = `
                <div class="error-message">
                    <p>Error al cargar los detalles del producto</p>
                    <button class="btn btn-primary" onclick="cerrarModal()">Cerrar</button>
                </div>
            `;
                    return;
                }

                let currentIndex = 0;
                const medios = producto.imagenes || [];
                if (medios.length === 0) {
                    document.getElementById('modalContent').innerHTML = `<p>No hay imágenes ni videos disponibles.</p>`;
                    return;
                }

                const renderMedio = (index, fade = true) => {
                    const contenedorMain = document.querySelector('.main-media-container');
                    if (!contenedorMain) return;

                    // Pausar cualquier video previo
                    contenedorMain.querySelectorAll('video').forEach(v => v.pause());

                    const medio = medios[index];
                    const esVideo = medio.match(/\.(mp4|webm|ogg)$/i);

                    const nuevoContenido = esVideo ?
                        `<video class="main-media" controls autoplay style="width:100%; max-height:400px; object-fit:contain;">
                       <source src="${medio}" type="video/mp4">
                       Tu navegador no soporta la reproducción de videos.
                   </video>` :
                        `<img class="main-media" src="${medio}" alt="${producto.nombre}" style="width:100%; max-height:400px; object-fit:contain;">`;

                    contenedorMain.classList.add('fade-out');
                    setTimeout(() => {
                        contenedorMain.innerHTML = nuevoContenido;
                        contenedorMain.classList.remove('fade-out');
                        contenedorMain.classList.add('fade-in');
                        setTimeout(() => contenedorMain.classList.remove('fade-in'), 300);
                    }, fade ? 300 : 0);
                };

                const precio = parseFloat(producto.precio) || 0;
                const precioOferta = producto.precio_oferta ? parseFloat(producto.precio_oferta) : null;
                const precioOfertaTipo = producto.precio_oferta_tipo ? parseFloat(producto.precio_oferta_tipo) : null;

                let precioMostrar = precioOferta || precio;
                let tipoSticker = '';

                if (producto.oferta_tipo) {
                    tipoSticker = producto.oferta_tipo; // ej: "2x1"
                }

                // Construir HTML del precio
                let precioHtml = `<span class="current-price">Bs. ${precioMostrar.toFixed(2)}</span>`;

                // Mostrar descuento si existe
                if (precioOferta) {
                    precioHtml += `
        <span class="original-price">Bs. ${precio.toFixed(2)}</span>
        <span class="discount-badge">-${Math.round((1 - precioOferta / precio) * 100)}%</span>
    `;
                }

                // Mostrar oferta tipo pero ahora como "2x Bs. X"
                if (precioOfertaTipo && producto.oferta_tipo) {
                    const cantidadPromo = producto.oferta_tipo.split('x')[0]; // obtiene el "2" de "2x1"
                    precioHtml += `
                    <span class="price-type-badge-cart">
                        ${cantidadPromo}x Bs. ${precioOfertaTipo.toFixed(2)}
                    </span>
                `;
                }
                // Construir contenido del modal
                document.getElementById('modalContent').innerHTML = `
            <div class="modal-images">
                  <div class="main-media-wrapper">
                        <div class="main-media-container"></div>
                        ${medios.length > 1 ? `
                            <button class="nav-btn nav-left"><i class="fas fa-chevron-left"></i></button>
                            <button class="nav-btn nav-right"><i class="fas fa-chevron-right"></i></button>
                        ` : ''}
                    </div>

                <div class="image-gallery gallery-grid">
                    ${medios.map((medio, index) =>
                        medio.match(/\.(mp4|webm|ogg)$/i)
                            ? `<video class="gallery-item" data-index="${index}" width="80" height="60" style="object-fit:cover;"><source src="${medio}" type="video/mp4"></video>`
                            : `<img class="gallery-item" src="${medio}" data-index="${index}" width="80" height="60" style="object-fit:cover;">`
                    ).join('')}
                </div>
            </div>
            <div class="modal-details">
                <div class="modal-category">${producto.categoria} / ${producto.subcategoria}</div>
                <h2 class="modal-title">${producto.nombre}</h2>
                <div class="modal-price">
                    ${precioHtml}
                </div>
                <p class="modal-description">${producto.descripcion}</p>
                <div class="modal-actions">
                    <button class="btn btn-primary" id="addToCartFromModal" data-id="${producto.id}">
                        <i class="fas fa-cart-plus"></i> Agregar al Carrito
                    </button>
                </div>
            </div>
        `;

                // Mostrar el primer medio
                renderMedio(currentIndex, false);

                // Botones de navegación
                const btnLeft = document.querySelector('.nav-left');
                const btnRight = document.querySelector('.nav-right');

                function actualizarBotones() {
                    if (!btnLeft || !btnRight) return;
                    btnLeft.style.display = currentIndex === 0 ? 'none' : 'flex';
                    btnRight.style.display = currentIndex === medios.length - 1 ? 'none' : 'flex';
                }

                // Mostrar el primer medio
                renderMedio(currentIndex, false);
                actualizarBotones();

                if (btnLeft && btnRight) {
                    btnLeft.addEventListener('click', () => {
                        if (currentIndex > 0) {
                            currentIndex--;
                            renderMedio(currentIndex);
                            actualizarBotones();
                        }
                    });

                    btnRight.addEventListener('click', () => {
                        if (currentIndex < medios.length - 1) {
                            currentIndex++;
                            renderMedio(currentIndex);
                            actualizarBotones();
                        }
                    });
                }

                // Miniaturas
                document.querySelectorAll('.gallery-item').forEach(item => {
                    item.addEventListener('click', function() {
                        currentIndex = parseInt(this.getAttribute('data-index'));
                        renderMedio(currentIndex);
                        actualizarBotones();
                    });
                });

                // Agregar al carrito
                document.getElementById('addToCartFromModal').addEventListener('click', function() {
                    const productId = parseInt(this.getAttribute('data-id'));
                    document.querySelectorAll('#productModal video').forEach(v => v.pause());
                    agregarAlCarrito(productId);
                    cerrarModal();
                });
            });
        }

        // Cerrar modal y pausar videos
        document.getElementById('closeModal').addEventListener('click', function() {
            const modal = document.getElementById('productModal');
            modal.classList.remove('open');
            modal.querySelectorAll('video').forEach(v => v.pause());
        });

        function cerrarModal() {
            const modal = document.getElementById('productModal');
            modal.classList.remove('open');
            modal.querySelectorAll('video').forEach(v => v.pause());
        }


        // Toggle del tema
        function toggleTema() {
            const themeToggle = document.getElementById('themeToggle');

            if (modoOscuro === 'light') {
                modoOscuro = 'dark';
                themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
            } else if (modoOscuro === 'dark') {
                modoOscuro = 'system';
                themeToggle.innerHTML = '<i class="fas fa-desktop"></i>';
            } else {
                modoOscuro = 'light';
                themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
            }

            localStorage.setItem('modoOscuro', modoOscuro);
            aplicarTema();
        }

        // Aplicar tema según preferencias
        function aplicarTema() {
            const themeToggle = document.getElementById('themeToggle');

            if (modoOscuro === 'system') {
                if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                    document.documentElement.setAttribute('data-theme', 'dark');
                    themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
                } else {
                    document.documentElement.removeAttribute('data-theme');
                    themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
                }
            } else if (modoOscuro === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
                themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
            } else {
                document.documentElement.removeAttribute('data-theme');
                themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
            }
        }

        // Manejar scroll infinito
        function manejarScrollInfinito() {
            const {
                scrollTop,
                scrollHeight,
                clientHeight
            } = document.documentElement;

            if (scrollTop + clientHeight >= scrollHeight - 100) {
                // Simular carga de más productos
                // En una implementación real, harías una petición AJAX al servidor
                setTimeout(() => {
                    // Aquí cargarías más productos
                    //console.log('Cargando más productos...');
                }, 1000);
            }
        }
    </script>
</body>

</html>