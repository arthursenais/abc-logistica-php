<?php session_start();

if (isset($_SESSION["id_usuario"])){

    $mysqli = require __DIR__ . "/bancodedados.php";

    $sql = "SELECT * FROM usuario WHERE id = {$_SESSION['id_usuario']}";

    $resultado = $mysqli->query($sql);
    $usuario =  $resultado->fetch_assoc();

} else{
    header('Location: login.php');
}

if (isset($_POST['submitsenha'])) {
    if (strlen($_POST["senha"]) < 5){
        die('O campo senha não pode ser vazio e nem menor que 5 caracteres');
    }
    if ($_POST["confirmarsenha"] !=  $_POST["senha"]){
        die("as senhas necessitam ser iguais");
    }
    $hash_senha = password_hash($_POST["senha"],PASSWORD_DEFAULT);
    $sql = "UPDATE usuario SET hash_senha = '{$hash_senha}' WHERE id={$usuario['id']}";
    $resultado = $mysqli->query($sql);
    if ($resultado){
        echo' <script> alert("Senha alterada com sucesso") </script>';
    }
}
if (isset($_POST['excluirconta'])) {
    if(password_verify($_POST["senha"], $usuario["hash_senha"])) {
        $sql = "DELETE FROM usuario WHERE id={$usuario['id']}";
        $resultado = $mysqli->query($sql);
        header("Location: sair.php");
    } else { echo '<script> alert("Não realizado. Senha incorreta")</script>';}
  
}

?>
<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Configurações | ABC logistica</title>
</head>
<body>
    <header>
        <img src="img/abclogistica.png">
    </header>
    <div class="wrapper">
        
 
    <div id="corpo">
    <div id="esquerda">
            <div id="categorias">
                <h1>Menu</h1>
                <a href="index.php">Agendamentos</a>
                <a href="relatorios.php">Relatórios</a>
                <a href="configuracoes.php">Configurações</a>
                <br>
            </div>
        
        </div>
    <div id="direita">
        <div class="cabecalho">
                    <h1 class="titulo" id="bemvindo">Bem vindo</h1>
                    <a href="sair.php" id="deslogar">Sair</a>
        </div>
        <center>
            <?php 
                echo "<h1 class='titulo'>Configurações</h1>"
            ?>
        </center>
        <div style="display:flex;flex-direction:column; gap: 50px; width: 100%;">
        <div><h2 class='sem-margem'><?php echo $usuario['nome'] ?></h2>
        <form method="post" id="form-deletar" class="sem-margem">
                <input  type="submit" value="Excluir conta" name="excluirconta" class="botao2">
                <input type="password" name="senha" placeholder="Senha p/ confirmar" style="padding: 5px">
        </form></div>
        
            <form method="post">
                <h3 style="margin-top: 0;">Mudar senha</h1>
                <label for="mudarSenha">Nova senha:</label>
                <input type="password" name="senha" style="padding: 5px">
                <label for="Confirmar senha">Confirmar senha:</label>
                <input type="password" name="confirmarsenha" style="padding: 5px">
                <input type="submit" value="Mudar senha" name="submitsenha" class="botao2">
            </form>
            <br><br>
            
            
        </div>
        </div>
        
        </div>
    </div>   </div>
    <footer>
           <p>© Copyright 2022 :: ABC Logística :: Todos os direitos reservados</p>
            <p> CPF/CNPJ: <?php echo $_SESSION['cpf']?> </p>
            <img src="img/abclogistica.png">
        </footer>
</body>
</html>