<?php
// router.php - Roteamento para servidor embutido do PHP

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Log para debug (verifique router.log se tiver problemas)
file_put_contents('router.log', date('[Y-m-d H:i:s] ') . "Request: $path\n", FILE_APPEND);

// Rotas Específicas
if ($path === '/painel' || $path === '/painel/') {
    require 'admin/index.php';
    exit;
}
if ($path === '/login' || $path === '/login/') {
    require 'admin/login.php';
    exit;
}
if ($path === '/configuracoes' || $path === '/configuracoes/') {
    require 'admin/settings.php';
    exit;
}
if ($path === '/logout' || $path === '/logout/') {
    require 'admin/logout.php';
    exit;
}
if ($path === '/produto' || strpos($path, '/produto') === 0) {
    require 'produto.php';
    exit;
}

// Arquivos Estáticos e Scripts Existentes
// Se o arquivo existe fisicamente, deixe o PHP servir (retorna false)
// Mas atenção: se for .php, o built-in server executa.
if ($path !== '/' && file_exists(__DIR__ . $path)) {
    return false;
}

// Fallback para index.php (SPA style ou Homepage)
require 'index.php';
