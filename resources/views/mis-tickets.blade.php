<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis tickets</title>
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen flex items-center justify-center px-4 bg-gradient-to-br from-sky-50 via-white to-indigo-50">

<div class="w-full max-w-md space-y-6 fade-up">

    <h1 class="text-2xl font-semibold text-center">Mis tickets</h1>

    @if(session('deleted'))
        <div class="ai-card bg-red-50 text-red-600 text-center">
            🗑 {{ session('deleted') }}
        </div>
    @endif

    @forelse($tickets as $ticket)
        <div class="ai-card relative space-y-4">

            <form method="POST"
                  action="{{ route('ticket.borrar', [$emailUsuario, $ticket['id']]) }}"
                  class="absolute top-4 right-4">
                @csrf
                <button class="text-red-500 hover:text-red-600">🗑</button>
            </form>

            <div class="text-center text-xl font-semibold">
                {{ $ticket['codigo'] }}
            </div>

            <div class="text-sm space-y-1">
                <p>
                    <strong>Estado:</strong>
                    <span class="{{ $ticket['estado'] === 'Completado' ? 'text-green-600' : 'text-orange-500' }}">
                        {{ $ticket['estado'] }}
                    </span>
                </p>

                <p><strong>Enviado:</strong> {{ $ticket['enviado_en'] ?? '—' }}</p>
                <p><strong>Nombre:</strong> {{ $ticket['nombre'] ?? '—' }}</p>
                <p><strong>Email:</strong> {{ $ticket['email'] ?? '—' }}</p>
                <p><strong>Tipo:</strong> {{ isset($ticket['tipo']) ? ucfirst($ticket['tipo']) : '—' }}</p>
            </div>

            <div class="bg-gray-50 rounded p-3">
                <strong>Mensaje:</strong>
                {{ $ticket['mensaje'] ?? '—' }}
            </div>

        </div>
    @empty
        <div class="ai-card text-center text-gray-500">
            No has creado ningún ticket todavía.
        </div>
    @endforelse

    <div class="text-center">
        <a href="{{ route('contacto') }}" class="ai-link">
            ← Volver
        </a>
    </div>

</div>
</body>
</html>
