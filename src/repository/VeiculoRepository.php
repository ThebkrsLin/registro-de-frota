<?php
class VeiculoRepository{
    private PDO $pdo;

    public function __construct(PDO $pdo){
        $this->pdo = $pdo;
    }

    public function cadastrarVeiculo(Veiculo $veiculo): void{
        $cadastrar = "INSERT INTO veiculos(placa, marca, modelo, ativo, ano, created_at, updated_at)
        VALUES(:placa, :marca, :modelo, :ativo, :ano, :created_at, :updated_at)";

        $stmt = $this->pdo->prepare($cadastrar);
        $stmt->execute([
            "placa"        => $veiculo->getPlaca(),
            "marca"        => $veiculo->getMarca(),
            "modelo"       => $veiculo->getModelo(),
            "ativo"        => $veiculo->getAtivo(),
            "ano"          => $veiculo->getAno(),
            "created_at"   => $veiculo->getCreatedAt(),
            "updated_at"   => $veiculo->getUpdatedAt(),
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
            $res["id"], $res["placa"], $res["modelo"], $res["marca"], $res["ano"], $res["created_at"], $res["updated_at"], $res["ativo"]
        );
        return $veiculo;
    }

    public function buscarVeiculoPorMotorista(int $mid): ?Veiculo{
        $buscar = "SELECT v.*
               FROM veiculos v
               INNER JOIN veiculo_motorista vm
                   ON vm.veiculo_id = v.id
               WHERE vm.motorista_id = :motorista_id
               AND vm.data_fim IS NULL";

        $stmt = $this->pdo->prepare($buscar);

        $stmt->execute([
            "motorista_id" => $mid
        ]);

        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        if($res === false){
            return null;
        }

        return Veiculo::reconstruirVeiculo(
            $res["id"],
            $res["placa"],
            $res["modelo"],
            $res["marca"],
            $res["ano"],
            $res["created_at"],
            $res["updated_at"],
            $res["ativo"]
        );
    }

    public function buscarPlaca(string $placa): ?Veiculo{

        $sql = "SELECT * FROM veiculos
                WHERE placa = :placa";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            "placa" => $placa
        ]);

        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        if($res === false){
            return null;
        }

        return Veiculo::reconstruirVeiculo(
            $res["id"],
            $res["placa"],
            $res["modelo"],
            $res["marca"],
            $res["ano"],
            $res["created_at"],
            $res["updated_at"],
            $res["ativo"]
        );
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

    public function listarVeiculos(): array{
        $listar = "SELECT * FROM veiculos";
        $stmt = $this->pdo->prepare($listar);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $veiculos = [];

        foreach($res as $v){
            $veiculos[] = Veiculo::reconstruirVeiculo(
                $v["id"], $v["placa"], $v["modelo"], $v["marca"], $v["ano"], $v["created_at"], $v["updated_at"], $v["ativo"]
            );
        }

        return $veiculos;
    }

    public function criarAssociacao(int $veiculoId, int $motoristaId): void{
        $sql = "INSERT INTO veiculo_motorista
                (veiculo_id, motorista_id, data_inicio)
                VALUES (:veiculo_id, :motorista_id, :data_inicio)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            "veiculo_id" => $veiculoId,
            "motorista_id" => $motoristaId,
            "data_inicio" => date("Y-m-d H:i:s")
        ]);
    }

    public function encerrarAssociacao(int $id, int $motorid): void{
        $sql = "UPDATE veiculo_motorista
                SET data_fim = :data_fim
                WHERE veiculo_id = :veiculo_id
                AND motorista_id = :motorista_id
                AND data_fim IS NULL";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            "veiculo_id" => $id,
            "motorista_id" => $motorid,
            "data_fim" => date("Y-m-d H:i:s")
        ]);
    }

    public function atualizarVeiculo(Veiculo $veiculo): void{
        $atualizar= "UPDATE veiculos
        SET placa = :placa, modelo = :modelo, 
        marca = :marca, ano = :ano, ativo = :ativo, 
        updated_at = :updated_at
        WHERE id = :id";
        $stmt = $this->pdo->prepare($atualizar);
        $stmt->execute([
            "id"           => $veiculo->getId() ,
            "placa"        => $veiculo->getPlaca(),
            "marca"        => $veiculo->getMarca(),
            "modelo"       => $veiculo->getModelo(),
            "ano"          => $veiculo->getAno(),
            "ativo"        => $veiculo->getAtivo(),
            "updated_at"   => $veiculo->getUpdatedAt(),
        ]);
    }
}