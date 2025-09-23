<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
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
    <h3 class="text-center mb-4">Criar Conta</h3>

    <div id="errorMessage" class="alert alert-danger d-none"></div>

    <form id="registerForm">
        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" name="name" class="form-control" id="name" required autofocus>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" name="email" class="form-control" id="email" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input type="password" name="password" class="form-control" id="password" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar Senha</label>
            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Cadastrar</button>

        <div class="text-center mt-3">
            <a href="{{ route('login') }}">Já tem uma conta? Faça login</a>
        </div>
    </form>
</div>

 <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
 $("#registerForm").submit(function (e) {
    e.preventDefault();

    const name = $("#name").val().trim();
    const email = $("#email").val().trim();
    const password = $("#password").val();
    const password_confirmation = $("#password_confirmation").val();

    $("#errorMessage").addClass('d-none');
    $("#errorMessage").html('');

    if (password !== password_confirmation) {
        $("#errorMessage").removeClass('d-none').text("As senhas não coincidem.");
        return;
    }

    $.ajax({
        url: "http://127.0.0.1:8000/api/register",
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify({
            name,
            email,
            password,
            password_confirmation
        }),
        success: function(response) {
            if (response.access_token) {
                localStorage.setItem("auth_token", response.access_token);
                window.location.href = "/todos";
            } else {
                $("#errorMessage").removeClass('d-none').text("Erro ao cadastrar.");
            }
        },
        error: function() {
            $("#errorMessage").removeClass('d-none').text("Erro de conexão com o servidor.");
        },
    });
});
</script>

</body>
</html>
