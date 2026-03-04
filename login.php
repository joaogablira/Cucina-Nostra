<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar - Cucina Nostra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-body">

    <div class="auth-container">
        <div class="auth-form">
            <h2 class="fw-bold mb-4" style="color: var(--azul-escuro); font-family: 'Playfair Display', serif;">Bem-vindo(a)!</h2>
            
            <ul class="nav nav-pills mb-4 gap-2" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active custom-tab" id="pills-login-tab" data-bs-toggle="pill" data-bs-target="#pills-login" type="button">Entrar</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link custom-tab" id="pills-register-tab" data-bs-toggle="pill" data-bs-target="#pills-register" type="button">Cadastrar</button>
                </li>
            </ul>

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-login">
                    <form action="controllers/AuthController.php" method="POST">
                        <input type="hidden" name="action" value="login">
                        
                        <div class="mb-3">
                            <label class="text-muted small">E-mail</label>
                            <input type="email" name="email" class="form-control-custom" required>
                        </div>
                        <div class="mb-4">
                            <label class="text-muted small">Senha</label>
                            <input type="password" name="password" class="form-control-custom" required>
                        </div>
                        <button type="submit" class="btn btn-login-verde w-100 mt-2">Fazer Login</button>
                    </form>
                </div>

                <div class="tab-pane fade" id="pills-register">
                    <form action="controllers/AuthController.php" method="POST">
                        <input type="hidden" name="action" value="register">

                        <div class="mb-3">
                            <label class="text-muted small">Nome Completo</label>
                            <input type="text" name="name" class="form-control-custom" required>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small">E-mail</label>
                            <input type="email" name="email" class="form-control-custom" required>
                        </div>
                        <div class="mb-4">
                            <label class="text-muted small">Senha</label>
                            <input type="password" name="password" class="form-control-custom" required>
                        </div>
                        <button type="submit" class="btn btn-login-vermelho w-100 mt-2">Criar Conta</button>
                    </form>
                </div>
            </div>
            
            <div class="mt-4 text-center">
                <a href="index.php" class="text-decoration-none text-muted small">← Voltar para a página inicial</a>
            </div>
        </div>

        <div class="auth-image">
            <!-- <img src="assets/img/cucinalogo.png" class="auth-logo-bg" alt="Logo de Fundo"> -->
            
            <div class="auth-image-content">
                <h1 class="fw-bold">Cucina Nostra</h1>
                <p style="font-size: 1rem; line-height: 1.6; font-weight: 300;">Junte-se a milhares de amantes da culinária italiana. Compartilhe suas receitas de família e descubra novos sabores.</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>