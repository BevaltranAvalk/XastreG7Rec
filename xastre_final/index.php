<?php
include('php/connect.php');
$message = "";
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

        $sql_code = "SELECT * FROM usuarios WHERE email = '$email' and senha = '$senha'";
        $sql_query = $mysqli->query($sql_code) or die("falha no sql");
        session_start();
        
        $quantidade = $sql_query->num_rows;
        $usuario = $sql_query->fetch_assoc();
        
        

        if ($quantidade == 1) {
            $_SESSION['id'] = $usuario['id']; 
            $_SESSION['CARGO'] = $usuario['CARGO']; 

            if ($_SESSION['CARGO'] == 'admin') {
                header("Location: admin.html");
                exit;
            } elseif ($_SESSION['CARGO'] == 'aluno') {
                header("Location: aluno.html");
                exit;
            } elseif ($_SESSION['CARGO'] == 'empresa') {
                header("Location: empresa.html");
                exit;
            } elseif ($usuario['CARGO'] == 'mentor') {
                header("Location: mentor.html");
                exit;
            }
        } else {
            $message = "Usuário ou senha incorretos!";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trabalho final</title>
</head>
<body>
    <div class="login_container">
        <div class="login_css">
            <div class="form_wrapper">
                <div class="entrar">
                    <form action="" method="post">
                        <h1>LOGIN</h1>
                        <label style for="email" class="label">Email</label>
                        <br>
                        <input type="text" id="email" name="email">
                        <br>
                        <label for="senha" class="label">Senha</label>
                        <br>
                        <input type="password" id="senha" name="senha">
                        <br>
                        <button type="submit">ENTRAR</button>
                    </form>
                    <form action="php/cadastro.php">
                    <button type="submit">CADASTRO</button>
                    
                    </form>
                    <p><?php echo $message; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>