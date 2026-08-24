<?php

class Veiculo{
    private ?int $id;
    private string $placa;
    private string $modelo;
    private string $marca;
    private bool $ativo;
    private int $ano;
    private string $created_at;
    private ?string $updated_at;
<<<<<<< Updated upstream
    private ?int $motorista_id;

    public function __construct(string $placa, string $mod, string $marca, int $ano, ?int $mid){
=======

    public function __construct(string $placa, string $mod, string $marca, int $ano){
>>>>>>> Stashed changes
        $this->placa = $this->validar($placa);
        $this->modelo = $this->validar($mod);
        $this->marca = $this->validar($marca);
        $this->ano = $this->validarAno($ano);
<<<<<<< Updated upstream
        $this->created_at = date("Y-m-d H:i:ss");
        $this->motorista_id = $mid;
=======
        $this->created_at = date("Y-m-d H:i:s");
>>>>>>> Stashed changes
        $this->id = null;
        $this->ativo = true;
        $this->updated_at = null;
    }

<<<<<<< Updated upstream
    public static function reconstruirVeiculo(int $id, string $placa, string $mod, string $marca, int $ano,  string $data, ?string $up, bool $at, ?int $mid): Veiculo{
        $carro = new Veiculo($placa, $mod, $marca, $ano, $mid);
=======
    public static function reconstruirVeiculo(int $id, string $placa, string $mod, string $marca, int $ano,  string $data, ?string $up, bool $at): Veiculo{
        $carro = new Veiculo($placa, $mod, $marca, $ano);
>>>>>>> Stashed changes
        $carro->id = $id;
        $carro->created_at = $data;
        $carro->ativo = $at;
        $carro->updated_at = $up;
        
        return $carro;
    }

    private function validar(string $v): string{
        if(trim($v) != ''){
            return trim($v);
        }
        
        throw new Exception("O dado digitado é inválido");
    }

    private function validarAno(int $ano): int{
        if($ano >= 2010 && $ano <= intval(date("Y"))){
            return $ano;
        }

        throw new Exception("O dado digitado é inválido!!");
    }

<<<<<<< Updated upstream
    public function associarMotorista(int $id): void{
        if($this->motorista_id !== null){
            throw new Exception("Este Veiculo já possui um motorista associado");
        }
            
        $this->registrarAtualizacao();
        $this->motorista_id = $id;

    }

    public function desassociarMotorista(): void{
        if($this->motorista_id === null){
            return;
        }

        $this->motorista_id = null;
        $this->registrarAtualizacao();
    }

=======
>>>>>>> Stashed changes
    private function registrarAtualizacao(): void{
        $this->updated_at = date("Y-m-d H:i:s");
    }

    public function atualizarPlaca(string $v): void{
        $this->placa = $this->validar($v);
        $this->registrarAtualizacao();
    }

    public function atualizarModelo(string $v): void{
        $this->modelo = $this->validar($v);
        $this->registrarAtualizacao();
    }

    public function atualizarMarca(string $v): void{
        $this->marca = $this->validar($v);
        $this->registrarAtualizacao();
    }

    public function atualizarAno(int $v): void{
        $this->ano = $this->validarAno($v);
       $this->registrarAtualizacao();
    }

    public function inativar(): void{
        if($this->ativo){
            $this->ativo = false;
            $this->registrarAtualizacao();
        }

    }

    /**
     * Get the value of modelo
     *
     * @return string
     */
    public function getModelo(): string {
        return $this->modelo;
    }

    /**
     * Get the value of marca
     *
     * @return string
     */
    public function getMarca(): string {
        return $this->marca;
    }

    /**
     * Get the value of ativo
     *
     * @return bool
     */
    public function getAtivo(): bool {
        return $this->ativo;
    }

    /**
     * Get the value of ano
     *
     * @return int
     */
    public function getAno(): int {
        return $this->ano;
    }

    /**
     * Get the value of created_at
     *
     * @return string
     */
    public function getCreatedAt(): string {
        return $this->created_at;
    }

    /**
     * Get the value of updated_at
     *
     * @return string
     */

    public function getUpdatedAt(): ?string {
        return $this->updated_at;
    }

    /**
     * Get the value of placa
     *
     * @return string
     */
    public function getPlaca(): string {
        return $this->placa;
    }

    /**
     * Set the value of updated_at
     *
     * @param ?string $updated_at
     *
     * @return self
     */


    /**
     * Get the value of id
     *
     * @return ?int
     */
    public function getId(): ?int {
        return $this->id;
    }

<<<<<<< Updated upstream
    public function getMotoristaId(): ?int{
        return $this->motorista_id;
    }
=======
>>>>>>> Stashed changes
}