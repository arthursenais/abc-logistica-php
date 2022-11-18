<?php
$l_invalido = false;
if($_SERVER["REQUEST_METHOD"] === "POST" ) {
    $msqli = require __DIR__ . "/bancodedados.php";

    $sql = sprintf("SELECT * FROM usuario WHERE cpfcnpj = '%s' ", $_POST["cpfcnpj"]);
    $resultado = $msqli->query($sql);
    $usuario =  $resultado->fetch_assoc();

    if ($usuario) {
        if(password_verify($_POST["senha"], $usuario["hash_senha"])) {
            session_start();
            session_regenerate_id();

            $_SESSION["cpf"] = $usuario["cpfcnpj"];
            $_SESSION["id_usuario"] = $usuario["id"];
            header('Location: index.php');
        }
    }
    $l_invalido = true;
}


?>
<!DOCTYPE html>
<html lang="pt_BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Logística login</title>
</head>

<body>
    <header>
    <img src="img/abclogistica.png">
    </header>
    <div class="wrapper">
        
  
    <div id="corpo1">
    <form id='formulario' method="post">
        <h1>Login </h1>     
        CPF/CNPJ:
        <input class="caixainput" type="text" name="cpfcnpj" value="<?php htmlspecialchars($_POST["cpfcnpj"] ?? "") ?>">
        Senha:
        <input class="caixainput" type="password" name='senha'>
        <?php if ($l_invalido):?>
        <em>Login inválido</em> <?php endif ?>
        <button id="botao">Entrar</button>
        <a href="registrar.html">Registrar-se</a>
    </form>
    
    </div>  </div>
    <footer>
           <p> © Copyright 2022 :: ABC Logística :: Todos os direitos reservados </p>
            <img src="img/abclogistica.png">
        </footer>
</body>

</html>
