<?php
session_start();
include('connect.php');

// Verifica o login
if (!isset($_SESSION['ID'])) {
    header("Location: index.php");
    exit;
}

// Função para obter todas as notas dos alunos
function getNotasPorCurso()
{
    global $mysqli;
    $query = "SELECT notas.*, usuarios.ID AS aluno_id, curso.nome_comercial
              FROM notas 
              INNER JOIN usuarios ON notas.id_aluno = usuarios.ID
              INNER JOIN curso ON notas.id_curso = curso.id
              ORDER BY curso.nome_comercial";
    $result = $mysqli->query($query) or die("Falha na consulta SQL: " . $mysqli->error);

    $notasPorCurso = [];
    while ($row = $result->fetch_assoc()) {
        $notasPorCurso[$row['nome_comercial']][] = $row;
    }

    return $notasPorCurso;
}

$notasPorCurso = getNotasPorCurso();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Todas as Notas por Curso</title>
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

        .notas_container {
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

        .curso_notas {
            margin-bottom: 20px;
        }

        .curso_notas h2 {
            font-size: 18px;
            color: #333;
            margin-bottom: 10px;
        }

        .nota_item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 5px;
            color: #333;
            font-size: 14px;
        }

        .nota_item span {
            font-weight: bold;
        }

        .nota_item .aluno_id {
            flex-grow: 1;
            text-align: left;
            margin-right: 10px;
        }

        .nota_item .nota {
            flex-grow: 0;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="notas_container">
        <h1>Todas as Notas por Curso</h1>

        <?php if (!empty($notasPorCurso)): ?>
            <?php foreach ($notasPorCurso as $curso => $notas): ?>
                <div class="curso_notas">
                    <h2>Curso: <?php echo $curso; ?></h2>
                    <?php foreach ($notas as $nota): ?>
                        <div class="nota_item">
                            <span class="aluno_id">ID do Aluno: <?php echo $nota['aluno_id']; ?></span>
                            <span class="nota">Nota: <?php echo $nota['nota']; ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Não há notas disponíveis.</p>
        <?php endif; ?>

        <a href="../empresa.html" class="btn-voltar">Voltar</a>
    </div>
</body>
</html>
