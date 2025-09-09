/**
 * Sistema de Votação Online - JavaScript
 * Funcionalidades gerais do sistema
 */

// Configurações globais
const SistemaVotacao = {
    // Configurações
    config: {
        animationDuration: 300,
        autoRefreshInterval: 30000, // 30 segundos
        maxRetries: 3
    },
    
    // Estado da aplicação
    state: {
        currentPage: window.location.pathname,
        autoRefreshEnabled: false,
        retryCount: 0
    },
    
    // Inicialização
    init: function() {
        this.setupEventListeners();
        this.initializeAnimations();
        this.setupFormValidations();
        this.initializeTooltips();
        this.setupAutoRefresh();
        
        console.log('Sistema de Votação inicializado');
    },
    
    // Event Listeners
    setupEventListeners: function() {
        // Smooth scroll para âncoras
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', this.handleSmoothScroll);
        });
        
        // Confirmação para ações críticas
        document.querySelectorAll('[data-confirm]').forEach(element => {
            element.addEventListener('click', this.handleConfirmAction);
        });
        
        // Auto-resize para textareas
        document.querySelectorAll('textarea').forEach(textarea => {
            textarea.addEventListener('input', this.autoResize);
        });
        
        // Formatação automática de campos
        this.setupFieldFormatting();
        
        // Feedback visual para formulários
        this.setupFormFeedback();
    },
    
    // Animações
    initializeAnimations: function() {
        // Fade in para cards
        const cards = document.querySelectorAll('.card');
        cards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.6s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
        
        // Contadores animados
        this.animateCounters();
    },
    
    // Validações de formulário
    setupFormValidations: function() {
        const forms = document.querySelectorAll('.needs-validation');
        
        forms.forEach(form => {
            form.addEventListener('submit', (event) => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                    this.showValidationErrors(form);
                }
                form.classList.add('was-validated');
            });
            
            // Validação em tempo real
            const inputs = form.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.addEventListener('blur', () => {
                    this.validateField(input);
                });
                
                input.addEventListener('input', () => {
                    if (input.classList.contains('is-invalid')) {
                        this.validateField(input);
                    }
                });
            });
        });
    },
    
    // Tooltips
    initializeTooltips: function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    },
    
    // Auto-refresh para relatórios
    setupAutoRefresh: function() {
        if (this.state.currentPage.includes('relatorio.php')) {
            this.state.autoRefreshEnabled = true;
            this.startAutoRefresh();
        }
    },
    
    // Funções utilitárias
    handleSmoothScroll: function(e) {
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            e.preventDefault();
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    },
    
    handleConfirmAction: function(e) {
        const message = this.getAttribute('data-confirm');
        if (!confirm(message)) {
            e.preventDefault();
        }
    },
    
    autoResize: function() {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
    },
    
    // Formatação de campos
    setupFieldFormatting: function() {
        // Matrícula (apenas letras e números)
        document.querySelectorAll('input[name*="matricula"]').forEach(input => {
            input.addEventListener('input', function(e) {
                this.value = this.value.replace(/[^a-zA-Z0-9]/g, '').toUpperCase();
            });
        });
        
        // Código da chapa (maiúsculo)
        document.querySelectorAll('input[name="codigo_chapa"]').forEach(input => {
            input.addEventListener('input', function(e) {
                this.value = this.value.toUpperCase().replace(/[^a-zA-Z0-9]/g, '');
            });
        });
        
        // Nomes (primeira letra maiúscula)
        document.querySelectorAll('input[name*="nome"]').forEach(input => {
            input.addEventListener('blur', function(e) {
                this.value = this.value.replace(/\b\w/g, char => char.toUpperCase());
            });
        });
    },
    
    // Feedback visual para formulários
    setupFormFeedback: function() {
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn && this.checkValidity()) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Processando...';
                    
                    // Reativar após 5 segundos (fallback)
                    setTimeout(() => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = submitBtn.getAttribute('data-original-text') || 'Enviar';
                    }, 5000);
                }
            });
        });
    },
    
    // Validação individual de campo
    validateField: function(field) {
        const isValid = field.checkValidity();
        
        if (isValid) {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');
        } else {
            field.classList.remove('is-valid');
            field.classList.add('is-invalid');
        }
        
        return isValid;
    },
    
    // Mostrar erros de validação
    showValidationErrors: function(form) {
        const invalidFields = form.querySelectorAll(':invalid');
        if (invalidFields.length > 0) {
            invalidFields[0].focus();
            
            // Mostrar notificação
            this.showNotification('Por favor, corrija os campos destacados.', 'warning');
        }
    },
    
    // Contadores animados
    animateCounters: function() {
        const counters = document.querySelectorAll('[data-counter]');
        
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-counter'));
            const current = parseInt(counter.textContent) || 0;
            const increment = target / 100;
            
            let count = current;
            const timer = setInterval(() => {
                count += increment;
                if (count >= target) {
                    counter.textContent = target;
                    clearInterval(timer);
                } else {
                    counter.textContent = Math.floor(count);
                }
            }, 20);
        });
    },
    
    // Auto-refresh
    startAutoRefresh: function() {
        if (!this.state.autoRefreshEnabled) return;
        
        setInterval(() => {
            if (!document.hidden) {
                this.refreshPageData();
            }
        }, this.config.autoRefreshInterval);
    },
    
    refreshPageData: function() {
        // Implementar refresh via AJAX para melhor UX
        // Por enquanto, apenas atualiza o timestamp
        const timestamp = document.querySelector('[data-timestamp]');
        if (timestamp) {
            timestamp.textContent = new Date().toLocaleString('pt-BR');
        }
    },
    
    // Sistema de notificações
    showNotification: function(message, type = 'info', duration = 5000) {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        notification.style.cssText = `
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            max-width: 500px;
        `;
        
        notification.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="bi bi-${this.getIconForType(type)} me-2"></i>
                <div>${message}</div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Auto-remover
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, duration);
    },
    
    getIconForType: function(type) {
        const icons = {
            success: 'check-circle',
            danger: 'exclamation-triangle',
            warning: 'exclamation-triangle',
            info: 'info-circle'
        };
        return icons[type] || 'info-circle';
    },
    
    // Utilitários
    formatNumber: function(num) {
        return new Intl.NumberFormat('pt-BR').format(num);
    },
    
    formatPercent: function(num) {
        return new Intl.NumberFormat('pt-BR', {
            style: 'percent',
            minimumFractionDigits: 1,
            maximumFractionDigits: 1
        }).format(num / 100);
    },
    
    formatDate: function(date) {
        return new Intl.DateTimeFormat('pt-BR', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit'
        }).format(new Date(date));
    },
    
    // Loading states
    showLoading: function(element) {
        if (element) {
            element.classList.add('loading');
            element.setAttribute('data-original-content', element.innerHTML);
            element.innerHTML = '<i class="bi bi-hourglass-split"></i> Carregando...';
        }
    },
    
    hideLoading: function(element) {
        if (element && element.classList.contains('loading')) {
            element.classList.remove('loading');
            element.innerHTML = element.getAttribute('data-original-content') || '';
        }
    },
    
    // API calls (para futuras implementações)
    apiCall: function(url, options = {}) {
        const defaultOptions = {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        };
        
        return fetch(url, { ...defaultOptions, ...options })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .catch(error => {
                console.error('API call failed:', error);
                this.showNotification('Erro ao conectar com o servidor.', 'danger');
                throw error;
            });
    }
};

