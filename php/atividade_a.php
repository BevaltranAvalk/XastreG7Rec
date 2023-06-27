<?php
session_start();
include('connect.php');

// Verifica login do mentor
if (!isset($_SESSION['ID'])) {
    header("Location: index.php");
    exit;
}

// Obtem as últimas notas
function getUltimasNotas()
{
    global $mysqli;
    $query = "SELECT notas.*, quiz.pergunta, quiz.resposta_correta, quiz.resposta1, quiz.resposta2, usuarios.ID AS aluno_id, curso.nome_comercial
              FROM notas 
              INNER JOIN quiz ON notas.id_curso = quiz.curso_id
              INNER JOIN usuarios ON notas.id_aluno = usuarios.ID
              INNER JOIN curso ON quiz.curso_id = curso.id
              ORDER BY notas.id_nota DESC LIMIT 5";
    $result = $mysqli->query($query) or die("Falha na consulta SQL: " . $mysqli->error);

    $notas = [];
    while ($row = $result->fetch_assoc()) {
        $notas[] = $row;
    }

    return $notas;
}


$ultimasNotas = getUltimasNotas();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Atividades A - Últimas Notas</title>
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

        .atividades_container {
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            border-radius: 20px;
            border: 1px solid #000000;
            background-color: #c3e6f9;
            text-align: center;
            padding: 20px;
            overflow-y: auto;
            color: #000000;
        }

        h1 {
            font-size: 24px;
            color: #333;
            text-align: center;
        }

        .curso_item {
            margin-bottom: 20px;
            color: #333;
            text-align: center;
        }

        .curso_item .info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .perguntas {
            margin-top: 10px;
            text-align: center;
        }

        .pergunta {
            margin-bottom: 40px;
        }

        .alternativas {
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
        }

        .alternativas p {
            margin: 0 5px;
        }

        .alternativa-correta {
            font-weight: bold;
        }

        .nota {
            margin-top: 20px;
            text-align: right;
            font-weight: bold;
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
    </style>
</head>
<body>
    <div class="atividades_container">
        <h1>Últimas Notas a Serem Feitas</h1>

        <?php if (count($ultimasNotas) > 0): ?>
            <?php $lastCursoID = null; ?>
            <?php foreach ($ultimasNotas as $nota): ?>
                <?php if ($lastCursoID !== $nota['id_curso']): ?>
                    <?php if (!is_null($lastCursoID)): ?>
                        </div>
                        <div class="nota">
                            <p>Nota: <?php echo $ultimasNotas[$lastCursoIndex]['nota']; ?></p>
                        </div>
                    <?php endif; ?>
                    <div class="curso_item">
                        <div class="info">
                            <span>Aluno: <?php echo $nota['aluno_id']; ?></span>
                            <span>Curso: <?php echo $nota['nome_comercial']; ?></span>
                        </div>
                        <div class="perguntas">
                            <?php $lastCursoID = $nota['id_curso']; ?>
                            <?php $lastCursoIndex = array_search($nota, $ultimasNotas); ?>
                <?php endif; ?>

                <div class="pergunta">
                <p>Pergunta: <?php echo $nota['pergunta']; ?></p>
                    <div class="alternativas">
                        <p><?php echo $nota['resposta1']; ?></p>
                        <p><?php echo $nota['resposta2']; ?></p>
                        <p><?php echo $nota['resposta_correta']; ?></p>
                    </div>
                    <p class="alternativa-correta">Resposta Correta: <?php echo $nota['resposta_correta']; ?></p>
                </div>
            <?php endforeach; ?>
            <?php if (!is_null($lastCursoID)): ?>
                </div>
                <div class="nota">
                    <p>Nota: <?php echo $ultimasNotas[count($ultimasNotas) - 1]['nota']; ?></p>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <p>Não há notas disponíveis.</p>
        <?php endif; ?>
    </div>
    <a href="../mentor.html" class="btn-voltar">Voltar</a>
</body>
</html>
