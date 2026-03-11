<?php
session_start();
require_once 'config/database.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT r.*, u.name as autor, (SELECT COUNT(*) FROM votes v WHERE v.recipe_id = r.id) as total_votos FROM recipes r JOIN users u ON r.user_id = u.id WHERE r.id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$receita = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$receita) {
    echo "Receita não encontrada!";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($receita['title']); ?> - Cucina Nostra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">

    <?php include __DIR__ . '/views/navbar.php'; ?>

    <div class="container my-5 pt-4">
        <div class="row">
            <div class="col-md-6 mb-4">
                <img src="<?php echo htmlspecialchars($receita['image_url']); ?>" class="img-fluid rounded shadow" style="width: 100%; height: 400px; object-fit: cover;">
            </div>
            <div class="col-md-6">
                <h1 class="fw-bold text-azul-escuro font-playfair"><?php echo htmlspecialchars($receita['title']); ?></h1>
                <p class="text-muted d-flex align-items-center gap-2">
                    Enviado por: 
                    <a href="perfil.php?id=<?php echo $receita['user_id']; ?>" class="text-decoration-none text-azul-escuro fw-bold fs-5 hover-underline">
                        👨‍🍳 <?php echo htmlspecialchars($receita['autor']); ?>
                    </a>
                </p>
                <h4 class="text-danger mt-4 fw-bold"><?php echo $receita['total_votos']; ?> Votos</h4>
                
                <form action="controllers/VoteController.php" method="POST" class="mt-3" id="formVoto">
                    <input type="hidden" name="recipe_id" value="<?php echo $receita['id']; ?>">
                    
                    <button type="button" onclick="computarVotoAnimado()" class="btn btn-outline-danger btn-lg rounded-pill shadow-sm d-flex align-items-center gap-2 fw-bold">
                        
                        <span style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; margin-left: -5px;">
                            <lottie-player id="lottie-heart" src="assets/img/Heart Animated.json" background="transparent" speed="1.5" style="width: 150%; height: 150%;"></lottie-player>
                        </span>
                        
                        Votar nesta Receita
                    </button>
                </form>

                <script>
                    function computarVotoAnimado() {
                        const lottieHeart = document.getElementById('lottie-heart');
                        
                        // Dá o play na animação do coração preenchendo
                        lottieHeart.play();
                        
                        // Segura o envio do formulário por 1 segundo (1000ms) pra dar tempo da animação rodar na tela
                        setTimeout(() => {
                            document.getElementById('formVoto').submit();
                        }, 1000);
                    }
                </script>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-4 h-100">
                    <h4 class="fw-bold text-success mb-3">Ingredientes</h4>
                    <p><?php echo nl2br(htmlspecialchars($receita['ingredients'])); ?></p>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card border-0 shadow-sm p-4 h-100">
                    <h4 class="fw-bold text-danger mb-3">Modo de Preparo</h4>
                    <p><?php echo nl2br(htmlspecialchars($receita['preparation'])); ?></p>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/views/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>