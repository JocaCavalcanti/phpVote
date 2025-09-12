<?php
$titulo = "Votação";
$base_url = "..";
require_once __DIR__ . '/../classes/Chapa.php';
require_once __DIR__ . '/../classes/Votacao.php';
require_once __DIR__ . '/../classes/Aluno.php';

$chapa_obj = new Chapa();
$votacao = new Votacao();
$aluno = new Aluno();

$chapas = $chapa_obj->listarTodas();
$mensagem = '';
$tipo_mensagem = '';
$chapa_selecionada = $_GET['chapa'] ?? '';

// Processar votação
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matricula_aluno = trim($_POST['matricula_aluno'] ?? '');
    $chapa_id = $_POST['chapa_id'] ?? '';
    
    if (empty($matricula_aluno)) {
        $mensagem = 'Por favor, informe sua matrícula!';
        $tipo_mensagem = 'danger';
    } elseif (!$aluno->validarMatricula($matricula_aluno)) {
        $mensagem = 'Matrícula inválida! Use apenas letras e números (mínimo 6 caracteres).';
        $tipo_mensagem = 'danger';
    } else {
        $resultado = $votacao->votar($matricula_aluno, $chapa_id);
        $mensagem = $resultado['message'];
        $tipo_mensagem = $resultado['success'] ? 'success' : 'danger';
        
        if ($resultado['success']) {
            // Limpar seleção após voto bem-sucedido
            $chapa_selecionada = '';
        }
    }
}

include __DIR__ . '/../includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="text-center mb-4">
            <h2 class="display-6 mb-3">
                <i class="bi bi-hand-thumbs-up text-primary"></i>
                Eleição para Líder de Turma
            </h2>
            <p class="lead text-muted">
                Escolha a chapa que melhor representa seus interesses e vote com responsabilidade.
            </p>
        </div>

        <?php if ($mensagem): ?>
            <div class="alert alert-<?php echo $tipo_mensagem; ?> alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-<?php echo $tipo_mensagem === 'success' ? 'check-circle-fill' : 'exclamation-triangle-fill'; ?> me-2"></i>
                    <div><?php echo htmlspecialchars($mensagem); ?></div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (empty($chapas)): ?>
            <div class="text-center py-5">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <h3 class="text-muted mt-3">Nenhuma chapa cadastrada</h3>
                <p class="text-muted mb-4">
                    É necessário cadastrar pelo menos uma chapa para iniciar a votação.
                </p>
                <a href="cadastro-chapa.php" class="btn btn-primary btn-lg">
                    <i class="bi bi-plus-circle"></i> Cadastrar Primeira Chapa
                </a>
            </div>
        <?php else: ?>
            <form method="POST" id="formVotacao" class="needs-validation" novalidate>
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-person-badge"></i> Identificação do Eleitor
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <label for="matricula_aluno" class="form-label">
                                    <i class="bi bi-card-text"></i> Sua Matrícula *
                                </label>
                                <input type="text" 
                                       class="form-control form-control-lg" 
                                       id="matricula_aluno" 
                                       name="matricula_aluno" 
                                       placeholder="Ex: 202301001"
                                       required
                                       maxlength="20">
                                <div class="invalid-feedback">
                                    Por favor, informe sua matrícula.
                                </div>
                                <div class="form-text">
                                    <i class="bi bi-shield-check"></i> 
                                    Sua identidade é protegida. O voto é anônimo e seguro.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-people"></i> Escolha sua Chapa
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-4">
                            Selecione a chapa em que deseja votar. Você pode votar apenas uma vez.
                        </p>
                        
                        <div class="row">
                            <?php foreach ($chapas as $c): ?>
                                <div class="col-lg-6 mb-3">
                                    <div class="card h-100 chapa-card" data-chapa-id="<?php echo $c['id']; ?>">
                                        <div class="card-body">
                                            <div class="form-check">
                                                <input class="form-check-input" 
                                                       type="radio" 
                                                       name="chapa_id" 
                                                       value="<?php echo $c['id']; ?>" 
                                                       id="chapa_<?php echo $c['id']; ?>"
                                                       <?php echo $chapa_selecionada == $c['id'] ? 'checked' : ''; ?>
                                                       required>
                                                <label class="form-check-label w-100" for="chapa_<?php echo $c['id']; ?>">
                                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                                        <h6 class="text-primary mb-0">
                                                            <i class="bi bi-people"></i>
                                                            <?php echo htmlspecialchars($c['nome_chapa']); ?>
                                                        </h6>
                                                        <span class="badge bg-primary">
                                                            <?php echo htmlspecialchars($c['codigo_chapa']); ?>
                                                        </span>
                                                    </div>
                                                    
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="mb-2">
                                                                <small class="text-muted d-block">
                                                                    <i class="bi bi-person-badge"></i> Líder
                                                                </small>
                                                                <div class="fw-semibold">
                                                                    <?php echo htmlspecialchars($c['nome_lider']); ?>
                                                                </div>
                                                                <small class="text-muted">
                                                                    <?php echo htmlspecialchars($c['matricula_lider']); ?>
                                                                </small>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="mb-2">
                                                                <small class="text-muted d-block">
                                                                    <i class="bi bi-person-plus"></i> Vice-Líder
                                                                </small>
                                                                <div class="fw-semibold">
                                                                    <?php echo htmlspecialchars($c['nome_vice']); ?>
                                                                </div>
                                                                <small class="text-muted">
                                                                    <?php echo htmlspecialchars($c['matricula_vice']); ?>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-body text-center">
                        <h6 class="text-warning mb-3">
                            <i class="bi bi-exclamation-triangle"></i> Confirme seu Voto
                        </h6>
                        <p class="text-muted mb-4">
                            Após confirmar, não será possível alterar seu voto. 
                            Certifique-se de que selecionou a chapa correta.
                        </p>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                            <a href="../" class="btn btn-outline-secondary btn-lg me-md-2">
                                <i class="bi bi-arrow-left"></i> Voltar ao Início
                            </a>
                            <button type="button" class="btn btn-warning btn-lg me-md-2" onclick="limparSelecao()">
                                <i class="bi bi-arrow-clockwise"></i> Limpar Seleção
                            </button>
                            <button type="submit" class="btn btn-success btn-lg" id="btnVotar">
                                <i class="bi bi-check-lg"></i> Confirmar Voto
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        <?php endif; ?>

        <div class="alert alert-info border-0 shadow-sm">
            <h6 class="alert-heading">
                <i class="bi bi-info-circle"></i> Informações Importantes
            </h6>
            <div class="row">
                <div class="col-md-6">
                    <ul class="mb-md-0">
                        <li>Cada aluno pode votar <strong>apenas uma vez</strong></li>
                        <li>É necessário informar sua <strong>matrícula</strong></li>
                        <li>O voto é <strong>anônimo e seguro</strong></li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="mb-0">
                        <li>Escolha com <strong>responsabilidade</strong></li>
                        <li>Não é possível alterar o voto após confirmar</li>
                        <li><a href="relatorio.php">Acompanhe os resultados</a> em tempo real</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.chapa-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.chapa-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.chapa-card.selected {
    border-color: #198754;
    box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25);
}

