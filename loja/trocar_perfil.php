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

// Processa troca de perfil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novo_tipo = $_POST['tipo'] ?? '';
    $senha_confirmacao = $_POST['senha_confirmacao'] ?? '';
    
    // Verifica se pode trocar para admin
    if ($novo_tipo === 'admin') {
        if (!isEmailAdmin($usuario['email'])) {
            $erro = "Seu email não está autorizado para acesso administrativo. 
                    Use um email com domínio @giorno.com";
        } elseif (!password_verify($senha_confirmacao, $usuario['senha'])) {
            $erro = "Senha incorreta. Confirme sua senha para virar administrador.";
        } else {
            // Atualiza para admin
            $sqlUpdate = "UPDATE usuarios SET tipo = 'admin' WHERE id = :id";
            $stmtUpdate = $pdo->prepare($sqlUpdate);
            $stmtUpdate->bindParam(':id', $_SESSION['usuario_id']);
            
            if ($stmtUpdate->execute()) {
                $_SESSION['usuario_tipo'] = 'admin';
                $sucesso = "Perfil alterado para Administrador com sucesso!";
            } else {
                $erro = "Erro ao alterar perfil.";
            }
        }
    } else {
        // Troca para cliente (sempre permitido)
        $sqlUpdate = "UPDATE usuarios SET tipo = 'cliente' WHERE id = :id";
        $stmtUpdate = $pdo->prepare($sqlUpdate);
        $stmtUpdate->bindParam(':id', $_SESSION['usuario_id']);
        
        if ($stmtUpdate->execute()) {
            $_SESSION['usuario_tipo'] = 'cliente';
            
            // Limpa carrinho se estava como admin
            if (isset($_SESSION['carrinho'])) {
                unset($_SESSION['carrinho']);
            }
            
            $sucesso = "Perfil alterado para Cliente com sucesso!";
        } else {
            $erro = "Erro ao alterar perfil.";
        }
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-dark-custom">
                <h3 class="card-title mb-0"><i class="fas fa-sync me-2"></i>Trocar Tipo de Perfil</h3>
            </div>
            <div class="card-body">
                <?php if (isset($sucesso)): ?>
                    <div class="alert alert-success"><?php echo $sucesso; ?></div>
                <?php endif; ?>
                
                <?php if (isset($erro)): ?>
                    <div class="alert alert-danger"><?php echo $erro; ?></div>
                <?php endif; ?>
                
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle"></i> Informações:</h6>
                    <ul class="mb-0">
                        <li>Para virar <strong>Administrador</strong>, seu email deve terminar com <code>@giorno.com</code></li>
                        <li>Administradores têm acesso ao painel de gerenciamento</li>
                        <li>Clientes têm acesso ao catálogo e carrinho de compras</li>
                    </ul>
                </div>
                
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Seu Email Atual</label>
                        <input type="email" class="form-control" 
                               value="<?php echo htmlspecialchars($usuario['email']); ?>" disabled>
                        <small class="text-muted">
                            Domínio: <?php echo isEmailAdmin($usuario['email']) ? 
                            '<span class="text-success">Autorizado para Admin</span>' : 
                            '<span class="text-warning">Não autorizado para Admin</span>'; ?>
                        </small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Selecionar Tipo de Perfil *</label>
                        <select name="tipo" class="form-select" required>
                            <option value="cliente" <?php echo $usuario['tipo'] === 'cliente' ? 'selected' : ''; ?>>
                                Cliente - Acesso ao catálogo e compras
                            </option>
                            <option value="admin" <?php echo $usuario['tipo'] === 'admin' ? 'selected' : ''; ?>
                                    <?php echo !isEmailAdmin($usuario['email']) ? 'disabled' : ''; ?>>
                                Administrador - Acesso completo ao sistema
                            </option>
                        </select>
                    </div>
                    
                    <div class="mb-3" id="senha-admin" style="display: none;">
                        <label class="form-label">Confirme sua Senha *</label>
                        <input type="password" name="senha_confirmacao" class="form-control" 
                               placeholder="Digite sua senha atual">
                        <small class="text-muted">Necessário para confirmar acesso administrativo</small>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-sync me-2"></i>Trocar Perfil
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

<script>
// Mostra campo de senha apenas quando selecionar admin
document.querySelector('select[name="tipo"]').addEventListener('change', function() {
    const senhaDiv = document.getElementById('senha-admin');
    if (this.value === 'admin') {
        senhaDiv.style.display = 'block';
    } else {
        senhaDiv.style.display = 'none';
    }
});

// Inicializa visibilidade do campo de senha
document.addEventListener('DOMContentLoaded', function() {
    const tipoSelect = document.querySelector('select[name="tipo"]');
    const senhaDiv = document.getElementById('senha-admin');
    if (tipoSelect.value === 'admin') {
        senhaDiv.style.display = 'block';
    }
});
</script>

<?php include 'rodape.php'; ?>