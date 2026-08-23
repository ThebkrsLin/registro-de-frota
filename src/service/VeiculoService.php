<?php

require_once __DIR__."/../repository/VeiculoRepository.php";
require_once __DIR__."/../repository/MotoristaRepository.php";
require_once __DIR__."/../entities/Veiculo.php";

class VeiculoService{
    private VeiculoRepository $vRepo;
    private MotoristaRepository $mRepo;


    public function __construct(PDO $pdo){
        $this->vRepo = new VeiculoRepository($pdo);
        $this->mRepo = new MotoristaRepository($pdo);
    }

    public function cadastrarVeiculo(string $p, string $mod, string $mar, int $ano, ?int $mid): void{
        if($mid !== null){
            $m = $this->mRepo->buscarId($mid);

            if($m === null){
                throw new Exception("Motorista não encontrado!!");
            }

            if(!$m->getAtivo()){
                throw new Exception("O veículo não pode ser associado a um motorista inativo!!!");
            }
        }
        
        $veiculo = new Veiculo($p, $mod, $mar, $ano, $mid);
        $this->vRepo->cadastrarVeiculo($veiculo);
    }

    public function associarMotorista(int $id, int $motorid): void{
        $v = $this->vRepo->buscarId($id);
        $m = $this->mRepo->buscarId($motorid);
        if($v === null){
            throw new Exception("Veiculo não encontrado!!!");
        }

        if(!$v->getAtivo()){
            throw new Exception("O Motorista não poderá ser associado a este veiculo, pois este veiculo está inativo");
        }

        if($m === null){
            throw new Exception("Motorista não encontrado!!");
        }

        if(!$m->getAtivo()){
            throw new Exception("O Motorista não poderá ser associado a este veiculo pois o mesmo está inativo!!");
        }

        $v->associarMotorista($motorid);
        $this->vRepo->atualizarVeiculo($v);
    }

    public function listarVeiculos(): array{
        return $this->vRepo->listarVeiculos();
    }

    public function inativarVeiculo(int $id): void{
        $veiculo = $this->vRepo->buscarId($id);
        if($veiculo === null){
            throw new Exception("Veiculo não encontrado!!!");
        }

        $veiculo->inativar();
        $this->vRepo->atualizarVeiculo($veiculo);
    }

    public function atualizarPlaca(int $id, string $placa): void{
        $veiculo = $this->vRepo->buscarId($id);
        if($veiculo === null){
            throw new Exception("Veiculo não encontrado!!!");
        }

        $veiculo->atualizarPlaca($placa);
        $this->vRepo->atualizarVeiculo($veiculo);
    }

    public function atualizarModelo(int $id, string $v): void{
        $veiculo = $this->vRepo->buscarId($id);
        if($veiculo === null){
            throw new Exception("Veiculo não encontrado!!!");
        }

        $veiculo->atualizarModelo($v);
        $this->vRepo->atualizarVeiculo($veiculo);
    }

    public function atualizarMarca(int $id, string $v): void{
        $veiculo = $this->vRepo->buscarId($id);
        if($veiculo === null){
            throw new Exception("Veiculo não encontrado!!!");
        }

        $veiculo->atualizarMarca($v);
        $this->vRepo->atualizarVeiculo($veiculo);
    }

    public function atualizarAno(int $id, int $v): void{
        $veiculo = $this->vRepo->buscarId($id);
        if($veiculo === null){
            throw new Exception("Veiculo não encontrado!!!");
        }

        $veiculo->atualizarAno($v);
        $this->vRepo->atualizarVeiculo($veiculo);
    }


}