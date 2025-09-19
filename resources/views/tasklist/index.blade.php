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
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
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
        .todo-done {
            text-decoration: line-through;
            color: gray;
        }
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 30px;
        }
    </style>
</head>
<body>

    {{-- Botão de logout --}}
    <form method="POST" action="{{ route('logout') }}" class="logout-btn">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>

    <div class="card">
        <h3 class="text-center mb-4">Minhas Listas de Tarefas</h3>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Formulário para criar novo ToDo --}}
        <form method="POST" action="{{ route('tasklist.store') }}" class="mb-4">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Título da Lista</label>
                <input type="text" name="title" id="title" class="form-control" placeholder="Nova Lista" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Adicionar Lista</button>
        </form>

        {{-- Listagem dos ToDo's --}}
        @if($todos->count() > 0)
            <ul class="list-group">
                @foreach($todos as $todo)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $todo->title }}</span>
                        <div class="btn-group btn-group-sm">
                            {{-- Editar (opcional) --}}
                            <button type="button" class="btn btn-success" onclick="editTodo({{ $todo->id }}, '{{ $todo->title }}')">Editar</button>

                            {{-- Excluir --}}
                            <form method="POST" action="{{ route('tasklist.destroy', $todo->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Excluir</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-center mt-3">Nenhuma lista cadastrada.</p>
        @endif
    </div>

    {{-- Script simples para edição (modal ou prompt) --}}
    <script>
        function editTodo(id, currentTitle) {
            const newTitle = prompt("Atualize o título da lista:", currentTitle);
            if(newTitle && newTitle !== currentTitle){
                fetch(`/todos/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ title: newTitle })
                }).then(res => location.reload());
            }
        }
    </script>

</body>
</html>