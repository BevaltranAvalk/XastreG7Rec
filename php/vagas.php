<?php
session_start();
include('connect.php');

// Verifica se o aluno está logado
if (!isset($_SESSION['ID'])) {
    header("Location: index.php");
    exit;
}

$alunoId = $_SESSION['ID'];

// Função para obter as vagas do banco de dados
function getVagas()
{
    global $mysqli, $alunoId;

    $queryCurso = "SELECT curso_atual FROM usuarios WHERE ID = ?";
    $stmtCurso = $mysqli->prepare($queryCurso);
    $stmtCurso->bind_param("i", $alunoId);
    $stmtCurso->execute();
    $resultCurso = $stmtCurso->get_result();
    $rowCurso = $resultCurso->fetch_assoc();
    $cursoAtual = $rowCurso['curso_atual'];

    // Verificar se o aluno já realizou o curso necessário e tem nota maior ou igual a 7
    $queryVagas = "SELECT v.*, n.nota, u.vaga_id
                   FROM vagas v
                   LEFT JOIN notas n ON v.id_curso = n.id_curso AND n.id_aluno = ?
                   LEFT JOIN usuarios u ON v.id_vaga = u.vaga_id AND u.ID = ?
                   WHERE v.id_curso = ?
                   HAVING n.nota >= 7 OR n.nota IS NULL";
    $stmtVagas = $mysqli->prepare($queryVagas);
    $stmtVagas->bind_param("iii", $alunoId, $alunoId, $cursoAtual);
    $stmtVagas->execute();
    $resultVagas = $stmtVagas->get_result();

    $vagas = [];
    while ($row = $resultVagas->fetch_assoc()) {
        $row['inscrito'] = ($row['vaga_id'] != null);
        $vagas[] = $row;
    }

    return $vagas;
}

function inscreverVaga($vagaId)
{
    global $mysqli, $alunoId;
    $query = "UPDATE usuarios SET vaga_id = ? WHERE ID = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ii", $vagaId, $alunoId);
    $stmt->execute();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['vaga_id'])) {
        $vagaId = $_POST['vaga_id'];
        inscreverVaga($vagaId);
        header("Location: vagas.php?success=true");
        exit;
    }
}

$vagas = getVagas();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vagas</title>
    <link rel="stylesheet" href="../frontend/main.css">
    <style>
        .already-registered {
            color: red;
            font-weight: bold;
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
    </style>
</head>
<body>
    <h1>Vagas Disponíveis</h1>

    <?php if (isset($_GET['success']) && $_GET['success'] === 'true'): ?>
        <p style="text-align: center;" class="success-message">Inscrição realizada com sucesso!</p>
    <?php endif; ?>

    <div class="login_container">
        <?php if (!empty($vagas)): ?>
            <?php foreach ($vagas as $vaga): ?>
                <div class="login_css">
                    <h2><?php echo $vaga['titulo']; ?></h2>
                    <p><?php echo $vaga['descricao']; ?></p>
                    <p>Faixa Salarial: <?php echo $vaga['faixa_salarial']; ?></p>
                    <?php if ($vaga['inscrito']): ?>
                        <p class="already-registered">Já Inscrito</p>
                    <?php else: ?>
                        <form action="" method="POST">
                            <input type="hidden" name="vaga_id" value="<?php echo $vaga['id_vaga']; ?>">
                            <button type="submit">Inscrever-se</button>
                        </form>
                    <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhuma vaga disponível. Experimente fazer os testes de algum curso.</p>
        <?php endif; ?>
                </div>
    </div>

    <a href="../aluno.php" class="btn-voltar">Voltar</a>
</body>
</html>
