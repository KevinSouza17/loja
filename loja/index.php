<?php include 'cabecalho.php'; ?>

<div class="row">
    <div class="col-md-8 mx-auto text-center">
        <div class="mb-4">
            <i class="fas fa-shirt fa-4x mb-3" style="color: #000;"></i>
            <h1>Bem-vindo à Giorno</h1>
            <p class="lead">Sua loja de roupas elegantes e modernas</p>
            <p>Estilo italiano com qualidade brasileira</p>
        </div>
        
        <?php if (!isset($_SESSION['usuario_id'])): ?>
            <div class="alert alert-info">
                <h5>Faça login para acessar o catálogo completo</h5>
                <div class="mt-3">
                    <a href="login.php" class="btn btn-primary me-2">Fazer Login</a>
                    <a href="criar_conta.php" class="btn btn-outline-dark">Criar Conta</a>
                </div>
            </div>
        <?php else: ?>
            <div class="row mt-5">
                <div class="col-md-6 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <i class="fas fa-shirt fa-2x mb-3"></i>
                            <h5>Catálogo</h5>
                            <p>Explore nossa coleção de roupas</p>
                            <a href="catalogo.php" class="btn btn-primary">Ver Catálogo</a>
                        </div>
                    </div>
                </div>
                
                <?php if ($_SESSION['usuario_tipo'] === 'cliente'): ?>
                    <div class="col-md-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <i class="fas fa-shopping-cart fa-2x mb-3"></i>
                                <h5>Meu Carrinho</h5>
                                <p>Gerencie seus itens selecionados</p>
                                <a href="carrinho.php" class="btn btn-primary">Ver Carrinho</a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="col-md-6 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <i class="fas fa-cog fa-2x mb-3"></i>
                                <h5>Painel Admin</h5>
                                <p>Gerencie produtos e estoque</p>
                                <a href="listar.php" class="btn btn-primary">Gerenciar</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'rodape.php'; ?>