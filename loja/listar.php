<?php include 'cabecalho.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fas fa-list me-2"></i>Lista de Produtos - Giorno</h2>
    <a href="form_cadastrar.php" class="btn btn-gold">
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

// Filtrar por categoria se especificado
$categoria_filtro = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$where = '';
$params = [];

if (!empty($categoria_filtro)) {
    $where = "WHERE categoria = :categoria";
    $params[':categoria'] = $categoria_filtro;
}
?>

<div class="card shadow">
    <div class="card-body">
        <?php if (!empty($categoria_filtro)): ?>
            <div class="alert alert-info">
                Mostrando produtos da categoria: <strong><?php echo ucfirst($categoria_filtro); ?></strong>
                <a href="listar.php" class="float-end">Ver todos os produtos</a>
            </div>
        <?php endif; ?>
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">IMAGEM</th>
                        <th scope="col">NOME</th>
                        <th scope="col">CATEGORIA</th>
                        <th scope="col">PREÇO (R$)</th>
                        <th scope="col">ESTOQUE</th>
                        <th scope="col" class="text-center">AÇÕES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require 'conexao.php';
                    
                    $sql = "SELECT * FROM produtos $where ORDER BY id DESC";
                    $stmt = $pdo->prepare($sql);
                    
                    foreach ($params as $key => $value) {
                        $stmt->bindValue($key, $value);
                    }
                    
                    $stmt->execute();
                    
                    if ($stmt->rowCount() > 0) {
                        while ($produto = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<tr>";
                            echo "<td>" . $produto['id'] . "</td>";
                            
                            // Imagem do produto
                            if (!empty($produto['imagem_principal'])) {
                                echo "<td><img src='" . $produto['imagem_principal'] . "' width='50' height='50' style='object-fit: cover;'></td>";
                            } else {
                                echo "<td><div class='bg-secondary rounded' style='width: 50px; height: 50px;'></div></td>";
                            }
                            
                            echo "<td>" . htmlspecialchars($produto['nome']) . "</td>";
                            echo "<td><span class='badge bg-info'>" . ucfirst($produto['categoria']) . "</span></td>";
                            
                            // Preço com possível desconto
                            if (!empty($produto['preco_promocional']) && $produto['preco_promocional'] < $produto['preco']) {
                                echo "<td>
                                        <span class='old-price'>R$ " . number_format($produto['preco'], 2, ',', '.') . "</span><br>
                                        <span class='price-tag'>R$ " . number_format($produto['preco_promocional'], 2, ',', '.') . "</span>
                                      </td>";
                            } else {
                                echo "<td class='price-tag'>R$ " . number_format($produto['preco'], 2, ',', '.') . "</td>";
                            }
                            
                            // Estoque
                            $estoque_class = $produto['quantidade'] > 10 ? 'bg-success' : ($produto['quantidade'] > 0 ? 'bg-warning' : 'bg-danger');
                            echo "<td><span class='badge $estoque_class'>" . $produto['quantidade'] . "</span></td>";
                            
                            // Ações
                            echo "<td class='text-center'>";
                            echo "<div class='btn-group' role='group'>";
                            echo "<a href='detalhes.php?id=" . $produto['id'] . "' class='btn btn-sm btn-info me-1'>";
                            echo "<i class='fas fa-eye me-1'></i>Ver</a>";
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
                        echo "<tr><td colspan='7' class='text-center py-4'>Nenhum produto cadastrado. <a href='form_cadastrar.php'>Cadastre o primeiro produto</a></td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="inicio.php" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-1"></i>Voltar para o Inicio
    </a>
</div>

<?php include 'rodape.php'; ?>