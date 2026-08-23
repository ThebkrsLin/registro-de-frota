<?php

class MotoristaRepository{
    private PDO $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function cadastrarMotorista(Motorista $motor): void{
        $salvar = "INSERT INTO motoristas(nome, cpf, ativo, created_at, updated_at) VALUES(
        :nome, :cpf, :ativo, :created_at, :updated_at)";
        $stmt = $this->pdo->prepare($salvar);
        $stmt->execute([
            "nome"       => $motor->getNome(),
            "cpf"        => $motor->getCpf(),
            "ativo"      => $motor->getAtivo(),
            "created_at" => $motor->getCreatedAt(),
            "updated_at" => $motor->getUpdatedAt()
        ]);
    }

    public function buscarId(int $id): ?Motorista{
        $buscarid = "SELECT * FROM motoristas WHERE id = :id";
        $stmt = $this->pdo->prepare($buscarid);
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
        $buscarCpf = "SELECT * FROM motoristas WHERE cpf = :cpf";
        $stmt = $this->pdo->prepare($buscarCpf);
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

    public function listarMotoristas(): array{
        $lista = "SELECT * FROM motoristas";
        $stmt = $this->pdo->prepare($lista);
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

    public function atualizarMotorista(int $id, string $nome): void{
        $motorista = $this->buscarId($id);

        if($motorista === null){
            throw new Exception("O Motorista não foi encontrado!!!");
        }

        $motorista->atualizarNome($nome);
        $atualizar = "UPDATE motoristas 
        SET nome = :nome, updated_at = :updated_at
        WHERE id = :id";

        $stmt = $this->pdo->prepare($atualizar);
        $stmt->execute([
            "nome" => $motorista->getNome(),
            "updated_at" => $motorista->getUpdatedAt(),
            "id"   => $motorista->getId()
        ]);
    }

    public function inativarMotorista(int $id): void{
        $motorista = $this->buscarId($id);

        if($motorista === null){
            throw new Exception("Motorista não encontrado!!");
        }

        $motorista->inativar();
        $atualizar = "UPDATE motoristas
        SET ativo = :ativo, updated_at = :updated_at
        WHERE id = :id";

        $stmt = $this->pdo->prepare($atualizar);
        $stmt->execute([
            "id" => $motorista->getId(),
            "ativo" => $motorista->getAtivo(),
            "updated_at" => $motorista->getUpdatedAt()
        ]);
    }

}