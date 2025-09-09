<?php
$titulo = "Consultar Chapas";
$base_url = "..";
require_once __DIR__ . '/../classes/Chapa.php';

$chapa = new Chapa();
$chapas = $chapa->listarTodas();
$busca = trim($_GET['busca'] ?? '');

// Filtrar chapas se houver busca
if (!empty($busca)) {
    $chapas = array_filter($chapas, function($c) use ($busca) {
        return stripos($c['nome_chapa'], $busca) !== false || 
               stripos($c['codigo_chapa'], $busca) !== false ||
               stripos($c['nome_lider'], $busca) !== false ||
               stripos($c['nome_vice'], $busca) !== false;
    });
}

include __DIR__ . '/../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">
        <i class="bi bi-search"></i> Chapas Cadastradas
    </h2>
    <a href="cadastro-chapa.php" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Nova Chapa
    </a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" 
                           class="form-control" 
                           name="busca" 
                           value="<?php echo htmlspecialchars($busca); ?>"
                           placeholder="Buscar por nome da chapa, código, líder ou vice-líder...">
                </div>
            </div>
            <div class="col-md-2">
                <div class="d-grid">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="bi bi-search"></i> Buscar
                    </button>
                </div>
            </div>
        </form>
        
        <?php if (!empty($busca)): ?>
            <div class="mt-3">
                <span class="badge bg-info">
                    <?php echo count($chapas); ?> resultado(s) para "<?php echo htmlspecialchars($busca); ?>"
                </span>
                <a href="consulta-chapa.php" class="btn btn-sm btn-outline-secondary ms-2">
                    <i class="bi bi-x"></i> Limpar
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if (empty($chapas)): ?>
    <div class="text-center py-5">
        <i class="bi bi-inbox display-1 text-muted"></i>
        <h3 class="text-muted mt-3">
            <?php echo !empty($busca) ? 'Nenhuma chapa encontrada' : 'Nenhuma chapa cadastrada'; ?>
        </h3>
        <p class="text-muted">
            <?php if (!empty($busca)): ?>
                Tente buscar com outros termos ou 
                <a href="consulta-chapa.php">ver todas as chapas</a>
            <?php else: ?>
                <a href="cadastro-chapa.php" class="btn btn-primary mt-3">
                    <i class="bi bi-plus-circle"></i> Cadastrar Primeira Chapa
                </a>
            <?php endif; ?>
        </p>
    </div>
<?php else: ?>
    <div class="row">
        <?php foreach ($chapas as $c): ?>
            <div class="col-lg-6 col-xl-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">
                            <i class="bi bi-people"></i> 
                            <?php echo htmlspecialchars($c['nome_chapa']); ?>
                        </h6>
                        <span class="badge bg-light text-primary">
                            <?php echo htmlspecialchars($c['codigo_chapa']); ?>
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h6 class="text-primary mb-2">
                                <i class="bi bi-person-badge"></i> Candidato a Líder
                            </h6>
                            <div class="ps-3">
                                <div class="fw-semibold"><?php echo htmlspecialchars($c['nome_lider']); ?></div>
                                <small class="text-muted">
                                    <i class="bi bi-card-text"></i> 
                                    Matrícula: <?php echo htmlspecialchars($c['matricula_lider']); ?>
                                </small>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <h6 class="text-success mb-2">
                                <i class="bi bi-person-plus"></i> Candidato a Vice-Líder
                            </h6>
                            <div class="ps-3">
                                <div class="fw-semibold"><?php echo htmlspecialchars($c['nome_vice']); ?></div>
                                <small class="text-muted">
                                    <i class="bi bi-card-text"></i> 
                                    Matrícula: <?php echo htmlspecialchars($c['matricula_vice']); ?>
                                </small>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="bi bi-calendar"></i>
                                <?php echo date('d/m/Y H:i', strtotime($c['created_at'])); ?>
                            </small>
                            <a href="../pages/votacao.php?chapa=<?php echo $c['id']; ?>" 
                               class="btn btn-sm btn-success">
                                <i class="bi bi-hand-thumbs-up"></i> Votar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <div class="row mt-4">
        <div class="col-12">
            <div class="card bg-light">
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <h4 class="text-primary fw-bold"><?php echo count($chapas); ?></h4>
                            <small class="text-muted">
                                <?php echo !empty($busca) ? 'Encontradas' : 'Total de Chapas'; ?>
                            </small>
                        </div>
                        <div class="col-md-3">
                            <h4 class="text-success fw-bold">
                                <?php echo count($chapas) * 2; ?>
                            </h4>
                            <small class="text-muted">Candidatos Total</small>
                        </div>
                        <div class="col-md-3">
                            <h4 class="text-info fw-bold">
                                <?php echo count($chapas); ?>
                            </h4>
                            <small class="text-muted">Líderes</small>
                        </div>
                        <div class="col-md-3">
                            <h4 class="text-warning fw-bold">
                                <?php echo count($chapas); ?>
                            </h4>
                            <small class="text-muted">Vice-Líderes</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card border-primary">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0">
                    <i class="bi bi-info-circle"></i> Como Votar
                </h6>
            </div>
            <div class="card-body">
                <ol class="mb-0">
                    <li>Escolha uma chapa candidata</li>
                    <li>Clique no botão "Votar" da chapa desejada</li>
                    <li>Informe sua matrícula para validação</li>
                    <li>Confirme seu voto</li>
                </ol>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card border-info">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0">
                    <i class="bi bi-exclamation-circle"></i> Regras Importantes
                </h6>
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    <li>Cada aluno pode votar apenas <strong>uma vez</strong></li>
                    <li>É necessário informar a <strong>matrícula</strong> para votar</li>
                    <li>Voto é <strong>anônimo e seguro</strong></li>
                    <li>Resultados podem ser acompanhados em tempo real</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>