<?php

session_start();

if (!isset($_SESSION['logado']) ||
    $_SESSION['logado'] != true)
{
    setcookie('message', 'Acesso negado!');
    header('Location: login.php');
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="shortcut icon" href="data:image/x-icon;," type="image/x-icon">

    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />

</head>

<body class="grey lighten-4">
    <h1>Olá dev<b>Raíz</b>, seja bem vindo!</h1>   
</body>

</html>

<!-- Compiled and minified JavaScript -->
<script src="js/jquery-3.2.1.min.js"></script>

<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="js/materialize.min.js"></script>