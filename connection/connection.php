<?php

function connection($host = 'localhost', $usuario = 'root', $senha = 'maria123', $banco_dados = 'login_php')
{
    $conn = mysqli_connect($host, $usuario, $senha, $banco_dados);

    if (!$conn)
    {
        die('Erro na conexão com o MariaDB!');
    }

    return $conn;
}