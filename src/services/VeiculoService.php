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

    public function cadastrarVeiculo(string $p, string $mod, string $mar, int $ano): void{
        $veiculoExistente = $this->vRepo->buscarPlaca($p);

        if($veiculoExistente !== null){
            throw new Exception("Já existe um veículo com esta placa!");
        }
        
        $veiculo = new Veiculo($p, $mod, $mar, $ano);
        $this->vRepo->cadastrarVeiculo($veiculo);
    }

    public function associarMotorista(int $id, int $motorid): void{

        $v = $this->vRepo->buscarId($id);

        if($v === null){
            throw new Exception("Veiculo não encontrado!!!");
        }

        if(!$v->getAtivo()){
            throw new Exception("O veículo está inativo!");
        }

        $m = $this->mRepo->buscarId($motorid);

        if($m === null){
            throw new Exception("Motorista não encontrado!!");
        }

        if(!$m->getAtivo()){
            throw new Exception("O motorista está inativo!");
        }

        $veiculoAtual = $this->vRepo->buscarVeiculoPorMotorista($motorid);

        if($veiculoAtual !== null){
            throw new Exception("Este motorista já está associado a outro veículo!");
        }
        $this->vRepo->criarAssociacao($v->getId(), $motorid);
    }

    public function desassociarMotorista(int $id, int $motorid): void{
       $v = $this->vRepo->buscarId($id);

        if ($v === null) {
            throw new Exception("Veiculo não encontrado!!!");
        }

        $m = $this->mRepo->buscarId($motorid);

        if ($m === null) {
            throw new Exception("Motorista não encontrado!!");
        }

        $veiculoAtual = $this->vRepo->buscarVeiculoPorMotorista($motorid);

        if ($veiculoAtual === null || $veiculoAtual->getId() !== $id) {
            throw new Exception("Este motorista não está associado a este veículo!");
        }

        $this->vRepo->encerrarAssociacao($id, $motorid);
    }

    public function buscarVeiculoPorMotorista(int $id): ?Motorista{
        return $this->vRepo->buscarMotoristaPorVeiculo($id);
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
        $vPlaca = $this->vRepo->buscarPlaca($placa);

        if($veiculo === null){
            throw new Exception("Veiculo não encontrado!!!");
        }

        if($vPlaca !== null && $vPlaca->getId() !== $id){
            throw new Exception("A placa já existe!!!");
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

    public function buscarMotoristaPorVeiculo(int $id): ?Motorista
    {
        return $this->vRepo->buscarMotoristaPorVeiculo($id);
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