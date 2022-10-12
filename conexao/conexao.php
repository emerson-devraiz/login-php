<?php

$host        = 'localhost';
$usuario     = 'root';
$senha       = 'maria123';
$banco_dados = 'login_php';

$conexao = mysqli_connect($host, $usuario, $senha, $banco_dados);

if (!$conexao)
{
    die('Erro na conexão com o MariaDB!');
}