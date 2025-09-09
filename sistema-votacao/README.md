# 🗳️ Sistema de Votação Online - Líder de Turma

Sistema completo para eleição online de líder e vice-líder de turma, desenvolvido em PHP com MySQL.

## 📋 Sobre o Projeto

Este projeto foi desenvolvido como **Produção de Aprendizagem Significativa (PAS)** para a disciplina de **Programação Web Back-end** do curso de **Análise e Desenvolvimento de Sistemas** - 4º Período.

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

### 🔧 Instalação Rápida

1. **Clone o projeto:**
```bash
git clone [seu-repositorio]
cd sistema-votacao
```

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

   **Opção B - Via Terminal/CMD:**
   ```bash
   # Entre no MySQL
   mysql -u root -p
   
   # Execute o script de criação do banco
   mysql -u root -p'gordo123' < database-mysql.sql
   ```

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

### 📊 Recursos Avançados

- **View `resultado_votacao`**: Consulta otimizada para resultados
- **Índices**: Performance otimizada para grandes volumes
- **Constraints**: Integridade referencial garantida

## 🔧 Configuração Personalizada

### Alterando Credenciais do Banco

Edite o arquivo `config/database-mysql.php`:

```php
$this->host = 'seu-host';
$this->port = '3306';
$this->dbname = 'sistema_votacao';
$this->username = 'seu-usuario';
$this->password = 'sua-senha';
```

### Executando em Produção

Para ambiente de produção:

1. Configure um servidor web real (Apache/Nginx)
2. Altere as credenciais do banco
3. Desabilite modo debug no `.env`:
```bash
APP_ENV=production
APP_DEBUG=false
```

## 🧪 Testes

### Testando o Sistema Completo

1. **Teste de Conexão:**
```bash
php test_connection.php
```

2. **Cadastre uma chapa de teste:**
   - Acesse: http://localhost:8000/pages/cadastro-chapa.php

3. **Realize um voto:**
   - Acesse: http://localhost:8000/pages/votacao.php

4. **Verifique os resultados:**
   - Acesse: http://localhost:8000/pages/resultados.php

## 📁 Estrutura do Projeto

```
sistema-votacao/
├── classes/              # Classes PHP (Models)
│   ├── Aluno.php
│   ├── Chapa.php
│   └── Votacao.php
├── config/               # Configurações
│   └── database-mysql.php
├── includes/             # Arquivos compartilhados
├── pages/                # Páginas da aplicação
├── public/               # Assets (CSS, JS, imagens)
├── database-mysql.sql    # Script de criação do banco
├── test_connection.php   # Teste de conexão
├── .env                  # Configurações do ambiente
├── .env.example          # Exemplo de configurações
├── composer.json         # Configuração do projeto (opcional)
└── index.php             # Página inicial
```

## 🔍 Solução de Problemas

### ❌ Erro "could not find driver"
```bash
# Instale as extensões MySQL
sudo apt install php8.3-mysql php8.3-pdo-mysql
```

### ❌ Erro "Access denied"
- Verifique usuário e senha no arquivo `config/database-mysql.php`
- Confirme se o usuário tem permissão no MySQL

### ❌ Erro "Unknown database"
```bash
# Execute o script de criação do banco
mysql -u root -p'gordo123' < database-mysql.sql
# OU use o MySQL Workbench conforme instruções acima
```

### ❌ Erro "Connection refused"
- Verifique se o MySQL está rodando:
```bash
sudo systemctl status mysql
sudo systemctl start mysql  # se não estiver rodando
```

## 🤝 Contribuições

Este é um projeto acadêmico, mas melhorias são bem-vindas!

## 📄 Licença

Projeto desenvolvido para fins educacionais.

---

## 🎓 Informações Acadêmicas

**Disciplina:** Programação Web Back-end  
**Curso:** Análise e Desenvolvimento de Sistemas - 4º Período  
**Tipo:** Produção de Aprendizagem Significativa (PAS)

---

**Desenvolvido com ❤️ usando PHP e MySQL**