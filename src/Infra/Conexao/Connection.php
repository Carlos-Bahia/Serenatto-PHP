<?php

namespace Serenatto\Infra\Conexao;

use PDO;

class Connection
{
    public static function conectar(): PDO
    {
        $connection = new PDO('mysql:host=localhost;dbname=serenatto;port=3307', 'root', '');

        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $connection;
    }
}
