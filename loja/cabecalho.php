<?php
// Iniciar sessão NO TOPO ABSOLUTO do arquivo
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giorno - Loja de Roupas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1a1a1a;
            --secondary-color: #d4af37;
            --accent-color: #8b4513;
            --light-color: #f8f9fa;
            --dark-color: #212529;
        }
        
        body {
            background-color: #f9f9f9;
            color: #333;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 20px;
        }
        
        .navbar-giorno {
            background-color: var(--primary-color) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--secondary-color) !important;
            font-size: 1.8rem;
        }
        
        .nav-link {
            color: #fff !important;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .nav-link:hover {
            color: var(--secondary-color) !important;
        }
        
        .btn-gold {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            color: #000;
            font-weight: 600;
        }
        
        .btn-gold:hover {
            background-color: #c19b2e;
            border-color: #c19b2e;
            color: #000;
        }
        
        .bg-dark-custom {
            background-color: var(--primary-color) !important;
            color: white;
        }
        
        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--secondary-color);
            color: black;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark navbar-giorno fixed-top">
    <div class="container">
        <a class="navbar-brand" href="inicio.php">GIORNO</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="inicio.php">Início</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Categorias
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="listar.php?categoria=masculino">Masculino</a></li>
                        <li><a class="dropdown-item" href="listar.php?categoria=feminino">Feminino</a></li>
                        <li><a class="dropdown-item" href="listar.php?categoria=infantil">Infantil</a></li>
                        <li><a class="dropdown-item" href="listar.php?categoria=acessorios">Acessórios</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="sobre.php">Sobre</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contato.php">Contato</a>
                </li>
            </ul>
            <div class="d-flex">
                <?php
                // Verificar quantidade no carrinho (a sessão já foi iniciada)
                $qtd_carrinho = isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : 0;
                ?>
                <a href="carrinho.php" class="btn btn-outline-light me-2 position-relative">
                    <i class="fas fa-shopping-cart"></i>
                    <?php if ($qtd_carrinho > 0): ?>
                        <span class="cart-badge"><?php echo $qtd_carrinho; ?></span>
                    <?php endif; ?>
                </a>
                <a href="form_cadastrar.php" class="btn btn-gold"><i class="fas fa-plus me-1"></i>Adicionar Produto</a>
            </div>
        </div>
    </div>
</nav>
<div class="container mt-5 pt-4">