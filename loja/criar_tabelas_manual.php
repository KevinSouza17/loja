<?php
// Script para criar as tabelas manualmente
$host = 'localhost';
$dbname = 'giorno_loja';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    
    // Criar banco se não existir
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    $pdo->exec("USE $dbname");
    
    // Criar tabela produtos
    $pdo->exec("CREATE TABLE IF NOT EXISTS produtos (
        id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(255) NOT NULL,
        preco DECIMAL(10,2) NOT NULL,
        quantidade INT(11) NOT NULL,
        tamanho VARCHAR(10) NOT NULL,
        categoria VARCHAR(50) NOT NULL,
        cor VARCHAR(30) NOT NULL,
        descricao TEXT,
        imagem VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Criar tabela usuarios
    $pdo->exec("CREATE TABLE IF NOT EXISTS usuarios (
        id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        tipo ENUM('admin', 'cliente') DEFAULT 'cliente',
        data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Inserir admin padrão
    $senhaHash = password_hash('admin123', PASSWORD_DEFAULT);
    $pdo->exec("INSERT IGNORE INTO usuarios (nome, email, senha, tipo) 
               VALUES ('Administrador', 'admin@giorno.com', '$senhaHash', 'admin')");
    
    echo "Tabelas criadas com sucesso!";
    
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>