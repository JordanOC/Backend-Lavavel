@extends('layouts.app')

@section('content')
<div class=" d-flex justify-content-center align-items-center" style="min-height: 100vh;">
<div class="container" style='width: 600px'>
    <div class="login-container text-center">
        <h4 class="mb-4 font-weight-bold">LIBZZ</h4>
        <h5 class="mb-4 text-muted">Iniciar Sessão</h5>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Erro:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" id="loginForm">
            @csrf
            <div class="form-floating mb-3">
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="E-mail" value="{{ old('email') }}" required>
                <label for="email">E-mail</label>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Senha" required>
                <label for="password">Senha</label>

                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3 form-check text-start">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Lembrar-me</label>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2" id="loginButton" style="background-color: #17c0eb; border-color: #17c0eb;">
                <span id="buttonText">Iniciar Sessão</span>
                <span id="buttonSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
            </button>
        </form>

        <div class="register-link mt-4">
            <p class="small">Não possui uma conta? <a href="{{ route('users.create') }}" class="text-decoration-none" style="color: #17c0eb;">Cadastre-se!</a></p>
        </div>
    </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const loginButton = document.getElementById('loginButton');
        const buttonText = document.getElementById('buttonText');
        const buttonSpinner = document.getElementById('buttonSpinner');

        loginButton.disabled = true;
        buttonText.classList.add('d-none');
        buttonSpinner.classList.remove('d-none');
    });
</script>
@endpush

@push('styles')
<style>
    body {
        background-color: #f8f9fa;
        height: 100vh;
    }
    .login-container {
        margin: 50px auto;
        background-color: white;
        padding: 1rem;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .form-floating label {
        font-size: 0.875rem;
    }
    .btn-primary {
        background-color: #17c0eb;
        border-color: #17c0eb;
        font-size: 1.1rem;
        font-weight: 500;
    }
    .btn-primary:hover {
        background-color: #14abd9;
        border-color: #14abd9;
    }
    .navbar-brand {
        font-weight: bold;
    }
    .register-link {
        text-align: center;
        margin-top: 1rem;
    }
    .alert {
        font-size: 0.875rem;
    }
</style>
@endpush
