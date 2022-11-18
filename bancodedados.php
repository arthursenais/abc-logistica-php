<?php

$host = "localhost";
$dbnome = "login_db";
$usuario = "root";
$senha =  "";

$mysqli = new mysqli($host,$usuario,$senha,$dbnome);
if ($mysqli->connect_errno) {
    die("Erro de conexão:  $mysqli->connect_error");
}


return $mysqli;

?>