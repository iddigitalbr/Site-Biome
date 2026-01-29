<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: /');
    exit;
}

// Buscar produto
$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$id]);
$produto = $stmt->fetch();
if (!$produto) {
    header('Location: /');
    exit;
}

// Buscar imagens da galeria
$stmtImg = $pdo->prepare("SELECT * FROM produto_imagens WHERE produto_id = ?");
$stmtImg->execute([$id]);
$imagens = $stmtImg->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo sanitize($produto['nome']); ?> - Biomê</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/favicon.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        .produto-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: start;
        }
        .produto-imagens {
            position: sticky;
            top: 20px;
        }
        .imagem-principal {
            width: 100%;
            border-radius: 12px;
            overflow: hidden;
            background: #f5f5f5;
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }
        .imagem-principal img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .galeria-thumbs {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(80px, 1fr));
            gap: 12px;
        }
        .thumb {
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            border: 2px solid transparent;
            transition: border-color 0.2s, transform 0.2s;
            aspect-ratio: 1;
            background: #f5f5f5;
        }
        .thumb:hover,
        .thumb.active {
            border-color: var(--primary-color, #3A5F40);
            transform: scale(1.05);
        }
        .thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .produto-info h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 12px;
            color: #1a1a1a;
        }
        .produto-categoria {
            font-size: 1rem;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 20px;
        }
        .produto-preco {
            font-size: 2rem;
            font-weight: 600;
            color: var(--primary-color, #3A5F40);
            margin-bottom: 24px;
        }
        .produto-descricao {
            font-size: 1.05rem;
            line-height: 1.7;
            color: #333;
            margin-bottom: 32px;
        }
        .btn-voltar {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: var(--primary-color, #3A5F40);
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: background 0.2s;
        }
        .btn-voltar:hover {
            background: var(--primary-hover, #2E4B32);
        }
        @media (max-width: 768px) {
            .produto-container {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            .produto-imagens {
                position: static;
            }
            .produto-info h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main class="produto-container">
        <div class="produto-imagens">
            <div class="imagem-principal" id="imagemPrincipal">
                <?php if ($produto['imagem_url']): ?>
                    <img src="<?php echo $produto['imagem_url']; ?>" alt="<?php echo sanitize($produto['nome']); ?>">
                <?php else: ?>
                    <span style="color:#999;">Sem imagem</span>
                <?php endif; ?>
            </div>
            <?php if (count($imagens) > 0): ?>
                <div class="galeria-thumbs">
                    <?php foreach ($imagens as $img): ?>
                        <div class="thumb" onclick="trocarImagem('<?php echo $img['imagem_url']; ?>')">
                            <img src="<?php echo $img['imagem_url']; ?>" alt="Imagem do produto">
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="produto-info">
            <h1><?php echo sanitize($produto['nome']); ?></h1>
            <div class="produto-categoria"><?php echo sanitize($produto['categoria']); ?></div>
            <div class="produto-preco"><?php echo formatPrice($produto['preco']); ?></div>
            <?php if ($produto['descricao']): ?>
                <div class="produto-descricao"><?php echo nl2br(sanitize($produto['descricao'])); ?></div>
            <?php endif; ?>
            <a href="/" class="btn-voltar">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Voltar para a Home
            </a>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>

    <script>
        function trocarImagem(url) {
            const principal = document.getElementById('imagemPrincipal');
            principal.innerHTML = `<img src="${url}" alt="Imagem do produto">`;
            // Atualizar thumb ativa
            document.querySelectorAll('.thumb').forEach(th => th.classList.remove('active'));
            event.currentTarget.classList.add('active');
        }
    </script>
</body>
</html>
