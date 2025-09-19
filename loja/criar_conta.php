<?php include 'cabecalho.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-dark-custom">
                <h3 class="card-title mb-0"><i class="fas fa-user-plus me-2"></i>Criar Conta</h3>
            </div>
            <div class="card-body">
                <?php
                if (isset($_GET['erro'])) {
                    $erro = $_GET['erro'];
                    if ($erro == 1) {
                        echo '<div class="alert alert-danger">Preencha todos os campos.</div>';
                    } else if ($erro == 2) {
                        echo '<div class="alert alert-danger">Email já cadastrado.</div>';
                    } else if ($erro == 3) {
                        echo '<div class="alert alert-danger">Erro ao criar conta. Tente novamente.</div>';
                    }
                }
                ?>
                
                <form action="processa_criar_conta.php" method="POST" class="mt-3">
                    <div class="mb-3">
                        <label class="form-label">Nome Completo</label>
                        <input type="text" name="nome" class="form-control" placeholder="Seu nome completo" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Seu email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Senha</label>
                        <input type="password" name="senha" class="form-control" placeholder="Mínimo 6 caracteres" required minlength="6">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-user-plus me-2"></i>Criar Conta
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-muted">
                <p class="mb-0">Já tem uma conta? <a href="login.php">Faça login aqui</a></p>
            </div>
        </div>
    </div>
</div>

<?php include 'rodape.php'; ?>