<?php include 'cabecalho.php'; 

// Verifica se usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

require 'conexao.php';

// Busca dados do usuário
$sql = "SELECT * FROM usuarios WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $_SESSION['usuario_id']);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    session_destroy();
    header('Location: login.php');
    exit;
}

// Processa atualização do perfil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $endereco = $_POST['endereco'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $data_nascimento = $_POST['data_nascimento'] ?? '';
    
    // Verifica se email já existe (exceto para o próprio usuário)
    $sqlCheck = "SELECT id FROM usuarios WHERE email = :email AND id != :id";
    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->bindParam(':email', $email);
    $stmtCheck->bindParam(':id', $_SESSION['usuario_id']);
    $stmtCheck->execute();
    
    if ($stmtCheck->rowCount() > 0) {
        $erro = "Este email já está em uso por outro usuário.";
    } else {
        // Atualiza dados do usuário
        $sqlUpdate = "UPDATE usuarios SET nome = :nome, email = :email, endereco = :endereco, 
                     telefone = :telefone, data_nascimento = :data_nascimento WHERE id = :id";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->bindParam(':nome', $nome);
        $stmtUpdate->bindParam(':email', $email);
        $stmtUpdate->bindParam(':endereco', $endereco);
        $stmtUpdate->bindParam(':telefone', $telefone);
        $stmtUpdate->bindParam(':data_nascimento', $data_nascimento);
        $stmtUpdate->bindParam(':id', $_SESSION['usuario_id']);
        
        if ($stmtUpdate->execute()) {
            // Atualiza sessão
            $_SESSION['usuario_nome'] = $nome;
            $_SESSION['usuario_email'] = $email;
            
            $sucesso = "Perfil atualizado com sucesso!";
        } else {
            $erro = "Erro ao atualizar perfil. Tente novamente.";
        }
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-dark-custom">
                <h3 class="card-title mb-0"><i class="fas fa-user me-2"></i>Meu Perfil</h3>
            </div>
            <div class="card-body">
                <?php if (isset($sucesso)): ?>
                    <div class="alert alert-success"><?php echo $sucesso; ?></div>
                <?php endif; ?>
                
                <?php if (isset($erro)): ?>
                    <div class="alert alert-danger"><?php echo $erro; ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nome Completo *</label>
                            <input type="text" name="nome" class="form-control" 
                                   value="<?php echo htmlspecialchars($usuario['nome']); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="form-control" 
                                   value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                            <small class="text-muted">
                                <?php if ($usuario['tipo'] === 'admin'): ?>
                                    <i class="fas fa-shield-alt"></i> Conta Administrativa
                                <?php else: ?>
                                    <i class="fas fa-user"></i> Conta Cliente
                                <?php endif; ?>
                            </small>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Telefone</label>
                            <input type="tel" name="telefone" class="form-control" 
                                   value="<?php echo htmlspecialchars($usuario['telefone'] ?? ''); ?>"
                                   placeholder="(11) 99999-9999">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Data de Nascimento</label>
                            <input type="date" name="data_nascimento" class="form-control" 
                                   value="<?php echo $usuario['data_nascimento'] ?? ''; ?>">
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Endereço</label>
                        <textarea name="endereco" class="form-control" rows="3" 
                                  placeholder="Digite seu endereço completo"><?php echo htmlspecialchars($usuario['endereco'] ?? ''); ?></textarea>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Atualizar Perfil
                        </button>
                    </div>
                </form>
                
                <hr>
                
                <div class="row">
                    <div class="col-md-6">
                        <h5>Informações da Conta</h5>
                        <p><strong>Tipo:</strong> 
                            <span class="badge bg-<?php echo $usuario['tipo'] === 'admin' ? 'danger' : 'primary'; ?>">
                                <?php echo ucfirst($usuario['tipo']); ?>
                            </span>
                        </p>
                        <p><strong>Data de Criação:</strong> 
                            <?php echo date('d/m/Y', strtotime($usuario['data_criacao'])); ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h5>Ações</h5>
                        <a href="alterar_senha.php" class="btn btn-outline-primary btn-sm mb-2">
                            <i class="fas fa-key me-1"></i>Alterar Senha
                        </a>
                        <br>
                        <a href="trocar_perfil.php" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-sync me-1"></i>Trocar Tipo de Perfil
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="index.php" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Voltar para Início
                </a>
            </div>
        </div>
    </div>
</div>

<?php include 'rodape.php'; ?>