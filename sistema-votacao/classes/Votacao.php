<?php

require_once __DIR__ . '/../config/database-mysql.php';
require_once __DIR__ . '/Aluno.php';
require_once __DIR__ . '/Chapa.php';

class Votacao {
    private $db;
    private $aluno;
    private $chapa;

    public function __construct() {
        $database = new DatabaseMySQL();
        $this->db = $database->getConnection();
        $this->aluno = new Aluno();
        $this->chapa = new Chapa();
    }

    public function votar($matricula_aluno, $chapa_id) {
        try {
            // Verificar se o aluno já votou
            if ($this->alunoJaVotou($matricula_aluno)) {
                return ['success' => false, 'message' => 'Você já votou! Cada aluno pode votar apenas uma vez.'];
            }

            // Verificar se a chapa existe
            $chapa = $this->chapa->buscarPorId($chapa_id);
            if (!$chapa) {
                return ['success' => false, 'message' => 'Chapa não encontrada'];
            }

            // Cadastrar aluno se não existir
            $this->aluno->cadastrarSeNaoExistir($matricula_aluno);

            // Registrar o voto
            $sql = "INSERT INTO votos (matricula_aluno, chapa_id) VALUES (:matricula_aluno, :chapa_id)";
            $stmt = $this->db->prepare($sql);
            $result = $stmt->execute([
                ':matricula_aluno' => $matricula_aluno,
                ':chapa_id' => $chapa_id
            ]);

            if ($result) {
                return ['success' => true, 'message' => 'Voto registrado com sucesso!'];
            } else {
                return ['success' => false, 'message' => 'Erro ao registrar voto'];
            }
        } catch (PDOException $e) {
            error_log("Erro ao votar: " . $e->getMessage());
            return ['success' => false, 'message' => 'Erro interno do servidor'];
        }
    }

    public function alunoJaVotou($matricula_aluno) {
        try {
            $sql = "SELECT COUNT(*) FROM votos WHERE matricula_aluno = :matricula";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':matricula' => $matricula_aluno]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Erro ao verificar voto: " . $e->getMessage());
            return false;
        }
    }

    public function getResultados() {
        try {
            $sql = "SELECT * FROM resultado_votacao";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $resultados = $stmt->fetchAll();

            // Calcular total de votos
            $totalVotos = $this->getTotalVotos();
            
            // Recalcular percentuais se necessário
            foreach ($resultados as &$resultado) {
                if ($totalVotos > 0) {
                    $resultado['percentual_votos'] = round(($resultado['total_votos'] / $totalVotos) * 100, 2);
                } else {
                    $resultado['percentual_votos'] = 0;
                }
            }

            return [
                'resultados' => $resultados,
                'total_votos' => $totalVotos,
                'total_chapas' => count($resultados)
            ];
        } catch (PDOException $e) {
            error_log("Erro ao obter resultados: " . $e->getMessage());
            return [
                'resultados' => [],
                'total_votos' => 0,
                'total_chapas' => 0
            ];
        }
    }

    public function getTotalVotos() {
        try {
            $sql = "SELECT COUNT(*) FROM votos";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Erro ao contar votos: " . $e->getMessage());
            return 0;
        }
    }

    public function getVotosPorChapa($chapa_id) {
        try {
            $sql = "SELECT COUNT(*) FROM votos WHERE chapa_id = :chapa_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':chapa_id' => $chapa_id]);
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Erro ao contar votos da chapa: " . $e->getMessage());
            return 0;
        }
    }

    public function getHistoricoVotos() {
        try {
            $sql = "SELECT v.*, c.nome_chapa, c.codigo_chapa, a.nome as nome_aluno
                    FROM votos v
                    JOIN chapas c ON v.chapa_id = c.id
                    LEFT JOIN alunos a ON v.matricula_aluno = a.matricula
                    ORDER BY v.created_at DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Erro ao obter histórico de votos: " . $e->getMessage());
            return [];
        }
    }

    public function resetarVotacao() {
        try {
            $this->db->beginTransaction();
            
            // Excluir todos os votos
            $sql = "DELETE FROM votos";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            
            $this->db->commit();
            return ['success' => true, 'message' => 'Votação resetada com sucesso'];
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Erro ao resetar votação: " . $e->getMessage());
            return ['success' => false, 'message' => 'Erro ao resetar votação'];
        }
    }

    public function getEstatisticasDetalhadas() {
        try {
            $resultados = $this->getResultados();
            $totalVotos = $resultados['total_votos'];
            $totalChapas = $resultados['total_chapas'];
            
            // Calcular média de votos por chapa
            $mediaVotos = $totalChapas > 0 ? round($totalVotos / $totalChapas, 2) : 0;
            
            // Encontrar chapa vencedora
            $chapaVencedora = null;
            $maiorVotacao = 0;
            foreach ($resultados['resultados'] as $resultado) {
                if ($resultado['total_votos'] > $maiorVotacao) {
                    $maiorVotacao = $resultado['total_votos'];
                    $chapaVencedora = $resultado;
                }
            }

            return [
                'total_votos' => $totalVotos,
                'total_chapas' => $totalChapas,
                'media_votos_por_chapa' => $mediaVotos,
                'chapa_vencedora' => $chapaVencedora,
                'participacao_percentual' => $this->calcularParticipacao()
            ];
        } catch (Exception $e) {
            error_log("Erro ao obter estatísticas detalhadas: " . $e->getMessage());
            return null;
        }
    }

    private function calcularParticipacao() {
        try {
            $totalAlunos = $this->aluno->getEstatisticas()['total_alunos'];
            $totalVotos = $this->getTotalVotos();
            
            if ($totalAlunos > 0) {
                return round(($totalVotos / $totalAlunos) * 100, 2);
            }
            return 0;
        } catch (Exception $e) {
            error_log("Erro ao calcular participação: " . $e->getMessage());
            return 0;
        }
    }
}