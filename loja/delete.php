<?php
// Todo o processamento ANTES de qualquer output
require 'conexao.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: listar.php');
    exit;
}

$id = $_GET['id'];

$sqlCheck = "SELECT * FROM produtos WHERE id = :id";
$stmtCheck = $pdo->prepare($sqlCheck);
$stmtCheck->bindParam(':id', $id);
$stmtCheck->execute();

if ($stmtCheck->rowCount() > 0) {
    $sql = "DELETE FROM produtos WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        header('Location: listar.php?excluido=1');
        exit;
    } else {
        header('Location: listar.php?erro=1');
        exit;
    }
} else {
    header('Location: listar.php?erro=2');
    exit;
}
?>