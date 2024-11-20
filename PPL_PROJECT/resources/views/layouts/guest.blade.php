<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Login Admin') }}</title>

    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            background-color: rgba(120, 205, 251, 0.7); /* Warna dasar dengan transparansi */
            backdrop-filter: blur(10px); /* Efek blur */
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            
            background-color: #f0f0f0;
        }

        .logo {
            width: 100px;
            height: 100px;
            margin: 0 auto 30px;
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-x {
            font-size: 40px;
            color: #ccc;
        }

        .form-group {
            margin-bottom: 15px;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }

        input::placeholder {
            color: #999;
        }

        .login-button {
            width: 100%;
            padding: 10px;
            background-color: #2196F3;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            text-transform: uppercase;
        }

        .login-button:hover {
            background-color: #1976D2;
        }

        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <span class="logo-x">×</span>
        </div>

        @if ($errors->any())
            <div class="alert">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <input 
                    type="text" 
                    name="email" 
                    value="{{ old('email') }}" 
                    placeholder="Username"
                    required 
                    autofocus
                >
            </div>

            <div class="form-group">
                <input 
                    type="password" 
                    name="password" 
                    placeholder="Password"
                    required
                >
            </div>

            <button type="submit" class="login-button">
                Login
            </button>
        </form>
    </div>
</body>
</html>