.form-check-input:checked ~ .form-check-label .chapa-card {
    border-color: #198754;
}
</style>

<script>
// Validação de formulário
(function() {
    'use strict';
    var isSubmitting = false;
    
    window.addEventListener('load', function() {
        var form = document.getElementById('formVotacao');
        var btnVotar = document.getElementById('btnVotar');
        
        if (form) {
            form.addEventListener('submit', function(event) {
                // Prevenir duplo submit
                if (isSubmitting) {
                    event.preventDefault();
                    return;
                }
                
                var matricula = document.getElementById('matricula_aluno').value.trim();
                var chapaSelected = document.querySelector('input[name="chapa_id"]:checked');
                
                var isValid = true;
                
                // Validar matrícula
                if (!matricula || matricula.length < 6) {
                    document.getElementById('matricula_aluno').setCustomValidity('Matrícula deve ter pelo menos 6 caracteres');
                    isValid = false;
                } else {
                    document.getElementById('matricula_aluno').setCustomValidity('');
                }
                
                
                if (!isValid || form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                } else {
                    // Desabilitar botão e mostrar loading
                    isSubmitting = true;
                    btnVotar.disabled = true;
                    btnVotar.innerHTML = '<i class="bi bi-hourglass-split"></i> Processando...';
                }
                
                form.classList.add('was-validated');
            }, false);
        }
    }, false);
})();

// Destacar chapa selecionada
document.querySelectorAll('input[name="chapa_id"]').forEach(function(radio) {
    radio.addEventListener('change', function() {
        // Remover classe selected de todas as chapas
        document.querySelectorAll('.chapa-card').forEach(function(card) {
            card.classList.remove('selected');
        });
        
        // Adicionar classe selected na chapa selecionada
        if (this.checked) {
            var card = document.querySelector('.chapa-card[data-chapa-id="' + this.value + '"]');
            if (card) {
                card.classList.add('selected');
            }
            document.getElementById('chapaError').style.display = 'none';
        }
    });
});

// Marcar chapa selecionada no carregamento da página
document.addEventListener('DOMContentLoaded', function() {
    var selectedRadio = document.querySelector('input[name="chapa_id"]:checked');
    if (selectedRadio) {
        var card = document.querySelector('.chapa-card[data-chapa-id="' + selectedRadio.value + '"]');
        if (card) {
            card.classList.add('selected');
        }
    }
});

// Função para limpar seleção
function limparSelecao() {
    document.querySelectorAll('input[name="chapa_id"]').forEach(function(radio) {
        radio.checked = false;
    });
    document.querySelectorAll('.chapa-card').forEach(function(card) {
        card.classList.remove('selected');
    });
    document.getElementById('matricula_aluno').value = '';
    document.getElementById('formVotacao').classList.remove('was-validated');
    document.getElementById('chapaError').style.display = 'none';
}

// Permitir clicar na área do card para selecionar
document.querySelectorAll('.chapa-card').forEach(function(card) {
    card.addEventListener('click', function() {
        var chapaId = this.getAttribute('data-chapa-id');
        var radio = document.getElementById('chapa_' + chapaId);
        if (radio) {
            radio.checked = true;
            radio.dispatchEvent(new Event('change'));
        }
    });
});
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>