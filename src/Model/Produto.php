<?php

namespace Serenatto\Model;

class Produto
{
    private ?int $id;
    private string $tipo;
    private string $nome;
    private string $descricao;
    private float $preco;
    private string $imagem;

    /**
     * @param int|null $id
     * @param string $tipo
     * @param string $nome
     * @param string $descricao
     * @param float $preco
     * @param string $imagem
     */
    public function __construct(?int $id, string $tipo, string $nome, string $descricao, float $preco, string $imagem = "logo-serenatto.png")
    {
        $this->id = $id;
        $this->tipo = $tipo;
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->preco = $preco;
        $this->imagem = $imagem;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getTipo(): string
    {
        return $this->tipo;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function getPreco(): float
    {
        return $this->preco;
    }

    public function getImagem(): string
    {
        return $this->imagem;
    }

    public function setImagem(string $imagem): void
    {
        $this->imagem = $imagem;
    }

    public function getPrecoFormatado(): string
    {
        return "R$ " .  number_format($this->preco, 2, ',', '.');
    }

    public function getImagemFormatado(string $diretorio): string
    {
        return $diretorio . $this->imagem;
    }
}
