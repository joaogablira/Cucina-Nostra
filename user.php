<?php
session_start();
require_once 'config/database.php';

// Se não estiver logado, vaza pro login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// 1. Puxa os dados do usuário
$stmt_user = $conn->prepare("SELECT * FROM users WHERE id = :id");
$stmt_user->bindParam(':id', $user_id);
$stmt_user->execute();
$user = $stmt_user->fetch(PDO::FETCH_ASSOC);

// 2. Puxa as receitas que ESSE usuário postou (ordenado por votos)
$query_recipes = "SELECT r.*, 
                  (SELECT COUNT(*) FROM votes v WHERE v.recipe_id = r.id) as total_votos 
                  FROM recipes r 
                  WHERE r.user_id = :user_id 
                  ORDER BY total_votos DESC";
$stmt_recipes = $conn->prepare($query_recipes);
$stmt_recipes->bindParam(':user_id', $user_id);
$stmt_recipes->execute();
$minhas_receitas = $stmt_recipes->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Meu Perfil - Cucina Nostra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-light">

    <?php include 'views/navbar.php'; ?>

    <div class="container my-5 pt-4">
        <div class="row">
            
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-sm rounded-4 text-center p-4">
                    <div class="mx-auto mb-3" style="width: 120px; height: 120px; background: var(--verde-gradient); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem; font-weight: bold; border: 4px solid white; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                        <?php 
                        if(!empty($user['profile_pic']) && $user['profile_pic'] != 'assets/img/default-avatar.png'){
                            echo '<img src="'.htmlspecialchars($user['profile_pic']).'" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">';
                        } else {
                            echo strtoupper(substr($user['name'], 0, 1)); 
                        }
                        ?>
                    </div>
                    
                    <h3 class="fw-bold text-azul-escuro font-playfair"><?php echo htmlspecialchars($user['name']); ?></h3>
                    <p class="text-muted small mb-3">✉️ <?php echo htmlspecialchars($user['email']); ?></p>
                    
                    <p class="text-muted" style="font-size: 0.95rem;">
                        <i>"<?php echo !empty($user['bio']) ? htmlspecialchars($user['bio']) : 'Nenhuma biografia adicionada ainda. Conte aos outros chefs quem é você!'; ?>"</i>
                    </p>

                    <hr>
                    
                    <h5 class="fw-bold text-start mt-4 mb-3 text-gradient-red">Editar Perfil</h5>
                    <form action="#" method="POST" class="text-start">
                        <div class="mb-3">
                            <label class="small text-muted">Nome de Exibição</label>
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>">
                        </div>
                        <div class="mb-3">
                            <label class="small text-muted">Biografia (Sobre mim)</label>
                            <textarea class="form-control" rows="3"><?php echo htmlspecialchars($user['bio']); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="small text-muted">Nova Senha (deixe em branco para não alterar)</label>
                            <input type="password" class="form-control" placeholder="••••••••">
                        </div>
                        <button type="button" class="btn btn-gradient-red w-100 rounded-pill mt-2" onclick="alert('Funcionalidade de atualização em desenvolvimento para a V2 do projeto!')">Salvar Alterações</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                    <h2 class="fw-bold text-gradient-green font-playfair mb-4">Minhas Receitas Publicadas</h2>
                    
                    <div class="row g-4">
                        <?php if(count($minhas_receitas) > 0): ?>
                            <?php foreach($minhas_receitas as $receita): ?>
                                <div class="col-md-6">
                                    <div class="card recipe-card h-100 border border-light shadow-sm">
                                        <img src="<?php echo htmlspecialchars($receita['image_url']); ?>" class="card-img-top" style="height: 180px; object-fit: cover;" alt="Receita">
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title fw-bold text-azul-escuro"><?php echo htmlspecialchars($receita['title']); ?></h5>
                                            <div class="mt-auto d-flex justify-content-between align-items-center pt-3 border-top">
                                                <span class="small fw-bold text-danger">❤️ <?php echo $receita['total_votos']; ?> Votos</span>
                                                <a href="receita.php?id=<?php echo $receita['id']; ?>" class="btn btn-sm btn-outline-success rounded-pill">Ver Receita</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12 text-center py-5">
                                <h4 class="text-muted">Você ainda não enviou nenhuma receita.</h4>
                                <p>Que tal compartilhar o segredo daquela massa da sua nonna?</p>
                                <a href="sugerir_receita.php" class="btn btn-gradient-red rounded-pill mt-2 px-4">Sugerir Minha Primeira Receita</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>