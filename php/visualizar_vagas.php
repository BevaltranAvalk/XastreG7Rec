<?php
session_start();
include('connect.php');

// Verifica se a vaga está armazenada na sessão
if (!isset($_SESSION['vaga'])) {
    header("Location: cria_vaga.php");
    exit;
}

$vaga = $_SESSION['vaga'];

if (isset($_POST['confirmar'])) {
    require_once 'connect.php';

    // Insere a vaga no banco de dados
    $query = "INSERT INTO vagas (titulo, empresa, descricao, requisitos, faixa_salarial)
              VALUES ('{$vaga['titulo']}', '{$vaga['empresa']}', '{$vaga['descricao']}', '{$vaga['requisitos']}', '{$vaga['faixa_salarial']}')";
    $result = $mysqli->query($query);

    if ($result) {
        $success_message = "Vaga criada!";
        unset($_SESSION['vaga']);
    } else {
        $error_message = "Erro ao criar a vaga. Por favor, tente novamente.";
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

        .info_item {
            margin-bottom: 20px;
            text-align: left;
        }

        .info_item label {
            font-weight: bold;
        }

        .success_message {
            color: green;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .error_message {
            color: red;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .btn-container {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        .btn-voltar {
            display: inline-block;
            background-color: #f2f2f2;
            color: #333;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 16px;
            margin-right: 10px;
        }

        .btn-confirmar {
            display: inline-block;
            background-color: #61bd4f;
            color: #fff;
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 16px;
        }

        .btn-voltar:hover,
        .btn-confirmar:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="vaga_container">
        <h1>Vaga</h1>

        <?php if (isset($success_message)): ?>
            <p class="success_message"><?php echo $success_message; ?></p>
            <div class="btn-container">
                <a href="../empresa.html" class="btn-voltar">Voltar para o Menu</a>
            </div>
        <?php elseif (isset($error_message)): ?>
            <p class="error_message"><?php echo $error_message; ?></p>
            <div class="btn-container">
                <a href="cria_vaga.php" class="btn-voltar">Voltar para a criação</a>
            </div>
        <?php else: ?>
            <div class="info_item">
                <label>Título da Vaga:</label>
                <p><?php echo $vaga['titulo']; ?></p>
            </div>

            <div class="info_item">
                <label>Empresa que está ofertando:</label>
                <p><?php echo $vaga['empresa']; ?></p>
            </div>

            <div class="info_item">
                <label>Descrição das atividades a serem desempenhadas:</label>
                <p><?php echo $vaga['descricao']; ?></p>
            </div>

            <div class="info_item">
                <label>Requisitos para candidatura:</label>
                <p><?php echo $vaga['requisitos']; ?></p>
            </div>

            <div class="info_item">
                <label>Faixa Salarial:</label>
                <p><?php echo $vaga['faixa_salarial']; ?></p>
            </div>

            <div class="btn-container">
                <a href="cria_vaga.php" class="btn-voltar">Editar</a>
                <form method="post">
                    <button type="submit" name="confirmar" class="btn-confirmar">Confirmar</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
