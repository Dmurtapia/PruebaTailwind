<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Admin - Tickets</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>

<body class="min-h-screen bg-gray-100 p-6">

    <h1 class="text-3xl font-semibold mb-6">🛠 Panel de tickets</h1>

    <input type="text" id="searchTicket" placeholder="Buscar por código (CT-XXXXXX)"
        class="mb-6 w-full max-w-md px-4 py-2 border rounded focus:outline-none focus:ring">

    @forelse($tickets as $email => $userTickets)
        @foreach ($userTickets as $ticket)
            <div class="ai-card mb-4 space-y-2 ticket-card" data-code="{{ strtoupper($ticket['codigo']) }}">

                <div class="text-sm font-bold text-gray-600">{{ $email }}</div>

                <div class="font-semibold text-lg">{{ $ticket['codigo'] }}</div>

                <p>
                    <strong>Estado:</strong>
                    <span class="{{ $ticket['estado'] === 'Completado' ? 'text-green-600' : 'text-orange-500' }}">
                        {{ $ticket['estado'] }}
                    </span>
                </p>

                <p><strong>Enviado:</strong> {{ $ticket['enviado_en'] }}</p>
                <p><strong>Mensaje:</strong> {{ $ticket['mensaje'] }}</p>

                <div class="flex gap-3 mt-4">

                    @if ($ticket['estado'] !== 'Completado')
                        <form method="POST" action="{{ route('admin.ticket.completar', [$email, $ticket['id']]) }}">
                            @csrf
                            <button class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                                ✔ Completar
                            </button>
                        </form>
                    @endif

                    <form method="POST" action="{{ route('ticket.borrar', [$email, $ticket['id']]) }}">
                        @csrf
                        <button class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                            🗑 Eliminar
                        </button>
                    </form>

                </div>
            </div>
        @endforeach
    @empty
        <div class="ai-card text-center text-gray-500">
            No hay tickets todavía.
        </div>
    @endforelse

    <div class="mt-10 text-center">
        <a href="{{ route('contacto') }}" class="ai-link">
            ← Volver al inicio
        </a>
    </div>

    <script>
        const input = document.getElementById('searchTicket');
        const cards = document.querySelectorAll('.ticket-card');

        input.addEventListener('input', () => {
            const value = input.value.toUpperCase();
            cards.forEach(card => {
                card.style.display = card.dataset.code.includes(value) ?
                    'block' :
                    'none';
            });
        });
    </script>

</body>

</html>
