<?php

namespace Serenatto\Repository;

use Serenatto\Model\Produto;

interface ProdutoRepository
{
    public function todosProdutos(): array;
    public function produtosDeCafeDaManha(): array;
    public function produtosDeAlmoco(): array;
    public function produtoPorId(int $idProduto): Produto;
    public function salvarProduto(Produto $produto): bool;
    public function deletarProduto(int $id): bool;
}
