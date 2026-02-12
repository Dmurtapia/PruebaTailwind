<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-sky-50 to-indigo-100 p-6">

    <h1 class="text-3xl font-bold mb-8 text-gray-800">
        Dashboard de Tickets
    </h1>

    {{-- Estadísticas --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

        <div class="ai-card text-center">
            <div class="text-4xl font-bold text-blue-600">
                {{ $total }}
            </div>
            <p class="mt-2 text-gray-600 font-medium">
                Total tickets
            </p>
        </div>

        <div class="ai-card text-center">
            <div class="text-4xl font-bold text-orange-500">
                {{ $pendientes }}
            </div>
            <p class="mt-2 text-gray-600 font-medium">
                Pendientes
            </p>
        </div>
    
        <div class="ai-card text-center">
            <div class="text-4xl font-bold text-green-600">
                {{ $completados }}
            </div>
            <p class="mt-2 text-gray-600 font-medium">
                Completados
            </p>
        </div>

    </div>

    {{-- Gráfica --}}
    <div class="ai-card max-w-md mx-auto">
        <canvas id="ticketsChart"></canvas>
    </div>

    <div class="mt-10 text-center">
        <a href="{{ route('contacto') }}" class="ai-link">
            ← Volver al inicio
        </a>
    </div>

<script>
    const ctx = document.getElementById('ticketsChart');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Pendientes', 'Completados'],
            datasets: [{
                data: [{{ $pendientes }}, {{ $completados }}],
                backgroundColor: [
                    '#FF0000', // rojo
                    '#16a34a'  // verde 
                    
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>

</body>
</html>
