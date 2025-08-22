<?php
    require 'conexao.php';
    $sql = "SELECT * FROM produtos";
    $stmt = $pdo->query($sql);
    while ($produto = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" .$produto['id'] . "</td>";
        echo "<td>" .$produto['nome'] . "</td>";
        echo "<td>" .$produto['preco'] . "</td>";
        echo "<td>" .$produto['quantidade'] . "</td>";
        echo "<td>"
                <div class='btn-group' role='group'>
                    <a href='#' type='button' class='btn btn-success'>atualizar</a>
                    <ahref='#'type='button'class='btnbtn-outline-danger'for='vbtn-radio2'>apagar</a>
                </div>
            "</td>";
        echo "</tr>";


    echo "ID: " . $produto['id'] . "<br>";
    echo "Nome: " . $produto['nome'] . "<br>";
    echo "Preço: R$" . $produto['preco'] . "<br>";
    echo "Estoque: " . $produto['estoque'] . "<br><br>";
}

    include 'cabecalho.php';
?>
<body>
    <div class="container">
        <h1>Bem vindo ao 1º Sistema com CRUD</h1>
        <h2>Kevin Flamenguista</h2>
    </div>
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">NOME</th>
                    <th scope="col">PREÇO</th>
                    <th scope="col">QUANTIDADE</th>
                    <th scope="col">OPÇÕES  </th>
                </tr>
                
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>latte machiatto</td>
                    <td>R$15,00</td>
                    <td>1</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                            <a href="#" type="button" class="btn btn-success">atualizar</a>
                            <a href="#" type="button" class="btn btn-outline-danger" for="vbtn-radio2">apagar</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>#</td>
                    <td>R$15,00</td>
                    <td>1</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                            <a href="#" type="button" class="btn btn-success">atualizar</a>
                            <a href="#" type="button" class="btn btn-outline-danger" for="vbtn-radio2">apagar</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>#</td>
                    <td>R$15,00</td>
                    <td>1</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                            <a href="#" type="button" class="btn btn-success">atualizar</a>
                            <a href="#" type="button" class="btn btn-outline-danger" for="vbtn-radio2">apagar</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">4</th>
                    <td>#</td>
                    <td>R$15,00</td>
                    <td>1</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                            <a href="#" type="button" class="btn btn-success">atualizar</a>
                            <a href="#" type="button" class="btn btn-outline-danger" for="vbtn-radio2">apagar</a>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row">5</th>
                    <td>#</td>
                    <td>R$15,00</td>
                    <td>1</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                            <a href="#" type="button" class="btn btn-success">atualizar</a>
                            <a href="#" type="button" class="btn btn-outline-danger" for="vbtn-radio2">apagar</a>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</body>