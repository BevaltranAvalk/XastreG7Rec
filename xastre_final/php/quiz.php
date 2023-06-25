<?php
include('connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se todos os campos foram preenchidos
    if(empty($_POST["questao1"])){
        echo "Preencha a pergunta.";
    }
    else if (empty($_POST["questao1"]) || empty($_POST["questao2"]) || empty($_POST["questao3"])) {
        echo "Preencha todas as questões.";
    } else {
        $pergunta = $mysqli->real_escape_string($_POST["pergunta"]);
        $questao1 = $mysqli->real_escape_string($_POST["questao1"]);
        $questao2 = $mysqli->real_escape_string($_POST["questao2"]);
        $questao3 = $mysqli->real_escape_string($_POST["questao3"]);

        // Insere as questões no banco de dados
        $insertQuery = "INSERT INTO quiz (pergunta,resposta_correta, resposta1, resposta2) VALUES ('$pergunta','$questao1', '$questao2', '$questao3')";
        $insertResult = $mysqli->query($insertQuery);

        if ($insertResult) {
            $message = "Quiz criado com sucesso!";
        } else {
            echo "Erro ao criar o quiz. Tente novamente mais tarde.";
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
    <title>Criar Quiz</title>
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
    <div class="quiz_container">
        <div class="quiz_css">
            <div class="form_wrapper">
                <div class="criar_quiz">
                    <form action="" method="post">
                        <h1>Criar Quiz</h1>
                        <label for="pergunta" class="label">Pergunta</label>
                        <br>
                        <input type="text" id="pergunta" name="pergunta">
                        <br>
                        <label for="questao1" class="label">Resposta</label>
                        <br>
                        <input type="text" id="questao1" name="questao1">
                        <br>
                        <label for="questao2" class="label">Questão 2</label>
                        <br>
                        <input type="text" id="questao2" name="questao2">
                        <br>
                        <label for="questao3" class="label">Questão 3</label>
                        <br>
                        <input type="text" id="questao3" name="questao3">
                        <br>
                        <div class="button-wrapper">
                            <button type="submit">Criar</button>
                        </div>
                    </form>
                    <div class="button-wrapper">
                    <button onclick="location.href='../admin.html'">Voltar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>