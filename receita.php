<?php
session_start();
require_once 'config/database.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

// Puxa os dados da receita específica
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
    <title><?php echo htmlspecialchars($receita['title']); ?> - Cucina Nostra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="index.php"><strong>← Voltar</strong></a>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row">
            <div class="col-md-6 mb-4">
                <img src="<?php echo htmlspecialchars($receita['image_url']); ?>" class="img-fluid rounded shadow" style="width: 100%; height: 400px; object-fit: cover;">
            </div>
            <div class="col-md-6">
                <h1 class="fw-bold text-azul-escuro"><?php echo htmlspecialchars($receita['title']); ?></h1>
                <p class="text-muted">Enviado por: <strong><?php echo htmlspecialchars($receita['autor']); ?></strong></p>
                <h4 class="text-danger mt-4">♥ <?php echo $receita['total_votos']; ?> Votos</h4>
                
                <form action="controllers/VoteController.php" method="POST" class="mt-3">
                    <input type="hidden" name="recipe_id" value="<?php echo $receita['id']; ?>">
                    <button type="submit" class="btn btn-verde btn-lg rounded-pill shadow-sm"> ✓ Votar nesta Receita</button>
                </form>
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

</body>
</html>