<?php include 'cabecalho.php'; 
require 'conexao.php';

// Verifica se usuário está logado como cliente
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'cliente') {
    header('Location: login.php');
    exit;
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-shirt me-2"></i>Catálogo de Roupas</h2>
    <a href="carrinho.php" class="btn btn-primary position-relative">
        <i class="fas fa-shopping-cart me-1"></i>Carrinho
        <?php
        $total_itens = 0;
        if (isset($_SESSION['carrinho'])) {
            foreach ($_SESSION['carrinho'] as $item) {
                $total_itens += $item['quantidade'];
            }
        }
        if ($total_itens > 0): ?>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                <?php echo $total_itens; ?>
            </span>
        <?php endif; ?>
    </a>
</div>

<div class="row">
    <?php
    $sql = "SELECT * FROM produtos WHERE quantidade > 0 ORDER BY nome";
    $stmt = $pdo->query($sql);
    
    if ($stmt->rowCount() > 0) {
        while ($produto = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<div class="col-md-4 mb-4">';
            echo '  <div class="card h-100">';
            echo '    <div class="card-body">';
            echo '      <h5 class="card-title">' . htmlspecialchars($produto['nome']) . '</h5>';
            echo '      <p class="card-text">';
            echo '        <strong>R$ ' . number_format($produto['preco'], 2, ',', '.') . '</strong><br>';
            echo '        Tamanho: ' . $produto['tamanho'] . '<br>';
            echo '        Cor: ' . $produto['cor'] . '<br>';
            echo '        Categoria: ' . $produto['categoria'] . '<br>';
            echo '        Estoque: ' . $produto['quantidade'] . ' unidades';
            echo '      </p>';
            if (!empty($produto['descricao'])) {
                echo '      <p class="card-text"><small>' . htmlspecialchars($produto['descricao']) . '</small></p>';
            }
            echo '    </div>';
            echo '    <div class="card-footer">';
            echo '      <form action="adicionar_carrinho.php" method="POST" class="d-flex">';
            echo '        <input type="hidden" name="produto_id" value="' . $produto['id'] . '">';
            echo '        <input type="number" name="quantidade" value="1" min="1" max="' . $produto['quantidade'] . '" class="form-control me-2" style="width: 80px;">';
            echo '        <button type="submit" class="btn btn-primary flex-grow-1">';
            echo '          <i class="fas fa-cart-plus me-1"></i>Adicionar';
            echo '        </button>';
            echo '      </form>';
            echo '    </div>';
            echo '  </div>';
            echo '</div>';
        }
    } else {
        echo '<div class="col-12">';
        echo '  <div class="alert alert-info text-center">Nenhuma roupa disponível no momento.</div>';
        echo '</div>';
    }
    ?>
</div>

<div class="mt-3">
    <a href="index.php" class="btn btn-outline-light">
        <i class="fas fa-arrow-left me-1"></i>Voltar para o Início
    </a>
</div>

<?php include 'rodape.php'; ?>