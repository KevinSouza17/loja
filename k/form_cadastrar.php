<?php
    include 'cabecalho.php';
?>
<body>
    <div class="container">
        <h2>Cadastrar Produto</h2>
    <form action="inserir.php" method="POST">
        <div class="mb-3">
            <input type="text" name="Produto" class="form-control" placeholder="Digite o nome do Produto">
        </div>
        <div class="mb-3">
            <input type="text" name="Preco" class="form-control" placeholder="Digite o preço do Produto">
        </div>
        <div class="mb-3">
            <input type="text" name="Estoque" class="form-control" placeholder="Digite a quantidade do Produto">
        </div>
        <button type="submit" class=btn btn-primary>Cadastrar</button>
    </form>
    
</body>
</html>