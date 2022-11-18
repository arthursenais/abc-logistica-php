<?php 
    if (empty($_POST["nome"])){
        die("Nome de usuário necessário");
    }
    if (empty($_POST["cpfcnpj"])){
        die("CPF/CNPJ necessário");
    }
    if (empty($_POST["cpfcnpj"]) or strlen($_POST["cpfcnpj"]) != 14 and strlen($_POST["cpfcnpj"]) != 11){
        die("Digite um CPF/CNPJ válido");
    }
    if (strlen($_POST["senha"]) < 5){
        die("Senha precisa ter no mínimo 5 caracteres");
    }
    if ($_POST["confirmarsenha"] !=  $_POST["senha"]){
        die("as senhas necessitam ser iguais");
    }
    $hash_senha = password_hash($_POST["senha"],PASSWORD_DEFAULT);
    
    $mysqli = require __DIR__ . "/bancodedados.php";


    $sql = "INSERT INTO usuario (nome,cpfcnpj,hash_senha) VALUES (?,?,?)";
    $stmt = $mysqli->stmt_init();
    if (! $stmt->prepare($sql)) {
        die("Erro SQL:" . $mysqli->error);
    }

    $stmt->bind_param("sss",$_POST["nome"],
                            $_POST["cpfcnpj"],
                            $hash_senha);
    if ($stmt->execute()) {
       header('Location: registrado-sucesso.html');
    } else {
        if ($mysqli->errno == 1062){
            die("cpf/cnpj já está sendo utilizado");
        } else{
            die($mysqli->error . " " . $mysqli->errno);
        }
    }
?>