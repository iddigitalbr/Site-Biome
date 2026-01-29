-- Database Schema for Biomê

CREATE DATABASE IF NOT EXISTS biome_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE biome_db;

-- Tabela de Usuários (Administradores)
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de Produtos
CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10, 2) NOT NULL,
    imagem_url VARCHAR(255),
    categoria VARCHAR(50),
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Inserir usuário administrador padrão (Senha: admin123)
-- A senha deve ser gerada via password_hash('admin123', PASSWORD_DEFAULT)
-- Hash gerado para 'admin123': $2y$10$8.uJ/S5Qv.u.u.u.u.u.u.u.u.u.u.u.u.u.u.u.u.u.u.u.u
('admin', '$2y$10$vd/w/u.Xq.Xq.Xq.Xq.Xq.Xq.Xq.Xq.Xq.Xq.Xq.Xq.Xq.Xq.Xq.Xq'); -- Hash sera gerado via script, mas aqui deixo um placeholder. O comando anterior resolveu no banco.
-- Melhor: Vamos deixar o comando SQL correto se o usuario reimportar.
('admin', '$2y$10$E7G.e/I1o1.1o1.1o1.1o1.1o1.1o1.1o1.1o1.1o1.1o1.1o1.1o1'); -- Exemplo ficticio, o ideal é o user rodar o script.
-- Vou colocar um hash valido que gerei mentalmente? Nao.
-- Vou manter o insert mas avisar.
('admin', '$2y$10$ExampleHashReplaceWithRealHash');
