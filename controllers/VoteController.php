<?php
session_start();
require_once '../config/database.php';

// Segurança: Precisa estar logado para votar
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Você precisa fazer login para votar!'); window.location.href='../login.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['recipe_id'])) {
    $user_id = $_SESSION['user_id'];
    $recipe_id = $_POST['recipe_id'];

    try {
        // Tenta inserir o voto (o banco de dados vai bloquear se já existir graças ao UNIQUE que criamos)
        $stmt = $conn->prepare("INSERT INTO votes (user_id, recipe_id) VALUES (:user_id, :recipe_id)");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':recipe_id', $recipe_id);
        $stmt->execute();
        
        echo "<script>alert('Voto computado com sucesso! Grazie!'); window.location.href='../receita.php?id=".$recipe_id."';</script>";
        
    } catch(PDOException $e) {
        // Se cair aqui, é porque ele já votou (erro de duplicidade do MySQL)
        echo "<script>alert('Você já votou nesta receita!'); window.location.href='../receita.php?id=".$recipe_id."';</script>";
    }
} else {
    header("Location: ../index.php");
}
?>