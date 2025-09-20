<?php include 'cabecalho.php'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-dark-custom">
                <h3 class="card-title mb-0"><i class="fas fa-plus-circle me-2"></i>Cadastro de Produto - Giorno</h3>
            </div>
            <div class="card-body">
                <?php
                if (isset($_GET['erro'])) {
                    $erro = $_GET['erro'];
                    if ($erro == 1) {
                        echo '<div class="alert alert-danger">Preencha todos os campos corretamente.</div>';
                    } else if ($erro == 2) {
                        echo '<div class="alert alert-danger">Erro ao cadastrar produto. Tente novamente.</div>';
                    }
                }
                
                if (isset($_GET['sucesso']) && $_GET['sucesso'] == 1) {
                    echo '<div class="alert alert-success">Produto cadastrado com sucesso!</div>';
                }
                ?>
                
                <form action="inserir.php" method="POST" class="mt-3" autocomplete="off" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nome do Produto</label>
                                <input type="text" name="nome" class="form-control" placeholder="Digite o nome do produto" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Categoria</label>
                                <select name="categoria" class="form-select" required>
                                    <option value="">Selecione uma categoria</option>
                                    <option value="masculino">Masculino</option>
                                    <option value="feminino">Feminino</option>
                                    <option value="infantil">Infantil</option>
                                    <option value="acessorios">Acessórios</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Descrição do Produto</label>
                        <textarea name="descricao" class="form-control" rows="3" placeholder="Digite a descrição do produto"></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Preço (R$)</label>
                                <input type="number" step="0.01" name="preco" class="form-control" placeholder="Digite o preço" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Preço Promocional (R$)</label>
                                <input type="number" step="0.01" name="preco_promocional" class="form-control" placeholder="Preço com desconto (opcional)">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Quantidade em Estoque</label>
                                <input type="number" name="quantidade" class="form-control" placeholder="Digite a quantidade" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tamanhos Disponíveis (separados por vírgula)</label>
                                <input type="text" name="tamanhos" class="form-control" placeholder="Ex: P,M,G,GG">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Cores Disponíveis (separadas por vírgula)</label>
                                <input type="text" name="cores" class="form-control" placeholder="Ex: Preto,Branco,Azul">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Imagem Principal</label>
                        <input type="file" name="imagem_principal" class="form-control" accept="image/*">
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="destaque" value="1" id="destaqueCheck">
                            <label class="form-check-label" for="destaqueCheck">
                                Destacar este produto
                            </label>
                        </div>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-gold btn-lg">
                            <i class="fas fa-save me-2"></i>Cadastrar Produto
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-muted">
                <a href="listar.php" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Voltar para a lista
                </a>
            </div>
        </div>
    </div>
</div>

<?php include 'rodape.php'; ?>