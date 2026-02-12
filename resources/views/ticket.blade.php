<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Ticket creado</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-sky-50 to-indigo-50">

    <div class="max-w-md w-full space-y-4 fade-up">

        @if (session('success'))
            <div class="ai-card bg-green-50 border border-green-200 text-green-600 text-center">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="ai-card text-center space-y-4">
            <h1 class="text-2xl font-semibold">🎫 Ticket creado</h1>

            <p>
                <strong>Referencia:</strong>
                {{ $ticket['codigo'] }}
            </p>

            <p>
                <strong>Estado:</strong>
                <span class="font-semibold text-orange-500">
                    {{ $ticket['estado'] }}
                </span>
            </p>

            <p>
                <strong>Enviado:</strong>
                {{ $ticket['enviado_en'] ?? '—' }}
            </p>

            <a href="{{ route('mis.tickets') }}" class="ai-button block mt-4">
                Ver mis tickets
            </a>

            <a href="{{ route('contacto') }}" class="ai-link block mt-2">
                Crear otro
            </a>
        </div>

    </div>

</body>

</html>
