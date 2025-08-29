<?php
    include "cabecalho.php"
?>
<Body>
    <div class="container">
        <h1>
            Sistema CRUD
        </h1>
        <table class="table">
            <thead>
                <tr>
                <th scope="col">ID</th>
                <th scope="col">NOME</th>
                <th scope="col">PREÇO</th>
                <th scope="col">QUANTIDADE</th>
                <th scope="col">OPÇÕES</th>
                </tr>
            </thead>
            <tbody>

            <?php
                require 'conexao.php';
                $sql = "SELECT * FROM produtos";
                $stmt = $pdo->query($sql);
                while ($produto = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    var_dump($produto); 
                    echo"<tr";
                    echo"<td>".$produto['id']."</td>";
                    echo"<td>".$produto['nome']."</td>";
                    echo"<td>".$produto['preco']."</td>";
                    echo"<td>".$produto['quantidade']."</td>";
                    echo"
                    <td>
                        <div class='btn-group' role='group' aria-label='Basic mixed styles example'>
                            <a href = 'form_atualizar.php?id=".$produto['id']."'type='button' class='btn btn-warning'>Atualizar</a>
                            <a href = '#'type='button' class='btn btn-danger'>Apagar</a>
                        </div>
                    </td>
                    ";
                    echo"</tr>  ";
                }
            ?>
            
            </tbody>
        </table>
        <a href = "index.php"type="button" class="btn btn-danger">voltar</a>

        <!-- SELECT * FROM produtos WHERE id = 1;
        UPDATE produtos SET nome = "NOVO NOME" WHERE id = 1; -->

    </div>
</Body>