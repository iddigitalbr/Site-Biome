<?php
require 'config/database.php';

try {
    $hash = password_hash('admin123', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE usuarios SET senha_hash = :hash WHERE usuario = 'admin'");
    $stmt->execute([':hash' => $hash]);
    
    // Se não atualizou nada (ex: usuário não existe), cria
    if ($stmt->rowCount() == 0) {
        $stmt = $pdo->prepare("INSERT INTO usuarios (usuario, senha_hash) VALUES ('admin', :hash)");
        $stmt->execute([':hash' => $hash]);
        echo "Usuário admin criado e senha definida.";
    } else {
        echo "Senha do admin atualizada com sucesso.";
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
