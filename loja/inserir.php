<?php
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $preco = $_POST['preco'] ?? 0;
    $quantidade = $_POST['quantidade'] ?? 0;
    $tamanho = $_POST['tamanho'] ?? '';
    $categoria = $_POST['categoria'] ?? '';
    $cor = $_POST['cor'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    
    if (empty($nome) || $preco <= 0 || $quantidade < 0 || empty($tamanho) || empty($categoria) || empty($cor)) {
        header('Location: form_cadastrar.php?erro=1');
        exit;
    }
    
    $sql = "INSERT INTO produtos (nome, preco, quantidade, tamanho, categoria, cor, descricao) 
            VALUES (:nome, :preco, :quantidade, :tamanho, :categoria, :cor, :descricao)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':preco', $preco);
    $stmt->bindParam(':quantidade', $quantidade);
    $stmt->bindParam(':tamanho', $tamanho);
    $stmt->bindParam(':categoria', $categoria);
    $stmt->bindParam(':cor', $cor);
    $stmt->bindParam(':descricao', $descricao);

    if ($stmt->execute()) {
        header('Location: listar.php?sucesso=1');
        exit;
    } else {
        header('Location: form_cadastrar.php?erro=2');
        exit;
    }
} else {
    header('Location: form_cadastrar.php');
    exit;
}
?>