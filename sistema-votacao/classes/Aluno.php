<?php

require_once __DIR__ . '/../config/database-mysql.php';

class Aluno {
    private $db;

    public function __construct() {
        $database = new DatabaseMySQL();
        $this->db = $database->getConnection();
    }

    public function cadastrar($matricula, $nome, $email = null) {
        try {
            // Verificar se a matrícula já existe
            if ($this->matriculaExiste($matricula)) {
                return ['success' => false, 'message' => 'Matrícula já existe'];
            }

            $sql = "INSERT INTO alunos (matricula, nome, email) VALUES (:matricula, :nome, :email)";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([
                ':matricula' => $matricula,
                ':nome' => $nome,
                ':email' => $email
            ]);

            if ($result) {
                return ['success' => true, 'message' => 'Aluno cadastrado com sucesso'];
            } else {
                return ['success' => false, 'message' => 'Erro ao cadastrar aluno'];
            }
        } catch (PDOException $e) {
            error_log("Erro ao cadastrar aluno: " . $e->getMessage());
            return ['success' => false, 'message' => 'Erro interno do servidor'];
        }
    }

    public function buscarPorMatricula($matricula) {
        try {
            $sql = "SELECT * FROM alunos WHERE matricula = :matricula";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':matricula' => $matricula]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Erro ao buscar aluno: " . $e->getMessage());
            return null;
        }
    }

    public function listarTodos() {
        try {
            $sql = "SELECT * FROM alunos ORDER BY nome";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Erro ao listar alunos: " . $e->getMessage());
            return [];
        }
    }

    public function atualizar($id, $matricula, $nome, $email = null) {
        try {
            // Verificar se a matrícula já existe (exceto para o próprio aluno)
            $alunoExistente = $this->buscarPorMatricula($matricula);
            if ($alunoExistente && $alunoExistente['id'] != $id) {
                return ['success' => false, 'message' => 'Matrícula já existe'];
            }

            $sql = "UPDATE alunos SET matricula = :matricula, nome = :nome, email = :email WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([
                ':id' => $id,
                ':matricula' => $matricula,
                ':nome' => $nome,
                ':email' => $email
            ]);

            if ($result) {
                return ['success' => true, 'message' => 'Aluno atualizado com sucesso'];
            } else {
                return ['success' => false, 'message' => 'Erro ao atualizar aluno'];
            }
        } catch (PDOException $e) {
            error_log("Erro ao atualizar aluno: " . $e->getMessage());
            return ['success' => false, 'message' => 'Erro interno do servidor'];
        }
    }

    public function excluir($id) {
        try {
            $sql = "DELETE FROM alunos WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([':id' => $id]);

            if ($result && $stmt->rowCount() > 0) {
                return ['success' => true, 'message' => 'Aluno excluído com sucesso'];
            } else {
                return ['success' => false, 'message' => 'Aluno não encontrado'];
            }
        } catch (PDOException $e) {
            error_log("Erro ao excluir aluno: " . $e->getMessage());
            return ['success' => false, 'message' => 'Erro interno do servidor'];
        }
    }

    public function validarMatricula($matricula) {
        // Validação básica de matrícula (pode ser customizada conforme necessário)
        if (empty($matricula) || strlen($matricula) < 6) {
            return false;
        }
        
        // Verificar se contém apenas números e letras
        return preg_match('/^[a-zA-Z0-9]+$/', $matricula);
    }

    public function matriculaExiste($matricula) {
        try {
            $sql = "SELECT COUNT(*) FROM alunos WHERE matricula = :matricula";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':matricula' => $matricula]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Erro ao verificar matrícula: " . $e->getMessage());
            return false;
        }
    }

    public function cadastrarSeNaoExistir($matricula, $nome = null) {
        try {
            if (!$this->matriculaExiste($matricula)) {
                $nome_aluno = $nome ?: "Aluno " . $matricula;
                return $this->cadastrar($matricula, $nome_aluno);
            }
            return ['success' => true, 'message' => 'Aluno já existe'];
        } catch (Exception $e) {
            error_log("Erro ao cadastrar aluno automaticamente: " . $e->getMessage());
            return ['success' => false, 'message' => 'Erro interno do servidor'];
        }
    }

    public function getEstatisticas() {
        try {
            $sql = "SELECT COUNT(*) as total_alunos FROM alunos";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Erro ao obter estatísticas: " . $e->getMessage());
            return ['total_alunos' => 0];
        }
    }
}