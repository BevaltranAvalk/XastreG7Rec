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

    // Obter o curso atual do aluno
    $queryCurso = "SELECT curso_atual FROM usuarios WHERE ID = $alunoId";
    $resultCurso = $mysqli->query($queryCurso);
    $rowCurso = $resultCurso->fetch_assoc();
    $cursoAtual = $rowCurso['curso_atual'];

    // Verificar se o aluno já realizou o curso necessário e tem nota maior ou igual a 7
    $queryVagas = "SELECT v.*, n.nota, u.vaga_id
                   FROM vagas v
                   LEFT JOIN notas n ON v.id_curso = n.id_curso AND n.id_aluno = $alunoId
                   LEFT JOIN usuarios u ON v.id_vaga = u.vaga_id AND u.ID = $alunoId
                   WHERE v.id_curso = $cursoAtual
                   HAVING n.nota >= 7 OR n.nota IS NULL";
    $resultVagas = $mysqli->query($queryVagas);

    $vagas = [];
    while ($row = $resultVagas->fetch_assoc()) {
        $row['inscrito'] = ($row['vaga_id'] != null); // Verificar se o aluno está inscrito
        $vagas[] = $row;
    }

    return $vagas;
}

// Função para se inscrever em uma vaga
function inscreverVaga($vagaId)
{
    global $mysqli, $alunoId;
    $query = "UPDATE usuarios SET vaga_id = ? WHERE ID = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ii", $vagaId, $alunoId);
    $stmt->execute();
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['vaga_id'])) {
        $vagaId = $_POST['vaga_id'];
        inscreverVaga($vagaId);
        // Redireciona para a página de vagas ou exibe uma mensagem de sucesso
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
    <link rel="stylesheet" href="../css/main.css">
    <style>
        .already-registered {
            color: red;
            font-weight: bold;
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
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhuma vaga disponível. Experimente fazer os testes de algum curso.</p>
        <?php endif; ?>
    </div>

    <a href="../aluno.php" class="btn-voltar">Voltar</a>
</body>
</html>
