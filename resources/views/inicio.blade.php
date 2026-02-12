<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Contacto</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen flex items-center justify-center px-4 bg-gradient-to-br from-sky-50 via-white to-indigo-50">

    <div class="w-full max-w-md space-y-6 fade-up">

        {{-- Bienvenida --}}
        @if ($user)
            <div class="text-center">
                <p class="text-xs uppercase tracking-widest text-cyan-600">
                    Bienvenido
                </p>
                <h1 class="text-2xl font-semibold text-gray-900 mt-1">
                    {{ $user['name'] }}
                </h1>
            </div>
        @endif

        {{-- Mensaje éxito --}}
        @if (session('success'))
            <div class="text-center text-green-600 font-medium">
                {{ session('success') }}
            </div>
        @endif

        {{-- Formulario --}}
        <form method="POST" action="{{ route('contacto.enviar') }}" class="ai-card">
            @csrf

            <h2 class="ai-title mb-2">Contacto</h2>
            <p class="ai-subtitle mb-6">Déjanos tu mensaje</p>

            <div class="mb-5">
                <label class="ai-label">Nombre</label>
                <input type="text" name="nombre" class="ai-input" required>
            </div>

            <div class="mb-5">
                <label class="ai-label">Email</label>
                <input type="email" name="email" class="ai-input" required>
            </div>

            <div class="mb-6">
                <label class="ai-label">Mensaje</label>
                <textarea name="mensaje" rows="4" class="ai-input resize-none" required></textarea>
            </div>

            <div class="mb-6">
                <label class="ai-label">Tipo de consulta</label>
                <select name="tipo" class="ai-input" required>
                    <option value="">Selecciona una opción</option>
                    <option value="soporte">Soporte técnico</option>
                    <option value="ventas">Ventas</option>
                    <option value="general">General</option>
                </select>
            </div>

            <button type="submit" class="ai-button">
                Enviar mensaje
            </button>

            {{-- Navegación --}}
            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="ai-link">
                    ← Volver al login
                </a>
            </div>

            <div class="mt-4 text-center">
                <a href="{{ route('mis.tickets') }}" class="ai-link">
                    📂 Ver mis tickets
                </a>
            </div>

            {{-- SOLO ADMIN --}}
            @if ($user && isset($user['role']) && $user['role'] === 'admin')
                <div class="mt-4 text-center">
                    <a href="{{ route('admin.tickets') }}" class="ai-link text-green-600">
                        🛠 Panel de administración
                    </a>
                </div>

                <div class="mt-3 text-center">
                    <a href="{{ route('dashboard') }}" class="ai-link">
                        📊 Ver Dashboard
                    </a>
                </div>
            @endif
            @if ($user && $user['role'] === 'admin')
                <div class="mt-3 text-center">
                    <a href="{{ route('ranking') }}" class="ai-link text-purple-600">
                        🏆 Ver Ranking de Usuarios
                    </a>
                </div>
            @endif


        </form>

    </div>

</body>

</html>
