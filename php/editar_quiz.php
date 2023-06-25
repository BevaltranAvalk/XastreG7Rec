<?php
include('connect.php');

// Verificar se o ID do quiz foi fornecido
if (isset($_GET['id'])) {
    $idQuiz = $_GET['id'];

    // Buscar as informações do quiz pelo ID
    $query = "SELECT * FROM quiz WHERE id = '$idQuiz'";
    $result = $mysqli->query($query);

    if ($result->num_rows > 0) {
        $quiz = $result->fetch_assoc();
    } else {
        echo "Quiz não encontrado.";
        exit;
    }
}

// Atualizar as informações do quiz
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar se todos os campos foram preenchidos e manda mesngaem caso nao esteja
    if (empty($_POST["pergunta"]) || empty($_POST["resposta_correta"]) || empty($_POST["resposta1"]) || empty($_POST["resposta2"])) {
        echo "Preencha todos os campos.";
    } else {
        $pergunta = $mysqli->real_escape_string($_POST["pergunta"]);
        $respostaCorreta = $mysqli->real_escape_string($_POST["resposta_correta"]);
        $resposta1 = $mysqli->real_escape_string($_POST["resposta1"]);
        $resposta2 = $mysqli->real_escape_string($_POST["resposta2"]);

        // Atualizar as informações do quiz no banco de dados
        $updateQuery = "UPDATE quiz SET pergunta='$pergunta', resposta_correta='$respostaCorreta', resposta1='$resposta1', resposta2='$resposta2' WHERE id='$idQuiz'";
        $updateResult = $mysqli->query($updateQuery);

        if ($updateResult) {
            echo "Quiz atualizado com sucesso!";
            
            // Buscar as informações atualizadas do quiz
            $query = "SELECT * FROM quiz WHERE id = '$idQuiz'";
            $result = $mysqli->query($query);

            if ($result->num_rows > 0) {
                $quiz = $result->fetch_assoc();
            }
        } else {
            echo "Erro ao atualizar o quiz: " . $mysqli->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editar Quiz</title>
    <link rel="stylesheet" href="../css/main.css">
    <style>
        .quiz_css {
            background-color: #8DE4FF;
            padding: 20px;
            border-radius: 10px;
            margin: 0 auto;
            max-width: 500px;
        }

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
            <div class="form_wrapper">
                <div class="criar_quiz">
                    <form action="" method="post">
                        <h1>Editar Quiz</h1>
                        <label for="pergunta" class="label">Pergunta</label>
                        <br>
                        <input type="text" id="pergunta" name="pergunta" value="<?php echo $quiz['pergunta']; ?>">
                        <br>
                        <label for="resposta_correta" class="label">Resposta Correta</label>
                        <br>
                        <input type="text" id="resposta_correta" name="resposta_correta" value="<?php echo $quiz['resposta_correta']; ?>">
                        <br>
                        <label for="resposta1" class="label">Resposta 1</label>
                        <br>
                        <input type="text" id="resposta1" name="resposta1" value="<?php echo $quiz['resposta1']; ?>">
                        <br>
                        <label for="resposta2" class="label">Resposta 2</label>
                        <br>
                        <input type="text" id="resposta2" name="resposta2" value="<?php echo $quiz['resposta2']; ?>">
                        <br>
                        <div class="button-wrapper">
                            <button type="submit">Atualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <a href="gerenciar.php" class="btn-voltar">Voltar</a>
</body>
</html>
