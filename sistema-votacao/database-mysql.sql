-- Script SQL para Sistema de Votação Online - Líder de Turma
-- Banco de dados: MySQL
-- Para usar MySQL ao invés de Supabase, use este arquivo

CREATE DATABASE IF NOT EXISTS sistema_votacao CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sistema_votacao;

-- Tabela de chapas
CREATE TABLE IF NOT EXISTS chapas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome_chapa VARCHAR(100) NOT NULL,
    codigo_chapa VARCHAR(20) NOT NULL UNIQUE,
    matricula_lider VARCHAR(20) NOT NULL,
    nome_lider VARCHAR(100) NOT NULL,
    matricula_vice VARCHAR(20) NOT NULL,
    nome_vice VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabela de alunos (para controle de votação)
CREATE TABLE IF NOT EXISTS alunos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    matricula VARCHAR(20) NOT NULL UNIQUE,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabela de votos
CREATE TABLE IF NOT EXISTS votos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    matricula_aluno VARCHAR(20) NOT NULL,
    chapa_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (chapa_id) REFERENCES chapas(id) ON DELETE CASCADE,
    UNIQUE KEY unique_vote (matricula_aluno)
) ENGINE=InnoDB;

-- Índices para melhor performance
CREATE INDEX idx_chapas_codigo ON chapas(codigo_chapa);
CREATE INDEX idx_alunos_matricula ON alunos(matricula);
CREATE INDEX idx_votos_matricula ON votos(matricula_aluno);
CREATE INDEX idx_votos_chapa ON votos(chapa_id);

-- View para facilitar consultas de resultados
CREATE OR REPLACE VIEW resultado_votacao AS
SELECT 
    c.id,
    c.nome_chapa,
    c.codigo_chapa,
    c.nome_lider,
    c.nome_vice,
    COUNT(v.id) as total_votos,
    ROUND(
        (COUNT(v.id) * 100.0 / (SELECT COUNT(*) FROM votos)), 
        2
    ) as percentual_votos
FROM chapas c
LEFT JOIN votos v ON c.id = v.chapa_id
GROUP BY c.id, c.nome_chapa, c.codigo_chapa, c.nome_lider, c.nome_vice
ORDER BY total_votos DESC, c.nome_chapa;