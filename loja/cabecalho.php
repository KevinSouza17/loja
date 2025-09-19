<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giorno - Loja de Roupas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            color: #212529;
            padding-top: 20px;
        }
        .navbar {
            margin-bottom: 20px;
            background-color: #000 !important;
        }
        .card {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .table {
            color: #212529;
        }
        .btn-primary {
            background-color: #000;
            border-color: #000;
        }
        .btn-primary:hover {
            background-color: #333;
            border-color: #333;
        }
        .btn-outline-light {
            border-color: #000;
            color: #000;
        }
        .btn-outline-light:hover {
            background-color: #000;
            color: #fff;
        }
        .bg-dark-custom {
            background-color: #000 !important;
            color: #fff;
        }
        .carrinho-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #dc3545;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand" href="index.php">
        <i class="fas fa-shirt me-2"></i>Giorno
    </a>
    <div class="navbar-nav me-auto">
      <a class="nav-link" href="index.php">Início</a>
      <a class="nav-link" href="catalogo.php">Catálogo</a>
      <?php if (isset($_SESSION['usuario_tipo']) && $_SESSION['usuario_tipo'] === 'admin'): ?>
        <a class="nav-link" href="form_cadastrar.php">Cadastrar Roupa</a>
        <a class="nav-link" href="listar.php">Gerenciar Produtos</a>
      <?php endif; ?>
    </div>
    <div class="navbar-nav">
      <?php if (isset($_SESSION['usuario_id'])): ?>
        <?php if ($_SESSION['usuario_tipo'] === 'cliente'): ?>
          <a class="nav-link position-relative" href="carrinho.php">
            <i class="fas fa-shopping-cart"></i>
            <?php
            $total_itens = 0;
            if (isset($_SESSION['carrinho'])) {
                foreach ($_SESSION['carrinho'] as $item) {
                    $total_itens += $item['quantidade'];
                }
            }
            if ($total_itens > 0): ?>
              <span class="carrinho-badge"><?php echo $total_itens; ?></span>
            <?php endif; ?>
          </a>
        <?php endif; ?>
        <span class="nav-link">Olá, <?php echo $_SESSION['usuario_nome']; ?></span>
        <a class="nav-link" href="logout.php">Sair</a>
      <?php else: ?>
        <a class="nav-link" href="login.php">Login</a>
        <a class="nav-link" href="criar_conta.php">Criar Conta</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
<div class="container">
    <!-- ... código anterior ... -->
<div class="navbar-nav">
    <?php if (isset($_SESSION['usuario_id'])): ?>
        <?php if ($_SESSION['usuario_tipo'] === 'cliente'): ?>
            <a class="nav-link position-relative" href="carrinho.php">
                <i class="fas fa-shopping-cart"></i>
                <?php
                $total_itens = 0;
                if (isset($_SESSION['carrinho'])) {
                    foreach ($_SESSION['carrinho'] as $item) {
                        $total_itens += $item['quantidade'];
                    }
                }
                if ($total_itens > 0): ?>
                    <span class="carrinho-badge"><?php echo $total_itens; ?></span>
                <?php endif; ?>
            </a>
        <?php endif; ?>
        
        <div class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                <i class="fas fa-user me-1"></i><?php echo $_SESSION['usuario_nome']; ?>
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="perfil.php"><i class="fas fa-user me-2"></i>Meu Perfil</a></li>
                <li><a class="dropdown-item" href="trocar_perfil.php"><i class="fas fa-sync me-2"></i>Trocar Perfil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Sair</a></li>
            </ul>
        </div>
    <?php else: ?>
        <a class="nav-link" href="login.php">Login</a>
        <a class="nav-link" href="criar_conta.php">Criar Conta</a>
    <?php endif; ?>
</div>
<!-- ... código posterior ... -->