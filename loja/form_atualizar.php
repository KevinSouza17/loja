<?php
include 'cabecalho.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: listar.php');
    exit;
}

$id = $_GET['id'];

require 'conexao.php';

// Verifica se a tabela existe
$tableExists = $pdo->query("SHOW TABLES LIKE 'produtos'")->rowCount() > 0;

if ($tableExists) {
    $sql = "SELECT * FROM produtos WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$produto) {
        header('Location: listar.php');
        exit;
    }
} else {
    header('Location: listar.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $preco = $_POST['preco'] ?? 0;
    $quantidade = $_POST['quantidade'] ?? 0;
    $tamanho = $_POST['tamanho'] ?? '';
    $categoria = $_POST['categoria'] ?? '';
    $cor = $_POST['cor'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    
    $sqlUpdate = "UPDATE produtos SET nome = :nome, preco = :preco, quantidade = :quantidade, 
                 tamanho = :tamanho, categoria = :categoria, cor = :cor, descricao = :descricao 
                 WHERE id = :id";
    $stmtUpdate = $pdo->prepare($sqlUpdate);
    $stmtUpdate->bindParam(':nome', $nome);
    $stmtUpdate->bindParam(':preco', $preco);
    $stmtUpdate->bindParam(':quantidade', $quantidade);
    $stmtUpdate->bindParam(':tamanho', $tamanho);
    $stmtUpdate->bindParam(':categoria', $categoria);
    $stmtUpdate->bindParam(':cor', $cor);
    $stmtUpdate->bindParam(':descricao', $descricao);
    $stmtUpdate->bindParam(':id', $id);
    
    if ($stmtUpdate->execute()) {
        header('Location: listar.php?atualizado=1');
        exit;
    } else {
        $erro = "Erro ao atualizar roupa.";
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-dark-custom">
                <h3 class="card-title mb-0"><i class="fas fa-edit me-2"></i>Editar Roupa</h3>
            </div>
            <div class="card-body">
                <?php if (isset($erro)): ?>
                    <div class="alert alert-danger"><?php echo $erro; ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nome da Roupa</label>
                            <input type="text" name="nome" class="form-control" value="<?php echo htmlspecialchars($produto['nome']); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Preço (R$)</label>
                            <input type="number" step="0.01" name="preco" class="form-control" value="<?php echo $produto['preco']; ?>" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Quantidade em Estoque</label>
                            <input type="number" name="quantidade" class="form-control" value="<?php echo $produto['quantidade']; ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tamanho</label>
                            <select name="tamanho" class="form-select" required>
                                <option value="P" <?php echo $produto['tamanho'] == 'P' ? 'selected' : ''; ?>>P</option>
                                <option value="M" <?php echo $produto['tamanho'] == 'M' ? 'selected' : ''; ?>>M</option>
                                <option value="G" <?php echo $produto['tamanho'] == 'G' ? 'selected' : ''; ?>>G</option>
                                <option value="GG" <?php echo $produto['tamanho'] == 'GG' ? 'selected' : ''; ?>>GG</option>
                                <option value="XG" <?php echo $produto['tamanho'] == 'XG' ? 'selected' : ''; ?>>XG</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Cor</label>
                            <input type="text" name="cor" class="form-control" value="<?php echo htmlspecialchars($produto['cor']); ?>" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Categoria</label>
                            <select name="categoria" class="form-select" required>
                                <option value="Camisetas" <?php echo $produto['categoria'] == 'Camisetas' ? 'selected' : ''; ?>>Camisetas</option>
                                <option value="Calças" <?php echo $produto['categoria'] == 'Calças' ? 'selected' : ''; ?>>Calças</option>
                                <option value="Vestidos" <?php echo $produto['categoria'] == 'Vestidos' ? 'selected' : ''; ?>>Vestidos</option>
                                <option value="Blusas" <?php echo $produto['categoria'] == 'Blusas' ? 'selected' : ''; ?>>Blusas</option>
                                <option value="Casacos" <?php echo $produto['categoria'] == 'Casacos' ? 'selected' : ''; ?>>Casacos</option>
                                <option value="Acessórios" <?php echo $produto['categoria'] == 'Acessórios' ? 'selected' : ''; ?>>Acessórios</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Descrição</label>
                            <textarea name="descricao" class="form-control" rows="1"><?php echo htmlspecialchars($produto['descricao']); ?></textarea>
                        </div>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Atualizar Roupa
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-muted">
                <a href="listar.php" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Voltar para o catálogo
                </a>
            </div>
        </div>
    </div>
</div>

<?php include 'rodape.php'; ?>