<?php
require 'conexao.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: listar.php');
    exit;
}

$id = $_GET['id'];

$tableExists = $pdo->query("SHOW TABLES LIKE 'produtos'")->rowCount() > 0;

if ($tableExists) {
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
} else {
    header('Location: listar.php');
    exit;
}
?>