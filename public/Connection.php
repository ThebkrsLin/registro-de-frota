<?php

class Connection{
    private PDO $pdo;

    public function __construct(string $host, string $database, string $user, string $password){
        try{
            $this->pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e){
            throw new Exception("Erro na conexão ".$e->getMessage());
        }
    }

    public function obterConexao(): PDO{
        return $this->pdo;
    }
}