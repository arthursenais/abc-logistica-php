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

?>
<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Index | Relatórios</title>
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
                <h3 class="branco">adicionar relatório:</h3>
                <form  method="post" id="relatorio">
                Destinatário:
                    <select name="destinatario">
                        <?php 
                            $sql = "SELECT * FROM usuario WHERE id != {$usuario['id']}";
                            $resultado = $mysqli->query($sql);
                            while($row = mysqli_fetch_assoc($resultado))
                            {
                            echo "<option value='{$row['id']}'> {$row['nome']}</option>";
                            }
                        ?>
                    </select>
                    Conteúdo:
                    <input type="text" name="conteudo">
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
                echo "<h1 class='titulo'>{$usuario["nome"]}</h> <h2 class='titulo'>Seus relatórios</h2>"
            ?>
        </center>
        <div style="display:flex;flex-direction:column; gap: 50px; width: 100%;">
            <?php
                $sql = "SELECT id, conteudo_relatorio,data_relatorio,postado_por,destinatario FROM relatorio WHERE destinatario = {$_SESSION['id_usuario']} OR postado_por = {$_SESSION['id_usuario']}";
                
                $resultado = $mysqli->query($sql);
                if(mysqli_num_rows($resultado) == 0)
            {
                echo '<h1 class=dia sem-margem>Você não tem nenhum relatório</h1>';
            }
            else
            {
                while($row = mysqli_fetch_assoc($resultado))
                {

                    if ($row['postado_por'] == $_SESSION['id_usuario']){
                        echo '<div class="conteudo">
                    <div class="dia-mes">
                        <h1 class="dia">você:</h1>
                    </div>
                    <div class="cartao">
                    <div>
                    <p class="dia sem-margem">para: '. $row['destinatario'].'</p>
                        <h3 class="sem-margem">'. $row['conteudo_relatorio'].'</h3>
                        <p class="dia sem-margem">'. strftime('%d/%m/%y - %R
                        ',strtotime($row['data_relatorio'])).'</p>
                    </div>
                        <form method="post">
                    
                            <input type="hidden" name="id" value="'.$row['id'].'">
                            
                            <input type="submit" value="Remover" name="remover"> </form>

                    </div>
                </div>'; 
                    } else{

                    echo '<div class="conteudo">
                    <div class="dia-mes">
                        <h1 class="dia">de '. $row['postado_por'] .':</h1>
                    </div>
                    <div class="cartao">
                    <div>
                    <p class="dia sem-margem">para: você</p>
                        <h3 class="sem-margem">'. $row['conteudo_relatorio'].'</h3>
                        <p class="dia sem-margem">'. strftime('%d/%m/%y - %H:%M',strtotime($row['data_relatorio'])).'</p>
                    </div>
                        <form method="post">
                
                            <input type="hidden" name="id" value="'.$row['id'].'">
                            
                            <input type="submit" value="Remover" name="remover"> </form>

                    </div>
                </div>'; }
                }
            }
    
            if (isset($_POST['adicionar'])){  
                $data = date('Y-m-d H:i:s');
                $_POST['conteudo'] = htmlspecialchars($_POST['conteudo']);
                $nome = $_POST['destinatario'];
                $sql = "INSERT INTO relatorio (conteudo_relatorio,data_relatorio,postado_por,destinatario) VALUES ('{$_POST['conteudo']}','{$data}',{$_SESSION['id_usuario']}, {$nome})";
                $resultado = $mysqli->query($sql);
                if ($resultado){header('Location: relatorios.php');}
                };
            if (isset($_POST['remover'])){
                $id = $_POST['id'];
                $sql = "DELETE FROM relatorio WHERE id = {$id}";
                $resultado = $mysqli->query($sql);
                if ($resultado){header('Location: relatorios.php');}
                };
            ?>
            
            
        </div>
        </div>
         </div>
        </div>
    </div>
    <footer>
           <p> © Copyright 2022 :: ABC Logística :: Todos os direitos reservados </p>
            <p> CPF/CNPJ: <?php echo $_SESSION['cpf']?> </p>
            <img src="img/abclogistica.png">
        </footer>
</body>
</html>