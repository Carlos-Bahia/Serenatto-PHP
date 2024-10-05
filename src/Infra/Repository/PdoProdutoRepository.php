<?php

namespace Serenatto\Infra\Repository;

use PDO;
use Serenatto\Infra\Conexao\Connection;
use Serenatto\Model\Produto;
use Serenatto\Repository\ProdutoRepository;

class PdoProdutoRepository implements ProdutoRepository
{
    private PDO $conexao;

    public function __construct(?PDO $conexao)
    {
        if(!($conexao instanceof PDO)){
            $conexao = Connection::conectar();
        }
        $this->conexao = $conexao;
    }

    public function salvarProduto(Produto $produto): bool
    {
        if($produto->getId() == null){
            return $this->inserirProduto($produto);

        } else {
            return $this->atualizarProduto($produto);
        }
    }

    private function inserirProduto(Produto $produto): bool
    {
        $sql = "INSERT INTO produtos (tipo, nome, descricao, imagem, preco) VALUES (:tipo, :nome, :descricao, :imagem, :preco)";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':tipo', $produto->getTipo());
        $stmt->bindValue(':nome', $produto->getNome());
        $stmt->bindValue(':descricao', $produto->getDescricao());
        $stmt->bindValue(':imagem', $produto->getImagem());
        $stmt->bindValue(':preco', $produto->getPreco());

        return $stmt->execute();
    }

    private function atualizarProduto(Produto $produto): bool
    {
        $sql = "UPDATE produtos SET tipo = :tipo, nome = :nome, descricao = :descricao, imagem = :imagem, preco = :preco WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':tipo', $produto->getTipo());
        $stmt->bindValue(':nome', $produto->getNome());
        $stmt->bindValue(':descricao', $produto->getDescricao());
        $stmt->bindValue(':imagem', $produto->getImagem());
        $stmt->bindValue(':preco', $produto->getPreco());
        $stmt->bindValue(':id', $produto->getId());

        return $stmt->execute();
    }

    public function deletarProduto(int $id): bool
    {
        $sql = "DELETE FROM produtos WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':id', $id);

        return $stmt->execute();
    }

    public function produtoPorId(int $idProduto): Produto
    {
        $sql = "SELECT * FROM produtos WHERE id = :id";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindValue(':id', $idProduto);
        $stmt->execute();

        $dadosProduto = $stmt->fetch();

        $produto = new Produto(
            $dadosProduto["id"],
            $dadosProduto["tipo"],
            $dadosProduto["nome"],
            $dadosProduto["descricao"],
            $dadosProduto["preco"],
            $dadosProduto["imagem"]
        );

        return $produto;
    }

    public function todosProdutos(): array
    {
        $sql = "SELECT * FROM produtos ORDER BY preco";
        $stmt = $this->conexao->prepare($sql);
        $stmt->execute();

        return $this->hidratarListaProdutos($stmt);
    }

    public function produtosDeCafeDaManha(): array
    {
        return $this->produtosPorTipo("Café");
    }

    public function produtosDeAlmoco(): array
    {
        return $this->produtosPorTipo("Almoço");
    }

    private function produtosPorTipo(string $tipo): array
    {
        $sql = 'SELECT * FROM produtos WHERE tipo = :tipo ORDER BY preco';
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->execute();

        return $this->hidratarListaProdutos($stmt);
    }

    private function hidratarListaProdutos(\PDOStatement $stmt): array
    {
        $dadosProdutos = $stmt->fetchAll();
        $listaProdutos = array();

        foreach ($dadosProdutos as $dadosProduto) {
            $listaProdutos[] = new Produto(
                $dadosProduto["id"],
                $dadosProduto["tipo"],
                $dadosProduto["nome"],
                $dadosProduto["descricao"],
                $dadosProduto["preco"],
                $dadosProduto["imagem"]
            );
        }

        return $listaProdutos;
    }

}
