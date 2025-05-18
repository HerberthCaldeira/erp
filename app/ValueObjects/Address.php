<?php

namespace App\ValueObjects;

class Address
{
    public function __construct(
        public string $cep,
        public string $logradouro,
        public ?string $complemento = null,
        public ?string $unidade = null,
        public string $bairro,
        public string $localidade,
        public string $uf,
        public string $estado,
        public string $regiao,
        public string $ibge,
        public ?string $gia = null,
        public string $ddd,
        public string $siafi
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['cep'],
            $data['logradouro'],
            $data['complemento'] ?? null,
            $data['unidade'] ?? null,
            $data['bairro'],
            $data['localidade'],
            $data['uf'],
            $data['estado'],
            $data['regiao'],
            $data['ibge'],
            $data['gia'] ?? null,
            $data['ddd'],
            $data['siafi']
        );
    }

}