<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórias - Cucina Nostra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <?php include __DIR__ . '/views/navbar.php'; ?>

    <div class="container my-5 pt-5">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Histórias da <span class="text-gradient-green">Nossa </span> <span class="text-gradient-red">Culinária</span></h1>
                <h3 class="text-success mb-3">O Surgimento da Pizza</h3> 
                <p>A verdadeira pizza nasceu em Nápoles, na Itália, no século XVIII. Era um prato popular entre os trabalhadores por ser barato e rápido de comer. A clássica Margherita foi criada em 1889 para homenagear a Rainha Margherita de Saboia, levando as cores da bandeira italiana: tomate (vermelho), muçarela (branco) e manjericão (verde).</p>
            </div>
            <div class="col-md-6 text-center mt-4 mt-lg-0">
                <div class="ratio ratio-16x9 shadow-lg rounded-4 overflow-hidden">
                    <iframe src="https://www.youtube.com/embed/6hbsPB41rFM?si=y5hPREk0fBUMa7qr" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
    
    <?php include __DIR__ . '/views/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>