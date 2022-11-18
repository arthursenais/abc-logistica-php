<?php session_start();

if (isset($_SESSION["id_usuario"])){

    $mysqli = require __DIR__ . "/bancodedados.php";

    $sql = "SELECT * FROM usuario WHERE id = {$_SESSION['id_usuario']}";

    $resultado = $mysqli->query($sql);
    $usuario =  $resultado->fetch_assoc();

} else{
    header('Location: login.php');
}



setlocale(LC_TIME,'pt-BR','portuguese');
date_default_timezone_set('America/Sao_Paulo');
$hora= new DateTime('H',new DateTimeZone('America/sao_paulo'));

if ($hora->format('H') >= 5 and $hora->format('H') < 12){
    $cumprimentar = 'Bom dia';
} elseif ($hora->format('H') >= 12 and $hora->format('H') < 19){
    $cumprimentar = 'Boa tarde';
} else { 
    $cumprimentar = 'Boa noite';
}
?>
<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Index</title>
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
                        <h3 class="branco">adicionar agendamento:</h3>
                        <form  method="post">
                            nome:
                            <input type="text" name="nome">
                            data:
                            <input type="datetime-local" name="data">
                            <input type="submit" value="Adicionar" name="adicionar">
                        </form>
                    </div>
                </div>
            <div id="direita">
                <div class="cabecalho">
                    <h1 class="titulo" id="bemvindo">Bem vindo</h1>
                    <a href="sair.php" id="deslogar">Sair</a>
                </div>
                <center>
                    <?php 
                        echo "<h1 class='titulo'>{$cumprimentar}, {$usuario["nome"]}</h> <h2 class='titulo'>Seus agendamentos para esta semana</h2>"
                    ?>
                </center>
                <div style="display:flex;flex-direction:column; gap: 50px; width: 100%;">
                    <?php
                        $sql = "SELECT  id, conteudo_post,data_post,postado_por FROM agendamento WHERE postado_por = {$_SESSION['id_usuario']}";
                        $resultado = $mysqli->query($sql);
                        if(mysqli_num_rows($resultado) == 0)
                    {
                        echo '<h1 class=dia sem-margem>Você não agendou nada ainda</h1>';
                    }
                    else
                    {
                        while($row = mysqli_fetch_assoc($resultado))
                        {           
                            echo '<div class="conteudo">
                            <div class="dia-mes">
                                <h1 class="dia">'. strftime('%a',strtotime($row['data_post'])) .'</h1>
                                <h3 class="dia">'. strftime('%d %h',strtotime($row['data_post'])).'</h3>
                                <h3 class="dia">'. strftime('%R',strtotime($row['data_post'])).'</h3>
                            </div>
                            <div class="cartao">
                                <p>'. $row['conteudo_post'].'</p>
                                <form method="post">
                                    <input type="hidden" name="id" value="'.$row['id'].'">
                                    <input type="submit" value="Remover" name="remover"> </form>
                            </div>
                        </div>'; 
                        
                        }
                    }

                    if (isset($_POST['adicionar'])){  
                        $_POST['nome'] = htmlspecialchars($_POST['nome']);
                        $sql = "INSERT INTO agendamento (conteudo_post,data_post,postado_por) VALUES ('{$_POST['nome']}','{$_POST['data']}',{$_SESSION['id_usuario']})";
                        $resultado = $mysqli->query($sql);
                        if ($resultado){header('Location: index.php');}
                        };
                    if (isset($_POST['remover'])){
                        $sql = "DELETE FROM agendamento WHERE id = {$_POST['id']}";
                        $resultado = $mysqli->query($sql);
                        if ($resultado){header('Location: index.php');}

                        }
                    ?>
                    
                    
                </div>
                
                </div>
            
            </div>
    </div>
            <footer>
            <p> © Copyright 2022 :: ABC Logística :: Todos os direitos reservados </p>
                <p> CPF/CNPJ: <?php echo $_SESSION['cpf']?> </p>
                <img src="img/abclogistica.png">
            </footer>
        </div></div>
</body>
</html>