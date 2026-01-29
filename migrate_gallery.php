<?php
require_once 'config/database.php';

try {
    // 1. Criar Tabela produto_imagens
    $sql = "CREATE TABLE IF NOT EXISTS produto_imagens (
        id INT AUTO_INCREMENT PRIMARY KEY,
        produto_id INT NOT NULL,
        imagem_url VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (produto_id) REFERENCES produtos(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
    
    $pdo->exec($sql);
    echo "Tabela 'produto_imagens' criada ou já existente.<br>";

    // 2. Migrar imagens atuais (se ainda não estiverem na tabela nova)
    // Pega todos os produtos que tem imagem setada
    $stmt = $pdo->query("SELECT id, imagem_url FROM produtos WHERE imagem_url IS NOT NULL AND imagem_url != ''");
    $produtos = $stmt->fetchAll();

    $count = 0;
    foreach ($produtos as $p) {
        // Verifica se essa imagem já está na galeria para evitar duplicata
        $check = $pdo->prepare("SELECT id FROM produto_imagens WHERE produto_id = ? AND imagem_url = ?");
        $check->execute([$p['id'], $p['imagem_url']]);
        
        if ($check->rowCount() == 0) {
            $insert = $pdo->prepare("INSERT INTO produto_imagens (produto_id, imagem_url) VALUES (?, ?)");
            $insert->execute([$p['id'], $p['imagem_url']]);
            $count++;
        }
    }

    echo "Migração concluída: $count imagens existentes movidas para a galeria.<br>";

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
