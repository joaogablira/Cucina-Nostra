<?php
session_start();

// Puxa a conexão com o banco de dados
require_once '../config/database.php';

// Agora pegamos a ação via $_POST (mais seguro)
$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');

if ($action == 'register') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Verifica se o e-mail já existe no banco
    $checkEmail = $conn->prepare("SELECT id FROM users WHERE email = :email");
    $checkEmail->bindParam(':email', $email);
    $checkEmail->execute();

    if ($checkEmail->rowCount() > 0) {
        echo "<script>alert('Este e-mail já está cadastrado!'); window.location.href='../login.php';</script>";
        exit;
    }

    // Criptografa a senha
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insere o novo usuário
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword);

    if ($stmt->execute()) {
        echo "<script>alert('Cadastro realizado com sucesso! Faça seu login.'); window.location.href='../login.php';</script>";
    } else {
        echo "<script>alert('Erro ao cadastrar. Tente novamente.'); window.location.href='../login.php';</script>";
    }
} 
elseif ($action == 'login') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header("Location: ../index.php");
        exit;
    } else {
        echo "<script>alert('E-mail ou senha incorretos!'); window.location.href='../login.php';</script>";
    }
} 
elseif ($action == 'logout') {
    session_destroy();
    header("Location: ../index.php");
    exit;
} else {
    // Se a pessoa cair na página sem enviar formulário
    echo "<script>alert('Ação inválida!'); window.location.href='../login.php';</script>";
}
?>