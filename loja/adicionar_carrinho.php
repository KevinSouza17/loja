<?php
session_start();
require 'conexao.php';

// Verifica se usuário está logado como cliente
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'cliente') {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produto_id = $_POST['produto_id'] ?? 0;
    $quantidade = $_POST['quantidade'] ?? 1;
    
    if ($produto_id <= 0 || $quantidade <= 0) {
        header('Location: catalogo.php');
        exit;
    }
    
    // Busca informações do produto
    $sql = "SELECT * FROM produtos WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $produto_id);
    $stmt->execute();
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$produto || $quantidade > $produto['quantidade']) {
        header('Location: catalogo.php');
        exit;
    }
    
    // Inicializa carrinho se não existir
    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }
    
    // Verifica se produto já está no carrinho
    $encontrado = false;
    foreach ($_SESSION['carrinho'] as &$item) {
        if ($item['id'] == $produto_id) {
            $nova_quantidade = $item['quantidade'] + $quantidade;
            if ($nova_quantidade <= $produto['quantidade']) {
                $item['quantidade'] = $nova_quantidade;
                $encontrado = true;
                break;
            }
        }
    }
    
    // Se não encontrou, adiciona novo item
    if (!$encontrado) {
        $_SESSION['carrinho'][] = [
            'id' => $produto['id'],
            'nome' => $produto['nome'],
            'preco' => $produto['preco'],
            'quantidade' => $quantidade,
            'tamanho' => $produto['tamanho'],
            'cor' => $produto['cor']
        ];
    }
    
    header('Location: carrinho.php');
    exit;
} else {
    header('Location: catalogo.php');
    exit;
}
?>