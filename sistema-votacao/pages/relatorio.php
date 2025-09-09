<?php
$titulo = "Relatório de Votação";
$base_url = "..";
require_once __DIR__ . '/../classes/Votacao.php';

$votacao = new Votacao();
$resultados = $votacao->getResultados();
$estatisticas = $votacao->getEstatisticasDetalhadas();

include __DIR__ . '/../includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">
        <i class="bi bi-bar-chart text-primary"></i> Relatório de Votação
    </h2>
    <div>
        <button onclick="window.print()" class="btn btn-outline-primary">
            <i class="bi bi-printer"></i> Imprimir
        </button>
        <button onclick="atualizarRelatorio()" class="btn btn-success">
            <i class="bi bi-arrow-clockwise"></i> Atualizar
        </button>
    </div>
</div>

<?php if ($resultados['total_votos'] === 0): ?>
    <div class="text-center py-5">
        <i class="bi bi-pie-chart display-1 text-muted"></i>
        <h3 class="text-muted mt-3">Nenhum voto registrado</h3>
        <p class="text-muted mb-4">
            Quando os primeiros votos forem registrados, os resultados aparecerão aqui.
        </p>
        <a href="votacao.php" class="btn btn-success btn-lg">
            <i class="bi bi-hand-thumbs-up"></i> Começar a Votar
        </a>
    </div>
<?php else: ?>
    <!-- Estatísticas Gerais -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <i class="bi bi-hand-thumbs-up display-4 mb-2"></i>
                    <h3 class="fw-bold"><?php echo $resultados['total_votos']; ?></h3>
                    <p class="mb-0">Total de Votos</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <i class="bi bi-people display-4 mb-2"></i>
                    <h3 class="fw-bold"><?php echo $resultados['total_chapas']; ?></h3>
                    <p class="mb-0">Chapas Concorrendo</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <i class="bi bi-graph-up display-4 mb-2"></i>
                    <h3 class="fw-bold"><?php echo $estatisticas ? $estatisticas['participacao_percentual'] : '0'; ?>%</h3>
                    <p class="mb-0">Participação</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <i class="bi bi-calculator display-4 mb-2"></i>
                    <h3 class="fw-bold"><?php echo $estatisticas ? $estatisticas['media_votos_por_chapa'] : '0'; ?></h3>
                    <p class="mb-0">Média por Chapa</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Chapa Vencedora -->
    <?php if ($estatisticas && $estatisticas['chapa_vencedora']): ?>
        <div class="alert alert-success border-0 shadow-sm mb-4">
            <div class="row align-items-center">
                <div class="col-md-2 text-center">
                    <i class="bi bi-trophy-fill display-3 text-warning"></i>
                </div>
                <div class="col-md-10">
                    <h4 class="alert-heading mb-2">
                        <i class="bi bi-star-fill text-warning"></i> Chapa Líder
                    </h4>
                    <h5 class="mb-1">
                        <?php echo htmlspecialchars($estatisticas['chapa_vencedora']['nome_chapa']); ?>
                        <span class="badge bg-success ms-2">
                            <?php echo htmlspecialchars($estatisticas['chapa_vencedora']['codigo_chapa']); ?>
                        </span>
                    </h5>
                    <p class="mb-2">
                        <strong>Líder:</strong> <?php echo htmlspecialchars($estatisticas['chapa_vencedora']['nome_lider']); ?> | 
                        <strong>Vice:</strong> <?php echo htmlspecialchars($estatisticas['chapa_vencedora']['nome_vice']); ?>
                    </p>
                    <div class="d-flex align-items-center">
                        <span class="me-3">
                            <i class="bi bi-hand-thumbs-up"></i>
                            <strong><?php echo $estatisticas['chapa_vencedora']['total_votos']; ?> voto(s)</strong>
                        </span>
                        <span>
                            <i class="bi bi-percent"></i>
                            <strong><?php echo $estatisticas['chapa_vencedora']['percentual_votos']; ?>%</strong>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Resultados Detalhados -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <i class="bi bi-list-ol"></i> Resultados por Chapa
            </h5>
        </div>
        <div class="card-body p-0">
            <?php 
            $posicao = 1;
            foreach ($resultados['resultados'] as $resultado): 
                $percentual = $resultado['percentual_votos'];
                $isVencedora = $posicao === 1 && $resultado['total_votos'] > 0;
            ?>
                <div class="border-bottom <?php echo $isVencedora ? 'bg-light' : ''; ?>">
                    <div class="p-4">
                        <div class="row align-items-center">
                            <div class="col-md-1 text-center">
                                <?php if ($isVencedora): ?>
                                    <i class="bi bi-trophy-fill text-warning display-6"></i>
                                <?php else: ?>
                                    <span class="display-6 text-muted"><?php echo $posicao; ?>º</span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="col-md-4">
                                <h6 class="mb-1 <?php echo $isVencedora ? 'text-success' : ''; ?>">
                                    <?php echo htmlspecialchars($resultado['nome_chapa']); ?>
                                    <span class="badge <?php echo $isVencedora ? 'bg-success' : 'bg-secondary'; ?> ms-2">
                                        <?php echo htmlspecialchars($resultado['codigo_chapa']); ?>
                                    </span>
                                </h6>
                                <div class="small text-muted">
                                    <div><strong>Líder:</strong> <?php echo htmlspecialchars($resultado['nome_lider']); ?></div>
                                    <div><strong>Vice:</strong> <?php echo htmlspecialchars($resultado['nome_vice']); ?></div>
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <div class="progress" style="height: 25px;">
                                    <div class="progress-bar <?php echo $isVencedora ? 'bg-success' : 'bg-primary'; ?>" 
                                         style="width: <?php echo $percentual; ?>%"
                                         aria-valuenow="<?php echo $percentual; ?>" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                        <?php if ($percentual > 0): ?>
                                            <?php echo $percentual; ?>%
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4 text-end">
                                <div class="d-flex justify-content-end align-items-center gap-3">
                                    <div>
                                        <div class="h4 mb-0 <?php echo $isVencedora ? 'text-success' : ''; ?>">
                                            <?php echo $resultado['total_votos']; ?>
                                        </div>
                                        <small class="text-muted">voto(s)</small>
                                    </div>
                                    <div>
                                        <div class="h5 mb-0 <?php echo $isVencedora ? 'text-success' : ''; ?>">
                                            <?php echo $percentual; ?>%
                                        </div>
                                        <small class="text-muted">do total</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php 
                $posicao++;
            endforeach; 
            ?>
        </div>
    </div>

    <!-- Gráfico de Pizza -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-pie-chart"></i> Distribuição de Votos
                    </h6>
                </div>
                <div class="card-body text-center">
                    <canvas id="graficoVotos" width="300" height="300"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-info-circle"></i> Resumo da Eleição
                    </h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><i class="bi bi-hand-thumbs-up text-primary"></i> Total de Votos:</td>
                            <td><strong><?php echo $resultados['total_votos']; ?></strong></td>
                        </tr>
                        <tr>
                            <td><i class="bi bi-people text-success"></i> Chapas Participantes:</td>
                            <td><strong><?php echo $resultados['total_chapas']; ?></strong></td>
                        </tr>
                        <?php if ($estatisticas): ?>
                            <tr>
                                <td><i class="bi bi-graph-up text-info"></i> Taxa de Participação:</td>
                                <td><strong><?php echo $estatisticas['participacao_percentual']; ?>%</strong></td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-calculator text-warning"></i> Média por Chapa:</td>
                                <td><strong><?php echo $estatisticas['media_votos_por_chapa']; ?> votos</strong></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td><i class="bi bi-clock text-secondary"></i> Última Atualização:</td>
                            <td><strong><?php echo date('d/m/Y H:i:s'); ?></strong></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="text-center mt-4 no-print">
    <a href="votacao.php" class="btn btn-success btn-lg me-2">
        <i class="bi bi-hand-thumbs-up"></i> Votar Agora
    </a>
    <a href="../" class="btn btn-outline-primary btn-lg">
        <i class="bi bi-house"></i> Página Inicial
    </a>
