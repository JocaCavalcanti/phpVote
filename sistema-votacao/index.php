<?php
$titulo = "Página Inicial";
require_once __DIR__ . '/classes/Chapa.php';
require_once __DIR__ . '/classes/Aluno.php';
require_once __DIR__ . '/classes/Votacao.php';

// Obter estatísticas
$chapa = new Chapa();
$aluno = new Aluno();
$votacao = new Votacao();

$estatisticasChapas = $chapa->getEstatisticas();
$estatisticasAlunos = $aluno->getEstatisticas();
$estatisticasVotacao = $votacao->getEstatisticasDetalhadas();

include __DIR__ . '/includes/header.php';
?>

<div class="hero-section bg-primary text-white rounded p-5 mb-5">
    <div class="row align-items-center">
        <div class="col-lg-8">
            <h1 class="display-4 fw-bold mb-3">
                <i class="bi bi-ballot-check"></i> Sistema de Votação Online
            </h1>
            <p class="lead mb-4">
                Sistema completo para eleição de Líder e Vice-Líder de Turma. 
                Vote de forma segura e acompanhe os resultados em tempo real.
            </p>
            <div class="d-flex flex-wrap gap-3">
                <a href="pages/cadastro-chapa.php" class="btn btn-light btn-lg">
                    <i class="bi bi-plus-circle"></i> Cadastrar Chapa
                </a>
                <a href="pages/votacao.php" class="btn btn-outline-light btn-lg">
                    <i class="bi bi-hand-thumbs-up"></i> Votar Agora
                </a>
            </div>
        </div>
        <div class="col-lg-4 text-center">
            <i class="bi bi-people display-1 opacity-50"></i>
        </div>
    </div>
</div>

<div class="row mb-5">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <i class="bi bi-people-fill text-primary display-4 mb-3"></i>
                <h3 class="fw-bold text-primary"><?php echo $estatisticasChapas['total_chapas']; ?></h3>
                <p class="text-muted mb-0">Chapas Registradas</p>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <i class="bi bi-person-check-fill text-success display-4 mb-3"></i>
                <h3 class="fw-bold text-success"><?php echo $estatisticasAlunos['total_alunos']; ?></h3>
                <p class="text-muted mb-0">Alunos Cadastrados</p>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <i class="bi bi-hand-thumbs-up-fill text-warning display-4 mb-3"></i>
                <h3 class="fw-bold text-warning"><?php echo $estatisticasVotacao ? $estatisticasVotacao['total_votos'] : 0; ?></h3>
                <p class="text-muted mb-0">Votos Computados</p>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <i class="bi bi-graph-up text-info display-4 mb-3"></i>
                <h3 class="fw-bold text-info"><?php echo $estatisticasVotacao ? $estatisticasVotacao['participacao_percentual'] : 0; ?>%</h3>
                <p class="text-muted mb-0">Participação</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom-0">
                <h5 class="card-title mb-0">
                    <i class="bi bi-info-circle text-primary"></i> Como Funciona
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-start mb-3">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                        <small class="fw-bold">1</small>
                    </div>
                    <div>
                        <h6 class="fw-semibold mb-1">Cadastro de Chapas</h6>
                        <small class="text-muted">As chapas candidatas são cadastradas com informações dos candidatos a líder e vice-líder.</small>
                    </div>
                </div>
                
                <div class="d-flex align-items-start mb-3">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                        <small class="fw-bold">2</small>
                    </div>
                    <div>
                        <h6 class="fw-semibold mb-1">Votação</h6>
                        <small class="text-muted">Cada aluno vota uma única vez informando sua matrícula e escolhendo uma chapa.</small>
                    </div>
                </div>
                
                <div class="d-flex align-items-start mb-0">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 32px; height: 32px;">
                        <small class="fw-bold">3</small>
                    </div>
                    <div>
                        <h6 class="fw-semibold mb-1">Resultados</h6>
                        <small class="text-muted">Acompanhe os resultados em tempo real com estatísticas detalhadas.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom-0">
                <h5 class="card-title mb-0">
                    <i class="bi bi-lightning text-warning"></i> Ações Rápidas
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-3">
                    <a href="pages/cadastro-chapa.php" class="btn btn-outline-primary d-flex align-items-center">
                        <i class="bi bi-plus-circle me-2"></i>
                        <div class="text-start">
                            <div class="fw-semibold">Cadastrar Nova Chapa</div>
                            <small class="text-muted">Registre uma nova chapa candidata</small>
                        </div>
                    </a>
                    
                    <a href="pages/consulta-chapa.php" class="btn btn-outline-info d-flex align-items-center">
                        <i class="bi bi-search me-2"></i>
                        <div class="text-start">
                            <div class="fw-semibold">Ver Todas as Chapas</div>
                            <small class="text-muted">Consulte as chapas cadastradas</small>
                        </div>
                    </a>
                    
                    <a href="pages/votacao.php" class="btn btn-success d-flex align-items-center">
                        <i class="bi bi-hand-thumbs-up me-2"></i>
                        <div class="text-start">
                            <div class="fw-semibold">Votar Agora</div>
                            <small class="text-muted">Registre seu voto na eleição</small>
                        </div>
                    </a>
                    
                    <a href="pages/relatorio.php" class="btn btn-outline-secondary d-flex align-items-center">
                        <i class="bi bi-bar-chart me-2"></i>
                        <div class="text-start">
                            <div class="fw-semibold">Ver Resultados</div>
                            <small class="text-muted">Acompanhe os resultados da votação</small>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($estatisticasVotacao && $estatisticasVotacao['chapa_vencedora']): ?>
<div class="alert alert-info border-0 shadow-sm mt-4">
    <div class="d-flex align-items-center">
        <i class="bi bi-trophy-fill text-warning display-6 me-3"></i>
        <div>
            <h6 class="alert-heading mb-1">Chapa Líder</h6>
            <p class="mb-0">
                <strong><?php echo htmlspecialchars($estatisticasVotacao['chapa_vencedora']['nome_chapa']); ?></strong> 
                está na liderança com 
                <strong><?php echo $estatisticasVotacao['chapa_vencedora']['total_votos']; ?> voto(s)</strong>
                (<?php echo $estatisticasVotacao['chapa_vencedora']['percentual_votos']; ?>%)
            </p>
        </div>
    </div>
</div>
<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>