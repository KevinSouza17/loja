<?php
include 'cabecalho.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: listar.php');
    exit;
}

$id = $_GET['id'];

require 'conexao.php';

$sql = "SELECT * FROM produtos WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    header('Location: listar.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $preco = $_POST['preco'] ?? 0;
    $preco_promocional = $_POST['preco_promocional'] ?? null;
    $quantidade = $_POST['quantidade'] ?? 0;
    $categoria = $_POST['categoria'] ?? '';
    $tamanhos = $_POST['tamanhos'] ?? '';
    $cores = $_POST['cores'] ?? '';
    $destaque = isset($_POST['destaque']) ? 1 : 0;
    
    $sqlUpdate = "UPDATE produtos SET nome = :nome, descricao = :descricao, preco = :preco, 
                 preco_promocional = :preco_promocional, quantidade = :quantidade, categoria = :categoria,
                 tamanhos = :tamanhos, cores = :cores, destaque = :destaque WHERE id = :id";
    
    $stmtUpdate = $pdo->prepare($sqlUpdate);
    $stmtUpdate->bindParam(':nome', $nome);
    $stmtUpdate->bindParam(':descricao', $descricao);
    $stmtUpdate->bindParam(':preco', $preco);
    $stmtUpdate->bindParam(':preco_promocional', $preco_promocional);
    $stmtUpdate->bindParam(':quantidade', $quantidade);
    $stmtUpdate->bindParam(':categoria', $categoria);
    $stmtUpdate->bindParam(':tamanhos', $tamanhos);
    $stmtUpdate->bindParam(':cores', $cores);
    $stmtUpdate->bindParam(':destaque', $destaque);
    $stmtUpdate->bindParam(':id', $id);
    
    if ($stmtUpdate->execute()) {
        header('Location: listar.php?atualizado=1');
        exit;
    } else {
        $erro = "Erro ao atualizar produto.";
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-dark-custom">
                <h3 class="card-title mb-0"><i class="fas fa-edit me-2"></i>Editar Produto - Giorno</h3>
            </div>
            <div class="card-body">
                <?php if (isset($erro)): ?>
                    <div class="alert alert-danger"><?php echo $erro; ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nome do Produto</label>
                                <input type="text" name="nome" class="form-control" value="<?php echo htmlspecialchars($produto['nome']); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Categoria</label>
                                <select name="categoria" class="form-select" required>
                                    <option value="">Selecione uma categoria</option>
                                    <option value="masculino" <?php echo $produto['categoria'] == 'masculino' ? 'selected' : ''; ?>>Masculino</option>
                                    <option value="feminino" <?php echo $produto['categoria'] == 'feminino' ? 'selected' : ''; ?>>Feminino</option>
                                    <option value="infantil" <?php echo $produto['categoria'] == 'infantil' ? 'selected' : ''; ?>>Infantil</option>
                                    <option value="acessorios" <?php echo $produto['categoria'] == 'acessorios' ? 'selected' : ''; ?>>Acessórios</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Descrição do Produto</label>
                        <textarea name="descricao" class="form-control" rows="3"><?php echo htmlspecialchars($produto['descricao']); ?></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Preço (R$)</label>
                                <input type="number" step="0.01" name="preco" class="form-control" value="<?php echo $produto['preco']; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Preço Promocional (R$)</label>
                                <input type="number" step="0.01" name="preco_promocional" class="form-control" value="<?php echo $produto['preco_promocional']; ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Quantidade em Estoque</label>
                                <input type="number" name="quantidade" class="form-control" value="<?php echo $produto['quantidade']; ?>" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tamanhos Disponíveis (separados por vírgula)</label>
                                <input type="text" name="tamanhos" class="form-control" value="<?php echo $produto['tamanhos']; ?>" placeholder="Ex: P,M,G,GG">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Cores Disponíveis (separadas por vírgula)</label>
                                <input type="text" name="cores" class="form-control" value="<?php echo $produto['cores']; ?>" placeholder="Ex: Preto,Branco,Azul">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="destaque" value="1" id="destaqueCheck" <?php echo $produto['destaque'] ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="destaqueCheck">
                                Destacar este produto
                            </label>
                        </div>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-gold btn-lg">
                            <i class="fas fa-save me-2"></i>Atualizar Produto
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-muted">
                <a href="listar.php" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Voltar para a lista
                </a>
            </div>
        </div>
    </div>
</div>

<?php include 'rodape.php'; ?>