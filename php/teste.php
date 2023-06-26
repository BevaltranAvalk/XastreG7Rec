<?php
session_start();
include('connect.php');

// Verifica se o aluno está logado
if (!isset($_SESSION['ID'])) {
    header("Location: index.php");
    exit;
}

$alunoId = $_SESSION['ID'];

// Função para obter o curso atual do aluno
function getCursoAtual()
{
    global $mysqli, $alunoId;
    $query = "SELECT curso_atual FROM usuarios WHERE ID = '$alunoId'";
    $result = $mysqli->query($query) or die("Falha na consulta SQL");
    $row = $result->fetch_assoc();
    return $row['curso_atual'];
}

// Função para obter as perguntas do curso atual
function getPerguntasDoCurso($cursoId)
{
    global $mysqli;
    $query = "SELECT * FROM quiz WHERE curso_id = '$cursoId'";
    $result = $mysqli->query($query) or die("Falha na consulta SQL");

    $perguntas = [];
    while ($row = $result->fetch_assoc()) {
        $perguntas[] = $row;
    }

    return $perguntas;
}

// Função para verificar se o aluno já respondeu o teste
function verificarTesteRespondido($alunoId, $cursoId)
{
    global $mysqli;
    $query = "SELECT nota FROM notas WHERE id_aluno = '$alunoId' AND id_curso = '$cursoId'";
    $result = $mysqli->query($query) or die("Falha na consulta SQL");
    return $result->num_rows > 0;
}

// Função para salvar a nota no banco de dados
function salvarNota($nota, $alunoId, $cursoId)
{
    global $mysqli;
    $query = "INSERT INTO notas (nota, id_aluno, id_curso) VALUES ('$nota', '$alunoId', '$cursoId')";
    $result = $mysqli->query($query) or die("Falha ao salvar a nota");
}

$cursoAtual = getCursoAtual();
$perguntas = getPerguntasDoCurso($cursoAtual);
$testeRespondido = verificarTesteRespondido($alunoId, $cursoAtual);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $respostas = $_POST['respostas'];
    $nota = 0;
    foreach ($perguntas as $index => $pergunta) {
        $respostaCorreta = $pergunta['resposta_correta'];
        if ($respostas[$index] === $respostaCorreta) {
            $nota++;
        }
    }
    $notaFinal = ($nota / count($perguntas)) * 10;
    salvarNota($notaFinal, $alunoId, $cursoAtual);
    $testeRespondido = true;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Perguntas do Curso</title>
    <link rel="stylesheet" href="../frontend/main.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #8ac4ff;
            color: #fff;
        }

        .perguntas_container {
            width: 400px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            border-radius: 20px;
            border: 1px solid #000000;
            background-color: #c3e6f9;
            text-align: center;
            padding: 20px;
            display: inline-block;
        }

        .pergunta_css {
            margin-bottom: 20px;
            color: #333;
        }

        h1 {
            font-size: 24px;
            color: #333;
            text-align: center;
        }

        p {
            font-size: 18px;
            color: #333;
            text-align: center;
        }

        .btn-voltar {
            display: block;
            text-align: center;
            margin-top: 20px;
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

        .opcoes {
            display: flex;
            justify-content: center;
        }

        .opcao {
            margin: 5px;
        }

        .mensagem {
            font-size: 20px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="perguntas_container">
        <h1>Perguntas do Curso</h1>

        <?php if ($testeRespondido): ?>
            <?php
            $query = "SELECT nota FROM notas WHERE id_aluno = '$alunoId' AND id_curso = '$cursoAtual'";
            $result = $mysqli->query($query) or die("Falha na consulta SQL");
            $row = $result->fetch_assoc();
            $nota = $row['nota'];
            ?>
            <p>Sua nota: <?php echo $nota; ?></p>
        <?php else: ?>
            <?php if (count($perguntas) > 0): ?>
                <form method="post" action="">
                    <?php foreach ($perguntas as $index => $pergunta): ?>
                        <div class="pergunta_css">
                            <h2><?php echo $pergunta['pergunta']; ?></h2>
                            <div class="opcoes">
                                <?php
                                $opcoes = [
                                    $pergunta['resposta_correta'],
                                    $pergunta['resposta1'],
                                    $pergunta['resposta2']
                                ];
                                shuffle($opcoes);
                                foreach ($opcoes as $opcao):
                                ?>
                                    <label class="opcao">
                                        <input type="radio" name="respostas[<?php echo $index; ?>]" value="<?php echo $opcao; ?>">
                                        <?php echo $opcao; ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <?php if ($testeRespondido): ?>
                        <button type="button" disabled>Teste enviado</button>
                    <?php else: ?>
                        <button type="submit">Enviar</button>
                    <?php endif; ?>
                </form>
            <?php else: ?>
                <p>Não há perguntas disponíveis para este curso.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <a href="../aluno.php" class="btn-voltar">Voltar</a>
</body>
</html>
