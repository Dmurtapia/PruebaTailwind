<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ranking de Usuarios</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-100 to-gray-200 p-6">

    <h1 class="text-3xl font-bold text-center mb-8">
        🏆 Ranking de Usuarios
    </h1>

    @forelse($ranking as $index => $user)

        <div class="max-w-xl mx-auto mb-6">

            <div class="ai-card p-6 space-y-3">

                <div class="flex justify-between items-center">

                    <div class="text-lg font-semibold">
                        {{ $index + 1 }}º — {{ $user['email'] }}
                    </div>

                    @if($index === 0)
                        <span class="text-yellow-500 text-xl">🥇</span>
                    @elseif($index === 1)
                        <span class="text-gray-500 text-xl">🥈</span>
                    @elseif($index === 2)
                        <span class="text-orange-500 text-xl">🥉</span>
                    @endif

                </div>

                <div class="text-sm space-y-1 text-gray-700">
                    <p><strong>Total tickets:</strong> {{ $user['total'] }}</p>
                    <p><strong>Completados:</strong> {{ $user['completados'] }}</p>
                    <p><strong>Resolución:</strong> {{ $user['porcentaje'] }}%</p>
                </div>

                {{-- Barra visual --}}
                <div class="w-full bg-gray-200 rounded-full h-3 mt-3">
                    <div class="h-3 rounded-full
                        {{ $user['porcentaje'] > 70 ? 'bg-green-500' : 'bg-orange-500' }}"
                        style="width: {{ $user['porcentaje'] }}%">
                    </div>
                </div>

            </div>

        </div>

    @empty

        <div class="text-center text-gray-500">
            No hay datos todavía.
        </div>

    @endforelse

    <div class="mt-10 text-center">
        <a href="{{ route('contacto') }}" class="ai-link">
            ← Volver al inicio
        </a>
    </div>

</body>
</html>
