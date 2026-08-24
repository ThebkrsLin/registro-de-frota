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

    public function __construct(string $placa, string $mod, string $marca, int $ano){

        $this->placa = $this->validar($placa);
        $this->modelo = $this->validar($mod);
        $this->marca = $this->validar($marca);
        $this->ano = $this->validarAno($ano);
        $this->created_at = date("Y-m-d H:i:ss");
        $this->created_at = date("Y-m-d H:i:s");

        $this->id = null;
        $this->ativo = true;
        $this->updated_at = null;
    }

    public static function reconstruirVeiculo(int $id, string $placa, string $mod, string $marca, int $ano,  string $data, ?string $up, bool $at): Veiculo{
        $carro = new Veiculo($placa, $mod, $marca, $ano);

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

    public function ativar(): void{
        if(!$this->ativo){
            $this->ativo = true;
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

}