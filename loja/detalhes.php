<?php
// Iniciar sessão NO TOPO do arquivo
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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

// Processar adição ao carrinho
$sucesso_carrinho = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adicionar_carrinho'])) {
    // Verificar se quantidade foi enviada
    $quantidade = isset($_POST['quantidade']) ? max(1, intval($_POST['quantidade'])) : 1;
    $tamanho = $_POST['tamanho'] ?? '';
    $cor = $_POST['cor'] ?? '';
    
    $item = [
        'id' => $produto['id'],
        'nome' => $produto['nome'],
        'preco' => !empty($produto['preco_promocional']) ? $produto['preco_promocional'] : $produto['preco'],
        'quantidade' => $quantidade,
        'tamanho' => $tamanho,
        'cor' => $cor,
        'imagem' => $produto['imagem_principal']
    ];
    
    // Inicializar carrinho se não existir
    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }
    
    $_SESSION['carrinho'][] = $item;
    $sucesso_carrinho = true;
}

// SÓ DEPOIS inclui o cabeçalho
include 'cabecalho.php';
?>

<div class="row">
    <div class="col-md-6">
        <?php if (!empty($produto['imagem_principal'])): ?>
            <img src="<?php echo $produto['imagem_principal']; ?>" class="product-detail-image" alt="<?php echo $produto['nome']; ?>">
        <?php else: ?>
            <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 400px; border-radius: 8px;">
                <i class="fas fa-image fa-5x text-light"></i>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
        ;        <?php if ($sucesso_carrinho): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Produto adicionado ao carrinho com sucesso!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <h2 class="card-title"><?php echo htmlspecialchars($produto['nome']); ?></h2>
                
                <div class="mb-3">
                    <span class="badge bg-info"><?php echo ucfirst($produto['categoria']); ?></span>
                    <?php if ($produto['destaque']): ?>
                        <span class="badge bg-warning">Destaque</span>
                    <?php endif; ?>
                </div>
                
                <?php if (!empty($produto['descricao'])): ?>
                    <p class="card-text"><?php echo nl2br(htmlspecialchars($produto['descricao'])); ?></p>
                <?php endif; ?>
                
                <div class="mb-3">
                    <?php if (!empty($produto['preco_promocional']) && $produto['preco_promocional'] < $produto['preco']): ?>
                        <h3 class="price-tag">R$ <?php echo number_format($produto['preco_promocional'], 2, ',', '.'); ?></h3>
                        <span class="old-price">De: R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></span>
                    <?php else: ?>
                        <h3 class="price-tag">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></h3>
                    <?php endif; ?>
                </div>
                
                <form method="POST">
                    <?php if (!empty($produto['tamanhos'])): ?>
                        <div class="mb-3">
                            <label class="form-label">Tamanho:</label>
                            <div class="size-selector">
                                <?php
                                $tamanhos = explode(',', $produto['tamanhos']);
                                foreach ($tamanhos as $index => $tamanho):
                                    $tamanho = trim($tamanho);
                                    if (!empty($tamanho)):
                                ?>
                                    <div class="size-option <?php echo $index === 0 ? 'selected' : ''; ?>" data-value="<?php echo $tamanho; ?>"><?php echo $tamanho; ?></div>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
                                <input type="hidden" name="tamanho" id="tamanhoSelecionado" value="<?php echo !empty($tamanhos[0]) ? trim($tamanhos[0]) : ''; ?>" required>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($produto['cores'])): ?>
                        <div class="mb-3">
                            <label class="form-label">Cor:</label>
                            <div>
                                <?php
                                $cores = explode(',', $produto['cores']);
                                foreach ($cores as $index => $cor):
                                    $cor = trim($cor);
                                    if (!empty($cor)):
                                ?>
                                    <div class="color-option d-inline-block <?php echo $index === 0 ? 'selected' : ''; ?>" data-value="<?php echo $cor; ?>" style="background-color: <?php echo obterCorHex($cor); ?>" title="<?php echo $cor; ?>"></div>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
                                <input type="hidden" name="cor" id="corSelecionada" value="<?php echo !empty($cores[0]) ? trim($cores[0]) : ''; ?>" required>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="mb-3">
                        <label class="form-label">Quantidade:</label>
                        <input type="number" name="quantidade" class="form-control" value="1" min="1" max="<?php echo $produto['quantidade']; ?>" required>
                        <div class="form-text">Disponível: <?php echo $produto['quantidade']; ?> unidades</div>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" name="adicionar_carrinho" class="btn btn-gold btn-lg">
                            <i class="fas fa-shopping-cart me-2"></i>Adicionar ao Carrinho
                        </button>
                    </div>
                </form>
                
                <div class="mt-3">
                    <a href="listar.php?categoria=<?php echo $produto['categoria']; ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Voltar para a Lista
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Função auxiliar para obter código hexadecimal de cores comuns
function obterCorHex($cor) {
    $cores = [
        'preto' => '#000000',
        'branco' => '#FFFFFF',
        'vermelho' => '#FF0000',
        'azul' => '#0000FF',
        'verde' => '#00FF00',
        'amarelo' => '#FFFF00',
        'rosa' => '#FFC0CB',
        'roxo' => '#800080',
        'laranja' => '#FFA500',
        'cinza' => '#808080',
        'marrom' => '#A52A2A',
        'bege' => '#F5F5DC',
        'azul-marinho' => '#000080',
        'verde-oliva' => '#808000',
        'vinho' => '#800000',
        'caramelo' => '#D2691E'
    ];
    
    $cor = strtolower(trim($cor));
    return isset($cores[$cor]) ? $cores[$cor] : '#CCCCCC';
}
?>

<script>
    // Seleção de tamanho
    document.querySelectorAll('.size-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.size-option').forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');
            document.getElementById('tamanhoSelecionado').value = this.getAttribute('data-value');
        });
    });
    
    // Seleção de cor
    document.querySelectorAll('.color-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.color-option').forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');
            document.getElementById('corSelecionada').value = this.getAttribute('data-value');
        });
    });
</script>

<?php include 'rodape.php'; ?>