<?php
include('connect.php');

if (!isset($_GET['id'])) {
    echo "ID do curso não fornecido.";
    exit;
}

$idCurso = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nomeComercial = $_POST["nome_comercial"];
    $descricao = $_POST["descricao"];
    $cargaHoraria = $_POST["carga_horaria"];
    $dataInicioInscricoes = $_POST["data_inicio_inscricoes"];
    $dataFimInscricoes = $_POST["data_fim_inscricoes"];
    $quantidadeMaximaInscritos = $_POST["quantidade_maxima_inscritos"];

    $cargaHorariaFormatada = date('H:i:s', strtotime($cargaHoraria));

    $updateQuery = "UPDATE curso SET 
        nome_comercial = '$nomeComercial',
        descricao = '$descricao',
        carga_horaria = '$cargaHorariaFormatada',
        dat_ini = '$dataInicioInscricoes',
        dat_fim = '$dataFimInscricoes',
        qtd_max = '$quantidadeMaximaInscritos'
        WHERE id = '$idCurso'";

    $updateResult = $mysqli->query($updateQuery);

    if ($updateResult) {
        echo "Curso atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar o curso: " . $mysqli->error;
    }
}

$cursoQuery = "SELECT * FROM curso WHERE id = '$idCurso'";
$cursoResult = $mysqli->query($cursoQuery);

if ($cursoResult->num_rows == 0) {
    echo "Curso não encontrado.";
    exit;
}

$curso = $cursoResult->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editar Curso</title>
    <link rel="stylesheet" href="../frontend/main.css">
    <style>
        .button-wrapper {
            text-align: center;
        }
        .button-wrapper button {
            margin: 10px;
        }
    </style>
</head>
<body>
    <div class="login_container">
        <div class="login_css">
            <h1>EDITAR CURSO</h1>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $idCurso; ?>">
                <label for="nome_comercial">Nome Comercial:</label>
                <input type="text" id="nome_comercial" name="nome_comercial" value="<?php echo htmlspecialchars($curso['nome_comercial']); ?>" required><br>

                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" required><?php echo htmlspecialchars($curso['descricao']); ?></textarea><br>

                <label for="carga_horaria">Carga Horária:</label>
                <input type="time" id="carga_horaria" name="carga_horaria" value="<?php echo date('H:i', strtotime($curso['carga_horaria'])); ?>" required><br>

                <label for="data_inicio_inscricoes">Data de Início das Inscrições:</label>
                <input type="date" id="data_inicio_inscricoes" name="data_inicio_inscricoes" value="<?php echo $curso['dat_ini']; ?>" required><br>

                <label for="data_fim_inscricoes">Data de Fim das Inscrições:</label>
                <input type="date" id="data_fim_inscricoes" name="data_fim_inscricoes" value="<?php echo $curso['dat_fim']; ?>" required><br>

                <label for="quantidade_maxima_inscritos">Quantidade Máxima de Inscritos:</label>
                <input type="number" id="quantidade_maxima_inscritos" name="quantidade_maxima_inscritos" value="<?php echo $curso['qtd_max']; ?>" required><br>

                <div class="button-wrapper">
                    <button type="submit">Atualizar</button>
                </div>
            </form>
        </div>
    </div>
    <a href="gerenciar.php" class="btn-voltar">Voltar</a>
</body>
</html>
