<?php

class VeiculoRepository{
    private PDO $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function cadastrarVeiculo(Veiculo $veiculo): void{
        $cadastrar = "INSERT INTO veiculos(placa, marca, modelo, ativo, ano, created_at, updated_at, motorista_id)
        VALUES(:placa, :marca, :modelo, :ativo, :ano, :created_at, :updated_at, :motorista_id)";

        $stmt = $this->pdo->prepare($cadastrar);
        $stmt->execute([
            "placa"        => $veiculo->getPlaca(),
            "marca"        => $veiculo->getMarca(),
            "modelo"       => $veiculo->getModelo(),
            "ativo"        => $veiculo->getAtivo(),
            "ano"          => $veiculo->getAno(),
            "created_at"   => $veiculo->getCreatedAt(),
            "updated_at"   => $veiculo->getUpdatedAt(),
            "motorista_id" => $veiculo->getMotoristaId()
        ]);
    }

    public function buscarId(int $id): ?Veiculo{
        $buscar = "SELECT * FROM veiculos WHERE id = :id";
        $stmt = $this->pdo->prepare($buscar);
        $stmt->execute([
            "id" => $id
        ]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        if($res === false){
            return null;
        }

        $veiculo = Veiculo::reconstruirVeiculo(
            $res["id"], $res["placa"], $res["modelo"], $res["marca"], $res["ano"], $res["created_at"], $res["updated_at"], $res["ativo"], $res["motorista_id"] 
        );
        return $veiculo;
    }

    public function associarMotorista(int $id, int $motorid): void{
        $veiculo = $this->buscarId($id);

        if($veiculo === null){
            throw new Exception("Veiculo não foi encontrado");
        }

        if($veiculo->getMotoristaId() == $motorid){
            return;
        }

        $veiculo->associarMotorista($motorid);

        $atualizar = "UPDATE veiculos 
        SET motorista_id = :motorista_id, updated_at = :updated_at
        WHERE id = :id";
        $stmt = $this->pdo->prepare($atualizar);
        $stmt->execute([
            "id" => $veiculo->getId(),
            "motorista_id" => $veiculo->getMotoristaId(),
            "updated_at" => $veiculo->getUpdatedAt()
        ]);
    }

    public function listarVeiculos(): array{
        $listar = "SELECT * FROM veiculos";
        $stmt = $this->pdo->prepare($listar);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $veiculos = [];

        foreach($res as $v){
            $veiculos[] = Veiculo::reconstruirVeiculo(
                $v["id"], $v["placa"], $v["modelo"], $v["marca"], $v["ano"], $v["created_at"], $v["updated_at"], $v["ativo"], $v["motorista_id"]
            );
        }

        return $veiculos;
    }

    public function atualizarVeiculo(Veiculo $veiculo): void{
        $atualizar= "UPDATE veiculos
        SET placa = :placa, modelo = :modelo, 
        marca = :marca, ano = :ano, updated_at = :updated_at, ativo = :ativo
        WHERE id = :id";
        $stmt = $this->pdo->prepare($atualizar);
        $stmt->execute([
            "id"         => $veiculo->getId() ,
            "placa"      => $veiculo->getPlaca(),
            "marca"      => $veiculo->getMarca(),
            "modelo"     => $veiculo->getModelo(),
            "ano"        => $veiculo->getAno(),
            "ativo"      => $veiculo->getAtivo(),
            "updated_at" => $veiculo->getUpdatedAt()
        ]);
    }
}