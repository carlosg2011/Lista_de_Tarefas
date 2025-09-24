<!DOCTYPE html>
<html lang="pt-br">


<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Minhas Listas de Tarefas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
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
            position: relative;
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

        /* Estilos para tarefas concluídas */
        .task-completed {
            text-decoration: line-through;
            opacity: 0.6;
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

        <!-- Formulário JS -->
        <form id="todoForm" class="mb-4">
            <div class="mb-3">
                <label for="title" class="form-label">Título da Lista</label>
                <input type="text" id="title" class="form-control" placeholder="Nova Lista" required />
            </div>
            <button type="submit" class="btn btn-primary w-100">Adicionar Lista</button>
        </form>

        <ul class="list-group" id="todoList"></ul>

        <p class="text-center mt-3 text-muted d-none" id="emptyMessage">Nenhuma lista cadastrada.</p>
    </div>

    <!-- Modal para editar lista e gerenciar tarefas -->
    <div class="modal fade" id="listModal" tabindex="-1" aria-labelledby="listModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <input type="text" id="modalListTitle" class="form-control fs-5 fw-bold" />
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <form id="taskForm" class="d-flex mb-3">
                        <input type="text" id="taskInput" class="form-control me-2" placeholder="Nova tarefa" required />
                        <button type="submit" class="btn btn-primary">Adicionar</button>
                    </form>

                    <ul class="list-group" id="taskList"></ul>
                    <p class="text-center text-muted mt-3 d-none" id="noTasksMessage">Nenhuma tarefa cadastrada.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" id="deleteListBtn" class="btn btn-danger me-auto">Excluir Lista</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" id="saveListBtn" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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

        $(function() {
            $('#todoForm').submit(function(e) {
                e.preventDefault();

                const title = $('#title').val().trim();
                if (!title) {
                    alert('Digite um título para a lista.');
                    return;
                }

                const apiUrl = 'http://127.0.0.1:8000/api/todos';


                $.ajax({
                    url: apiUrl,
                    method: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify({
                        title: title
                    }),
                    headers: {
                        'Authorization': 'Bearer ' + token
                    },

                    success: function(response) {

                        $('#successMessage').text('Lista criada com sucesso!').removeClass('d-none');
                        $('#errorMessage').addClass('d-none');


                        $('#title').val('');

                        $('#todoList').append(
                            $('<li>').addClass('list-group-item').text(response.title || title)
                        );
                        loadTodos();
                    },
                    error: function(xhr) {
                        $('#errorMessage').text('Erro ao criar lista.').removeClass('d-none');
                        $('#successMessage').addClass('d-none');
                    }
                });
            });

        })

        // Crud Listas - inicio

        function loadTodos() {
            $.ajax({
                url: API_URL,
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                success: function(lists) {
                    const container = $('#todoList').empty();

                    if (lists.length === 0) {
                        $('#emptyMessage').removeClass('d-none');
                        return;
                    }

                    $('#emptyMessage').addClass('d-none');

                    lists.forEach(list => {
                        const item = $(`
                    <li class="list-group-item list-group-item-action" data-id="${list.id}">
                        ${list.title}
                    </li>
                `);

                        item.on("click", function() {
                            selectedListId = list.id;
                            $("#todoList .list-group-item").removeClass("active");
                            $(this).addClass("active");
                            $('#modalListTitle').val(list.title);
                            $('#listModal').modal('show');
                            loadTasks();
                        });

                        container.append(item);
                    });
                },
                error: function(xhr) {
                    console.error("Erro ao carregar listas:", xhr.status, xhr.responseText);
                }
            });
        }

        $('#saveListBtn').on('click', function() {
            const newTitle = $('#modalListTitle').val().trim();

            if (!newTitle) {
                alert('O título não pode estar vazio.');
                return;
            }

            if (!selectedListId) {
                alert('Nenhuma lista selecionada.');
                return;
            }

            $.ajax({
                url: `${API_URL}/${selectedListId}`,
                method: 'PUT',
                contentType: 'application/json',
                data: JSON.stringify({
                    title: newTitle
                }),
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                success: function(response) {
                    $('#listModal').modal('hide');
                    loadTodos();
                },
                error: function(xhr) {
                    console.error('Erro ao salvar alterações:', xhr.responseText);
                    alert('Erro ao salvar alterações.');
                }
            });
        });

        $('#deleteListBtn').on('click', function() {
            if (!selectedListId) {
                alert('Nenhuma lista selecionada.');
                return;
            }

            if (!confirm('Tem certeza que deseja excluir esta lista?')) return;

            $.ajax({
                url: `${API_URL}/${selectedListId}`,
                method: 'DELETE',
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                success: function() {
                    $('#listModal').modal('hide');
                    loadTodos();
                },
                error: function(xhr) {
                    console.error('Erro ao excluir lista:', xhr.responseText);
                    alert('Erro ao excluir lista.');
                }
            });
        });

        // Crud Listas - fim

        // Crud Tarefas - inicio
        $('#taskForm').on('submit', function(e) {
            e.preventDefault();

            const taskTitle = $('#taskInput').val().trim();

            if (!taskTitle || !selectedListId) {
                alert('Preencha a tarefa e selecione uma lista.');
                return;
            }

            const apiUrl = `http://127.0.0.1:8000/api/todos/${selectedListId}/tasks`;

            $.ajax({
                url: apiUrl,
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    title: taskTitle
                }),
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                success: function(response) {
                    $('#taskInput').val('');
                    $('#taskList').append(
                        $('<li>').addClass('list-group-item').text(response.title)
                    );
                    loadTasks();
                },
                error: function(xhr) {
                    console.error('Erro ao criar tarefa:', xhr.responseText);
                    alert('Erro ao criar tarefa.');
                }
            });
        });


        function loadTasks() {
            if (!selectedListId) return;

            $.ajax({
                url: `${API_URL}/${selectedListId}/tasks`,
                method: 'GET',
                headers: {
                    'Authorization': 'Bearer ' + token
                },
                success: function(tasks) {
                    const container = $('#taskList').empty();

                    if (tasks.length === 0) {
                        $('#noTasksMessage').removeClass('d-none');
                        return;
                    }

                    $('#noTasksMessage').addClass('d-none');

                    tasks.forEach(task => {
                        const isChecked = task.is_done ? 'checked' : '';
                        const textStyle = task.is_done ? 'text-decoration: line-through; opacity: 0.6;' : '';

                        const item = $(`
                    <li class="list-group-item d-flex justify-content-between align-items-center" data-id="${task.id}">
                        <div class="form-check flex-grow-1" style="${textStyle}">
                            <input class="form-check-input me-2 task-check" type="checkbox" ${isChecked}>
                            <span class="task-title">${task.title}</span>
                        </div>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-outline-primary btn-edit-task">Editar</button>
                            <button class="btn btn-sm btn-outline-danger btn-delete-task">Excluir</button>
                        </div>
                    </li>
                `);

                        // Checkbox
                        item.find('.task-check').on('change', function() {
                            const is_done = $(this).is(':checked');

                            $.ajax({
                                url: `${API_URL}/${selectedListId}/tasks/${task.id}`,
                                method: 'PUT',
                                contentType: 'application/json',
                                headers: {
                                    'Authorization': 'Bearer ' + token
                                },
                                data: JSON.stringify({
                                    is_done: is_done
                                }),
                                success: function() {
                                    loadTasks();
                                },
                                error: function(xhr) {
                                    console.error("Erro ao atualizar tarefa:", xhr.responseText);
                                    alert("Erro ao atualizar tarefa.");
                                }
                            });
                        });

                        // Editar
                        item.find('.btn-edit-task').on('click', function() {
                            const $btn = $(this);
                            const $titleSpan = item.find('.task-title');

                            if ($btn.text() === "Salvar") {
                                const newTitle = item.find('.task-edit-input').val().trim();

                                if (!newTitle) {
                                    alert("O título não pode estar vazio.");
                                    return;
                                }

                                $.ajax({
                                    url: `${API_URL}/${selectedListId}/tasks/${task.id}`,
                                    method: 'PUT',
                                    contentType: 'application/json',
                                    headers: {
                                        'Authorization': 'Bearer ' + token
                                    },
                                    data: JSON.stringify({
                                        title: newTitle
                                    }),
                                    success: function() {
                                        loadTasks();
                                    },
                                    error: function(xhr) {
                                        console.error("Erro ao editar tarefa:", xhr.responseText);
                                        alert("Erro ao editar tarefa.");
                                    }
                                });
                            } else {
                                const currentTitle = $titleSpan.text();
                                $titleSpan.replaceWith(`<input type="text" class="form-control form-control-sm task-edit-input" value="${currentTitle}">`);
                                $btn.text("Salvar");
                            }
                        });

                        // Excluir
                        item.find('.btn-delete-task').on('click', function() {
                            if (!confirm("Tem certeza que deseja excluir esta tarefa?")) return;

                            $.ajax({
                                url: `${API_URL}/${selectedListId}/tasks/${task.id}`,
                                method: 'DELETE',
                                headers: {
                                    'Authorization': 'Bearer ' + token
                                },
                                success: function() {
                                    loadTasks();
                                },
                                error: function(xhr) {
                                    console.error("Erro ao excluir tarefa:", xhr.responseText);
                                    alert("Erro ao excluir tarefa.");
                                }
                            });
                        });

                        container.append(item);
                    });
                },
                error: function(xhr) {
                    console.error("Erro ao carregar tarefas:", xhr.status, xhr.responseText);
                }
            });
        }

        loadUser();
        loadTodos();
    </script>

</body>

</html>