<?php
// Todo o processamento ANTES de qualquer output
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $preco = $_POST['preco'] ?? 0;
    $preco_promocional = $_POST['preco_promocional'] ?? null;
    $quantidade = $_POST['quantidade'] ?? 0;
    $categoria = $_POST['categoria'] ?? '';
    $tamanhos = $_POST['tamanhos'] ?? '';
    $cores = $_POST['cores'] ?? '';
    $destaque = isset($_POST['destaque']) ? 1 : 0;
    
    if (empty($nome) || $preco <= 0 || $quantidade < 0 || empty($categoria)) {
        header('Location: form_cadastrar.php?erro=1');
        exit;
    }
    
    // Processar upload de imagem
    $imagem_principal = null;
    if (isset($_FILES['imagem_principal']) && $_FILES['imagem_principal']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $extensao = pathinfo($_FILES['imagem_principal']['name'], PATHINFO_EXTENSION);
        $nomeArquivo = uniqid() . '.' . $extensao;
        $caminhoCompleto = $uploadDir . $nomeArquivo;
        
        if (move_uploaded_file($_FILES['imagem_principal']['tmp_name'], $caminhoCompleto)) {
            $imagem_principal = $caminhoCompleto;
        }
    }
    
    $sql = "INSERT INTO produtos (nome, descricao, preco, preco_promocional, quantidade, categoria, tamanhos, cores, imagem_principal, destaque) 
            VALUES (:nome, :descricao, :preco, :preco_promocional, :quantidade, :categoria, :tamanhos, :cores, :imagem_principal, :destaque)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':preco', $preco);
    $stmt->bindParam(':preco_promocional', $preco_promocional);
    $stmt->bindParam(':quantidade', $quantidade);
    $stmt->bindParam(':categoria', $categoria);
    $stmt->bindParam(':tamanhos', $tamanhos);
    $stmt->bindParam(':cores', $cores);
    $stmt->bindParam(':imagem_principal', $imagem_principal);
    $stmt->bindParam(':destaque', $destaque);

    if ($stmt->execute()) {
        header('Location: form_cadastrar.php?sucesso=1');
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