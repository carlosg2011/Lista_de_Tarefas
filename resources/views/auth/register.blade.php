@extends('layouts.layout')

@section('title', 'Registrar')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header text-center bg-primary text-white">
                    <h4>Criar Conta</h4>
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

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nome completo</label>
                            <input type="text" name="name" class="form-control" id="name" required value="{{ old('name') }}">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" name="email" class="form-control" id="email" required value="{{ old('email') }}">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" name="password" class="form-control" id="password" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Registrar</button>
                    </form>

                    <div class="mt-3 text-center">
                        <a href="{{ route('login') }}">Já tem uma conta? Entrar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
