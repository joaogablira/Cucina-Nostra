<?php
session_start();
require_once 'config/database.php';

$where = "WHERE 1=1";
$params = [];
 
if (isset($_GET['busca']) && !empty(trim($_GET['busca']))) {
    $where .= " AND (r.title LIKE :busca OR u.name LIKE :busca)";
    $params[':busca'] = '%' . trim($_GET['busca']) . '%';
}

if (isset($_GET['categoria']) && !empty($_GET['categoria'])) {
    $where .= " AND r.category_id = :categoria";
    $params[':categoria'] = $_GET['categoria'];
}

$query = "SELECT r.*, u.name as autor, 
          (SELECT COUNT(*) FROM votes v WHERE v.recipe_id = r.id) as total_votos 
          FROM recipes r 
          JOIN users u ON r.user_id = u.id 
          $where
          ORDER BY total_votos DESC LIMIT 12";

$stmt = $conn->prepare($query);
$stmt->execute($params);
$receitas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cucina Nostra - O Melhor da Culinária Italiana</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <?php include __DIR__ . '/views/navbar.php'; ?>

    <?php if(!isset($_GET['busca']) && !isset($_GET['categoria'])): ?>
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h1 class="hero-title fw-bold">Onde você encontra o <span class="text-gradient-green">Melhor</span> da <span class="text-gradient-red">Culinária Italiana</span></h1>
                    <p class="lead mt-3 text-white">Descubra, vote e compartilhe as receitas que aquecem o coração e a alma.</p>
                    <a href="#receitas" class="btn btn-login-red mt-4 px-5 py-3 fs-5 rounded-pill" style="background-color: #FF3B30; color: white;">Ver as Mais Votadas!</a>
                </div>
            </div>
        </div>
    </section>

    <div class="separador-bandeira"></div>

    <section id="cardapio" class="container my-5 pt-5">
        <h3 class="section-title">Conheça nosso <span class="text-gradient-green">Cardápio</span></h3>
        <div class="row g-4">
            <div class="col-md-3">
                <a href="index.php?categoria=3#receitas" class="text-decoration-none text-dark">
                    <div class="category-card">
                        <h5 class="fw-bold mt-3 text-azul-escuro">Doces</h5>
                        <p class="text-muted small">Cannolis, Tiramisu e sobremesas clássicas.</p>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="index.php?categoria=1#receitas" class="text-decoration-none text-dark">
                    <div class="category-card">
                        <h5 class="fw-bold mt-3 text-azul-escuro">Massas</h5>
                        <p class="text-muted small">Receitas tradicionais de famílias italianas.</p>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="index.php?categoria=2#receitas" class="text-decoration-none text-dark">
                    <div class="category-card">
                        <h5 class="fw-bold mt-3 text-azul-escuro">Pizzas</h5>
                        <p class="text-muted small">A verdadeira massa napolitana em casa.</p>
                    </div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="index.php?categoria=4#receitas" class="text-decoration-none text-dark">
                    <div class="category-card">
                        <h5 class="fw-bold mt-3 text-azul-escuro">Carnes</h5>
                        <p class="text-muted small">Os melhores cortes com tempero rústico.</p>
                    </div>
                </a>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <section id="receitas" class="container my-5 pt-5">
        <h2 class="section-title">
            <?php if(isset($_GET['busca'])): ?>
                Resultados para: <span class="text-gradient-red">"<?php echo htmlspecialchars($_GET['busca']); ?>"</span>
            <?php elseif(isset($_GET['categoria'])): ?>
                Receitas da <span class="text-gradient-green">Categoria</span>
            <?php else: ?>
                Nossas <span class="text-gradient-green">RECEITAS</span> <br>mais <span class="text-gradient-red">VOTADAS</span>
            <?php endif; ?>
        </h2>
        
        <?php if(isset($_GET['busca']) || isset($_GET['categoria'])): ?>
            <div class="text-center mb-5">
                <a href="index.php" class="btn btn-outline-secondary rounded-pill px-4">Limpar Filtros ✖</a>
            </div>
        <?php endif; ?>

        <div class="row g-4">
            <?php if(count($receitas) > 0): ?>
                <?php foreach($receitas as $receita): ?>
                    <div class="col-md-6">
                        <div class="card recipe-card h-100">
                            <div class="row g-0 h-100">
                                <div class="col-md-5 overflow-hidden">
                                    <img src="<?php echo htmlspecialchars($receita['image_url']); ?>" class="img-fluid h-100 w-100" style="object-fit: cover; min-height: 250px;" alt="Receita">
                                </div>
                                <div class="col-md-7">
                                    <div class="card-body p-4 d-flex flex-column h-100 card-body-blue">
                                        <p class="small text-muted mb-2 d-flex align-items-center gap-1">
                                            Chef: 
                                            <a href="perfil.php?id=<?php echo $receita['user_id']; ?>" class="text-decoration-none text-azul-escuro fw-bold hover-underline">
                                                👨‍🍳 <?php echo htmlspecialchars($receita['autor']); ?>
                                            </a>
                                        </p>
                                        <p class="small text-muted mb-2">Chef: <strong><?php echo htmlspecialchars($receita['autor']); ?></strong></p>
                                        
                                       <div class="d-inline-block bg-white px-3 py-1 rounded-pill shadow-sm mb-3 border" style="width: fit-content;">
                                            <span class="small fw-bold text-danger d-flex align-items-center gap-1">
                                                <span style="width: 22px; height: 22px; display: flex; align-items: center; justify-content: center;">
                                                    <lottie-player src="assets/img/Heart Animated.json" background="transparent" speed="1" style="width: 150%; height: 150%;" autoplay></lottie-player>
                                                </span>
                                                <?php echo $receita['total_votos']; ?> Votos
                                            </span>
                                        </div>
                                        
                                        <p class="card-text text-muted" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; font-size: 0.95rem;">
                                            <?php echo htmlspecialchars($receita['ingredients']); ?>
                                        </p>
                                        
                                        <div class="mt-auto pt-3 border-top text-end">
                                            <a href="receita.php?id=<?php echo $receita['id']; ?>" class="text-decoration-none fw-bold text-success">Ver Receita Completa →</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <h4 class="text-muted">Nenhuma receita encontrada para sua busca. 😢</h4>
                    <p class="mb-4">Que tal ser o primeiro a sugerir uma?</p>
                    <a href="sugerir_receita.php" class="btn btn-gradient-red rounded-pill px-4">Sugerir Receita</a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php include __DIR__ . '/views/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>