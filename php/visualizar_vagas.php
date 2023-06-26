<?php
session_start();
include('connect.php');

// Verifica login
if (!isset($_SESSION['ID'])) {
    header("Location: index.php");
    exit;
}

// Verifica se o ID da vaga foi enviado via GET
if (!isset($_GET['id_vagas'])) {
    header("Location: index.php");
    exit;
}

// Obtém o ID da vaga
$vagaId = $_GET['id_vagas'];

// Obtém os detalhes da vaga do banco de dados
$query = "SELECT * FROM vagas WHERE id_vagas = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $vagaId);
$stmt->execute();
$result = $stmt->get_result();
$vaga = $result->fetch_assoc();

// Verifica se a vaga existe
if (!$vaga) {
    echo "Vaga não encontrada.";
    exit;
}

// Variáveis de mensagem
$message = "";
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica qual botão foi clicado
    if (isset($_POST['confirmar'])) {
        // Ação de confirmar (salvar a vaga no banco de dados)
        // Código para salvar a vaga no banco de dados
        $message = "Vaga salva com sucesso!";
        $success = true;
    } elseif (isset($_POST['editar'])) {
        // Ação de editar (redirecionar para a página de edição)
        header("Location: editar_vaga.php?id_vagas=" . $vagaId);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Visualizar Vaga</title>
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

        .vaga_container {
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

        .info {
            margin-bottom: 20px;
            text-align: center;
        }

        .info label {
            font-weight: bold;
            display: block;
        }

        .message {
            color: #333;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }

        .buttons {
            margin-top: 20px;
        }

        .buttons input[type="submit"] {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;
        }

        .buttons input[type="submit"]:hover {
            background-color: #555;
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
    </style>
</head>
<body>
    <div class="vaga_container">
        <h1>Visualizar Vaga</h1>
        <?php if ($message !== "") : ?>
            <div class="message <?php echo $success ? 'success' : 'error'; ?>"><?php echo $message; ?></div>
        <?php endif; ?>
        <div class="info">
            <label for="titulo">Título da Vaga:</label>
            <span><?php echo $vaga['titulo']; ?></span>
        </div>
        <div class="info">
            <label for="empresa">Empresa:</label>
            <span><?php echo $vaga['empresa']; ?></span>
        </div>
        <div class="info">
            <label for="descricao">Descrição:</label>
            <span><?php echo $vaga['descricao']; ?></span>
        </div>
        <div class="info">
            <label for="requisitos">Requisitos:</label>
            <span><?php echo $vaga['requisitos']; ?></span>
        </div>
        <div class="info">
            <label for="faixa_salarial">Faixa Salarial:</label>
            <span><?php echo $vaga['faixa_salarial']; ?></span>
        </div>
        <div class="buttons">
            <form method="POST" action="">
                <input type="submit" name="confirmar" value="Confirmar">
                <input type="submit" name="editar" value="Editar">
            </form>
        </div>
    </div>
    <a href="../empresa.html" class="btn-voltar">Voltar</a>
</body>
</html>
