<?php
session_start();
require_once '../config/database.php';

// O burrão tem que estar logado pra votar
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Você precisa fazer login para votar!'); window.location.href='../login.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['recipe_id'])) {
    $user_id = $_SESSION['user_id'];
    $recipe_id = $_POST['recipe_id'];

    try {
        // Tenta coisar o voto (o banco de dados vai bloquear se já existir graças ao UNIQUE que tá feito)
        $stmt = $conn->prepare("INSERT INTO votes (user_id, recipe_id) VALUES (:user_id, :recipe_id)");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':recipe_id', $recipe_id);
        $stmt->execute();
        
        // Se a caçamba der certo, mantemos o redirecionamento normal para recarregar a página e atualizar o contador de voto da comida, deu mó fome pprt
        echo "<script>alert('Voto computado com sucesso! Grazie!'); window.location.href='../receita.php?id=".$recipe_id."';</script>";
        
    } catch(PDOException $e) {
        // Se o incompetente vier parar aqui, é porque já votou antes aí tem um history.back() para voltar pra mesma tela suavemente porque o cara é bom
        echo "<script>alert('Você já votou nesta receita!'); history.back();</script>";
    }
} else {
    header("Location: ../index.php");
}
?>