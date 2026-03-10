<?php
session_start();
require_once '../config/database.php';

// Segurança: Se os cara não estiver logado, não pode enviar receita
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Você precisa estar logado para enviar uma receita!'); window.location.href='../login.php';</script>";
    exit;
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == 'create') {
    // 1. Pega os dados de texto do formulário
    $user_id = $_SESSION['user_id'];
    $title = trim($_POST['title']);
    $category_id = $_POST['category_id'];
    $ingredients = trim($_POST['ingredients']);
    $preparation = trim($_POST['preparation']);
    
    // 2. Lógica para Upload da Imagem
    $image_path = ''; // Variável que vai guardar o caminho da imagem no banco

    if (isset($_FILES['image_upload']) && $_FILES['image_upload']['error'] == 0) {
        
        // Pega a extensão original do arquivo (ex: jpg, png)
        $extensao = pathinfo($_FILES['image_upload']['name'], PATHINFO_EXTENSION);
        
        // Cria um nome único para a imagem (ex: 64b5f8a9e2d1c.jpg) para evitar nomes duplicados
        $novo_nome = uniqid() . '.' . $extensao;
        
        // Define a pasta onde a imagem será salva
        $diretorio_destino = '../assets/img/uploads/';
        
        // Se a pasta não existir, o PHP cria ela automaticamente
        if (!is_dir($diretorio_destino)) {
            mkdir($diretorio_destino, 0777, true);
        }

        // Essa joça tenta mover o arquivo temporário para a pasta definitiva
        if (move_uploaded_file($_FILES['image_upload']['tmp_name'], $diretorio_destino . $novo_nome)) {
            // Se deu certo, o caminho que vai pro banco de dados é:
            $image_path = 'assets/img/uploads/' . $novo_nome;
        } else {
            // AQUI MUDOU: Volta uma página sem perder os textos digitados
            echo "<script>alert('Erro ao salvar a imagem na pasta.'); history.back();</script>";
            exit;
        }
    } else {
        // AQUI MUDOU: Volta uma página sem perder os textos digitados
        echo "<script>alert('Você precisa enviar uma imagem válida!'); history.back();</script>";
        exit;
    }

    // 3. Prepara a inserção no banco de dados (agora usando o $image_path)
    try {
        $stmt = $conn->prepare("INSERT INTO recipes (user_id, category_id, title, ingredients, preparation, image_url, status) 
                                VALUES (:user_id, :category_id, :title, :ingredients, :preparation, :image_url, 'pending')");
        
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':ingredients', $ingredients);
        $stmt->bindParam(':preparation', $preparation);
        $stmt->bindParam(':image_url', $image_path); // onde salva o caminho da foto upada

        // aqui a caçamba executa e avisa o usuário
        if ($stmt->execute()) {
            // SUCESSO: Como deu tudo certo, aí sim a gente tira o cara dessa página e joga na Home!
            echo "<script>alert('Mamma mia! Sua receita foi enviada com sucesso e já está na área de votação!'); window.location.href='../index.php';</script>";
        } else {
            // AQUI MUDOU: Deu erro? Volta sem perder os dados
            echo "<script>alert('Ops, ocorreu um erro ao salvar sua receita. Tente novamente.'); history.back();</script>";
        }

    } catch(PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>