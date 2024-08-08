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
            <h2>Create a new Event</h2>
        </div>
        
        <form id="event-form">
            @csrf

            <span class="form-error" id="login-error"></span>

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" required>
                <span class="form-error" id="title-error"></span>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" required rows="4"></textarea>
                <span class="form-error" id="description-error"></span>
            </div>

            <div class="form-group">
                <label for="deadline">Deadline</label>
                <input type="datetime-local" name="deadline" id="deadline" class="form-control" required>
                <span class="form-error" id="deadline-error"></span>
            </div>

            <div class="form-group">
                <label for="date">Date</label>
                <input type="datetime-local" name="date" id="date" class="form-control" required>
                <span class="form-error" id="date-error"></span>
            </div>

            <div class="form-group">
                <label for="location">Location</label>
                <input type="text" name="location" id="location" class="form-control" required>
                <span class="form-error" id="location-error"></span>
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" name="price" id="price" class="form-control" required min="0" step=".01">
                <span class="form-error" id="price-error"></span>
            </div>

            <div class="form-group">
                <label for="attendee_limit">Attendee Limit</label>
                <input type="number" name="attendee_limit" id="attendee_limit" class="form-control" required min="0">
                <span class="form-error" id="attendee_limit-error"></span>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
    @vite('resources/js/createEventPage.js')
</body>
</html>
