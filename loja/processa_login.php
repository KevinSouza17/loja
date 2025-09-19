<?php
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    
    if (empty($email) || empty($senha)) {
        header('Location: login.php?erro=2');
        exit;
    }
    
    $sql = "SELECT * FROM usuarios WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        $_SESSION['usuario_email'] = $usuario['email'];
        $_SESSION['usuario_tipo'] = $usuario['tipo'];
        
        // Verifica se email é de admin e atualiza tipo se necessário
        if (isEmailAdmin($usuario['email']) && $usuario['tipo'] === 'cliente') {
            $_SESSION['usuario_tipo'] = 'admin';
            // Atualiza no banco também
            $sqlUpdate = "UPDATE usuarios SET tipo = 'admin' WHERE id = :id";
            $stmtUpdate = $pdo->prepare($sqlUpdate);
            $stmtUpdate->bindParam(':id', $usuario['id']);
            $stmtUpdate->execute();
        }
        
        // Inicializa carrinho se for cliente
        if ($_SESSION['usuario_tipo'] === 'cliente' && !isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }
        
        header('Location: index.php');
        exit;
    } else {
        header('Location: login.php?erro=1');
        exit;
    }
} else {
    header('Location: login.php');
    exit;
}
?>