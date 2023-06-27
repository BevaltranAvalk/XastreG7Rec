<?php
include('connect.php');

$vagaMessage = "";

// Editar uma vaga
if (isset($_POST['editar_vaga'])) {
    $idVaga = $_POST['id_vaga'];
    $idCurso = $_POST['id_curso'];
    $tituloVaga = $_POST['titulo'];
    $empresa = $_POST['empresa'];
    $descricao = $_POST['descricao'];
    $faixaSalarial = $_POST['faixa_salarial'];

    $updateQuery = "UPDATE vagas SET id_curso = '$idCurso', titulo = '$tituloVaga', empresa = '$empresa', descricao = '$descricao', faixa_salarial = '$faixaSalarial' WHERE id_vaga = '$idVaga'";
    $updateResult = $mysqli->query($updateQuery);

    if ($updateResult) {
        $vagaMessage = "Vaga atualizada com sucesso!";
    } else {
        $vagaMessage = "Erro ao atualizar a vaga: " . $mysqli->error;
    }
}

// Buscar a vaga pelo ID
if (isset($_GET['id'])) {
    $idVaga = $_GET['id'];

    $vagaQuery = "SELECT * FROM vagas WHERE id_vaga = '$idVaga'";
    $vagaResult = $mysqli->query($vagaQuery);

    if ($vagaResult->num_rows == 1) {
        $vaga = $vagaResult->fetch_assoc();
    } else {
        header("Location: gerenciar.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editar Vaga</title>
    <link rel="stylesheet" href="../frontend/main.css">
    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .vaga_css {
            border-radius: 20px;
            border: 1px solid #000000;
            background-color: #c3e6f9;
            text-align: center;
            padding: 20px;
            max-width: 400px;
            max-height: 800px;
        }
        .form-wrapper label {
            text-align: left;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-wrapper input,
        .form-wrapper textarea {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
        }
        .form-wrapper input[type="submit"] {
            margin-top: 20px;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="vaga_css">
            <h2>Editar Vaga</h2>
            <?php if (!empty($vagaMessage)): ?>
                <p class="message"><?php echo $vagaMessage; ?></p>
            <?php endif; ?>
            <form method="POST" action="">
                <input type="hidden" name="id_vaga" value="<?php echo $vaga['id_vaga']; ?>">
                <div class="form-wrapper">
                    <label for="id_curso">ID do Curso:</label>
                    <input type="text" id="id_curso" name="id_curso" value="<?php echo $vaga['id_curso']; ?>">
                </div>
                <div class="form-wrapper">
                    <label for="titulo_vaga">Título da Vaga:</label>
                    <input type="text" id="titulo" name="titulo" value="<?php echo $vaga['titulo']; ?>">
                </div>
                <div class="form-wrapper">
                    <label for="empresa">Empresa:</label>
                    <input type="text" id="empresa" name="empresa" value="<?php echo $vaga['empresa']; ?>">
                </div>
                <div class="form-wrapper">
                    <label for="descricao">Descrição:</label>
                    <textarea id="descricao" name="descricao"><?php echo $vaga['descricao']; ?></textarea>
                </div>
                <div class="form-wrapper">
                    <label for="faixa_salarial">Faixa Salarial:</label>
                    <input type="text" id="faixa_salarial" name="faixa_salarial" value="<?php echo $vaga['faixa_salarial']; ?>">
                </div>
                <input type="submit" name="editar_vaga" value="Atualizar Vaga">
            </form>
        </div>
    </div>
    <a href="ver_vagas.php" class="btn-voltar">Voltar</a>
</body>
</html>