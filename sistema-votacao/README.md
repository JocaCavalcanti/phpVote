## 📋 Sobre o Projeto

Este projeto foi desenvolvido como **Produção de Aprendizagem Significativa (PAS)** para a disciplina de **Programação Web Back-end** do curso de **Análise e Desenvolvimento de Sistemas** - 5º Período.

### 🎯 Objetivo

Criar um sistema web que permita:
- Cadastro de chapas candidatas
- Sistema de votação online seguro
- Consulta de chapas cadastradas
- Relatórios detalhados com estatísticas da votação

## 🚀 Funcionalidades

### ✅ Módulos Implementados

- **Cadastro de Chapas**: Registro de candidatos (líder e vice)
- **Sistema de Votação**: Interface para voto por matrícula
- **Controle de Duplicação**: Impede voto múltiplo do mesmo aluno
- **Resultados em Tempo Real**: Visualização atualizada dos resultados
- **Estatísticas Detalhadas**: Relatórios completos da votação
- **Interface Responsiva**: Design adaptável para desktop e mobile

## ⚙️ Configuração e Instalação

### 📋 Pré-requisitos

- **PHP 8.0+** 
- **MySQL 5.7+** ou **MariaDB 10.3+**
- **Servidor Web** (Apache, Nginx ou servidor embutido do PHP)

### 🔧 para rodar

2. **Instale as extensões PHP necessárias:**
```bash
sudo apt install php8.3-mysql php8.3-pdo-mysql php8.3-curl
```

3. **Configure o banco de dados MySQL:**

   **Opção A - Via MySQL Workbench (Interface Gráfica):**
   
   1. Abra o **MySQL Workbench**
   2. Conecte na sua conexão (localhost:3306) com senha `gordo123`
   3. Abra o **Editor de Query** (ícone de raio ou `Ctrl + T`)
   4. **Cole todo o conteúdo** do arquivo `database-mysql.sql` na área de texto
   5. Clique em **Execute** (ícone de play) ou `Ctrl + Shift + Enter`
   6. Verifique no painel esquerdo (**Navigator/Schemas**) se apareceu o banco `sistema_votacao`
   7. Clique em refresh 🔄 para ver as tabelas: `chapas`, `alunos`, `votos`

4. **Configure as credenciais (se necessário):**
   - O arquivo `.env` já está configurado para `localhost:3306`
   - Usuário: `root` / Senha: `gordo123`
   - Se suas credenciais forem diferentes, edite o arquivo `config/database-mysql.php`

5. **Teste a conexão:**
```bash
php test_connection.php
```

6. **Inicie o servidor:**
```bash
php -S localhost:8000
```

7. **Acesse o sistema:**
   - Abra o navegador em: http://localhost:8000

## 🗄️ Estrutura do Banco de Dados

O sistema utiliza 3 tabelas principais:

- **`chapas`**: Armazena informações das chapas candidatas
- **`alunos`**: Controla os alunos que podem votar
- **`votos`**: Registra os votos (com controle de duplicação)

