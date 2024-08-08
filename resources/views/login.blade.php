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
            <h2>Login</h2>
            <span>Or you can <a href="{{ route('register') }}">Register</a></span>
        </div>

        <form id="login-form">
            @csrf

            <span class="form-error" id="login-error"></span>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus>
                <span class="form-error" id="email-error"></span>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
                <span class="form-error" id="password-error"></span>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>
    @vite('resources/js/loginPage.js')
</body>
</html>
