<nav class="navbar navbar-expand-lg navbar-custom sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <img src="assets/img/cucinalogo.png" alt="Logo Cucina Nostra" style="height: 45px !important; margin-right: 12px; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));">
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
            
            <form class="d-flex search-container mx-lg-3 my-3 my-lg-0" action="index.php" method="GET" style="flex-grow: 1; max-width: 400px;">
                <div class="input-group shadow-sm" style="border-radius: 50px; overflow: hidden;">
                    <input class="form-control border-0 px-4" type="search" name="busca" placeholder="Buscar prato ou chef..." aria-label="Search" value="<?php echo isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : ''; ?>" style="box-shadow: none; background-color: #f8f9fa;">
                    <button class="btn btn-light text-success fw-bold px-4 border-0" type="submit" style="background-color: white;">Buscar</button>
                </div>
            </form>

            <div class="d-flex align-items-center mt-2 mt-lg-0 gap-3">
                <?php if(isset($_SESSION['user_id'])): ?>
                    
                    <a href="sugerir_receita.php" class="btn btn-gradient-red rounded-pill px-4 fw-bold shadow-sm d-flex align-items-center gap-2">
                        <span>➕</span> Sugerir Receita
                    </a>
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FF3B30"><path d="M360-400h80v-200h-80v200Zm-160-60q-46-23-73-66.5T100-621q0-75 51.5-127T278-800q12 0 24.5 2t24.5 5q25-41 65-64t88-23q48 0 88 23t65 64q12-3 24-5t25-2q75 0 126.5 52T860-621q0 51-27 94.5T760-460v220H200v-220Zm320 60h80v-200h-80v200Zm-240 80h400v-189l44-22q26-13 41-36.5t15-52.5q0-42-28.5-71T682-720q-11 0-20 2t-19 5l-47 13-31-52q-14-23-36.5-35.5T480-800q-26 0-48.5 12.5T395-752l-31 52-48-13q-10-2-19.5-4.5T277-720q-41 0-69 29t-28 71q0 29 15 52.5t41 36.5l44 22v189Zm-80 80h80v80h400v-80h80v160H200v-160Zm280-80Z"></path></svg>

                    <div class="dropdown">
                        <a class="btn btn-outline-light rounded-pill px-4 dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown" style="border: 2px solid rgba(255,255,255,0.5);">
                            <span style="width: 28px; height: 28px; background-color: white; color: var(--verde-italia); border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.9rem;">
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
                    <a href="login.php" class="btn btn-light text-success fw-bold rounded-pill px-4 py-2 shadow-sm" style="transition: all 0.3s;">Entrar / Cadastrar</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>