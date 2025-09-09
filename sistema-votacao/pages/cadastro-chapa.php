<?php
$titulo = "Cadastrar Chapa";
$base_url = "..";
require_once __DIR__ . '/../classes/Chapa.php';

$chapa = new Chapa();
$mensagem = '';
$tipo_mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_chapa = trim($_POST['nome_chapa'] ?? '');
    $codigo_chapa = trim($_POST['codigo_chapa'] ?? '');
    $matricula_lider = trim($_POST['matricula_lider'] ?? '');
    $nome_lider = trim($_POST['nome_lider'] ?? '');
    $matricula_vice = trim($_POST['matricula_vice'] ?? '');
    $nome_vice = trim($_POST['nome_vice'] ?? '');
    
    // Validações básicas
    if (empty($nome_chapa) || empty($codigo_chapa) || empty($matricula_lider) || 
        empty($nome_lider) || empty($matricula_vice) || empty($nome_vice)) {
        $mensagem = 'Todos os campos são obrigatórios!';
        $tipo_mensagem = 'danger';
    } elseif ($matricula_lider === $matricula_vice) {
        $mensagem = 'As matrículas do líder e vice-líder devem ser diferentes!';
        $tipo_mensagem = 'danger';
    } else {
        $resultado = $chapa->cadastrar($nome_chapa, $codigo_chapa, $matricula_lider, $nome_lider, $matricula_vice, $nome_vice);
        $mensagem = $resultado['message'];
        $tipo_mensagem = $resultado['success'] ? 'success' : 'danger';
        
        // Limpar campos se sucesso
        if ($resultado['success']) {
            $nome_chapa = $codigo_chapa = $matricula_lider = $nome_lider = $matricula_vice = $nome_vice = '';
        }
    }
}

include __DIR__ . '/../includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <i class="bi bi-plus-circle"></i> Cadastrar Nova Chapa
                </h4>
            </div>
            <div class="card-body">
                <?php if ($mensagem): ?>
                    <div class="alert alert-<?php echo $tipo_mensagem; ?> alert-dismissible fade show" role="alert">
                        <i class="bi bi-<?php echo $tipo_mensagem === 'success' ? 'check-circle' : 'exclamation-triangle'; ?>"></i>
                        <?php echo htmlspecialchars($mensagem); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <p class="text-muted mb-4">
                    Preencha as informações da chapa candidata à eleição de líder de turma.
                </p>
                
                <form method="POST" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nome_chapa" class="form-label">
                                <i class="bi bi-people"></i> Nome da Chapa *
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="nome_chapa" 
                                   name="nome_chapa" 
                                   value="<?php echo htmlspecialchars($nome_chapa ?? ''); ?>"
                                   placeholder="Ex: União Estudantil" 
                                   required
                                   maxlength="100">
                            <div class="invalid-feedback">
                                Por favor, informe o nome da chapa.
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="codigo_chapa" class="form-label">
                                <i class="bi bi-hash"></i> Código da Chapa *
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="codigo_chapa" 
                                   name="codigo_chapa" 
                                   value="<?php echo htmlspecialchars($codigo_chapa ?? ''); ?>"
                                   placeholder="Ex: UE2024" 
                                   required
                                   maxlength="20"
                                   style="text-transform: uppercase;">
                            <div class="invalid-feedback">
                                Por favor, informe o código da chapa.
                            </div>
                            <div class="form-text">Código único para identificar a chapa</div>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <h6 class="text-primary mb-3">
                        <i class="bi bi-person-badge"></i> Informações do Líder
                    </h6>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="matricula_lider" class="form-label">
                                <i class="bi bi-card-text"></i> Matrícula do Líder *
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="matricula_lider" 
                                   name="matricula_lider" 
                                   value="<?php echo htmlspecialchars($matricula_lider ?? ''); ?>"
                                   placeholder="Ex: 202301001" 
                                   required
                                   maxlength="20">
                            <div class="invalid-feedback">
                                Por favor, informe a matrícula do líder.
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="nome_lider" class="form-label">
                                <i class="bi bi-person"></i> Nome do Líder *
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="nome_lider" 
                                   name="nome_lider" 
                                   value="<?php echo htmlspecialchars($nome_lider ?? ''); ?>"
                                   placeholder="Ex: João Silva" 
                                   required
                                   maxlength="100">
                            <div class="invalid-feedback">
                                Por favor, informe o nome do líder.
                            </div>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <h6 class="text-primary mb-3">
                        <i class="bi bi-person-plus"></i> Informações do Vice-Líder
                    </h6>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="matricula_vice" class="form-label">
                                <i class="bi bi-card-text"></i> Matrícula do Vice-Líder *
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="matricula_vice" 
                                   name="matricula_vice" 
                                   value="<?php echo htmlspecialchars($matricula_vice ?? ''); ?>"
                                   placeholder="Ex: 202301002" 
                                   required
                                   maxlength="20">
                            <div class="invalid-feedback">
                                Por favor, informe a matrícula do vice-líder.
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="nome_vice" class="form-label">
                                <i class="bi bi-person"></i> Nome do Vice-Líder *
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="nome_vice" 
                                   name="nome_vice" 
                                   value="<?php echo htmlspecialchars($nome_vice ?? ''); ?>"
                                   placeholder="Ex: Maria Santos" 
                                   required
                                   maxlength="100">
                            <div class="invalid-feedback">
                                Por favor, informe o nome do vice-líder.
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="../" class="btn btn-outline-secondary btn-lg me-md-2">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-check-lg"></i> Cadastrar Chapa
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="alert alert-info mt-4">
            <h6 class="alert-heading">
                <i class="bi bi-info-circle"></i> Informações Importantes
            </h6>
            <ul class="mb-0">
                <li>Cada chapa deve ter um <strong>código único</strong></li>
                <li>As <strong>matrículas do líder e vice-líder devem ser diferentes</strong></li>
                <li>Todos os campos são obrigatórios</li>
                <li>Após cadastrar, a chapa estará disponível para votação</li>
            </ul>
        </div>
    </div>
</div>

<script>
// Validação de formulário Bootstrap
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

// Converter código da chapa para maiúsculo
document.getElementById('codigo_chapa').addEventListener('input', function(e) {
    e.target.value = e.target.value.toUpperCase();
});
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>