<?php

session_start();

if (isset($_SESSION['ID']) && $_SESSION['CARGO'] == 'aluno') {
    $alunoId = $_SESSION['ID'];
} else {
    header("location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>aluno</title>
    <link rel="stylesheet" href="css/adm.css">
    <style>
        .logo {
    position: absolute;
    top: 10px;
    left: 10px;
    width: 100px;
}
.btn-voltar {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #f2f2f2;
    color: #333;
    padding: 10px 20px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 16px;
}

.btn-voltar:hover {
    background-color: #e0e0e0;
}

.admin-container {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.admin-sidebar {
    margin-top: 20px;
    display: flex;
    justify-content: center;
}

.admin-sidebar ul {
    display: flex;
    list-style-type: none;
    padding: 0;
}

.admin-sidebar li {
    margin-right: 10px;
}

.admin-sidebar a {
    text-decoration: none;
    color: #333;
    padding: 5px 10px;
    background-color: #f2f2f2;
    border-radius: 6px;
}

h1 {
    font-size: 30px;
    color: #333;
    text-align: center;
}

p {
    font-size: 30px;
    color: #333;
    text-align: center;
}

body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    background-color: #8ac4ff;
    color: #fff;
}

.fundo_opcoes {
    background-color: #8DE4FF;
    display: flex;
    justify-content: center;
    width: 1000px;
    height: 100px;
    border-radius: 25px;
    align-items: center;
}

.fundo_opcoes .wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
}

.fundo_opcoes a {
    display: block;
    width: 200px;
    height: 50px;
    border-radius: 25px;
    line-height: 40px;
    font-size: 18px;
    font-family: sans-serif;
    text-decoration: none;
    color: #333;
    border: 2px solid #333;
    letter-spacing: 2px;
    text-align: center;
    position: relative;
    transition: all .35s;
    margin-right: 10px;
}

.fundo_opcoes a span {
    position: relative;
    z-index: 2;
}

.fundo_opcoes a:after {
    position: absolute;
    content: "";
    top: 0;
    left: 0;
    width: 0;
    height: 100%;
    border-radius: 25px;
    background: #ff003b;
    transition: all .35s;
}

.fundo_opcoes a:hover {
    color: #fff;
}

.fundo_opcoes a:hover:after {
    width: 100%;
}
    </style>
<body>
    <div class="admin-container">
        <img src="logo/logo.png" alt="Logo" class="logo">
        <h1>Bem-vindo à página do aluno</h1>
        <p style="font-size:larger">Escolha uma opção:</p>
        <div class="admin-sidebar">
            <div class="fundo_opcoes">
                <div class="wrapper">
                    <a href="php/cursos.php"><span>Cursos</span></a>
                    <a href="php/teste.php"><span>testes</span></a>
                    <a href="php/vagas.php" class="active"><span> vagas</span></a>
                </div>
            </div>
        </div>
    </div>
    <a href="php/logout.php" class="btn-voltar">DESLOGAR</a>
</body>
</html>
