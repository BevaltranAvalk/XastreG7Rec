<?php
include('connect.php');

if(isset($_POST["email"]) && isset($_POST["senha"])){
    if(empty($_POST["email"])){
        echo "Preencha o campo de email.";
    }
    elseif(empty($_POST["senha"])){
        echo "Preencha o campo de senha.";
    }
    elseif(!preg_match('/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/', $_POST["email"])){
        echo "Email inválido.";
    }
    else{
        $email = $mysqli->real_escape_string($_POST["email"]);
        $senha = $mysqli->real_escape_string($_POST["senha"]);

        // Verifica se o email já está cadastrado
        $emailExistsQuery = "SELECT * FROM usuarios WHERE email = '$email'";
        $emailExistsResult = $mysqli->query($emailExistsQuery);

        if($emailExistsResult->num_rows > 0){
            echo "O email informado já está cadastrado.";
        }
        else{
            // Extrai o domínio do email
            $domain = explode('@', $email)[1];

            // Verifica o domínio para definir o cargo
            if($domain === 'admin.com'){
                $cargo = 'admin';
            }
            elseif($domain === 'empresa.com'){
                $cargo = 'empresa';
            }
            elseif($domain === 'mentor.com'){
                $cargo = 'mentor';
            }
            else{
                $cargo = 'aluno';
            }

            // Insere o novo usuário no banco de dados com o cargo
            $insertQuery = "INSERT INTO usuarios (email, senha, cargo) VALUES ('$email', '$senha', '$cargo')";
            $insertResult = $mysqli->query($insertQuery);

            if($insertResult){
                $menssage = "Cadastro realizado com sucesso!";
                header("location: ../index.php");
            }
            else{
                echo "Erro ao cadastrar. Tente novamente mais tarde.";
            }
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trabalho final</title>
</head>
<body>
    <div class="login_container">
        <div class="login_css">
            <div class="form_wrapper">
                <div class="cadastrar">
                    <form action="" method="post">
                        <h1>CADASTRO</h1>
                        <label for="email" class="label">Email</label>
                        <br>
                        <input type="text" id="email" name="email">
                        <br>
                        <label for="senha" class="label">Senha</label>
                        <br>
                        <input type="password" id="senha" name="senha">
                        <br>
                        <button type="submit">CADASTRAR</button>
                    </form>
                    <form action="../index.php">
                        <button type="submit">VOLTAR</button>
                    </form>
                    <p><? echo $menssage;?></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
