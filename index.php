<?php
session_start();
require_once 'config/database.php';

// Lógica de Filtro e Pesquisa
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
    <style>
        /* Ajustes rápidos específicos da Navbar */
        .navbar-brand img {
            height: 45px;
            margin-right: 12px;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));
        }
        .search-container {
            flex-grow: 1;
            max-width: 400px;
        }
        .avatar-circle {
            width: 28px;
            height: 28px;
            background-color: white;
            color: var(--verde-italia);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="assets/img/cucinalogo.png" alt="Logo Cucina Nostra">
                <strong class="text-white">Cucina Nostra</strong>
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto ms-lg-4 gap-2">
                    <li class="nav-item"><a class="nav-link" href="sobre.php">Sobre o Projeto</a></li>
                    <li class="nav-item"><a class="nav-link" href="sobre.php#historias">Histórias</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php#cardapio">Cardápio</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php#receitas">Receitas</a></li>
                </ul>
                
                <form class="d-flex search-container mx-lg-3 my-3 my-lg-0" action="index.php" method="GET">
                    <div class="input-group shadow-sm" style="border-radius: 50px; overflow: hidden;">
                        <input class="form-control border-0 px-4" type="search" name="busca" placeholder="Buscar prato ou chef..." aria-label="Search" value="<?php echo isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : ''; ?>" style="box-shadow: none;">
                        <button class="btn btn-light text-success fw-bold px-4 border-0" type="submit">Buscar</button>
                    </div>
                </form>

                <div class="d-flex align-items-center mt-2 mt-lg-0">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <div class="dropdown">
                            <a class="btn btn-outline-light rounded-pill px-4 dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown" style="border: 2px solid rgba(255,255,255,0.5);">
                                <span class="avatar-circle"><?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?></span>
                                <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end mt-3 shadow-lg border-0" style="border-radius: 15px;">
                                <li><a class="dropdown-item text-success fw-bold py-2" href="sugerir_receita.php">✨ Sugerir Receita</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger py-2" href="controllers/AuthController.php?action=logout">Sair</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-light text-success fw-bold rounded-pill px-4 py-2 shadow-sm" style="transition: all 0.3s;">Entrar / Cadastrar</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <?php if(!isset($_GET['busca']) && !isset($_GET['categoria'])): ?>
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h1 class="hero-title fw-bold">Onde você encontra o <span class="text-gradient-green">Melhor</span> da <span class="text-gradient-red">Culinária Italiana</span></h1>
                    <p class="lead mt-3 text-white">Descubra, vote e compartilhe as receitas que aquecem o coração e a alma.</p>
                    <a href="#receitas" class="btn btn-login-red mt-4 px-5 py-3 fs-5 rounded-pill">Ver as Mais Votadas!</a>
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
                    <div class="category-card border-primary" style="border-color: var(--verde-italia) !important;">
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
                                        <h5 class="card-title fw-bold text-gradient-red"><?php echo htmlspecialchars($receita['title']); ?></h5>
                                        <p class="small text-muted mb-2">Chef: <strong><?php echo htmlspecialchars($receita['autor']); ?></strong></p>
                                        
                                        <div class="d-inline-block bg-white px-3 py-1 rounded-pill shadow-sm mb-3 border" style="width: fit-content;">
                                            <span class="small fw-bold text-danger">❤️ <?php echo $receita['total_votos']; ?> Votos</span>
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

    <footer class="text-center py-5 mt-5" style="background-color: #f1f3f5;">
        <img src="assets/img/cucinalogo.png" alt="Cucina Nostra" style="height: 50px; opacity: 0.5;" class="mb-3">
        <p class="text-muted mb-0">© 2024 - Projeto Acadêmico Cucina Nostra</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>