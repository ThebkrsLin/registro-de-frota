<?php

class Vehicles{
    private string $placa;
    private string $modelo;
    private string $marca;
    private bool $ativo;
    private int $ano;
    private string $created_at;
    private string $updated_at;

    public function __construct(string $p, string $m, string $marca, int $ano){
        $this->placa = $this->validar($p);
        $this->modelo = $this->validar($m);
        $this->marca = $this->validar($marca);
        $this->ativo = true;
        $this->ano = $ano;
        $this->created_at = date("Y/m/d H:i:s");
        //e o resto menos o updated_at
    }

    private function validar($v){
        if($v === ''){
            throw new Exception("O dado digitado é inválido");

        }
        return $v;
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
    public function getUpdatedAt(): string {
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
}