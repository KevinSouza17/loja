<?php
// Iniciar sessão NO TOPO do arquivo
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Processar remoção de item do carrinho ANTES de qualquer output
if (isset($_GET['remover'])) {
    $index = $_GET['remover'];
    if (isset($_SESSION['carrinho'][$index])) {
        unset($_SESSION['carrinho'][$index]);
        $_SESSION['carrinho'] = array_values($_SESSION['carrinho']);
    }
    header('Location: carrinho.php');
    exit;
}

// Processar atualização de quantidades
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['atualizar_carrinho'])) {
    foreach ($_POST['quantidade'] as $index => $quantidade) {
        if (isset($_SESSION['carrinho'][$index])) {
            $_SESSION['carrinho'][$index]['quantidade'] = max(1, intval($quantidade));
        }
    }
}

// SÓ DEPOIS inclui o cabeçalho
include 'cabecalho.php';

$carrinho = isset($_SESSION['carrinho']) ? $_SESSION['carrinho'] : [];
$total = 0;
?>

<!-- ... restante do código HTML ... -->

<div class="row">
    <div class="col-md-8">
        <div class="card shadow mb-4">
            <div class="card-header bg-dark-custom">
                <h3 class="card-title mb-0"><i class="fas fa-shopping-cart me-2"></i>Meu Carrinho</h3>
            </div>
            <div class="card-body">
                <?php if (empty($carrinho)): ?>
                    <div class="text-center py-5">
                        <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                        <h4>Seu carrinho está vazio</h4>
                        <p>Adicione produtos para continuar</p>
                        <a href="listar.php" class="btn btn-gold">Continuar Comprando</a>
                    </div>
                <?php else: ?>
                    <form method="POST">
                        <?php foreach ($carrinho as $index => $item): ?>
                            <?php
                            $subtotal = $item['preco'] * $item['quantidade'];
                            $total += $subtotal;
                            ?>
                            <div class="cart-item">
                                <div class="row">
                                    <div class="col-3">
                                        <?php if (!empty($item['imagem'])): ?>
                                            <img src="<?php echo $item['imagem']; ?>" class="img-fluid rounded" alt="<?php echo $item['nome']; ?>">
                                        <?php else: ?>
                                            <div class="bg-secondary rounded d-flex align-items-center justify-content-center" style="height: 100px;">
                                                <i class="fas fa-image fa-2x text-light"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-6">
                                        <h5><?php echo htmlspecialchars($item['nome']); ?></h5>
                                        <?php if (!empty($item['tamanho'])): ?>
                                            <div>Tamanho: <strong><?php echo $item['tamanho']; ?></strong></div>
                                        <?php endif; ?>
                                        <?php if (!empty($item['cor'])): ?>
                                            <div>Cor: <strong><?php echo $item['cor']; ?></strong></div>
                                        <?php endif; ?>
                                        <div class="price-tag">R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></div>
                                    </div>
                                    <div class="col-3">
                                        <div class="input-group mb-2">
                                            <input type="number" name="quantidade[<?php echo $index; ?>]" value="<?php echo $item['quantidade']; ?>" min="1" class="form-control">
                                        </div>
                                        <div class="d-grid">
                                            <a href="carrinho.php?remover=<?php echo $index; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Remover este item do carrinho?')">
                                                <i class="fas fa-trash me-1"></i>Remover
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <div class="d-flex justify-content-between mt-3">
                            <a href="listar.php" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Continuar Comprando
                            </a>
                            <button type="submit" name="atualizar_carrinho" class="btn btn-outline-primary">
                                <i class="fas fa-sync me-1"></i>Atualizar Carrinho
                            </button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header bg-dark-custom">
                <h3 class="card-title mb-0"><i class="fas fa-receipt me-2"></i>Resumo do Pedido</h3>
            </div>
            <div class="card-body">
                <?php if (!empty($carrinho)): ?>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span>R$ <?php echo number_format($total, 2, ',', '.'); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Frete:</span>
                        <span>Grátis</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total:</strong>
                        <strong class="price-tag">R$ <?php echo number_format($total, 2, ',', '.'); ?></strong>
                    </div>
                    
                    <div class="d-grid">
                        <a href="checkout.php" class="btn btn-gold btn-lg">
                            <i class="fas fa-check me-2"></i>Finalizar Compra
                        </a>
                    </div>
                <?php else: ?>
                    <p class="text-muted">Adicione produtos ao carrinho para ver o resumo</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'rodape.php'; ?>