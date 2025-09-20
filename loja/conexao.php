<?php

// conexao.php - Sistema de fallback para conexão com MySQL
$host = 'localhost';
$dbname = 'loja_giorno';
$user = 'root';
$pass = '';

// Verificar se o MySQL está rodando
function testarConexaoMySQL($host, $user, $pass) {
    try {
        $test_pdo = new PDO("mysql:host=$host", $user, $pass);
        $test_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return true;
    } catch (PDOException $e) {
        return false;
    }
}

// Verificar se o MySQL está disponível
if (!testarConexaoMySQL($host, $user, $pass)) {
    die("
        <div class='container mt-5'>
            <div class='alert alert-danger'>
                <h4><i class='fas fa-database me-2'></i>Erro de Conexão com o MySQL</h4>
                <p>O servidor MySQL não está respondendo. Verifique:</p>
                <ul>
                    <li>O serviço MySQL está iniciado?</li>
                    <li>As credenciais estão corretas? (Usuário: $user, Senha: $pass)</li>
                    <li>O MySQL está na porta padrão (3306)?</li>
                </ul>
                <p><strong>Para usuários XAMPP/WAMP:</strong> Inicie o MySQL pelo painel de controle.</p>
            </div>
        </div>
    ");
}

try {
    // Tentar conectar ao banco específico
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    //echo "<div class='alert alert-success'>Conectado ao banco loja_giorno com sucesso!</div>";
    
} catch (PDOException $e) {
    // Se o banco não existe (erro 1049)
    if ($e->getCode() == 1049) {
        try {
            // Conectar sem especificar o banco
            $pdo = new PDO("mysql:host=$host", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Criar o banco de dados
            $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
            $pdo->exec("USE $dbname");
            
            //echo "<div class='alert alert-info'>Banco de dados '$dbname' criado com sucesso!</div>";
            
            // Criar tabela de produtos expandida
            $pdo->exec("CREATE TABLE IF NOT EXISTS produtos (
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                nome VARCHAR(255) NOT NULL,
                descricao TEXT NULL,
                preco DECIMAL(10,2) NOT NULL,
                preco_promocional DECIMAL(10,2) NULL,
                quantidade INT(11) NOT NULL,
                categoria VARCHAR(100) NOT NULL,
                subcategoria VARCHAR(100) NULL,
                tamanhos VARCHAR(255) NULL,
                cores VARCHAR(255) NULL,
                imagem_principal VARCHAR(255) NULL,
                imagens TEXT NULL,
                destaque TINYINT(1) DEFAULT 0,
                ativo TINYINT(1) DEFAULT 1,
                data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,
                data_atualizacao DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )");
            
            // Criar tabela de categorias
            $pdo->exec("CREATE TABLE IF NOT EXISTS categorias (
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                nome VARCHAR(100) NOT NULL UNIQUE,
                descricao TEXT NULL,
                imagem VARCHAR(255) NULL,
                ativo TINYINT(1) DEFAULT 1,
                data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP
            )");
            
            // Criar tabela de clientes
            $pdo->exec("CREATE TABLE IF NOT EXISTS clientes (
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                nome VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                senha VARCHAR(255) NOT NULL,
                telefone VARCHAR(20) NULL,
                endereco TEXT NULL,
                data_nascimento DATE NULL,
                data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
                ativo TINYINT(1) DEFAULT 1
            )");
            
            // Criar tabela de pedidos
            $pdo->exec("CREATE TABLE IF NOT EXISTS pedidos (
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                cliente_id INT(11) NULL,
                total DECIMAL(10,2) NOT NULL,
                status ENUM('pendente','processando','enviado','entregue','cancelado') DEFAULT 'pendente',
                endereco_entrega TEXT NOT NULL,
                metodo_pagamento VARCHAR(100) NOT NULL,
                data_pedido DATETIME DEFAULT CURRENT_TIMESTAMP,
                data_atualizacao DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )");
            
            // Criar tabela de itens de pedido
            $pdo->exec("CREATE TABLE IF NOT EXISTS pedido_itens (
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                pedido_id INT(11) NOT NULL,
                produto_id INT(11) NOT NULL,
                quantidade INT(11) NOT NULL,
                preco_unitario DECIMAL(10,2) NOT NULL,
                tamanho VARCHAR(10) NULL,
                cor VARCHAR(50) NULL
            )");
            
            // Inserir categorias padrão
            $categorias = [
                ['masculino', 'Roupas masculinas'],
                ['feminino', 'Roupas femininas'],
                ['infantil', 'Roupas infantis'],
                ['acessorios', 'Acessórios diversos']
            ];
            
            $sql = "INSERT IGNORE INTO categorias (nome, descricao) VALUES (?, ?)";
            $stmt = $pdo->prepare($sql);
            
            foreach ($categorias as $categoria) {
                $stmt->execute($categoria);
            }
            
            //echo "<div class='alert alert-success'>Tabelas criadas e categorias inseridas com sucesso!</div>";
            
        } catch (PDOException $e2) {
            die("<div class='alert alert-danger'>Erro ao criar banco de dados: " . $e2->getMessage() . "</div>");
        }
    } 
    // Se a conexão foi recusada (erro 2002)
    else if ($e->getCode() == 2002) {
        die("
            <div class='container mt-5'>
                <div class='alert alert-danger'>
                    <h4><i class='fas fa-ban me-2'></i>Conexão Recusada pelo MySQL</h4>
                    <p>O MySQL recusou a conexão. Verifique:</p>
                    <ul>
                        <li>O MySQL está realmente em execução?</li>
                        <li>O usuário '$user' tem permissão para acessar?</li>
                        <li>A senha está correta? (Senha atual: '$pass')</li>
                        <li>O firewall não está bloqueando a conexão?</li>
                    </ul>
                    <p><strong>Dica:</strong> No XAMPP/WAMP, a senha do MySQL geralmente está vazia (senha: '')</p>
                </div>
            </div>
        ");
    }
    else {
        die("<div class='alert alert-danger'>Erro de conexão: " . $e->getMessage() . "</div>");
    }
}
?>