// Funcionalidades específicas para votação
const VotacaoManager = {
    init: function() {
        this.setupChapaSelection();
        this.setupVotingValidation();
    },
    
    setupChapaSelection: function() {
        const chapaCards = document.querySelectorAll('.chapa-card');
        
        chapaCards.forEach(card => {
            card.addEventListener('click', function() {
                const chapaId = this.getAttribute('data-chapa-id');
                const radio = document.getElementById(`chapa_${chapaId}`);
                
                if (radio) {
                    radio.checked = true;
                    radio.dispatchEvent(new Event('change'));
                    
                    // Feedback visual
                    chapaCards.forEach(c => c.classList.remove('selected'));
                    this.classList.add('selected');
                    
                    // Scroll suave para o botão de confirmar
                    setTimeout(() => {
                        const confirmBtn = document.getElementById('btnVotar');
                        if (confirmBtn) {
                            confirmBtn.scrollIntoView({
                                behavior: 'smooth',
                                block: 'center'
                            });
                            confirmBtn.classList.add('pulse');
                            setTimeout(() => confirmBtn.classList.remove('pulse'), 2000);
                        }
                    }, 500);
                }
            });
        });
    },
    
    setupVotingValidation: function() {
        const form = document.getElementById('formVotacao');
        if (!form) return;
        
        form.addEventListener('submit', function(e) {
            const matricula = document.getElementById('matricula_aluno').value.trim();
            const chapaSelected = document.querySelector('input[name="chapa_id"]:checked');
            
            if (!matricula || matricula.length < 6) {
                e.preventDefault();
                SistemaVotacao.showNotification('Por favor, informe uma matrícula válida (mínimo 6 caracteres).', 'warning');
                document.getElementById('matricula_aluno').focus();
                return;
            }
            
            if (!chapaSelected) {
                e.preventDefault();
                SistemaVotacao.showNotification('Por favor, selecione uma chapa para votar.', 'warning');
                return;
            }
            
            // Confirmação final
            const chapa = document.querySelector(`label[for="chapa_${chapaSelected.value}"] h6`).textContent;
            if (!confirm(`Confirma seu voto na chapa "${chapa}"?\n\nEsta ação não pode ser desfeita.`)) {
                e.preventDefault();
            }
        });
    }
};

// Funcionalidades para relatórios
const RelatorioManager = {
    init: function() {
        this.setupChartAnimations();
        this.setupPrintFunction();
    },
    
    setupChartAnimations: function() {
        // Animação para barras de progresso
        const progressBars = document.querySelectorAll('.progress-bar');
        progressBars.forEach((bar, index) => {
            const width = bar.style.width;
            bar.style.width = '0%';
            
            setTimeout(() => {
                bar.style.transition = 'width 1.5s ease-in-out';
                bar.style.width = width;
            }, index * 200);
        });
    },
    
    setupPrintFunction: function() {
        const printBtn = document.querySelector('[onclick="window.print()"]');
        if (printBtn) {
            printBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Adicionar classe para impressão
                document.body.classList.add('printing');
                
                // Aguardar um momento para aplicar estilos
                setTimeout(() => {
                    window.print();
                    document.body.classList.remove('printing');
                }, 100);
            });
        }
    }
};

// Inicialização quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', function() {
    SistemaVotacao.init();
    
    // Inicializar funcionalidades específicas baseadas na página
    if (window.location.pathname.includes('votacao.php')) {
        VotacaoManager.init();
    }
    
    if (window.location.pathname.includes('relatorio.php')) {
        RelatorioManager.init();
    }
});

// Salvar referência global para depuração
window.SistemaVotacao = SistemaVotacao;
window.VotacaoManager = VotacaoManager;
window.RelatorioManager = RelatorioManager;