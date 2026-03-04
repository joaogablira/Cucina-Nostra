<?php
//config/database.php
$host = 'localhost';
$db_name = 'cucina_nostra';
$username = 'root'; 
$password = ''; 

try {
    $conn = new PDO("mysql:host={$host};dbname={$db_name};charset=utf8", $username, $password);
    //configura o PDO para lançar exceções em caso de erro
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $exception) {
    echo "Erro de conexão: " . $exception->getMessage();
    exit;
}
?>