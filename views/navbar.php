<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>

<nav class="navbar navbar-expand-xl navbar-custom sticky-top">
    <div class="container-fluid px-4">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="assets/img/cucinalogo.png" alt="Logo Cucina Nostra" style="height: 45px !important; margin-right: 12px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));">
            <strong class="text-white text-nowrap">Cucina Nostra</strong>
        </a>
        
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto ms-lg-4 gap-2">
                <li class="nav-item"><a class="nav-link text-nowrap" href="sobre.php">Sobre o Projeto</a></li>
                <li class="nav-item"><a class="nav-link text-nowrap" href="historias.php#historias">Histórias</a></li>
                <li class="nav-item"><a class="nav-link text-nowrap" href="index.php#cardapio">Cardápio</a></li>
                <li class="nav-item"><a class="nav-link text-nowrap" href="index.php#receitas">Receitas</a></li>
            </ul>
            
            <form class="d-flex search-container mx-lg-3 my-3 my-lg-0" action="index.php" method="GET" style="flex-grow: 1; max-width: 350px;">
                <div class="input-group shadow-sm" style="border-radius: 50px; overflow: hidden;">
                    <input class="form-control border-0 px-3" type="search" name="busca" placeholder="Buscar prato ou chef..." value="<?php echo isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : ''; ?>" style="box-shadow: none; background-color: #f8f9fa;">
                    <button class="btn btn-light text-success fw-bold px-3 border-0" type="submit" style="background-color: #FF3B30;">Buscar</button>
                </div>
            </form>

            <div class="d-flex align-items-center mt-2 mt-lg-0 gap-2 flex-nowrap">
                
                <button id="themeToggleBtn" class="border-0 bg-transparent d-flex align-items-center justify-content-center" onclick="toggleTheme()" style="padding: 0; cursor: pointer; width: 45px; height: 45px; flex-shrink: 0;">
                    

                    <lottie-player
                        id="lottie-theme"
                        src="assets/img/moon-to-sun.json" 
                        background="transparent"
                        speed="2"
                        style="width: 100%; height: 100%;">
                    </lottie-player>

                </button>

                <?php if(isset($_SESSION['user_id'])): ?>
                    <a href="sugerir_receita.php" class="btn btn-gradient-red rounded-pill px-3 fw-bold shadow-sm d-flex align-items-center gap-2 text-nowrap" style="flex-shrink: 0; font-size: 0.95rem;">
                        <span>➕</span> Sugerir Receita
                    </a>

                    <div class="dropdown" style="flex-shrink: 0;">
                        <a class="btn btn-outline-light rounded-pill px-3 dropdown-toggle d-flex align-items-center gap-2 text-nowrap" href="#" role="button" data-bs-toggle="dropdown" style="border: 2px solid rgba(255,255,255,0.5); font-size: 0.95rem;">
                            <span style="width: 26px; height: 26px; background-color: white; color: var(--verde-italia); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.85rem;">
                                <?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?>
                            </span>
                            <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end mt-3 shadow-lg border-0" style="border-radius: 15px;">
                            <li><a class="dropdown-item fw-bold text-azul-escuro py-2" href="user.php">👤 Meu Perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger py-2" href="controllers/AuthController.php?action=logout">Sair</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="login.php" class="btn btn-light text-success fw-bold rounded-pill px-4 py-2 shadow-sm text-nowrap" style="flex-shrink: 0;">Entrar / Cadastrar</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<script>
    const lottiePlayer = document.getElementById('lottie-theme');
    
    lottiePlayer.addEventListener('ready', () => {
        if (localStorage.getItem('cucina_theme') === 'dark') {
            document.body.classList.add('dark-theme');
            lottiePlayer.seek("100%"); // Fica na Lua
        } else {
            lottiePlayer.seek("0%"); // Fica no Sol
        }
    });

    function toggleTheme() {
        const body = document.body;
        body.classList.toggle('dark-theme');
        
        if (body.classList.contains('dark-theme')) {
            localStorage.setItem('cucina_theme', 'dark');
            lottiePlayer.setDirection(1); 
            lottiePlayer.play(); // Gira pro Escuro
        } else {
            localStorage.setItem('cucina_theme', 'light');
            lottiePlayer.setDirection(-1); 
            lottiePlayer.play(); // Gira pro Claro
        }
    }
</script>