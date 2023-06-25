<?php
session_start();
include('connect.php');

// Verifica login
if (!isset($_SESSION['ID'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obter os dados do formulário
    $titulo = $_POST['titulo'];
    $empresa = $_POST['empresa'];
    $descricao = $_POST['descricao'];
    $requisitos = $_POST['requisitos'];
    $faixa_salarial = $_POST['faixa_salarial'];

    // Armazenar os dados da vaga em uma sessão
    $_SESSION['vaga'] = [
        'titulo' => $titulo,
        'empresa' => $empresa,
        'descricao' => $descricao,
        'requisitos' => $requisitos,
        'faixa_salarial' => $faixa_salarial
    ];

    // Redirecionar para a visualização da vaga
    header("Location: visualizar_vagas.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Criar Vaga</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #8ac4ff;
            color: #000;
        }

        .form_container {
            width: 600px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            border-radius: 20px;
            border: 1px solid #000000;
            background-color: #c3e6f9;
            text-align: center;
            padding: 20px;
        }

        h1 {
            font-size: 24px;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .form_item {
            margin-bottom: 20px;
            text-align: center;
        }

        .form_item label {
            font-weight: bold;
            display: block;
        }

        .form_item input[type="text"], .form_item textarea, .form_item input[type="number"] {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            text-align: center;
        }

        .form_item textarea {
            height: 100px;
        }

        .btn-submit {
            display: inline-block;
            margin-right: 10px;
            background-color: #f2f2f2;
            color: #333;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 16px;
        }

        .btn-submit:hover {
            background-color: #e0e0e0;
        }

        .btn-voltar {
            display: inline-block;
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
    </style>
</head>
<body>
    <div class="form_container">
        <h1>Criar Vaga</h1>

        <form method="POST">
            <div class="form_item">
                <label>Título da Vaga:</label>
                <input type="text" name="titulo" required>
            </div>

            <div class="form_item">
                <label>Empresa que está ofertando:</label>
                <input type="text" name="empresa" required>
            </div>

            <div class="form_item">
                <label>Descrição das atividades a serem desempenhadas:</label>
                <textarea name="descricao" required></textarea>
            </div>

            <div class="form_item">
                <label>Requisitos para candidatura:</label>
                <textarea name="requisitos" required></textarea>
            </div>

            <div class="form_item">
                <label>Faixa Salarial:</label>
                <input type="number" name="faixa_salarial" required>
            </div>

            <button type="submit" class="btn-submit">Criar</button>
            <a href="../empresa.html" class="btn-voltar">Voltar</a>
        </form>
    </div>
</body>
</html>
