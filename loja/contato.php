<?php
include 'cabecalho.php';

// Processar formulário de contato
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $assunto = $_POST['assunto'] ?? '';
    $mensagem = $_POST['mensagem'] ?? '';
    
    // Aqui você normalmente enviaria um e-mail ou salvaria no banco de dados
    // Por simplicidade, vamos apenas mostrar uma mensagem de sucesso
    
    $sucesso = true;
}
?>

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow">
            <div class="card-header bg-dark-custom">
                <h3 class="card-title mb-0"><i class="fas fa-envelope me-2"></i>Entre em Contato</h3>
            </div>
            <div class="card-body">
                <?php if (isset($sucesso) && $sucesso): ?>
                    <div class="alert alert-success">
                        <strong>Mensagem enviada com sucesso!</strong> Retornaremos em breve.
                    </div>
                <?php endif; ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Nome</label>
                                <input type="text" name="nome" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">E-mail</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Assunto</label>
                                <select name="assunto" class="form-select" required>
                                    <option value="">Selecione...</option>
                                    <option value="duvida">Dúvida</option>
                                    <option value="sugestao">Sugestão</option>
                                    <option value="reclamacao">Reclamação</option>
                                    <option value="elogio">Elogio</option>
                                    <option value="outro">Outro</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Mensagem</label>
                                <textarea name="mensagem" class="form-control" rows="5" required></textarea>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-gold">Enviar Mensagem</button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="col-md-6">
                        <h4 class="mt-3">Informações de Contato</h4>
                        
                        <div class="mb-3">
                            <i class="fas fa-map-marker-alt me-2"></i> 
                            <strong>Endereço:</strong><br>
                            Av. Paulista, 1000 - Bela Vista<br>
                            São Paulo - SP, 01310-100
                        </div>
                        
                        <div class="mb-3">
                            <i class="fas fa-phone me-2"></i> 
                            <strong>Telefone:</strong><br>
                            (11) 9999-9999
                        </div>
                        
                        <div class="mb-3">
                            <i class="fas fa-envelope me-2"></i> 
                            <strong>E-mail:</strong><br>
                            contato@giorno.com.br
                        </div>
                        
                        <div class="mb-3">
                            <i class="fas fa-clock me-2"></i> 
                            <strong>Horário de Funcionamento:</strong><br>
                            Segunda a Sexta: 9h às 18h<br>
                            Sábado: 10h às 16h
                        </div>
                        
                        <div class="mt-4">
                            <h5>Nos acompanhe nas redes sociais:</h5>
                            <div class="social-icons">
                                <a href="#" class="btn btn-outline-dark me-2"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="btn btn-outline-dark me-2"><i class="fab fa-instagram"></i></a>
                                <a href="#" class="btn btn-outline-dark me-2"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="btn btn-outline-dark"><i class="fab fa-pinterest"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'rodape.php'; ?>