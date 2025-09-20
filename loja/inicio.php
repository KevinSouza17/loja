<?php include 'cabecalho.php'; ?>

<div class="hero-section mt-5">
    <div class="container text-center">
        <h1 class="display-4 fw-bold">GIORNO MODA</h1>
        <p class="lead">Estilo e elegância para todos os momentos</p>
        <a href="listar.php" class="btn btn-gold btn-lg mt-3">Ver Coleção</a>
    </div>
</div>

<div class="container">
    <div class="row mb-5">
        <div class="col-md-4">
            <div class="card border-0 text-center">
                <div class="card-body">
                    <i class="fas fa-truck fa-3x text-secondary mb-3"></i>
                    <h5>Entrega Rápida</h5>
                    <p>Entregamos em todo o Brasil com rapidez e segurança.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 text-center">
                <div class="card-body">
                    <i class="fas fa-shield-alt fa-3x text-secondary mb-3"></i>
                    <h5>Compra Segura</h5>
                    <p>Seus dados protegidos e processo de compra seguro.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 text-center">
                <div class="card-body">
                    <i class="fas fa-undo fa-3x text-secondary mb-3"></i>
                    <h5>Trocas Fáceis</h5>
                    <p>Troque ou devolva em até 30 dias após a compra.</p>
                </div>
            </div>
        </div>
    </div>

    <h2 class="section-title text-center">Destaques</h2>
    
    <div class="row">
        <?php
        require 'conexao.php';
        
        $sql = "SELECT * FROM produtos WHERE destaque = 1 AND ativo = 1 ORDER BY id DESC LIMIT 3";
        $stmt = $pdo->query($sql);
        
        if ($stmt->rowCount() > 0) {
            while ($produto = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo '<div class="col-md-4">';
                echo '  <div class="card card-product">';
                echo '    <div class="position-relative">';
                
                if (!empty($produto['imagem_principal'])) {
                    echo '      <img src="' . $produto['imagem_principal'] . '" class="card-img-top product-image" alt="' . $produto['nome'] . '">';
                } else {
                    echo '      <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 250px;">';
                    echo '        <i class="fas fa-image fa-3x text-light"></i>';
                    echo '      </div>';
                }
                
                echo '      <span class="category-badge">' . ucfirst($produto['categoria']) . '</span>';
                echo '    </div>';
                echo '    <div class="card-body">';
                echo '      <h5 class="card-title">' . htmlspecialchars($produto['nome']) . '</h5>';
                
                if (!empty($produto['descricao'])) {
                    echo '      <p class="card-text">' . substr(htmlspecialchars($produto['descricao']), 0, 100) . '...</p>';
                }
                
                echo '      <div class="d-flex justify-content-between align-items-center">';
                
                if (!empty($produto['preco_promocional']) && $produto['preco_promocional'] < $produto['preco']) {
                    echo '        <div>';
                    echo '          <span class="price-tag">R$ ' . number_format($produto['preco_promocional'], 2, ',', '.') . '</span>';
                    echo '          <span class="old-price">R$ ' . number_format($produto['preco'], 2, ',', '.') . '</span>';
                    echo '        </div>';
                } else {
                    echo '        <span class="price-tag">R$ ' . number_format($produto['preco'], 2, ',', '.') . '</span>';
                }
                
                echo '      </div>';
                echo '      <div class="d-grid gap-2 mt-3">';
                echo '        <a href="detalhes.php?id=' . $produto['id'] . '" class="btn btn-outline-dark">Ver Detalhes</a>';
                echo '        <a href="carrinho.php" class="btn btn-gold">Adicionar ao Carrinho</a>';
                echo '      </div>';
                echo '    </div>';
                echo '  </div>';
                echo '</div>';
            }
        } else {
            echo '<div class="col-12 text-center py-4">';
            echo '  <p>Nenhum produto em destaque no momento.</p>';
            echo '  <a href="listar.php" class="btn btn-gold">Ver Todos os Produtos</a>';
            echo '</div>';
        }
        ?>
    </div>
    
    <div class="text-center mt-5">
        <a href="listar.php" class="btn btn-gold btn-lg">Ver Todos os Produtos</a>
    </div>
</div>

<?php include 'rodape.php'; ?>