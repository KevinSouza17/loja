<?php
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    
    if (empty($nome) || empty($email) || empty($senha)) {
        header('Location: criar_conta.php?erro=1');
        exit;
    }
    
    // Verifica se email já existe
    $sqlCheck = "SELECT id FROM usuarios WHERE email = :email";
    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->bindParam(':email', $email);
    $stmtCheck->execute();
    
    if ($stmtCheck->rowCount() > 0) {
        header('Location: criar_conta.php?erro=2');
        exit;
    }
    
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO usuarios (nome, email, senha, tipo) VALUES (:nome, :email, :senha, 'cliente')";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senhaHash);
    
    if ($stmt->execute()) {
        header('Location: login.php?sucesso=1');
        exit;
    } else {
        header('Location: criar_conta.php?erro=3');
        exit;
    }
} else {
    header('Location: criar_conta.php');
    exit;
}
?>