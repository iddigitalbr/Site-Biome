<?php
require_once 'config/database.php';
require_once 'includes/functions.php';

// Buscar produtos recentes via PDO
try {
    $stmt = $pdo->query("SELECT * FROM produtos ORDER BY data_cadastro DESC LIMIT 12");
    $produtos = $stmt->fetchAll();
} catch (PDOException $e) {
    $produtos = [];
}
?>

<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h1>Mãos que protegem</h1>
        <p>Sua casa será nossa continuidade. Móveis orgânicos que conectam você à essência da selva brasileira.</p>
        <a href="#produtos" class="btn-cta">Conheça a Coleção</a>
    </div>
</section>

<!-- Vitrine Dinâmica -->
<section id="produtos" class="products-section">
    <div class="container">
        <h2 class="section-title">Nossas Criações</h2>
        
        <?php if (count($produtos) > 0): ?>
            <div class="product-grid">
                <?php foreach ($produtos as $produto): ?>
                    <article class="product-card">
                        <div class="product-image">
                            <?php if ($produto['imagem_url']): ?>
                                <a href="/produto?id=<?php echo $produto['id']; ?>" target="_blank" title="Ver detalhes">
                                    <img src="<?php echo $produto['imagem_url']; ?>" alt="<?php echo sanitize($produto['nome']); ?>">
                                </a>
                            <?php else: ?>
                                <div style="width:100%; height:100%; background:#e0e0e0; display:flex; align-items:center; justify-content:center; color:#999;">Sem Imagem</div>
                            <?php endif; ?>
                        </div>
                        <div class="product-info">
                            <span class="category"><?php echo sanitize($produto['categoria']); ?></span>
                            <h3><?php echo sanitize($produto['nome']); ?></h3>
                            <div class="price"><?php echo formatPrice($produto['preco']); ?></div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p style="text-align:center; color: #777;">Nenhum produto cadastrado no momento.</p>
        <?php endif; ?>
    </div>
</section>

<!-- Sobre -->
<section id="sobre" style="padding: 80px 0; background-color: white;">
    <div class="container" style="text-align: center; max-width: 800px;">
        <h2 class="section-title">A Essência Biomê</h2>
        <p style="font-size: 1.1rem; color: #555; line-height: 1.8;">
            Nascemos da conexão entre a matéria-prima bruta e o toque humano. 
            Cada peça conta uma história de preservação, design e funcionalidade. 
            Utilizamos madeiras certificadas e processos que respeitam o tempo da natureza.
        </p>
    </div>
</section>

<!-- Contato -->
<section id="contato" style="padding: 80px 0;">
    <div class="container" style="text-align: center;">
        <h2 class="section-title">Entre em Contato</h2>
        <p style="margin-bottom: 20px;">Tem dúvida sobre algum projeto? Fale conosco.</p>
        <a href="#" class="btn-cta">WhatsApp</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
