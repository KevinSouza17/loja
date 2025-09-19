<?php include 'cabecalho.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-dark-custom">
                <h3 class="card-title mb-0"><i class="fas fa-sign-in-alt me-2"></i>Login</h3>
            </div>
            <div class="card-body">
                <?php
                if (isset($_GET['erro'])) {
                    $erro = $_GET['erro'];
                    if ($erro == 1) {
                        echo '<div class="alert alert-danger">Email ou senha incorretos.</div>';
                    } else if ($erro == 2) {
                        echo '<div class="alert alert-danger">Preencha todos os campos.</div>';
                    }
                }
                
                if (isset($_GET['sucesso'])) {
                    echo '<div class="alert alert-success">Conta criada com sucesso! Faça login.</div>';
                }
                ?>
                
                <form action="processa_login.php" method="POST" class="mt-3">
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Seu email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Senha</label>
                        <input type="password" name="senha" class="form-control" placeholder="Sua senha" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>Entrar
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-muted">
                <p class="mb-0">Não tem uma conta? <a href="criar_conta.php">Crie uma aqui</a></p>
            </div>
        </div>
    </div>
</div>

<?php include 'rodape.php'; ?>