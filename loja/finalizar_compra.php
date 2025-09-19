<?php include 'cabecalho.php'; 

// Verifica se usuário está logado como cliente e tem itens no carrinho
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'cliente' || empty($_SESSION['carrinho'])) {
    header('Location: catalogo.php');
    exit;
}

require 'conexao.php';

// Processa a compra
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo->beginTransaction();
        
        foreach ($_SESSION['carrinho'] as $item) {
            // Atualiza estoque
            $sql = "UPDATE produtos SET quantidade = quantidade - :quantidade WHERE id = :id AND quantidade >= :quantidade";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':quantidade', $item['quantidade']);
            $stmt->bindParam(':id', $item['id']);
            $stmt->execute();
            
            if ($stmt->rowCount() === 0) {
                throw new Exception("Estoque insuficiente para: " . $item['nome']);
            }
        }
        
        $pdo->commit();
        
        // Limpa carrinho
        $_SESSION['carrinho'] = [];
        
        echo '<div class="alert alert-success text-center">';
        echo '  <i class="fas fa-check-circle fa-3x mb-3"></i>';
        echo '  <h4>Compra realizada com sucesso!</h4>';
        echo '  <p>Obrigado por comprar na Giorno.</p>';
        echo '  <a href="catalogo.php" class="btn btn-primary">Continuar Comprando</a>';
        echo '</div>';
        
    } catch (Exception $e) {
        $pdo->rollBack();
        echo '<div class="alert alert-danger text-center">';
        echo '  <h4>Erro na compra</h4>';
        echo '  <p>' . $e->getMessage() . '</p>';
        echo '  <a href="carrinho.php" class="btn btn-warning">Voltar ao Carrinho</a>';
        echo '</div>';
    }
} else {
    // Mostra resumo da compra
    $total = 0;
    foreach ($_SESSION['carrinho'] as $item) {
        $subtotal = $item['preco'] * $item['quantidade'];
        $total += $subtotal;
    }
    ?>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h3 class="card-title mb-0"><i class="fas fa-check-circle me-2"></i>Finalizar Compra</h3>
                </div>
                <div class="card-body">
                    <h5>Resumo do Pedido</h5>
                    <ul class="list-group mb-3">
                        <?php foreach ($_SESSION['carrinho'] as $item): ?>
                            <li class="list-group-item">
                                <?php echo htmlspecialchars($item['nome']); ?> - 
                                <?php echo $item['quantidade']; ?> x 
                                R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <h5 class="text-end">Total: R$ <?php echo number_format($total, 2, ',', '.'); ?></h5>
                    
                    <form method="POST" class="mt-4">
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-check me-2"></i>Confirmar Compra
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <a href="carrinho.php" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Voltar ao Carrinho
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php
}
?>

<?php include 'rodape.php'; ?>