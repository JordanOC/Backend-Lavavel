@extends('layouts.app')

@section('content')
<div class=" d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="container" style='width: 600px'>
        <div class="login-container text-center">
            <h4 class="mb-4 font-weight-bold">LIBZZ</h4>
            <h5 class="mb-4 text-muted">Cadastrar-se</h5>

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

            <form action="{{ route('users.store') }}" method="POST" id="registerForm">
                @csrf
                <div class="form-floating mb-3">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nome" value="{{ old('name') }}" required>
                    <label for="name">Nome</label>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

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

                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirmar Senha" required>
                    <label for="password_confirmation">Confirmar Senha</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" placeholder="Endereço" value="{{ old('address') }}" required>
                    <label for="address">Endereço</label>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Telefone" value="{{ old('phone') }}" required>
                    <label for="phone">Telefone</label>
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2" id="registerButton" style="background-color: #17c0eb; border-color: #17c0eb;">
                    <span id="buttonText">Registrar-se</span>
                    <span id="buttonSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>
            </form>

            <div class="register-link mt-4">
                <p class="small">Já possui uma conta? <a href="{{ route('login') }}" class="text-decoration-none" style="color: #17c0eb;">Iniciar Sessão!</a></p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        const registerButton = document.getElementById('registerButton');
        const buttonText = document.getElementById('buttonText');
        const buttonSpinner = document.getElementById('buttonSpinner');

        registerButton.disabled = true;
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
    .register-link {
        text-align: center;
        margin-top: 1rem;
    }
    .alert {
        font-size: 0.875rem;
    }
</style>
@endpush
