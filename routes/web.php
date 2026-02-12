<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/* LOGIN */

Route::get('/login', fn() => view('login'))->name('login');

Route::post('/login', function (Request $request) {

    $role = $request->email === 'admin@admin.com' ? 'admin' : 'user';

    session([
        'user' => [
            'email' => $request->email,
            'name'  => $request->email,
            'role'  => $role,
        ]
    ]);

    return redirect()->route('contacto');
})->name('login.procesar');

/* REGISTRO (SIMULADO) */
Route::get('/registro', fn() => view('registro'))->name('registro');

Route::post('/registro', function (Request $request) {

    session([
        'user' => [
            'email' => $request->email,
            'name'  => $request->name,
            'role'  => 'user',
        ]
    ]);

    return redirect()->route('contacto');
})->name('registro.procesar');

/* CONTACTO */
Route::get('/contacto', function () {
    return view('inicio', [
        'user' => session('user')
    ]);
})->name('contacto');

/* CREAR TICKET */
Route::post('/contacto', function (Request $request) {

    $user = session('user');
    if (!$user) return redirect()->route('login');

    $emailUsuario = $user['email'];

    $ticket = [
        'id'         => (string) Str::uuid(),
        'codigo'     => 'CT-' . strtoupper(Str::random(6)),
        'estado'     => 'Pendiente',
        'enviado_en' => now()->format('d/m/Y H:i'),
        'nombre'     => $request->nombre,
        'email'      => $request->email,
        'tipo'       => $request->tipo,
        'mensaje'    => $request->mensaje,
    ];

    $tickets = session('tickets', []);
    $tickets[$emailUsuario][] = $ticket;

    session([
        'tickets' => $tickets,
        'ticket_actual' => $ticket
    ]);

    return redirect()->route('ticket.creado');
})->name('contacto.enviar');

/* TICKET CREADO */
Route::get('/contacto/ticket', function () {

    if (!session()->has('ticket_actual')) {
        return redirect()->route('contacto');
    }

    return view('ticket', [
        'ticket' => session('ticket_actual')
    ]);
})->name('ticket.creado');

/* MIS TICKETS */
Route::get('/contacto/mis-tickets', function () {

    $user = session('user');
    if (!$user) return redirect()->route('login');

    $tickets = session('tickets', []);
    $misTickets = $tickets[$user['email']] ?? [];

    return view('mis-tickets', [
        'tickets' => $misTickets,
        'emailUsuario' => $user['email']
    ]);
})->name('mis.tickets');

/* BORRAR TICKET */
Route::post('/ticket/borrar/{email}/{id}', function ($email, $id) {

    $user = session('user');
    if (!$user) return redirect()->route('login');

    if ($user['role'] !== 'admin' && $user['email'] !== $email) {
        abort(403);
    }

    $tickets = session('tickets', []);

    $tickets[$email] = array_values(array_filter(
        $tickets[$email] ?? [],
        fn($t) => $t['id'] !== $id
    ));

    session()->put('tickets', $tickets);

    return redirect()->route('admin.tickets');
})->name('ticket.borrar');

/* ADMIN - VER TICKETS */
Route::get('/admin/tickets', function () {

    $user = session('user');
    if (!$user || $user['role'] !== 'admin') abort(403);

    return view('admin-tickets', [
        'tickets' => session('tickets', [])
    ]);
})->name('admin.tickets');

/* ADMIN - COMPLETAR TICKET */
Route::post('/admin/ticket/completar/{email}/{id}', function ($email, $id) {

    $user = session('user');
    if (!$user || $user['role'] !== 'admin') abort(403);

    $tickets = session('tickets', []);

    if (!isset($tickets[$email])) {
        return redirect()->route('admin.tickets');
    }

    foreach ($tickets[$email] as $index => $ticket) {
        if ($ticket['id'] === $id) {
            $tickets[$email][$index]['estado'] = 'Completado';
            break;
        }
    }

    session()->put('tickets', $tickets);

    return redirect()->route('admin.tickets');
})->name('admin.ticket.completar');

/* DASHBOARD */
Route::get('/dashboard', function () {

    $user = session('user');
    if (!$user) return redirect()->route('login');

    $tickets = session('tickets', []);

    $total = 0;
    $pendientes = 0;
    $completados = 0;
    $hoy = 0;

    $fechaHoy = now()->format('d/m/Y');

    foreach ($tickets as $email => $userTickets) {
        foreach ($userTickets as $ticket) {

            $total++;

            if ($ticket['estado'] === 'Pendiente') {
                $pendientes++;
            }

            if ($ticket['estado'] === 'Completado') {
                $completados++;
            }

            if (isset($ticket['enviado_en']) && str_contains($ticket['enviado_en'], $fechaHoy)) {
                $hoy++;
            }
        }
    }

    return view('dashboard', compact(
        'total',
        'pendientes',
        'completados',
        'hoy'
    ));
})->name('dashboard');

/* RANKING DE USUARIOS */
Route::get('/ranking', function () {

    $user = session('user');
    if (!$user || $user['role'] !== 'admin') {
        abort(403);
    }

    $tickets = session('tickets', []);
    $ranking = [];

    foreach ($tickets as $email => $userTickets) {

        $total = count($userTickets);
        $completados = 0;

        foreach ($userTickets as $ticket) {
            if (($ticket['estado'] ?? '') === 'Completado') {
                $completados++;
            }
        }

        $porcentaje = $total > 0
            ? round(($completados / $total) * 100)
            : 0;

        $ranking[] = [
            'email' => $email,
            'total' => $total,
            'completados' => $completados,
            'porcentaje' => $porcentaje,
        ];
    }

    // Ordenar por total tickets DESC
    usort($ranking, fn($a, $b) => $b['total'] <=> $a['total']);

    return view('ranking', compact('ranking'));
})->name('ranking');
