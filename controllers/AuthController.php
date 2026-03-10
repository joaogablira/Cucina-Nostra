<?php
session_start();
require_once '../config/database.php';

// Pega a ação via POST (login/register) ou via GET (logout)
$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');

// ==========================================
// 1. LÓGICA DE CADASTRO
// ==========================================
if ($action == 'register') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($name) || empty($email) || empty($password)) {
        // AQUI: Volta sem perder os dados
        echo "<script>alert('Por favor, preencha todos os campos!'); history.back();</script>";
        exit;
    }

    try {
        // Verifica se o email já existe no banco
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // AQUI: Volta sem perder os dados (se o email já existir)
            echo "<script>alert('Esse e-mail já está cadastrado. Tente fazer login!'); history.back();</script>";
            exit;
        }

        // Criptografa a senha com segurança máxima
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insere o novo usuário
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);

        if ($stmt->execute()) {
            // SUCESSO: Redireciona para o login para ele entrar na conta nova
            echo "<script>alert('Cadastro realizado com sucesso! Mamma mia, agora você pode fazer o login.'); window.location.href='../login.php';</script>";
        } else {
            // AQUI: Erro no banco, volta sem perder dados
            echo "<script>alert('Erro ao cadastrar. Tente novamente.'); history.back();</script>";
        }

    } catch(PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

// ==========================================
// 2. LÓGICA DE LOGIN
// ==========================================
elseif ($action == 'login') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        // AQUI: Volta sem perder o email digitado
        echo "<script>alert('Por favor, preencha e-mail e senha!'); history.back();</script>";
        exit;
    }

    try {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifica se o usuário existe e se a senha bate com o hash
        if ($user && password_verify($password, $user['password'])) {
            // SUCESSO: Salva os dados na sessão
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            
            // Joga o cara pra Home
            header("Location: ../index.php");
            exit;
        } else {
            // AQUI: Senha errada? Volta sem perder o email que ele já digitou
            echo "<script>alert('E-mail ou senha incorretos! Verifique e tente novamente.'); history.back();</script>";
        }

    } catch(PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}

// ==========================================
// 3. LÓGICA DE LOGOUT (SAIR)
// ==========================================
elseif ($action == 'logout') {
    // Destrói a sessão e joga o cara pra Home deslogado
    session_destroy();
    header("Location: ../index.php");
    exit;
}
?>