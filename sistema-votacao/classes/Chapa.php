<?php

require_once __DIR__ . '/../config/database-mysql.php';

class Chapa {
    private $db;

    public function __construct() {
        $database = new DatabaseMySQL();
        $this->db = $database->getConnection();
    }

    public function cadastrar($nome_chapa, $codigo_chapa, $matricula_lider, $nome_lider, $matricula_vice, $nome_vice) {
        try {
            // Verificar se o código da chapa já existe
            if ($this->chapaExiste($codigo_chapa)) {
                return ['success' => false, 'message' => 'Código da chapa já existe'];
            }

            // Verificar se as matrículas do líder e vice já estão sendo usadas
            if ($this->matriculaJaUsada($matricula_lider) || $this->matriculaJaUsada($matricula_vice)) {
                return ['success' => false, 'message' => 'Matrícula já está sendo usada em outra chapa'];
            }

            $sql = "INSERT INTO chapas (nome_chapa, codigo_chapa, matricula_lider, nome_lider, matricula_vice, nome_vice) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([
                $nome_chapa,
                $codigo_chapa,
                $matricula_lider,
                $nome_lider,
                $matricula_vice,
                $nome_vice
            ]);

            if ($result) {
                return ['success' => true, 'message' => 'Chapa cadastrada com sucesso'];
            } else {
                return ['success' => false, 'message' => 'Erro ao cadastrar chapa'];
            }
        } catch (PDOException $e) {
            error_log("Erro ao cadastrar chapa: " . $e->getMessage());
            return ['success' => false, 'message' => 'Erro interno do servidor'];
        }
    }

    public function listarTodas() {
        try {
            $sql = "SELECT * FROM chapas ORDER BY nome_chapa";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Erro ao listar chapas: " . $e->getMessage());
            return [];
        }
    }

    public function buscarPorId($id) {
        try {
            $sql = "SELECT * FROM chapas WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Erro ao buscar chapa: " . $e->getMessage());
            return null;
        }
    }

    public function buscarPorCodigo($codigo) {
        try {
            $sql = "SELECT * FROM chapas WHERE codigo_chapa = :codigo";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':codigo' => $codigo]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Erro ao buscar chapa por código: " . $e->getMessage());
            return null;
        }
    }

    public function atualizar($id, $nome_chapa, $codigo_chapa, $matricula_lider, $nome_lider, $matricula_vice, $nome_vice) {
        try {
            // Verificar se o código da chapa já existe (exceto para a própria chapa)
            $chapaExistente = $this->buscarPorCodigo($codigo_chapa);
            if ($chapaExistente && $chapaExistente['id'] != $id) {
                return ['success' => false, 'message' => 'Código da chapa já existe'];
            }

            $sql = "UPDATE chapas SET 
                        nome_chapa = :nome_chapa, 
                        codigo_chapa = :codigo_chapa, 
                        matricula_lider = :matricula_lider, 
                        nome_lider = :nome_lider, 
                        matricula_vice = :matricula_vice, 
                        nome_vice = :nome_vice,
                        updated_at = CURRENT_TIMESTAMP
                    WHERE id = :id";
            
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([
                ':id' => $id,
                ':nome_chapa' => $nome_chapa,
                ':codigo_chapa' => $codigo_chapa,
                ':matricula_lider' => $matricula_lider,
                ':nome_lider' => $nome_lider,
                ':matricula_vice' => $matricula_vice,
                ':nome_vice' => $nome_vice
            ]);

            if ($result) {
                return ['success' => true, 'message' => 'Chapa atualizada com sucesso'];
            } else {
                return ['success' => false, 'message' => 'Erro ao atualizar chapa'];
            }
        } catch (PDOException $e) {
            error_log("Erro ao atualizar chapa: " . $e->getMessage());
            return ['success' => false, 'message' => 'Erro interno do servidor'];
        }
    }

    public function excluir($id) {
        try {
            $sql = "DELETE FROM chapas WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([$id]);

            if ($result && $stmt->rowCount() > 0) {
                return ['success' => true, 'message' => 'Chapa excluída com sucesso'];
            } else {
                return ['success' => false, 'message' => 'Chapa não encontrada'];
            }
        } catch (PDOException $e) {
            error_log("Erro ao excluir chapa: " . $e->getMessage());
            return ['success' => false, 'message' => 'Erro interno do servidor'];
        }
    }

    private function chapaExiste($codigo_chapa) {
        $sql = "SELECT COUNT(*) FROM chapas WHERE codigo_chapa = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$codigo_chapa]);
        return $stmt->fetchColumn() > 0;
    }

    private function matriculaJaUsada($matricula) {
        $sql = "SELECT COUNT(*) FROM chapas WHERE matricula_lider = ? OR matricula_vice = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$matricula, $matricula]);
        return $stmt->fetchColumn() > 0;
    }

    public function getEstatisticas() {
        try {
            $sql = "SELECT COUNT(*) as total_chapas FROM chapas";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Erro ao obter estatísticas: " . $e->getMessage());
            return ['total_chapas' => 0];
        }
    }
}