<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <x-user />
    <div class="container">
        <div class="container-header">
            <h2>My Tickets</h2>
        </div>

        <div class="ticket-container" id="tickets-container">

        </div>
    </div>
    @vite('resources/js/ticketsPage.js')
</body>
</html>
