<?php
include('connect.php');

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os valores do formulário
    $nomeComercial = $_POST["nome_comercial"];
    $descricao = $_POST["descricao"];
    $cargaHoraria = $_POST["carga_horaria"];
    $dataInicioInscricoes = $_POST["data_inicio_inscricoes"];
    $dataFimInscricoes = $_POST["data_fim_inscricoes"];
    $quantidadeMaximaInscritos = $_POST["quantidade_maxima_inscritos"];

    // Converte a carga horária para o formato TIME do bd
    $cargaHorariaFormatada = date('H:i:s', strtotime($cargaHoraria));

    // Insere os dados do curso
    $insertQuery = "INSERT INTO curso (nome_comercial, descricao, carga_horaria, dat_ini, dat_fim, qtd_max)
            VALUES ('$nomeComercial', '$descricao', '$cargaHorariaFormatada', '$dataInicioInscricoes', '$dataFimInscricoes', '$quantidadeMaximaInscritos')";

    $insertResult = $mysqli->query($insertQuery);

    if ($insertResult) {
        $message = "Curso criado com sucesso!";
    } else {
        echo "Erro ao criar o curso: " . $mysqli->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Criar Curso</title>
    <link rel="stylesheet" href="../css/main.css">
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
            <?php if (!empty($message)): ?>
                <div class="button-wrapper">
                    <p><?php echo $message; ?></p>
                </div>
            <?php endif; ?>

            <h1>CRIAR CURSO</h1>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="nome_comercial">Nome Comercial:</label>
                <input type="text" id="nome_comercial" name="nome_comercial" required><br>

                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" required></textarea><br>

                <label for="carga_horaria">Carga Horária:</label>
                <input type="time" id="carga_horaria" name="carga_horaria" required><br>

                <label for="data_inicio_inscricoes">Data de Início das Inscrições:</label>
                <input type="date" id="data_inicio_inscricoes" name="data_inicio_inscricoes" required><br>

                <label for="data_fim_inscricoes">Data de Fim das Inscrições:</label>
                <input type="date" id="data_fim_inscricoes" name="data_fim_inscricoes" required><br>

                <label for="quantidade_maxima_inscritos">Quantidade Máxima de Inscritos:</label>
                <input type="number" id="quantidade_maxima_inscritos" name="quantidade_maxima_inscritos" required><br>

                <div class="button-wrapper">
                    <button type="submit">Criar</button>
                </div>
            </form>
            <div class="button-wrapper">
            </div>
        </div>
    </div>
    <a href="../admin.html" class="btn-voltar">Voltar</a>
</body>
</html>
