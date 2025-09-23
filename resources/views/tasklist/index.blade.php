<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Listas de Tarefas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6B73FF 0%, #000DFF 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding-top: 50px;
        }

        .card {
            border-radius: 1rem;
            padding: 2rem;
            width: 500px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            background-color: #fff;
            margin-bottom: 20px;
        }

        .btn-primary {
            background: #6B73FF;
            border: none;
        }

        .btn-primary:hover {
            background: #000DFF;
        }

        .logout-btn {
            position: absolute;
            top: 20px;
            right: 30px;
        }
    </style>
</head>

<body>

    <button onclick="logout()" class="btn btn-danger logout-btn">Logout</button>

    <div class="card">
        <h3 class="text-center mb-2">Minhas Listas de Tarefas</h3>
        <div class="text-center mb-3 text-muted" id="userInfo"></div>

        <div id="successMessage" class="alert alert-success d-none"></div>
        <div id="errorMessage" class="alert alert-danger d-none"></div>

        {{-- Formulário JS --}}
        <form id="todoForm" class="mb-4">
            <div class="mb-3">
                <label for="title" class="form-label">Título da Lista</label>
                <input type="text" id="title" class="form-control" placeholder="Nova Lista" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Adicionar Lista</button>
        </form>

        <ul class="list-group" id="todoList"></ul>

        <p class="text-center mt-3 text-muted d-none" id="emptyMessage">Nenhuma lista cadastrada.</p>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        const API_URL = "http://127.0.0.1:8000/api/todos";
        const token = localStorage.getItem("auth_token");
        const headers = {
            "Content-Type": "application/json",
            Authorization: `Bearer ${token}`,
        };

        if (!token) window.location.href = '/login';

        async function loadUser() {
            try {
                const data = await fetch('/api/todos', {
                    headers
                });

                console.log('Dados recebidos:', data);

                if (data.ok) {
                    userInfo.textContent = `Bem vindo de volta!`;
                } else {
                    console.warn('Resposta não OK:', data.status);
                    logout();
                }
            } catch (err) {
                console.error('Erro em loadUser:', err);
                logout();
            }
        }

        function logout() {
            localStorage.clear();
            localStorage.clear('token');
            window.location.href = '/login';
        }

        loadUser();
    </script>

</body>

</html>