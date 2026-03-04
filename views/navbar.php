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
                <li class="nav-item"><a class="nav-link" href="historias.php#historias">Histórias</a></li>
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