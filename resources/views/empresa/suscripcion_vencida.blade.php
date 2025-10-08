<style>
    body.suscripcion-vencida {
        background: #f5f7fa;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        font-family: 'Poppins', sans-serif;
    }

    .suscripcion-card {
        background: #ffffff;
        padding: 40px 30px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        max-width: 500px;
        width: 100%;
        text-align: center;
        animation: fadeIn 0.8s ease;
    }

    .suscripcion-card img {
        width: 80px;
        margin-bottom: 20px;
    }

    .suscripcion-card h1 {
        color: #d9534f;
        font-size: 24px;
        margin-bottom: 15px;
    }

    .suscripcion-card p {
        color: #555;
        font-size: 16px;
        margin-bottom: 25px;
    }

    .suscripcion-card a {
        display: inline-block;
        padding: 12px 25px;
        font-size: 16px;
        border-radius: 6px;
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        transition: 0.3s;
    }

    .suscripcion-card a:hover {
        background-color: #0056b3;
    }

    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(-20px);}
        to {opacity: 1; transform: translateY(0);}
    }

    @media(max-width: 576px) {
        .suscripcion-card {
            padding: 30px 20px;
        }

        .suscripcion-card h1 {
            font-size: 20px;
        }

        .suscripcion-card p {
            font-size: 14px;
        }
    }
</style>

<body class="suscripcion-vencida">
    <div class="suscripcion-card">
        <img src="{{ asset('images/yane/tuxon2.png') }}" alt="Logo {{ config('app.name') }}">
        <h1>Suscripción Vencida</h1>
        <p>Tu suscripción al sistema <strong>{{ config('app.name') }}</strong> ha expirado. 
        Para continuar usando todos los servicios, por favor renueva tu suscripción.</p>
        <a href="{{ route('home') }}">Volver al inicio</a>
    </div>
</body>