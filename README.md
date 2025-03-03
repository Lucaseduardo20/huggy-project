README


🚀 Aplicação Laravel + Vue.js (TypeScript)

Este projeto é uma aplicação full-stack desenvolvida com **Laravel** no back-end e **Vue.js (TypeScript)** no front-end. Ele utiliza **Docker** para facilitar o ambiente de desenvolvimento, **TailwindCSS** para estilização, **Axios** para requisições HTTP e **Laravel Data** para validação e formatação de dados.

---

## 📋 Pré-requisitos

Antes de começar, certifique-se de ter instalado:

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Node.js](https://nodejs.org/) (caso não use Docker)
- [Yarn](https://yarnpkg.com/) (caso não use Docker)

---

## 🐳 Rodando com Docker (Recomendado)

### Passo 1: Clone o repositório

```bash
git clone https://github.com/Lucaseduardo20/huggy-project.git
cd huggy-project
```

### Passo 2: Inicie os contêineres Docker

O Docker já está configurado com um **Dockerfile** e **docker-compose.yml**. Para iniciar os contêineres, execute:

```bash
docker-compose up -d
```

Isso irá subir os seguintes serviços:

- **App**: Servidor Laravel (PHP + Nginx)
- **DB**: Banco de dados MySQL
- **Node**: Ambiente para o front-end Vue.js

### Passo 3: Instale as dependências do back-end

Acesse o contêiner do Laravel:

```bash
docker-compose exec app bash
```

Dentro do contêiner, instale as dependências do Laravel:

```bash
composer install
```

### Passo 4: Configure o ambiente

Copie o arquivo `.env.example` para `.env` e configure as variáveis de ambiente:

```bash
cp .env.example .env
```

Gere a chave do Laravel:

```bash
php artisan key:generate
```

### Passo 5: Execute as migrations

Ainda dentro do contêiner, execute as migrations para criar as tabelas no banco de dados:

```bash
php artisan migrate
```

### Passo 6: Instale as dependências do front-end

Em outro terminal, acesse o contêiner do Node:

```bash
docker-compose exec node bash
```

Instale as dependências do Vue.js:

```bash
yarn install
```

### Passo 7: Inicie o servidor de desenvolvimento do front-end

Dentro do contêiner do Node, execute:

```bash
yarn dev
```

O front-end estará disponível em: [http://localhost:5173](http://localhost:5173).

---

## 🖥️ Rodando sem Docker

### Passo 1: Configure o banco de dados

Crie um banco de dados MySQL e configure o arquivo `.env` com as seguintes informações:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=secret
```

### Passo 2: Instale as dependências do back-end

No terminal, instale as dependências do Laravel:

```bash
composer install
```

### Passo 3: Execute as migrations

Execute as migrations para criar as tabelas no banco de dados:

```bash
php artisan migrate
```

### Passo 4: Instale as dependências do front-end

No terminal, instale as dependências do Vue.js:

```bash
yarn install
```

### Passo 5: Inicie o servidor de desenvolvimento do front-end

Execute o servidor de desenvolvimento:

```bash
yarn dev
```

O front-end estará disponível em: [http://localhost:5173](http://localhost:5173).

---

## 🛠️ Tecnologias Utilizadas

### Back-end:
- **Laravel**
- **MySQL**
- **Laravel Data (DTOs)**
- **Testes de Feature (CRUD de clientes)**

### Front-end:
- **Vue.js (TypeScript)**
- **TailwindCSS**
- **Axios**

### Ferramentas:
- **Docker**
- **Yarn**
- **Postman** (para testes de API)

---

## 🗂️ Estrutura do Projeto

### Back-end (Laravel):
- **Controller**: Recebe as requisições HTTP.
- **Service**: Contém a lógica de negócio.
- **Repository**: Acessa o banco de dados.
- **DTOs**: Validação e formatação de dados com Laravel Data.
- **Testes**: Testes de feature para o CRUD de clientes.

### Front-end (Vue.js):
- **Components**: Componentes Vue.js.
- **Views**: Páginas da aplicação.
- **Services**: Requisições HTTP com Axios.
- **Router**: Roteamento com vue-router.
- **Type**: Tipagem Typescript.
- **Json**: Armazenamento de JSON's úteis.


---

## 🧪 Testes

Os testes de feature para o CRUD de **clientes** podem ser executados com:

```bash
php artisan test
```

---

## 📡 API Documentation

A collection do Postman com todas as rotas da API está disponível aqui:

[Postman Collection](https://app.getpostman.com/join-team?invite_code=8460493bff1ea97dc9bb862c350c38ccaabafae590db072604e1aa3a63a9f3d3)

---

## 🚨 Observações

- **Senha do banco de dados**: `secret`
- **Portas**:
    - Front-end: `5173`
    - Back-end: `8000`
    - MySQL: `3306`
