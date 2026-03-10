<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Sobre o Projeto - Cucina Nostra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <?php include __DIR__ . '/views/navbar.php'; ?>

    <div class="container my-5 pt-5">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">O que é a <span class="text-gradient-green">Cucina</span> <span class="text-gradient-red">Nostra</span>?</h1>
                <p class="lead">A Cucina Nostra não é apenas um site de receitas; é uma celebração da tradição, do sabor e da comunidade italiana.</p>
                <p>Nascido como um desafio acadêmico, o projeto foca em <strong>Gestão de Conteúdo Web</strong>, permitindo que usuários não apenas consumam, mas construam juntos um acervo gastronômico através de um sistema interativo de sugestões e votações.</p>
                
                <div class="card bg-light border-0 p-4 mt-5 shadow-sm" style="border-radius: 20px; border-left: 5px solid #4caf50 !important;">
                    <h5 class="fw-bold"> Nota do Projeto</h5>
                    <p class="mb-1"><strong>Disciplina:</strong> Gestão de Conteúdo Web</p>
                    <p class="mb-1"><strong>Orientação:</strong> Profª Edilma Bindá</p>
                    <p class="mb-0"><strong>Desenvolvimento:</strong> João Gabriel Tavares de Lira</p>
                </div>
            </div>
            <div class="col-lg-6 mt-5 mt-lg-0">
                <div class="position-relative">
                    <div style="position:absolute; width:100px; height:100px; background:var(--vermelho-gradient); border-radius:50%; top:-20px; right:-20px; z-index:-1;"></div>
                    <img src="assets/img/cozinhando.jpg" class="img-fluid rounded-5 shadow-lg" alt="Cozinhando">
                    <div style="position:absolute; width:150px; height:150px; background:var(--verde-gradient); border-radius:50%; bottom:-30px; left:-30px; z-index:-1;"></div>
                </div>
            </div>
        </div>

        <div class="row mt-5 pt-5 text-center">
            <div class="col-md-4">
                <h2 class="text-gradient-green">Comunidade</h2>
                <p>Espaço para compartilhar segredos de família e receitas que atravessam gerações.</p>
            </div>
            <div class="col-md-4">
                <h2 class="text-gradient-red">Interação</h2>
                <p>Sistema dinâmico de votação onde os usuários definem os grandes destaques da semana.</p>
            </div>
            <div class="col-md-4">
                <h2 class="text-gradient-green">História</h2>
                <p>Mais que ingredientes, entregamos contexto e a rica cultura por trás de cada prato.</p>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/views/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>