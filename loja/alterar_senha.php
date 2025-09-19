<?php include 'cabecalho.php'; 

// Verifica se usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit;
}

require 'conexao.php';

// Processa alteração de senha
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $senha_atual = $_POST['senha_atual'] ?? '';
    $nova_senha = $_POST['nova_senha'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';
    
    // Busca usuário
    $sql = "SELECT senha FROM usuarios WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $_SESSION['usuario_id']);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$usuario || !password_verify($senha_atual, $usuario['senha'])) {
        $erro = "Senha atual incorreta.";
    } elseif ($nova_senha !== $confirmar_senha) {
        $erro = "As novas senhas não coincidem.";
    } elseif (strlen($nova_senha) < 6) {
        $erro = "A nova senha deve ter pelo menos 6 caracteres.";
    } else {
        $nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
        
        $sqlUpdate = "UPDATE usuarios SET senha = :senha WHERE id = :id";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->bindParam(':senha', $nova_senha_hash);
        $stmtUpdate->bindParam(':id', $_SESSION['usuario_id']);
        
        if ($stmtUpdate->execute()) {
            $sucesso = "Senha alterada com sucesso!";
        } else {
            $erro = "Erro ao alterar senha. Tente novamente.";
        }
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-dark-custom">
                <h3 class="card-title mb-0"><i class="fas fa-key me-2"></i>Alterar Senha</h3>
            </div>
            <div class="card-body">
                <?php if (isset($sucesso)): ?>
                    <div class="alert alert-success"><?php echo $sucesso; ?></div>
                <?php endif; ?>
                
                <?php if (isset($erro)): ?>
                    <div class="alert alert-danger"><?php echo $erro; ?></div>
                <?php endif; ?>
                
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Senha Atual *</label>
                        <input type="password" name="senha_atual" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Nova Senha *</label>
                        <input type="password" name="nova_senha" class="form-control" 
                               placeholder="Mínimo 6 caracteres" required minlength="6">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Confirmar Nova Senha *</label>
                        <input type="password" name="confirmar_senha" class="form-control" required>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Alterar Senha
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <a href="perfil.php" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Voltar ao Perfil
                </a>
            </div>
        </div>
    </div>
</div>

<?php include 'rodape.php'; ?>