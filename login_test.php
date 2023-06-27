<?php
session_start();
include('php/connect.php');

function login($mysqli, $queryResult) {
    if ($queryResult->num_rows == 1) {
        $usuario = $queryResult->fetch_assoc();

        $_SESSION['ID'] = $usuario['ID'];
        $_SESSION['CARGO'] = $usuario['CARGO'];

        if ($_SESSION['CARGO'] == 'admin') {
            return "admin";
        } elseif ($_SESSION['CARGO'] == 'aluno') {
            return "aluno";
        } elseif ($_SESSION['CARGO'] == 'empresa') {
            return "empresa";
        } elseif ($_SESSION['CARGO'] == 'mentor') {
            return "mentor";
        }
    }
    else{
        return "erro";
    }
}

function testLogin($email, $senha) {
    global $mysqli;
    if (empty($email)) {
        return "Preencha o campo de email.";
    } elseif (empty($senha)) {
        return "Preencha o campo de senha.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Email inválido.";
    } else {
        $email = $mysqli->real_escape_string($email);
        $senha = $mysqli->real_escape_string($senha);

        $sql_code = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
        $sql_query = $mysqli->query($sql_code) or die("Falha na consulta SQL");

        return login($mysqli, $sql_query);
    }
}

$email = "admin@admin.com";
$senha = "12345";

$resultado = testLogin($email, $senha);

if ($resultado == "admin") {
    echo "Login bem-sucedido como administrador.";
} elseif ($resultado == "aluno") {
    echo "Login bem-sucedido como aluno.";
} elseif ($resultado == "empresa") {
    echo "Login bem-sucedido como empresa.";
} elseif ($resultado == "mentor") {
    echo "Login bem-sucedido como mentor.";
} else {
    echo "Falha no login: $resultado";
}
?>