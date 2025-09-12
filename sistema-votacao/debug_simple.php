<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/config/database-mysql.php';

try {
    $database = new DatabaseMySQL();
    $db = $database->getConnection();
    
    echo "Conexão OK\n";
    
    $sql = "INSERT INTO chapas (nome_chapa, codigo_chapa, matricula_lider, nome_lider, matricula_vice, nome_vice) VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $db->prepare($sql);
    $result = $stmt->execute([
        'Teste Simples',
        'SIMPLE01',
        '111111',
        'João Teste',
        '222222', 
        'Maria Teste'
    ]);
    
    if ($result) {
        echo "✅ Inserção OK\n";
    } else {
        echo "❌ Erro na inserção\n";
        print_r($stmt->errorInfo());
    }
    
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
}
?>