</div>

<style>
@media print {
    .no-print, .navbar, .footer {
        display: none !important;
    }
    .container {
        max-width: none !important;
        margin: 0 !important;
        padding: 0 !important;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
<?php if ($resultados['total_votos'] > 0): ?>
// Dados para o gráfico
const dadosGrafico = {
    labels: [<?php echo '"' . implode('", "', array_map(function($r) { return htmlspecialchars($r['nome_chapa']); }, $resultados['resultados'])) . '"'; ?>],
    datasets: [{
        data: [<?php echo implode(', ', array_map(function($r) { return $r['total_votos']; }, $resultados['resultados'])); ?>],
        backgroundColor: [
            '#198754', // Verde
            '#0d6efd', // Azul
            '#fd7e14', // Laranja
            '#6f42c1', // Roxo
            '#d63384', // Rosa
            '#20c997', // Teal
            '#ffc107', // Amarelo
            '#dc3545'  // Vermelho
        ],
        borderWidth: 2,
        borderColor: '#fff'
    }]
};

// Configuração do gráfico
const config = {
    type: 'pie',
    data: dadosGrafico,
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 20,
                    usePointStyle: true
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                        const percentual = ((context.parsed / total) * 100).toFixed(1);
                        return context.label + ': ' + context.parsed + ' voto(s) (' + percentual + '%)';
                    }
                }
            }
        }
    }
};

// Renderizar gráfico
const ctx = document.getElementById('graficoVotos').getContext('2d');
new Chart(ctx, config);
<?php endif; ?>

// Função para atualizar relatório
function atualizarRelatorio() {
    window.location.reload();
}

// Atualização automática a cada 30 segundos
setInterval(function() {
    // Verificar se a página ainda está visível
    if (!document.hidden) {
        const now = new Date();
        const lastUpdate = document.querySelector('td strong:last-child');
        if (lastUpdate) {
            // Atualizar timestamp
            lastUpdate.textContent = now.toLocaleString('pt-BR');
        }
        
        // Recarregar dados (você pode implementar AJAX aqui para melhor UX)
        // Para simplicidade, vamos recarregar a página apenas se houver interação recente
    }
}, 30000);
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>