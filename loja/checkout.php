<?php
// Iniciar sessão NO TOPO do arquivo
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirecionar se o carrinho estiver vazio ANTES de qualquer output
if (empty($_SESSION['carrinho'])) {
    header('Location: carrinho.php');
    exit;
}

// Processar finalização de pedido
$erro = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'conexao.php';
    
    // Calcular total
    $total = 0;
    foreach ($_SESSION['carrinho'] as $item) {
        $total += $item['preco'] * $item['quantidade'];
    }
    
    // Inserir pedido
    $sql = "INSERT INTO pedidos (cliente_id, total, endereco_entrega, metodo_pagamento) 
            VALUES (:cliente_id, :total, :endereco, :metodo_pagamento)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':cliente_id', null);
    $stmt->bindParam(':total', $total);
    $stmt->bindParam(':endereco', $_POST['endereco']);
    $stmt->bindParam(':metodo_pagamento', $_POST['metodo_pagamento']);
    
    if ($stmt->execute()) {
        $pedido_id = $pdo->lastInsertId();
        
        // Inserir itens do pedido
        $sql_itens = "INSERT INTO pedido_itens (pedido_id, produto_id, quantidade, preco_unitario, tamanho, cor) 
                      VALUES (:pedido_id, :produto_id, :quantidade, :preco_unitario, :tamanho, :cor)";
        
        $stmt_itens = $pdo->prepare($sql_itens);
        
        foreach ($_SESSION['carrinho'] as $item) {
            $stmt_itens->bindValue(':pedido_id', $pedido_id);
            $stmt_itens->bindValue(':produto_id', $item['id']);
            $stmt_itens->bindValue(':quantidade', $item['quantidade']);
            $stmt_itens->bindValue(':preco_unitario', $item['preco']);
            $stmt_itens->bindValue(':tamanho', $item['tamanho']);
            $stmt_itens->bindValue(':cor', $item['cor']);
            $stmt_itens->execute();
        }
        
        // Limpar carrinho
        unset($_SESSION['carrinho']);
        
        // Redirecionar para página de sucesso
        header('Location: pedido_sucesso.php?id=' . $pedido_id);
        exit;
    } else {
        $erro = "Erro ao processar pedido. Tente novamente.";
    }
}

// SÓ DEPOIS inclui o cabeçalho
include 'cabecalho.php';
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <!-- ... restante do código HTML ... -->

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-dark-custom">
                <h3 class="card-title mb-0"><i class="fas fa-check-circle me-2"></i>Finalizar Compra</h3>
            </div>
            <div class="card-body">
                <?php if (isset($erro)): ?>
                    <div class="alert alert-danger"><?php echo $erro; ?></div>
                <?php endif; ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="mb-3">Resumo do Pedido</h4>
                        <div class="card mb-4">
                            <div class="card-body">
                                <?php
                                $total = 0;
                                foreach ($_SESSION['carrinho'] as $item):
                                    $subtotal = $item['preco'] * $item['quantidade'];
                                    $total += $subtotal;
                                ?>
                                    <div class="d-flex justify-content-between mb-2">
                                        <div>
                                            <strong><?php echo $item['quantidade']; ?>x</strong> <?php echo htmlspecialchars($item['nome']); ?>
                                            <?php if (!empty($item['tamanho'])): ?>
                                                <br><small>Tamanho: <?php echo $item['tamanho']; ?></small>
                                            <?php endif; ?>
                                            <?php if (!empty($item['cor'])): ?>
                                                <br><small>Cor: <?php echo $item['cor']; ?></small>
                                            <?php endif; ?>
                                        </div>
                                        <div>R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></div>
                                    </div>
                                <?php endforeach; ?>
                                
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <strong>Total:</strong>
                                    <strong class="price-tag">R$ <?php echo number_format($total, 2, ',', '.'); ?></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <h4 class="mb-3">Informações de Entrega</h4>
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Nome Completo</label>
                                <input type="text" name="nome" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">E-mail</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Telefone</label>
                                <input type="tel" name="telefone" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Endereço de Entrega</label>
                                <textarea name="endereco" class="form-control" rows="3" required></textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Método de Pagamento</label>
                                <select name="metodo_pagamento" class="form-select" required>
                                    <option value="">Selecione...</option>
                                    <option value="cartao_credito">Cartão de Crédito</option>
                                    <option value="cartao_debito">Cartão de Débito</option>
                                    <option value="pix">PIX</option>
                                    <option value="boleto">Boleto Bancário</option>
                                </select>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-gold btn-lg">
                                    <i class="fas fa-check me-2"></i>Finalizar Pedido
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'rodape.php'; ?>