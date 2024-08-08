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
            <h2>Events</h2>
            <a href="{{ route('createEvent') }}">Create new Event</a>
        </div>

        <div class="my-events-checkbox-group">
          <input type="checkbox" name="my-events" id="my-events"/>
          <label for="my-events">Filter by my Events</label>
        </div>

        <div class="events-container" id="events-container">

        </div>
    </div>
    @vite('resources/js/eventsPage.js')
</body>
</html>
