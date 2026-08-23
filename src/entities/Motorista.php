<?php

class Motorista{
    private ?int $id;
    private string $nome;
    private string $cpf;
    private bool $ativo;
    private string $created_at;
    private ?string $updated_at;

    public function __construct(string $nome, string $cpf)
    {
        $this->id = null;
        $this->nome = $this->validarNome($nome);
        $this->cpf = $this->validarCpf($cpf);
        $this->ativo = true;
        $this->created_at = date("Y-m-d H:i:s");
        $this->updated_at = null;
    }

    public static function reconstruirMotorista(int $id, string $nome, string $cpf, bool $ativo, string $data, ?string $up): Motorista{
        $motorista = new Motorista($nome, $cpf);
        $motorista->id = $id;
        $motorista->created_at = $data;
        $motorista->ativo = $ativo;
        
        if($up !== null){
            $motorista->updated_at = $up;
        }

        return $motorista;
    }

    private function validarNome(string $v): string{
        if(trim($v) != ''){
            return trim($v);
        }

        throw new Exception("O dado Registrado é inválido");
    }

    private function validarCpf(string $cpf): string{
        if($cpf === ''){
            throw new Exception("O dado digitado está inválido!!!");
        }

        if(mb_strlen($cpf) == 11){
            $cpf_formatado = preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "$1.$2.$3-$4", $cpf);
            return $cpf_formatado;
        }

        if(mb_strlen($cpf) == 14 && preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "$1.$2.$3-$4", $cpf)){
            return $cpf;
        }

        throw new Exception("O cpf digitado é inválido!!");
        
    }

    private function registrarAtualizacao(): void{
        $this->updated_at = date("Y-m-d H:i:s");
    }

    public function inativar(): void{
        if($this->ativo){
            $this->ativo = false;
            $this->registrarAtualizacao();
        }

    }

    public function atualizarNome(string $nome): void{
        $this->nome = $this->validarNome($nome);
        $this->registrarAtualizacao();
    }

    // Metodos Acessores
    public function getId(): ?int{
        return $this->id;
    }

    public function getNome(): string{
        return $this->nome;
    }

    public function getCpf(): string{
        return $this->cpf;
    }

    public function getAtivo(): bool{
        return $this->ativo;
    }

    public function getCreatedAt(): string{
        return $this->created_at;
    }

    public function getUpdatedAt(): ?string{
        return $this->updated_at;
    }
    
}