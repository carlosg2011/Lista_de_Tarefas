# Lista de Tarefas — API REST Full Stack

![Laravel](https://img.shields.io/badge/Laravel-10-FF2D20?logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8-4479A1?logo=mysql&logoColor=white)
![Docker](https://img.shields.io/badge/Docker-ready-2496ED?logo=docker&logoColor=white)
![JWT](https://img.shields.io/badge/Auth-JWT-F7B93E?logo=jsonwebtokens&logoColor=black)

Aplicação web completa de gerenciamento de tarefas com autenticação JWT e rotas protegidas. Backend em **Laravel 10** com banco **MySQL** e containerização via **Docker**. Frontend em **HTML, Bootstrap 5 e jQuery** consumindo a API REST.

---

## Tecnologias

| Camada | Tecnologia | Versão |
|---|---|---|
| Backend | Laravel | 10 |
| Autenticação | tymon/jwt-auth | — |
| Banco de Dados | MySQL | 8 |
| Frontend | HTML + Bootstrap + jQuery | 5 |
| Containers | Docker + Docker Compose | — |

---

## Funcionalidades

- Registro e login de usuários com autenticação JWT
- Criação e gerenciamento de listas de tarefas
- CRUD completo de tarefas por lista
- Marcar tarefas como concluídas ou pendentes
- Controle de sessão por token com logout
- Rotas protegidas — somente usuários autenticados acessam os endpoints

---

## Pré-requisitos

- Docker e Docker Compose instalados
- **ou** PHP 8.x + Composer + MySQL (execução local sem Docker)

---

## Instalação e execução local

```bash
# Clone o repositório
git clone https://github.com/carlosg2011/Lista_de_Tarefas.git
cd Lista_de_Tarefas

# Instale as dependências
composer install

# Configure o ambiente
cp .env.example .env
# Edite .env com suas credenciais de banco de dados

# Gere a chave da aplicação
php artisan key:generate

# Gere a chave JWT
php artisan jwt:secret

# Rode as migrations
php artisan migrate

# Inicie o servidor
php artisan serve
```

Acesse em: `http://localhost:8000`

---

## Execução com Docker

```bash
# Suba os containers
docker compose up --build -d

# Entre no container e configure
docker exec -it todo-api sh
php artisan migrate --force
php artisan jwt:secret
```

| Serviço | URL |
|---|---|
| Aplicação | http://localhost:8000 |
| MySQL | localhost:3306 |

---

## Estrutura de pastas
