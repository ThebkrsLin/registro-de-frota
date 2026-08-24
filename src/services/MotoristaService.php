<?php

require_once __DIR__."/../repository/MotoristaRepository.php";
require_once __DIR__."/../entities/Motorista.php";

class MotoristaService{
    private MotoristaRepository $mRepo;

    public function __construct(PDO $pdo){
        $this->mRepo = new MotoristaRepository($pdo);
    }

    public function cadastrarMotorista(string $nome, string $cpf): void{
        $motorista = $this->mRepo->buscarCpf($cpf);

        if($motorista !== null){
            throw new Exception("O Motorista já existe!");
        }

        $motorista = new Motorista($nome, $cpf);
        $this->mRepo->cadastrarMotorista($motorista);
    }

    public function buscarMotoristaPorVeiculo(int $vid): ?Motorista{
        return $this->mRepo->buscarMotoristaPorVeiculo($vid);
    }

    public function listarMotoristas(): array{
        return $this->mRepo->listarMotoristas();
    }

    public function atualizarNome(int $id, string $nome): void{
        $motorista = $this->mRepo->buscarId($id);

        if($motorista === null){
            throw new Exception("O motorista não foi encontrado!!");
        }

        $motorista->atualizarNome($nome);
        $this->mRepo->atualizarMotorista($motorista);
    }

    public function inativarMotorista(int $id): void{
        $motorista = $this->mRepo->buscarId($id);

        if($motorista === null){
            throw new Exception("O motorista não foi encontrado!!");
        }

        $motorista->inativar();
        $this->mRepo->atualizarMotorista($motorista);
    }
}