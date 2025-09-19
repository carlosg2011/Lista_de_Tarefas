<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6B73FF 0%, #000DFF 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            border-radius: 1rem;
            padding: 2rem;
            width: 400px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            background-color: #fff;
        }
        .btn-primary {
            background: #6B73FF;
            border: none;
        }
        .btn-primary:hover {
            background: #000DFF;
        }
    </style>
</head>
<body>

<div class="card">
    <h3 class="text-center mb-4">Bem-vindo de volta!</h3>

    @if ($errors->has('login_error'))
        <div class="alert alert-danger">{{ $errors->first('login_error') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input type="password" name="password" class="form-control" id="password" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Entrar</button>

        <div class="text-center mt-3">
            <a href="{{ route('register') }}">Não tem uma conta? Cadastre-se</a>
        </div>
    </form>
</div>

</body>
</html>
