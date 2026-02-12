<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen flex items-center justify-center px-4 bg-gradient-to-br from-sky-50 via-white to-indigo-50">

    <form method="POST" action="{{ route('registro.procesar') }}" class="ai-card max-w-sm fade-up">
        @csrf

        <h2 class="ai-title mb-2">Registro</h2>
        <p class="ai-subtitle mb-6">Crea tu cuenta</p>

        @if ($errors->any())
            <div class="ai-error mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="mb-5">
            <label class="ai-label">Nombre</label>
            <input type="text" name="name" value="{{ old('name') }}" class="ai-input" required>
        </div>

        <div class="mb-5">
            <label class="ai-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="ai-input" required>
        </div>

        <div class="mb-6">
            <label class="ai-label">Contraseña</label>
            <input type="password" name="password" class="ai-input" required>
        </div>

        <button type="submit" class="ai-button">
            Crear cuenta
        </button>

        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="ai-link">
                ¿Ya tienes cuenta? Inicia sesión
            </a>
        </div>
    </form>

</body>

</html>
