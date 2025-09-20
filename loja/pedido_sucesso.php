<?php
include 'cabecalho.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: inicio.php');
    exit;
}

$pedido_id = $_GET['id'];
?>

<div class="row justify-content-center">
    <div class="col-md-6 text-center">
        <div class="card shadow">
            <div class="card-body py-5">
                <div class="mb-4">
                    <i class="fas fa-check-circle fa-5x text-success"></i>
                </div>
                
                <h2 class="card-title">Pedido Realizado com Sucesso!</h2>
                <p class="lead">Obrigado por comprar na Giorno Moda.</p>
                
                <div class="alert alert-info">
                    <strong>Número do Pedido:</strong> #<?php echo str_pad($pedido_id, 6, '0', STR_PAD_LEFT); ?>
                </div>
                
                <p>Em breve você receberá um e-mail com os detalhes do seu pedido.</p>
                
                <div class="mt-4">
                    <a href="listar.php" class="btn btn-gold me-2">Continuar Comprando</a>
                    <a href="inicio.php" class="btn btn-outline-secondary">Voltar ao Início</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'rodape.php'; ?>