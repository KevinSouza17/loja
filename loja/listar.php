<?php include 'cabecalho.php'; 

// Verifica se usuário é admin
if (!isset($_SESSION['usuario_tipo']) || $_SESSION['usuario_tipo'] !== 'admin') {
    header('Location: index.php');
    exit;
}
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-list me-2"></i>Gerenciar Produtos</h2>
    <a href="form_cadastrar.php" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i>Novo Produto
    </a>
</div>

<?php
if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sucesso!</strong> Produto cadastrado com êxito.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
}

if (isset($_GET['atualizado']) && $_GET['atualizado'] == 1) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sucesso!</strong> Produto atualizado com êxito.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
}

if (isset($_GET['excluido']) && $_GET['excluido'] == 1) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sucesso!</strong> Produto excluído com êxito.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
}
?>

<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">NOME</th>
                        <th scope="col">PREÇO (R$)</th>
                        <th scope="col">ESTOQUE</th>
                        <th scope="col">TAMANHO</th>
                        <th scope="col">CATEGORIA</th>
                        <th scope="col">COR</th>
                        <th scope="col" class="text-center">AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require 'conexao.php';
                    
                    $sql = "SELECT * FROM produtos ORDER BY id DESC";
                    $stmt = $pdo->query($sql);
                    
                    if ($stmt->rowCount() > 0) {
                        while ($produto = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . $produto['id'] . "</td>";
                            echo "<td>" . htmlspecialchars($produto['nome']) . "</td>";
                            echo "<td>R$ " . number_format($produto['preco'], 2, ',', '.') . "</td>";
                            echo "<td>" . $produto['quantidade'] . "</td>";
                            echo "<td>" . $produto['tamanho'] . "</td>";
                            echo "<td>" . $produto['categoria'] . "</td>";
                            echo "<td>" . $produto['cor'] . "</td>";
                            echo "<td class='text-center'>";
                            echo "<div class='btn-group' role='group'>";
                            echo "<a href='form_atualizar.php?id=" . $produto['id'] . "' class='btn btn-sm btn-warning me-1'>";
                            echo "<i class='fas fa-edit me-1'></i>Editar</a>";
                            echo "<a href='delete.php?id=" . $produto['id'] . "' class='btn btn-sm btn-danger' 
                                  onclick='return confirm(\"Tem certeza que deseja excluir este produto?\")'>";
                            echo "<i class='fas fa-trash me-1'></i>Excluir</a>";
                            echo "</div>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8' class='text-center py-4'>Nenhum produto cadastrado.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="index.php" class="btn btn-outline-light">
        <i class="fas fa-arrow-left me-1"></i>Voltar para o Início
    </a>
</div>

<?php include 'rodape.php'; ?>