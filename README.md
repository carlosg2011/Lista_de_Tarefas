# 📝 Lista de Tarefas - Projeto Fullstack com Laravel, JWT, MySQL e Bootstrap

Aplicação de **lista de tarefas (ToDo List)** com backend em **Laravel + JWT**, banco de dados **MySQL**, e frontend simples feito com **HTML, Bootstrap e jQuery**. O projeto pode ser executado totalmente via **Docker** ou localmente com PHP/MySQL.

---

## 📦 Estrutura do Projeto

Lista_de_Tarefas/
├── app/ # Backend Laravel (API JWT)
├── public/ # Frontend e assets (HTML/CSS/JS)
├── database/ # Migrations e seeds
├── routes/ # Rotas do Laravel
├── docker-compose.yml
└── README.md


---

## 🚀 Como Rodar o Projeto

### Pré-requisitos
- Docker instalado e funcionando (opcional para ambiente isolado)
- Docker Compose (opcional)
- PHP 8.x e Composer (se não usar Docker)

---

### 🔧 Passos para rodar localmente

1. Clonar o projeto:

```bash
git clone https://github.com/carlosg2011/Lista_de_Tarefas.git
cd Lista_de_Tarefas
```
Instalar dependências do Laravel:
```bash
composer install
```
Configurar o arquivo .env:
```bash
cp .env.example .env
```
Edite as variáveis do banco de dados:
```php
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=todo_list
DB_USERNAME=carlos
DB_PASSWORD=Cgps201@
```
Gerar a chave da aplicação:
```bash
php artisan key:generate
```
Rodar as migrations:
```bash
php artisan migrate
```
Gerar a chave JWT:
```bash
php artisan jwt:secret
```
```bash
php artisan serve --host=0.0.0.0 --port=8000
```
Acesse a aplicação em: http://localhost:8000

Passos para rodar com Docker (opcional)
Se desejar usar Docker para rodar a aplicação completa, crie um docker-compose.yml com serviços de PHP/Laravel, MySQL e phpMyAdmin, depois:
```bash
docker compose up --build -d
```


Frontend e backend: http://localhost:8000
MySQL: localhost:3306 (user: carlos, pass: Cgps201@)

Entrar no container Laravel para rodar comandos:
```bash
docker exec -it nome_do_container_php sh
php artisan migrate --force
php artisan jwt:secret
```
Roteiro de Uso

📋 Registro
Crie um usuário via formulário de registro.

🔐 Login
Informe email e senha para gerar token JWT.
O token é necessário para acessar os endpoints de tarefas.

🗂️ Gerenciar Listas
Criar novas listas de tarefas.
Selecionar uma lista para visualizar e manipular suas tarefas.

✅ Gerenciar Tarefas
Adicionar tarefas via frontend.
Marcar como concluída ou desfazer.
Deletar tarefas existentes.

🚪 Logout
Apagar token JWT e sair da sessão.

🛠️ Tecnologias

Backend: Laravel 10, JWT Auth (tymon/jwt-auth)
Frontend: HTML, Bootstrap 5, jQuery
Banco de Dados: MySQL 8
Containers: Docker, Docker Compose (opcional)

Comandos úteis:
```bash
# Subir containers
docker compose up -d

# Parar containers
docker compose down

# Entrar no container da API
docker exec -it todo-api sh

# Rodar migrations
php artisan migrate --force

# Gerar JWT secret
php artisan jwt:secret

# Ver logs da API
docker logs -f todo-api
```

📄 Licença

Este projeto está sob a licença MIT.
