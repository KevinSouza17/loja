<?php
session_start();

$host = 'localhost';
$dbname = 'giorno_loja';
$user = 'root';
$pass = '';

// Domínios autorizados para admin
$dominios_admin = ['@giorno.com', '@admin.giorno', '@giorno.admin'];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Verifica e cria as tabelas se não existirem
    criarTabelas($pdo);
    
} catch (PDOException $e) {
    // Tenta criar o banco de dados se não existir
    if ($e->getCode() == 1049) {
        try {
            $pdo = new PDO("mysql:host=$host", $user, $pass);
            $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
            $pdo->exec("USE $dbname");
            
            // Cria todas as tabelas
            criarTabelas($pdo);
            
            echo "<div class='alert alert-info'>Banco de dados criado com sucesso!</div>";
        } catch (PDOException $e2) {
            die("<div class='alert alert-danger'>Erro ao criar banco de dados: " . $e2->getMessage() . "</div>");
        }
    } else {
        die("<div class='alert alert-danger'>Erro de conexão: " . $e->getMessage() . "</div>");
    }
}

function criarTabelas($pdo) {
    // Cria a tabela produtos
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
    
    // Cria a tabela usuarios
    $pdo->exec("CREATE TABLE IF NOT EXISTS usuarios (
        id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        senha VARCHAR(255) NOT NULL,
        tipo ENUM('admin', 'cliente') DEFAULT 'cliente',
        data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        endereco TEXT,
        telefone VARCHAR(20),
        data_nascimento DATE
    )");
    
    // Verifica se já existe admin e insere se não existir
    $stmt = $pdo->query("SELECT COUNT(*) FROM usuarios WHERE tipo = 'admin'");
    if ($stmt->fetchColumn() == 0) {
        $senhaHash = password_hash('Admin123!', PASSWORD_DEFAULT);
        $pdo->exec("INSERT INTO usuarios (nome, email, senha, tipo) 
                   VALUES ('Administrador Master', 'admin@giorno.com', '$senhaHash', 'admin')");
    }
}

// Função para verificar se email é de admin
function isEmailAdmin($email) {
    global $dominios_admin;
    foreach ($dominios_admin as $dominio) {
        if (strpos($email, $dominio) !== false) {
            return true;
        }
    }
    return false;
}
?>