@extends('layouts.guest')

@section('content')
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <input type="email" name="email" placeholder="Email Akademik" required>
            <span class="icon">
                <i class="fas fa-envelope"></i>
            </span>
        </div>

        <div class="form-group">
            <input type="password" name="password" placeholder="Password" required>
            <span class="icon">
                <i class="fas fa-lock"></i>
            </span>
        </div>

        <div class="form-actions">
            <label>
                <input type="checkbox" class="mr-2">
                Ingat Saya
            </label>
            
        </div>

        <button type="submit" class="submit-button">
            Masuk Sistem
            <i class="fas fa-calendar-alt icon"></i>
        </button>
    </form>
@endsection