# Sistema de Formatação de CPFs

Sistema web para formatação de CPFs desenvolvido com Laravel 12 e Vue.js 3. Permite processar múltiplos CPFs de uma vez, formatando-os automaticamente no padrão brasileiro (XXX.XXX.XXX-XX).

## 🚀 Funcionalidades

- Formatação automática de CPFs no padrão brasileiro
- Suporte a múltiplos CPFs separados por ponto e vírgula (`;`) ou vírgula (`,`)
- Interface web moderna com Vue.js e Tailwind CSS
- API REST para processamento de CPFs
- Testes unitários e de integração completos
- Normalização automática (remove caracteres especiais, preenche zeros à esquerda)

## 📋 Requisitos

- PHP >= 8.2
- Composer
- Node.js >= 18.x e npm
- SQLite (ou outro banco de dados suportado pelo Laravel)

## 🔧 Instalação

### 1. Clone o repositório

```bash
git clone <url-do-repositorio>
cd project-test
```

### 2. Instale as dependências do PHP

```bash
composer install
```

### 3. Configure o ambiente

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure o banco de dados

O projeto usa SQLite por padrão. Crie o arquivo de banco de dados:

```bash
touch database/database.sqlite
```

Ou configure outro banco de dados no arquivo `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=usuario
DB_PASSWORD=senha
```

### 5. Execute as migrações

```bash
php artisan migrate
```

### 6. Instale as dependências do Node.js

```bash
npm install
```

### 7. Compile os assets

Para desenvolvimento:

```bash
npm run dev
```

Para produção:

```bash
npm run build
```

## 🏃 Como Executar

### Desenvolvimento

Em um terminal, inicie o servidor Laravel:

```bash
php artisan serve
```

Em outro terminal, inicie o Vite (se estiver em modo de desenvolvimento):

```bash
npm run dev
```

Acesse a aplicação em: `http://localhost:8000`

### Produção

Após compilar os assets com `npm run build`, inicie apenas o servidor Laravel:

```bash
php artisan serve
```

## 🧪 Executando os Testes

Execute todos os testes:

```bash
php artisan test
```

Execute apenas os testes de CPF:

```bash
php artisan test --filter Cpf
```

Execute testes específicos:

```bash
php artisan test tests/Unit/CpfFormatterServiceTest.php
php artisan test tests/Feature/CpfControllerTest.php
```

## 📡 API Endpoints

### POST `/api/processar-cpfs`

Processa e formata múltiplos CPFs.

**Request Body:**
```json
{
  "cpfs": "12345678901;98765432100;11122233344"
}
```

**Response (Sucesso):**
```json
{
  "success": true,
  "message": "CPFs processados e formatados com sucesso",
  "data": [
    "123.456.789-01",
    "987.654.321-00",
    "111.222.333-44"
  ]
}
```

**Response (Erro):**
```json
{
  "success": false,
  "message": "Dados inválidos na requisição",
  "errors": {
    "cpfs": ["The cpfs field must be a string."]
  }
}
```

**Exemplo com cURL:**
```bash
curl -X POST http://localhost:8000/api/processar-cpfs \
  -H "Content-Type: application/json" \
  -d '{"cpfs": "12345678901;98765432100"}'
```

## 📁 Estrutura do Projeto

```
project-test/
├── app/
│   └── Http/
│       ├── Controllers/
│       │   └── CpfController.php      # Controller da API
│       └── Services/
│           └── CpfFormatterService.php # Serviço de formatação
├── resources/
│   ├── js/
│   │   ├── App.vue                    # Componente principal Vue
│   │   └── components/
│   │       └── CpfInput.vue           # Componente de input
│   └── views/
│       └── welcome.blade.php          # View principal
├── routes/
│   ├── api.php                        # Rotas da API
│   └── web.php                        # Rotas web
└── tests/
    ├── Unit/
    │   └── CpfFormatterServiceTest.php # Testes unitários
    └── Feature/
        └── CpfControllerTest.php      # Testes de integração
```

## 🎯 Como Usar

### Interface Web

1. Acesse `http://localhost:8000`
2. Digite os CPFs no campo de texto, separados por ponto e vírgula (`;`)
3. Clique em "Processar CPFs"
4. Os CPFs formatados serão exibidos na lista abaixo

**Exemplo de entrada:**
```
12345678901;98765432100;11122233344
```

### API

Faça uma requisição POST para `/api/processar-cpfs` com o campo `cpfs` contendo os CPFs separados por ponto e vírgula ou vírgula.

## 🔍 Funcionalidades do Formatador

- Remove caracteres não numéricos
- Preenche com zeros à esquerda se o CPF tiver menos de 11 dígitos
- Trunca se o CPF tiver mais de 11 dígitos
- Aplica a máscara padrão: `XXX.XXX.XXX-XX`

## 📝 Exemplos

### CPF com menos de 11 dígitos
- Entrada: `123456789`
- Saída: `001.234.567-89`

### CPF já formatado
- Entrada: `123.456.789-01`
- Saída: `123.456.789-01`

### CPF com caracteres especiais
- Entrada: `123 456 789 01`
- Saída: `123.456.789-01`

### CPF com mais de 11 dígitos
- Entrada: `123456789012345`
- Saída: `123.456.789-01` (trunca)

## 🛠️ Tecnologias Utilizadas

- **Backend:** Laravel 12
- **Frontend:** Vue.js 3, Tailwind CSS
- **Build Tool:** Vite
- **Testes:** PHPUnit
- **HTTP Client:** Axios

## 📄 Licença

Este projeto está sob a licença MIT.
