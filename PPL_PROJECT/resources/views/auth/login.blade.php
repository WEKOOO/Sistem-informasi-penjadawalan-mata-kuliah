@extends('layouts.guest')

@section('content')
    <form method="POST" action="{{ url('dosen/navigation') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">Email</label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                class="form-input" 
                value="{{ old('email') }}" 
                required 
                autofocus
                autocomplete="username"
            >
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">Password</label>
            <div class="relative">
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    class="form-input" 
                    required
                    autocomplete="current-password"
                >
                <button type="button" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-300" onclick="togglePassword('password')">
                    <i class="fas fa-eye"></i>
                </button>
            </div>
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label class="flex items-center">
                <input type="checkbox" name="remember" class="form-checkbox">
                <span class="ml-2 text-sm text-gray-300">Ingat Saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="auth-link text-sm" href="{{ route('password.request') }}">
                    Lupa Password?
                </a>
            @endif
        </div>

        <div class="flex flex-col space-y-4">
            <button type="submit" class="btn-primary">
                <i class="fas fa-sign-in-alt mr-2"></i>Login
            </button>

            @if (Route::has('register'))
                <div class="auth-footer">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="auth-link">
                        Daftar disini
                    </a>
                </div>
            @endif
        </div>
    </form>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = event.currentTarget.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
@endsection