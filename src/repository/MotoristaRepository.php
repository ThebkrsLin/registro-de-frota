<?php

class MotoristaRepository{
    private PDO $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function cadastrarMotorista(Motorista $motor): void{
        $sql = "INSERT INTO motoristas(nome, cpf, ativo, created_at, updated_at) VALUES(
        :nome, :cpf, :ativo, :created_at, :updated_at)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            "nome"       => $motor->getNome(),
            "cpf"        => $motor->getCpf(),
            "ativo"      => $motor->getAtivo(),
            "created_at" => $motor->getCreatedAt(),
            "updated_at" => $motor->getUpdatedAt()
        ]);
    }

    public function buscarId(int $id): ?Motorista{
        $sql = "SELECT * FROM motoristas WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            "id" => $id
        ]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if($res === false){
            return null;
        }
        $motorista = Motorista::reconstruirMotorista(
            $res["id"], $res["nome"], $res["cpf"], $res["ativo"], $res["created_at"], $res["updated_at"]
        );
        return $motorista;
    }

    public function buscarCpf(string $cpf): ?Motorista{
        $sql = "SELECT * FROM motoristas WHERE cpf = :cpf";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            "cpf" => $cpf
        ]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if($res === false){
            return null;
        }

        $motorista = Motorista::reconstruirMotorista(
            $res["id"], $res["nome"], $res["cpf"], $res["ativo"], $res["created_at"], $res["updated_at"]
        );
        return $motorista;

    }

    public function buscarMotoristaPorVeiculo(int $veiculoId): ?Motorista
    {
        $sql = "SELECT m.*
                FROM motoristas m
                INNER JOIN veiculo_motorista vm
                    ON vm.motorista_id = m.id
                WHERE vm.veiculo_id = :veiculo_id
                AND vm.data_fim IS NULL";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            "veiculo_id" => $veiculoId
        ]);

        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($res === false) {
            return null;
        }

        return Motorista::reconstruirMotorista(
            $res["id"],
            $res["nome"],
            $res["cpf"],
            $res["ativo"],
            $res["created_at"],
            $res["updated_at"]
        );
    }



    public function listarMotoristas(): array{
        $sql = "SELECT * FROM motoristas";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $motoristas = [];

        foreach($res as $motor){
            $motoristas[] = Motorista::reconstruirMotorista(
            $motor["id"], $motor["nome"], $motor["cpf"], $motor["ativo"], $motor["created_at"], $motor["updated_at"]
            );
        }

        return $motoristas;
    }

    public function atualizarMotorista(Motorista $motorista): void{
        $sql = "UPDATE motoristas 
        SET nome = :nome, updated_at = :updated_at
        WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            "nome" => $motorista->getNome(),
            "updated_at" => $motorista->getUpdatedAt(),
            "id"   => $motorista->getId()
        ]);
    }

}