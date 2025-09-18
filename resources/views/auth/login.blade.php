@extends('layouts.layout')

@section('title', 'Entrar')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white text-center">
                    <h4>Login</h4>
                </div>
                <div class="card-body">
                    <!-- Exibir erros de validação -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" name="email" class="form-control" id="email" required value="{{ old('email') }}">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" name="password" class="form-control" id="password" required>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">Lembrar de mim</label>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Entrar</button>
                    </form>

                    <div class="mt-3 text-center">
                        <a href="{{ route('register') }}">Não tem uma conta? Registrar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
