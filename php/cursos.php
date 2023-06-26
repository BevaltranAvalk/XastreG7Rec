<?php
session_start();
include('connect.php');

// Verifica se o aluno está logado
if (!isset($_SESSION['ID'])) {
    header("Location: index.php");
    exit;
}

$alunoId = $_SESSION['ID'];

// Função para obter os cursos
function getCursos()
{
    global $mysqli, $alunoId;
    $query = "SELECT * FROM curso";
    $result = $mysqli->query($query) or die("Falha na consulta SQL");

    $cursos = [];
    while ($row = $result->fetch_assoc()) {
        // Verifica se o aluno já está inscrito no curso atual
        $cursoId = $row['id'];
        $query = "SELECT * FROM usuarios WHERE ID = '$alunoId' AND curso_atual = '$cursoId'";
        $result2 = $mysqli->query($query) or die("Falha na consulta SQL");
        $inscrito = $result2->num_rows > 0;

        $row['inscrito'] = $inscrito;
        $cursos[] = $row;
    }

    return $cursos;
}

// Função para se inscrever em um curso
function inscreverCurso($cursoId)
{
    global $mysqli, $alunoId;
    $query = "UPDATE usuarios SET curso_atual = '$cursoId' WHERE ID = '$alunoId'";
    $mysqli->query($query) or die("Falha na consulta SQL");
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['curso_id'])) {
        $cursoId = $_POST['curso_id'];
        inscreverCurso($cursoId);
        // Redireciona para a página de cursos
        header("Location: cursos.php?success=true");
        exit;
    }
}

$cursos = getCursos();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cursos</title>
    <link rel="stylesheet" href="../css/main.css">
    <style>
        .already-registered {
            color: red;
            font-weight: bold;
        }
        .course-container {
            margin-bottom: 20px;
            text-align: center;
        }
        .login_container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
    </style>
</head>
<body>
    <h1>Cursos Disponíveis</h1>

    <?php if (isset($_GET['success']) && $_GET['success'] === 'true'): ?>
        <p style="text-align: center;" class="success-message">Inscrição realizada com sucesso!</p>
    <?php endif; ?>

    <div class="login_container">
        <?php foreach ($cursos as $curso): ?>
            <div class="course-container">
                <div class="login_css">
                    <h2><?php echo $curso['nome_comercial']; ?></h2>
                    <p><?php echo $curso['descricao']; ?></p>
                    <p>Carga Horária: <?php echo $curso['carga_horaria']; ?></p>
                    <?php if ($curso['inscrito']): ?>
                        <p class="already-registered">Já Inscrito</p>
                    <?php else: ?>
                        <form action="" method="POST">
                            <input type="hidden" name="curso_id" value="<?php echo $curso['id']; ?>">
                            <button type="submit">Inscrever-se</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <a href="../aluno.php" class="btn-voltar">Voltar</a>
</body>
</html>
