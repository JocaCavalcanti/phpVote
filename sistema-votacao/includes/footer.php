    </div>

    <footer class="bg-dark text-light mt-5 py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="bi bi-ballot-check"></i> Sistema de Votação Online</h5>
                    <p class="mb-1">Sistema para eleição de Líder e Vice-Líder de Turma</p>
                    <small class="text-muted">Desenvolvido para a disciplina de Programação Web Back-end</small>
                </div>
                <div class="col-md-6">
                    <h6>Links Úteis</h6>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo isset($base_url) ? $base_url : '.'; ?>/" class="text-light text-decoration-none">
                            <i class="bi bi-house"></i> Página Inicial
                        </a></li>
                        <li><a href="<?php echo isset($base_url) ? $base_url : '.'; ?>/pages/votacao.php" class="text-light text-decoration-none">
                            <i class="bi bi-hand-thumbs-up"></i> Votar Agora
                        </a></li>
                        <li><a href="<?php echo isset($base_url) ? $base_url : '.'; ?>/pages/relatorio.php" class="text-light text-decoration-none">
                            <i class="bi bi-bar-chart"></i> Ver Resultados
                        </a></li>
                    </ul>
                </div>
            </div>
            <hr class="my-3">
            <div class="row">
                <div class="col-md-12 text-center">
                    <small class="text-muted">
                        © <?php echo date('Y'); ?> Sistema de Votação Online - 
                        Análise e Desenvolvimento de Sistemas - 5º Período
                    </small>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo isset($base_url) ? $base_url : '.'; ?>/public/js/script.js"></script>
</body>
</html>