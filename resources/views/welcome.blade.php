<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TUXON - Soluciones de Software a Medida</title>
    <style>
        :root {
            --primary: #2c3e50;
            --secondary: #3498db;
            --accent: #e74c3c;
            --light: #ecf0f1;
            --dark: #2c3e50;
            --text: #333;
            --text-light: #7f8c8d;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--light);
            color: var(--text);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        header {
            background: linear-gradient(135deg, var(--primary), var(--dark));
            color: white;
            padding: 40px 0;
            position: relative;
            overflow: hidden;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo-icon {
            width: 60px;
            height: 60px;
            background-color: var(--accent);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 15px;
            position: relative;
        }

        .logo-icon::before {
            content: "";
            position: absolute;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: white;
            top: 10px;
        }

        .logo-icon::after {
            content: "";
            position: absolute;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: var(--accent);
            top: 5px;
            left: 15px;
            box-shadow:
                20px 0 0 var(--accent),
                0 25px 0 var(--accent),
                20px 25px 0 var(--accent);
        }

        .logo-text h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .logo-text p {
            font-size: 1rem;
            opacity: 0.9;
        }

        .nav-links {
            display: flex;
            list-style: none;
        }

        .nav-links li {
            margin-left: 30px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .nav-links a:hover {
            color: var(--accent);
        }

        .hero {
            text-align: center;
            padding: 80px 0;
        }

        .hero h2 {
            font-size: 3rem;
            margin-bottom: 20px;
            color: var(--primary);
        }

        .hero p {
            font-size: 1.2rem;
            max-width: 800px;
            margin: 0 auto 40px;
            color: var(--text-light);
        }

        .btn {
            display: inline-block;
            background-color: var(--accent);
            color: white;
            padding: 12px 30px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #c0392b;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .services {
            padding: 80px 0;
            background-color: white;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            color: var(--primary);
            position: relative;
            display: inline-block;
        }

        .section-title h2::after {
            content: "";
            position: absolute;
            width: 50px;
            height: 3px;
            background-color: var(--accent);
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .service-card {
            background-color: var(--light);
            border-radius: 10px;
            padding: 30px;
            transition: all 0.3s ease;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        .service-icon {
            font-size: 3rem;
            color: var(--secondary);
            margin-bottom: 20px;
        }

        .service-card h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: var(--primary);
        }

        .service-card p {
            color: var(--text-light);
        }

        .industries {
            padding: 80px 0;
            background-color: #f9f9f9;
        }

        .industries-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .industry-item {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .industry-icon {
            width: 50px;
            height: 50px;
            background-color: var(--light);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-right: 15px;
            color: var(--secondary);
            font-size: 1.5rem;
        }

        .cta {
            padding: 100px 0;
            background: linear-gradient(135deg, var(--primary), var(--dark));
            color: white;
            text-align: center;
        }

        .cta h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .cta p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 40px;
            opacity: 0.9;
        }

        footer {
            background-color: var(--dark);
            color: white;
            padding: 50px 0 20px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .footer-column h3 {
            font-size: 1.3rem;
            margin-bottom: 20px;
            position: relative;
        }

        .footer-column h3::after {
            content: "";
            position: absolute;
            width: 30px;
            height: 2px;
            background-color: var(--accent);
            bottom: -8px;
            left: 0;
        }

        .footer-column p {
            opacity: 0.8;
            margin-bottom: 15px;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: white;
            text-decoration: none;
            opacity: 0.8;
            transition: all 0.3s ease;
        }

        .footer-links a:hover {
            opacity: 1;
            padding-left: 5px;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .footer-bottom p {
            opacity: 0.7;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                text-align: center;
            }

            .logo {
                margin-bottom: 20px;
                justify-content: center;
            }

            .nav-links {
                margin-top: 20px;
            }

            .nav-links li {
                margin: 0 10px;
            }

            .hero h2 {
                font-size: 2.2rem;
            }

            .hero p {
                font-size: 1rem;
            }
        }

        /* Animaciones */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>

<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <img src="{{ asset('images/yane/tuxon2.png') }}" alt="" class="logo-icon floating">
                    <div class="logo-text">
                        <h1>TUXON</h1>
                        <p>Soluciones de Software a Medida</p>
                    </div>
                </div>
                <ul class="nav-links">
                    <li><a href="#servicios">Servicios</a></li>
                    <li><a href="#industrias">Industrias</a></li>
                    <li><a href="#contacto">Contacto</a></li>
                </ul>
            </div>
        </div>
    </header>

    <section class="hero">
        <div class="container">
            <h2>Transformamos tu negocio con tecnología</h2>
            <p>En TUXON desarrollamos sistemas de software personalizados que optimizan tus operaciones, mejoran la experiencia de tus clientes y aumentan tu productividad.</p>
            <a href="#contacto" class="btn">Contáctanos</a>
        </div>
    </section>

    <section class="services" id="servicios">
        <div class="container">
            <div class="section-title">
                <h2>Nuestros Servicios</h2>
            </div>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">👨‍💻</div>
                    <h3>Sistemas para Gimnasios</h3>
                    <p>Módulos completos para gestión de inventario, control de asistencia por huella digital, registro y verificación biométrica, y gestión de ventas con código de barras.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">🏪</div>
                    <h3>Tiendas Virtuales</h3>
                    <p>Plataformas de consulta por WhatsApp para que tus clientes puedan realizar pedidos fácilmente sin necesidad de pagos en línea.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">💊</div>
                    <h3>Sistemas para Farmacias</h3>
                    <p>Soluciones especializadas para el control de inventario, ventas y gestión de medicamentos en farmacias.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">🛠️</div>
                    <h3>Sistemas para Ferreterías</h3>
                    <p>Herramientas digitales para la gestión de productos, ventas y control de inventario en ferreterías.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">🍽️</div>
                    <h3>Sistemas para Restaurantes</h3>
                    <p>Plataformas completas para gestión de pedidos, mesas, inventario y ventas en establecimientos gastronómicos.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">📦</div>
                    <h3>Sistemas a Medida</h3>
                    <p>Desarrollamos software personalizado adaptado a las necesidades específicas de tu negocio.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="industries" id="industrias">
        <div class="container">
            <div class="section-title">
                <h2>Industrias que Atendemos</h2>
            </div>
            <div class="industries-grid">
                <div class="industry-item">
                    <div class="industry-icon">💪</div>
                    <div>
                        <h3>Gimnasios</h3>
                        <p>Control de membresías y asistencia</p>
                    </div>
                </div>
                <div class="industry-item">
                    <div class="industry-icon">🛒</div>
                    <div>
                        <h3>Comercios</h3>
                        <p>Gestión de ventas e inventario</p>
                    </div>
                </div>
                <div class="industry-item">
                    <div class="industry-icon">💊</div>
                    <div>
                        <h3>Farmacias</h3>
                        <p>Control de medicamentos</p>
                    </div>
                </div>
                <div class="industry-item">
                    <div class="industry-icon">🛠️</div>
                    <div>
                        <h3>Ferreterías</h3>
                        <p>Gestión de productos</p>
                    </div>
                </div>
                <div class="industry-item">
                    <div class="industry-icon">🍽️</div>
                    <div>
                        <h3>Restaurantes</h3>
                        <p>Control de pedidos y mesas</p>
                    </div>
                </div>
                <div class="industry-item">
                    <div class="industry-icon">📊</div>
                    <div>
                        <h3>Empresas Varias</h3>
                        <p>Soluciones personalizadas</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta" id="contacto">
        <div class="container">
            <h2>¿Listo para digitalizar tu negocio?</h2>
            <p>En TUXON estamos comprometidos con el éxito de tu empresa a través de soluciones tecnológicas innovadoras y personalizadas.</p>
            <a href="#" class="btn">Solicitar una Cotización</a>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>Sobre TUXON</h3>
                    <p>Somos una empresa especializada en desarrollo de software a medida, comprometida con la excelencia y la innovación tecnológica.</p>
                    <p>Nuestro nombre y logo están inspirados en la elegancia y agilidad de un gato, valores que reflejamos en nuestros productos.</p>
                </div>
                <div class="footer-column">
                    <h3>Servicios</h3>
                    <ul class="footer-links">
                        <li><a href="#">Sistemas para Gimnasios</a></li>
                        <li><a href="#">Tiendas Virtuales</a></li>
                        <li><a href="#">Sistemas para Farmacias</a></li>
                        <li><a href="#">Sistemas para Ferreterías</a></li>
                        <li><a href="#">Sistemas para Restaurantes</a></li>
                        <li><a href="#">Desarrollo a Medida</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Contacto</h3>
                    
                    <style>
.whatsapp-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.9rem;
    background-color: #25D366; /* verde WhatsApp */
    color: white;
    text-decoration: none;
    font-weight: 600;
    border-radius: 6px;
    transition: background 0.2s;
}

.whatsapp-btn:hover {
    background-color: #1ebe57; /* verde más oscuro al pasar */
}

.whatsapp-btn svg {
    width: 20px;
    height: 20px;
    fill: white;
}
</style>

<p>
  <a class="whatsapp-btn" href="https://wa.me/59178538094" target="_blank" rel="noopener">
    <svg viewBox="0 0 24 24">
      <path d="M12.004 2C6.486 2 2 6.486 2 12.004c0 2.128.553 4.116 1.517 5.854L2 22l4.325-1.41A9.954 9.954 0 0012.004 22C17.522 22 22 17.514 22 12.004 22 6.486 17.522 2 12.004 2zm0 18.151c-1.863 0-3.605-.575-5.062-1.544l-.361-.236-2.563.835.858-2.496-.243-.38A8.134 8.134 0 013.853 12c0-4.503 3.65-8.153 8.151-8.153 4.502 0 8.152 3.65 8.152 8.152 0 4.503-3.65 8.153-8.152 8.153zm4.5-6.033c-.245-.123-1.45-.716-1.675-.797-.225-.082-.389-.123-.554.123-.164.245-.634.797-.777.964-.143.164-.286.184-.531.061-.245-.123-1.034-.38-1.968-1.216-.728-.648-1.219-1.45-1.364-1.695-.143-.245-.015-.377.108-.5.111-.111.245-.286.367-.429.123-.143.164-.245.246-.409.082-.164.041-.307-.02-.429-.061-.123-.554-1.337-.758-1.838-.199-.48-.401-.415-.554-.423-.143-.008-.307-.01-.471-.01-.164 0-.429.061-.654.307-.225.245-.859.838-.859 2.044s.879 2.367 1 2.533c.123.164 1.727 2.635 4.184 3.693.585.252 1.04.402 1.395.515.586.188 1.118.162 1.538.098.47-.07 1.45-.592 1.655-1.164.205-.571.205-1.062.143-1.164-.061-.102-.225-.164-.471-.286z"/>
    </svg>
    +591 78538094
  </a>
</p>

<p>
  <a class="whatsapp-btn" href="https://wa.me/59164455289" target="_blank" rel="noopener">
    <svg viewBox="0 0 24 24">
      <path d="M12.004 2C6.486 2 2 6.486 2 12.004c0 2.128.553 4.116 1.517 5.854L2 22l4.325-1.41A9.954 9.954 0 0012.004 22C17.522 22 22 17.514 22 12.004 22 6.486 17.522 2 12.004 2zm0 18.151c-1.863 0-3.605-.575-5.062-1.544l-.361-.236-2.563.835.858-2.496-.243-.38A8.134 8.134 0 013.853 12c0-4.503 3.65-8.153 8.151-8.153 4.502 0 8.152 3.65 8.152 8.152 0 4.503-3.65 8.153-8.152 8.153zm4.5-6.033c-.245-.123-1.45-.716-1.675-.797-.225-.082-.389-.123-.554.123-.164.245-.634.797-.777.964-.143.164-.286.184-.531.061-.245-.123-1.034-.38-1.968-1.216-.728-.648-1.219-1.45-1.364-1.695-.143-.245-.015-.377.108-.5.111-.111.245-.286.367-.429.123-.143.164-.245.246-.409.082-.164.041-.307-.02-.429-.061-.123-.554-1.337-.758-1.838-.199-.48-.401-.415-.554-.423-.143-.008-.307-.01-.471-.01-.164 0-.429.061-.654.307-.225.245-.859.838-.859 2.044s.879 2.367 1 2.533c.123.164 1.727 2.635 4.184 3.693.585.252 1.04.402 1.395.515.586.188 1.118.162 1.538.098.47-.07 1.45-.592 1.655-1.164.205-.571.205-1.062.143-1.164-.061-.102-.225-.164-.471-.286z"/>
    </svg>
    +591 64455289
  </a>
</p>

                    <p>Santa Cruz - Montero</p>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 TUXON. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script>
        // Efecto smooth scroll para los enlaces
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();

                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Animación al hacer scroll
        window.addEventListener('scroll', revealOnScroll);

        function revealOnScroll() {
            const elements = document.querySelectorAll('.service-card, .industry-item');
            const windowHeight = window.innerHeight;

            elements.forEach(element => {
                const elementPosition = element.getBoundingClientRect().top;
                const elementVisible = 150;

                if (elementPosition < windowHeight - elementVisible) {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }
            });
        }

        // Inicializar elementos con opacidad 0 para la animación
        document.addEventListener('DOMContentLoaded', function() {
            const serviceCards = document.querySelectorAll('.service-card');
            const industryItems = document.querySelectorAll('.industry-item');

            serviceCards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                card.style.transition = 'all 0.6s ease';
            });

            industryItems.forEach(item => {
                item.style.opacity = '0';
                item.style.transform = 'translateY(20px)';
                item.style.transition = 'all 0.6s ease';
            });

            // Ejecutar la función una vez al cargar
            revealOnScroll();
        });
    </script>
</body>

</html>