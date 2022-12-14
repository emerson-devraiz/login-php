<?php

session_start();

require 'connection/connection.php';

$conn = connection();

if (isset($_COOKIE['message'])) {
    $message = $_COOKIE['message'];
    setcookie('message', '', -1, '/');
}

if (isset($_POST['btnAcessar'])) {
    $email    = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

    $sqlExistEmail  = "SELECT *
                       FROM client
                       WHERE (email = '$email');";
    $queryExistEmail = mysqli_query($conn, $sqlExistEmail) or die('Erro SQL: queryExistEmail');
    $dataExistEmail  = mysqli_fetch_assoc($queryExistEmail);

    if (empty($dataExistEmail) === true) {
        echo "<script>
                alert('E-mail não encontrado!');
                location.href = 'login.php';
              </script>";
        exit;
    }

    if (password_verify($password, $dataExistEmail['password']) === false) {
        echo "<script>
                alert('Senha inválida!');
                location.href = 'login.php';
              </script>";
        exit;
    }

    $_SESSION['logged'] = true;
    header('Location: home.php');

} else {
    if (isset($_SESSION['logged'])) {
        unset($_SESSION['logged']);
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
                    <input id="password" name="password" type="password" maxlength="50" obrigatorio="true" nome-validar="Senha" value="">
                    <label for="password">Senha</label>
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