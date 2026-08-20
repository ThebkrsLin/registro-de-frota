<?php

$host = 'localhost';
$db   = 'cadastro';
$user = 'root';
$password = '';

try{
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("Erro na conexão ". $e->getMessage());
}
$stmt = $pdo->prepare("SELECT * FROM pessoa");
$stmt->execute();
$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($resultado as $pessoas){
    echo "{$pessoas['id']} -> {$pessoas['nome']}<br>";
}
