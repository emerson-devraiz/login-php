<?php

session_start();

require 'conexao/conexao.php';

if (isset($_COOKIE['message'])) {
    $message = $_COOKIE['message'];
    setcookie('message', '', -1, '/login');
}

if (isset($_POST['btnAcessar'])) {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sqlLogin = "SELECT *
                 FROM cliente
                 WHERE (email = '$email')
                 AND   (senha = '$senha');";
    $queryLogin = mysqli_query($conexao, $sqlLogin) or die('Erro SQL: queryLogin');
    $dadosLogin = mysqli_fetch_assoc($queryLogin);

    if ($dadosLogin) // Encontrou e-mail e senha?
    {
        $_SESSION['logado'] = true;
        header('Location: home.php');
    } else {
        echo "<script>alert('Usuário ou senha inválidos!');</script>";
    }
} else {
    if (isset($_SESSION['logado'])) {
        unset($_SESSION['logado']);
    }
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

    <link type="text/css" rel="stylesheet" href="css/custom-login.css" />

</head>

<body class="grey lighten-4 valign-wrapper">
    <form id="frmLogin" name="frmLogin" method="POST" class="full-width" autocomplete="off">
        <ul class="collection with-header">
            <li class="collection-header">
                <h5 class="center purple-text">AUTENTICAÇÃO</h5>
            </li>
            <li class="collection-item">
                <div class="input-field">
                    <input id="email" name="email" type="text" maxlength="50" obrigatorio="true" nome-validar="E-mail" value="emerson@devraiz.com.br">
                    <label for="email">E-mail</label>
                </div>
            </li>
            <li class="collection-item">
                <div class="input-field">
                    <input id="senha" name="senha" type="password" maxlength="50" obrigatorio="true" nome-validar="Senha" value="">
                    <label for="senha">Senha</label>
                </div>
            </li>
            <li class="collection-item center">
                <button class="btn waves-effect waves-light purple" preloader="true" type="submit" id="btnAcessar" name="btnAcessar" style="width: 150px;">
                    <span>acessar</span>
                    <div class="preloader-wrapper small-1 active hide">
                        <div class="spinner-layer spinner-white-only">
                            <div class="circle-clipper left">
                                <div class="circle"></div>
                            </div>
                            <div class="gap-patch">
                                <div class="circle"></div>
                            </div>
                            <div class="circle-clipper right">
                                <div class="circle"></div>
                            </div>
                        </div>
                    </div>
                </button>
            </li>
        </ul>
    </form>
</body>

</html>

<!-- Compiled and minified JavaScript -->
<script src="js/jquery-3.2.1.min.js"></script>

<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="js/materialize.min.js"></script>

<script type="text/javascript" src="js/validacao.js"></script>

<?php if (isset($message)) : ?>
    <script>
        Materialize.toast('<?= $message; ?>', 4000, 'rounded red');
    </script>
<?php endif; ?>