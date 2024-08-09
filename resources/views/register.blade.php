<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <div class="container-header">
            <h2>Register</h2>
            <span>Or you can <a href="{{ route('login') }}">Login</a></span>
        </div>

        <form id="register-form">
            @csrf

            <span class="form-error" id="register-error"></span>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus>
                <span class="form-error" id="email-error"></span>
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="name" name="username" id="username" class="form-control" required>
                <span class="form-error" id="username-error"></span>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
                <span class="form-error" id="password-error"></span>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Register</button>
            </div>
        </form>
    </div>
    @vite('resources/js/registerPage.js')
</body>
</html>
