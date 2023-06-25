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
    $query = "SELECT * FROM vagas";
    $result = $mysqli->query($query);

    $vagas = [];
    while ($row = $result->fetch_assoc()) {
        // Verifica se o aluno já está inscrito na vaga atual
        $vagaId = $row['id_vaga'];
        $query = "SELECT * FROM usuarios WHERE ID = ? AND vaga_id = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("ii", $alunoId, $vagaId);
        $stmt->execute();
        $result2 = $stmt->get_result();
        $inscrito = $result2->num_rows > 0;

        $row['inscrito'] = $inscrito;
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
    </div>

    <a href="../aluno.php" class="btn-voltar">Voltar</a>
</body>
</html>
