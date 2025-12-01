# Cheque Master - Sistema de Gerenciamento de Cheques

Sistema web desenvolvido para o **Grupo Rocha** para gerenciamento completo de cheques e fornecedores. Permite cadastrar, editar, visualizar e controlar cheques, além de gerenciar fornecedores vinculados.

## 📋 Funcionalidades

### Gerenciamento de Cheques
- ✅ Cadastro de cheques com informações completas (número, valor, datas de emissão e vencimento)
- ✅ Edição de cheques existentes
- ✅ Exclusão de cheques
- ✅ Listagem de cheques com filtros avançados:
  - Filtro por número do cheque
  - Filtro por fornecedor
  - Visualização de cheques vencidos
- ✅ Controle de pagamento (registro de data de pagamento)
- ✅ Vinculação de cheques a fornecedores
- ✅ Campo de observações para cada cheque

### Gerenciamento de Fornecedores
- ✅ Cadastro de fornecedores (nome, telefone, cidade)
- ✅ Edição de fornecedores
- ✅ Exclusão de fornecedores (com validação de cheques vinculados)
- ✅ Listagem completa de fornecedores

### Dashboard
- 📊 Visualização de estatísticas em tempo real:
  - Total de fornecedores cadastrados
  - Total de cheques cadastrados
  - Quantidade de cheques vencidos
- 🎯 Acesso rápido às principais funcionalidades

### Autenticação
- 🔐 Sistema de login seguro com hash de senhas
- 🆕 Registro de novos usuários com senha hasheada diretamente pela interface
- 🔒 Controle de sessão para proteção de rotas
- 🚪 Logout seguro

## 🛠️ Tecnologias Utilizadas

- **Backend**: PHP 7.4+
- **Banco de Dados**: MySQL/MariaDB
- **Frontend**: 
  - HTML5
  - CSS3 (Custom + Bootstrap 5.3.2)
  - JavaScript (Bootstrap Bundle)
- **Framework CSS**: Bootstrap 5.3.2
- **Servidor**: Apache (XAMPP)

## 📦 Requisitos

- PHP 7.4 ou superior
- MySQL/MariaDB 5.7 ou superior
- Apache Web Server
- XAMPP (recomendado para desenvolvimento) ou servidor web equivalente

## 🚀 Instalação

### 1. Clone o repositório
```bash
git clone <url-do-repositorio>
cd Gestao_Cheques
```

### 2. Configure o banco de dados

Crie um banco de dados MySQL chamado `gestao_cheques` e execute as seguintes queries:

```sql
-- Tabela de usuários
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL
);

-- Tabela de fornecedores
CREATE TABLE fornecedores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    telefone VARCHAR(20),
    cidade VARCHAR(100)
);

-- Tabela de cheques
CREATE TABLE cheques (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_cheque VARCHAR(50) NOT NULL,
    valor DECIMAL(10,2) NOT NULL,
    data_emissao DATE NOT NULL,
    data_vencimento DATE NOT NULL,
    data_pagamento DATE NULL,
    observacao TEXT,
    fornecedor_id INT NULL,
    FOREIGN KEY (fornecedor_id) REFERENCES fornecedores(id) ON DELETE SET NULL
);
```

### 3. Configure a conexão com o banco de dados

Edite o arquivo `database/connect.php` e ajuste as credenciais:

```php
$conn = new mysqli("localhost", "seu_usuario", "sua_senha", "gestao_cheques", 3307);
```

**Nota**: Ajuste a porta (3307) conforme sua configuração do MySQL.

### 4. (Opcional) Crie um usuário inicial via SQL

Este passo é opcional, pois agora é possível registrar usuários diretamente na aplicação
pela tela de registro (`auth/register.php`). Se preferir criar um usuário inicial via SQL,
você ainda pode usar o fluxo abaixo:

Use o arquivo `hash.php` para gerar o hash de uma senha:

```php
<?php
echo password_hash('sua_senha_aqui', PASSWORD_DEFAULT);
?>
```

Depois, insira o usuário no banco:

```sql
INSERT INTO usuarios (username, senha) VALUES ('admin', '<hash_gerado>');
```

### 5. Configure o servidor web

- Se estiver usando XAMPP, coloque o projeto em `C:\xampp\htdocs\Gestao_Cheques`
- Ajuste os caminhos no código se necessário (atualmente configurado para `/gestao_cheques/`)

### 6. Acesse o sistema

Abra seu navegador e acesse:
```
http://localhost/gestao_cheques/
```

## 📁 Estrutura do Projeto

```
Gestao_Cheques/
├── auth/                    # Autenticação
│   ├── login.php            # Página de login
│   ├── register.php         # Página de registro de novos usuários
│   └── logout.php           # Logout do sistema
├── cheques/                 # Módulo de cheques
│   ├── create.php           # Cadastro de cheques
│   ├── edit.php             # Edição de cheques
│   ├── delete.php           # Exclusão de cheques
│   └── list.php             # Listagem de cheques
├── fornecedores/            # Módulo de fornecedores
│   ├── create.php           # Cadastro de fornecedores
│   ├── edit.php             # Edição de fornecedores
│   ├── delete.php           # Exclusão de fornecedores
│   └── list.php             # Listagem de fornecedores
├── database/                # Configuração do banco
│   └── connect.php          # Conexão com MySQL
├── includes/                 # Arquivos compartilhados
│   ├── header.php           # Cabeçalho e estilos
│   ├── navbar.php           # Barra de navegação
│   └── footer.php           # Rodapé
├── index.php                # Dashboard principal
├── style.css                # Estilos customizados
├── hash.php                 # Utilitário para hash de senhas
└── README.md                # Este arquivo
```

## 🎨 Características de Design

- **Interface moderna e responsiva** com Bootstrap 5
- **Tema verde** seguindo identidade visual do projeto
- **Footer fixo** na base de todas as páginas
- **Navegação intuitiva** com botões de ação coloridos:
  - 🟢 Verde: Ações principais
  - 🟠 Laranja: Botões de navegação (Voltar)
  - 🔴 Vermelho: Ações de exclusão/logout

## 🔒 Segurança

- ✅ Proteção contra SQL Injection (prepared statements)
- ✅ Proteção XSS (htmlspecialchars)
- ✅ Autenticação baseada em sessão
- ✅ Senhas armazenadas com hash (password_hash)
- ✅ Validação de rotas protegidas

## 📝 Uso

1. **Registro (opcional)**: Acesse `auth/register.php` para criar um novo usuário, caso ainda não exista
2. **Login**: Acesse `auth/login.php` e faça login com suas credenciais
3. **Dashboard**: Visualize estatísticas e acesse os módulos principais
4. **Fornecedores**: Cadastre fornecedores antes de criar cheques vinculados
5. **Cheques**: Gerencie todos os cheques, filtre por critérios e acompanhe vencimentos
6. **Filtros**: Use os filtros na listagem de cheques para encontrar registros específicos

## 👤 Desenvolvido por

**Diogo José Varaschin de Oliveira**

© 2025 - Todos os direitos reservados

## 📄 Licença

Este projeto é de uso interno do Grupo Rocha.

---

**Versão**: 1.0  
**Última atualização**: 2025
