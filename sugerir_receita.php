<?php
session_start();

// Trava de segurança: Se não estiver logado, manda para o login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sugerir Receita - Cucina Nostra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="index.php"><strong>← Voltar para Cucina Nostra</strong></a>
            <span class="text-white">Logado como: <strong><?php echo htmlspecialchars($_SESSION['user_name']); ?></strong></span>
        </div>
    </nav>

    <div class="container my-5" style="animation: surgirSuave 0.6s ease-out forwards;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0" style="border-radius: 15px;">
                    <div class="card-body p-5">
                        <h2 class="fw-bold text-azul-escuro mb-4 text-center">Compartilhe sua Receita</h2>
                        <p class="text-muted text-center mb-5">Sua receita irá para votação. Se for escolhida, ela ganhará destaque na nossa página inicial!</p>

                        <form action="controllers/RecipeController.php?action=create" method="POST" enctype="multipart/form-data">
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold">Nome da Receita</label>
                                <input type="text" name="title" class="form-control form-control-lg" placeholder="Ex: Macarrão à Carbonara da Nonna" required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Categoria</label>
                                <select name="category_id" class="form-select form-select-lg" required>
                                    <option value="" disabled selected>Selecione uma categoria...</option>
                                    <option value="1">Massas</option>
                                    <option value="2">Pizzas</option>
                                    <option value="3">Doces</option>
                                    <option value="4">Carnes</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Ingredientes</label>
                                <textarea name="ingredients" class="form-control" rows="4" placeholder="Coloque um ingrediente por linha..." required></textarea>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Modo de Preparo</label>
                                <textarea name="preparation" class="form-control" rows="5" placeholder="Descreva o passo a passo..." required></textarea>
                            </div>

                            <form action="controllers/RecipeController.php?action=create" method="POST" enctype="multipart/form-data">

                                <div class="mb-5">
                                    <label class="form-label fw-bold">Imagem da Receita</label>
                                    <input type="file" name="image_upload" class="form-control" accept="image/*" required>
                                    <div class="form-text">Envie uma foto bonita do prato direto do seu computador ou celular (JPG, PNG).</div>
                                </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-verde btn-lg rounded-pill fw-bold">Enviar para Votação</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>