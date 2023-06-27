<?php
session_start();
include('php/connect.php');

$message = "";

function login() {
    global $mysqli, $message;

    if (isset($_POST["email"]) && isset($_POST["senha"])) {
        if (empty($_POST["email"])) {
            $message = "Preencha o campo de email.";
        } elseif (empty($_POST["senha"])) {
            $message = "Preencha o campo de senha.";
        } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $message = "Email inválido.";
        } else {       
            $email = $mysqli->real_escape_string($_POST["email"]);
            $senha = $mysqli->real_escape_string($_POST["senha"]);

            $sql_code = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
            $sql_query = $mysqli->query($sql_code) or die("Falha na consulta SQL");

            $quantidade = $sql_query->num_rows;
            $usuario = $sql_query->fetch_assoc();

            if ($quantidade == 1) {
                $_SESSION['ID'] = $usuario['ID'];
                $_SESSION['CARGO'] = $usuario['CARGO'];

                if ($_SESSION['CARGO'] == 'admin') {
                    $message = "Login bem-sucedido como admin.";
                } elseif ($_SESSION['CARGO'] == 'aluno') {
                    $message = "Login bem-sucedido como aluno.";
                } elseif ($_SESSION['CARGO'] == 'empresa') {
                    $message = "Login bem-sucedido como empresa.";
                } elseif ($_SESSION['CARGO'] == 'mentor') {
                    $message = "Login bem-sucedido como mentor.";
                }
            } else {
                $message = "Usuário ou senha incorretos!";
            }
        }
    }
}

// Realize testes manuais chamando a função de login com diferentes dados de entrada
// e verificando o comportamento esperado

// Teste 1: Teste de login bem-sucedido como admin
$_POST["email"] = "admin@example.com";
$_POST["senha"] = "admin123";
login();
echo $message . PHP_EOL;  // Esperado: "Login bem-sucedido como admin."

// Teste 2: Teste de login bem-sucedido como aluno
$_POST["email"] = "aluno@example.com";
$_POST["senha"] = "aluno123";
login();
echo $message . PHP_EOL;  // Esperado: "Login bem-sucedido como aluno."

// Teste 3: Teste de login bem-sucedido como empresa
$_POST["email"] = "empresa@example.com";
$_POST["senha"] = "empresa123";
login();
echo $message . PHP_EOL;  // Esperado: "Login bem-sucedido como empresa."

// Teste 4: Teste de login bem-sucedido como mentor
$_POST["email"] = "mentor@example.com";
$_POST["senha"] = "mentor123";
login();
echo $message . PHP_EOL;  // Esperado: "Login bem-sucedido como mentor."

// Teste 5: Teste de email vazio
$_POST["email"] = "";
$_POST["senha"] = "senha123";
login();
echo $message . PHP_EOL;  // Esperado: "Preencha o campo de email."

// Teste 6: Teste de senha vazia
$_POST["email"] = "test@example.com";
$_POST["senha"] = "";
login();
echo $message . PHP_EOL;  // Esperado: "Preencha o campo de senha."


$_POST["email"] = "invalid_email";
$_POST["senha"] = "senha123";
login();
echo $message . PHP_EOL;

$_POST["email"] = "invalid@example.com";
$_POST["senha"] = "wrongpassword";
login();
echo $message . PHP_EOL;
?>
