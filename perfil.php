<?php
session_start();
require_once 'config/database.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$perfil_id = $_GET['id'];

// Puxa os dados do autor
$stmt_user = $conn->prepare("SELECT name, bio, profile_pic FROM users WHERE id = :id");
$stmt_user->bindParam(':id', $perfil_id);
$stmt_user->execute();
$autor = $stmt_user->fetch(PDO::FETCH_ASSOC);

if (!$autor) {
    echo "Chefe não encontrado!";
    exit;
}

// Puxa as receitas desse autor
$query_recipes = "SELECT r.*, 
                  (SELECT COUNT(*) FROM votes v WHERE v.recipe_id = r.id) as total_votos 
                  FROM recipes r 
                  WHERE r.user_id = :user_id 
                  ORDER BY total_votos DESC";
$stmt_recipes = $conn->prepare($query_recipes);
$stmt_recipes->bindParam(':user_id', $perfil_id);
$stmt_recipes->execute();
$receitas = $stmt_recipes->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de <?php echo htmlspecialchars($autor['name']); ?> - Cucina Nostra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">

    <?php include __DIR__ . '/views/navbar.php'; ?>

    <div class="container my-5 pt-4">
        <div class="row mb-5 justify-content-center">
            <div class="col-md-8 text-center">
                <div class="mx-auto mb-3" style="width: 150px; height: 150px; background: var(--verde-gradient); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 4rem; font-weight: bold; border: 4px solid white; box-shadow: 0 5px 15px rgba(0,0,0,0.1); overflow: hidden;">
                    <?php 
                    if(!empty($autor['profile_pic']) && file_exists($autor['profile_pic'])){
                        echo '<img src="'.htmlspecialchars($autor['profile_pic']).'" style="width: 100%; height: 100%; object-fit: cover;">';
                    } else {
                        echo strtoupper(substr($autor['name'], 0, 1)); 
                    }
                    ?>
                </div>
                <h1 class="fw-bold text-azul-escuro" style="font-family: 'Playfair Display', serif;">Chef <?php echo htmlspecialchars($autor['name']); ?></h1>
                <p class="text-muted fst-italic">
                    "<?php echo !empty($autor['bio']) ? htmlspecialchars($autor['bio']) : 'Amante da culinária italiana.'; ?>"
                </p>
            </div>
        </div>

        <h3 class="fw-bold text-gradient-red mb-4 text-center" style="font-family: 'Playfair Display', serif;">Receitas de <?php echo htmlspecialchars($autor['name']); ?></h3>
        
        <div class="row g-4">
            <?php if(count($receitas) > 0): ?>
                <?php foreach($receitas as $receita): ?>
                    <div class="col-md-4">
                        <div class="card recipe-card h-100 border-0 shadow-sm">
                            <img src="<?php echo htmlspecialchars($receita['image_url']); ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="Receita">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold text-azul-escuro"><?php echo htmlspecialchars($receita['title']); ?></h5>
                                
                                <p class="small text-muted mb-3 d-flex align-items-center gap-1">
                                    Chef: 
                                    <a href="perfil.php?id=<?php echo $receita['user_id']; ?>" class="text-decoration-none text-azul-escuro fw-bold hover-underline">
                                        👨‍🍳 <?php echo htmlspecialchars($autor['name']); ?>
                                    </a>
                                </p>

                                <div class="d-inline-block bg-white px-3 py-1 rounded-pill shadow-sm mb-3 border" style="width: fit-content;">
                                    <span class="small fw-bold text-danger d-flex align-items-center gap-1">
                                        <span style="width: 22px; height: 22px; display: flex; align-items: center; justify-content: center;">
                                            <lottie-player src="assets/img/Heart Animated.json" background="transparent" speed="1" style="width: 150%; height: 150%;" autoplay></lottie-player>
                                        </span>
                                        <?php echo $receita['total_votos']; ?> Votos
                                    </span>
                                </div>
                                
                                <div class="mt-auto pt-3 border-top text-end">
                                    <a href="receita.php?id=<?php echo $receita['id']; ?>" class="btn btn-outline-success w-100 rounded-pill fw-bold">Ver Receita</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <h5 class="text-muted">Este chef ainda não publicou nenhuma receita. 😢</h5>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include __DIR__ . '/views/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>