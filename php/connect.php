<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

$mysqli = new mysqli($servername, $username, $password, $dbname);

if ($mysqli->error) {
    die("Erro na conexão com o banco de dados: " . $mysqli -> error);
}