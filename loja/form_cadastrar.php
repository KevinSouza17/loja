<?php include 'cabecalho.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-dark-custom">
                <h3 class="card-title mb-0"><i class="fas fa-plus-circle me-2"></i>Cadastro de Roupa</h3>
            </div>
            <div class="card-body">
                <?php
                if (isset($_GET['erro'])) {
                    $erro = $_GET['erro'];
                    if ($erro == 1) {
                        echo '<div class="alert alert-danger">Preencha todos os campos corretamente.</div>';
                    } else if ($erro == 2) {
                        echo '<div class="alert alert-danger">Erro ao cadastrar roupa. Tente novamente.</div>';
                    }
                }
                ?>
                
                <form action="inserir.php" method="POST" class="mt-3" autocomplete="off">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nome da Roupa</label>
                            <input type="text" name="nome" class="form-control" placeholder="Ex: Camiseta Básica" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Preço (R$)</label>
                            <input type="number" step="0.01" name="preco" class="form-control" placeholder="Digite o preço" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Quantidade em Estoque</label>
                            <input type="number" name="quantidade" class="form-control" placeholder="Digite a quantidade" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tamanho</label>
                            <select name="tamanho" class="form-select" required>
                                <option value="">Selecione</option>
                                <option value="P">P</option>
                                <option value="M">M</option>
                                <option value="G">G</option>
                                <option value="GG">GG</option>
                                <option value="XG">XG</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Cor</label>
                            <input type="text" name="cor" class="form-control" placeholder="Ex: Preto, Azul, etc." required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Categoria</label>
                            <select name="categoria" class="form-select" required>
                                <option value="">Selecione</option>
                                <option value="Camisetas">Camisetas</option>
                                <option value="Calças">Calças</option>
                                <option value="Vestidos">Vestidos</option>
                                <option value="Blusas">Blusas</option>
                                <option value="Casacos">Casacos</option>
                                <option value="Acessórios">Acessórios</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Descrição</label>
                            <textarea name="descricao" class="form-control" placeholder="Descrição do produto" rows="1"></textarea>
                        </div>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Cadastrar Roupa
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-muted">
                <a href="listar.php" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Voltar para o catálogo
                </a>
            </div>
        </div>
    </div>
</div>

<?php include 'rodape.php'; ?>