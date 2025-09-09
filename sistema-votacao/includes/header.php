<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($titulo) ? $titulo . ' - ' : ''; ?>Sistema de Votação Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="<?php echo isset($base_url) ? $base_url : '.'; ?>/public/css/style.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="<?php echo isset($base_url) ? $base_url : '.'; ?>/">
                <i class="bi bi-ballot-check"></i> Sistema de Votação
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" 
                           href="<?php echo isset($base_url) ? $base_url : '.'; ?>/">
                            <i class="bi bi-house"></i> Início
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'cadastro-chapa.php' ? 'active' : ''; ?>" 
                           href="<?php echo isset($base_url) ? $base_url : '.'; ?>/pages/cadastro-chapa.php">
                            <i class="bi bi-plus-circle"></i> Cadastrar Chapa
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'consulta-chapa.php' ? 'active' : ''; ?>" 
                           href="<?php echo isset($base_url) ? $base_url : '.'; ?>/pages/consulta-chapa.php">
                            <i class="bi bi-search"></i> Consultar Chapas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'votacao.php' ? 'active' : ''; ?>" 
                           href="<?php echo isset($base_url) ? $base_url : '.'; ?>/pages/votacao.php">
                            <i class="bi bi-hand-thumbs-up"></i> Votar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'relatorio.php' ? 'active' : ''; ?>" 
                           href="<?php echo isset($base_url) ? $base_url : '.'; ?>/pages/relatorio.php">
                            <i class="bi bi-bar-chart"></i> Relatório
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">