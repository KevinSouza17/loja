<?php include 'cabecalho.php'; 

// Verifica se usuário está logado como cliente
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'cliente') {
    header('Location: login.php');
    exit;
}

// Processa remoção de item
if (isset($_GET['remover'])) {
    $index = $_GET['remover'];
    if (isset($_SESSION['carrinho'][$index])) {
        unset($_SESSION['carrinho'][$index]);
        $_SESSION['carrinho'] = array_values($_SESSION['carrinho']);
    }
    header('Location: carrinho.php');
    exit;
}

// Processa atualização de quantidade
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['atualizar'])) {
    foreach ($_POST['quantidade'] as $index => $quantidade) {
        if (isset($_SESSION['carrinho'][$index]) && $quantidade > 0) {
            $_SESSION['carrinho'][$index]['quantidade'] = $quantidade;
        }
    }
    header('Location: carrinho.php');
    exit;
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-shopping-cart me-2"></i>Meu Carrinho</h2>
    <a href="catalogo.php" class="btn btn-outline-light">
        <i class="fas fa-arrow-left me-1"></i>Continuar Comprando
    </a>
</div>

<?php if (empty($_SESSION['carrinho'])): ?>
    <div class="alert alert-info text-center">
        <i class="fas fa-shopping-cart fa-3x mb-3"></i>
        <h4>Seu carrinho está vazio</h4>
        <p>Adicione alguns produtos para começar a comprar!</p>
        <a href="catalogo.php" class="btn btn-primary">Ver Catálogo</a>
    </div>
<?php else: ?>
    <form method="POST">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th>Produto</th>
                                <th>Preço</th>
                                <th>Quantidade</th>
                                <th>Subtotal</th>
                                <th>Ação</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total = 0;
                            foreach ($_SESSION['carrinho'] as $index => $item):
                                $subtotal = $item['preco'] * $item['quantidade'];
                                $total += $subtotal;
                            ?>
                                <tr>
                                    <td>
                                        <strong><?php echo htmlspecialchars($item['nome']); ?></strong><br>
                                        <small>Tamanho: <?php echo $item['tamanho']; ?> | Cor: <?php echo $item['cor']; ?></small>
                                    </td>
                                    <td>R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                                    <td>
                                        <input type="number" name="quantidade[<?php echo $index; ?>]" 
                                               value="<?php echo $item['quantidade']; ?>" min="1" class="form-control" style="width: 80px;">
                                    </td>
                                    <td>R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></td>
                                    <td>
                                        <a href="carrinho.php?remover=<?php echo $index; ?>" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                <td><strong>R$ <?php echo number_format($total, 2, ',', '.'); ?></strong></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <button type="submit" name="atualizar" class="btn btn-warning">
                        <i class="fas fa-sync me-1"></i>Atualizar Carrinho
                    </button>
                    <a href="finalizar_compra.php" class="btn btn-success">
                        <i class="fas fa-check me-1"></i>Finalizar Compra
                    </a>
                </div>
            </div>
        </div>
    </form>
<?php endif; ?>

<?php include 'rodape.php'; ?>