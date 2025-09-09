<?php
echo "=== Teste de Conexão MySQL ===\n";

try {
    require_once 'config/database-mysql.php';
    
    $database = new DatabaseMySQL();
    $pdo = $database->getConnection();
    
    echo "✅ Conexão com MySQL: OK\n";
    
    // Testar se o banco existe
    $stmt = $pdo->query("SHOW DATABASES LIKE 'sistema_votacao'");
    $exists = $stmt->fetch();
    
    if ($exists) {
        echo "✅ Banco 'sistema_votacao': Existe\n";
        
        // Testar tabelas
        $pdo->exec("USE sistema_votacao");
        $tables = $pdo->query("SHOW TABLES")->fetchAll();
        
        echo "📊 Tabelas encontradas: " . count($tables) . "\n";
        foreach ($tables as $table) {
            echo "  - " . array_values($table)[0] . "\n";
        }
        
    } else {
        echo "❌ Banco 'sistema_votacao': Não existe\n";
        echo "ℹ️  Execute o script database-mysql.sql\n";
    }
    
} catch (Exception $e) {
    echo "❌ Erro de conexão: " . $e->getMessage() . "\n";
    echo "ℹ️  Verifique se o MySQL está rodando e as credenciais estão corretas\n";
}

echo "\n=== Fim do Teste ===\n";
?>