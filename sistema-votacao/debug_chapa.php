<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "=== Debug Cadastro Chapa ===\n\n";

require_once __DIR__ . '/classes/Chapa.php';

try {
    echo "1. Criando objeto Chapa...\n";
    $chapa = new Chapa();
    echo "✅ Objeto criado com sucesso\n\n";
    
    echo "2. Tentando cadastrar chapa de teste...\n";
    $resultado = $chapa->cadastrar(
        'Chapa Teste',
        'TESTE001', 
        '123456',
        'João da Silva',
        '654321',
        'Maria Santos'
    );
    
    echo "✅ Método executado\n";
    echo "Resultado: " . print_r($resultado, true) . "\n";
    
} catch (Exception $e) {
    echo "❌ ERRO: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
?>