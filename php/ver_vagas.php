<?php
include('connect.php');

$vagaMessage = "";

// Excluir uma vaga
if (isset($_GET['excluir_vaga'])) {
    $idVaga = $_GET['excluir_vaga'];

    $deleteQuery = "DELETE FROM vagas WHERE id_vaga = '$idVaga'";
    $deleteResult = $mysqli->query($deleteQuery);

    if ($deleteResult) {
        $vagaMessage = "Vaga excluída com sucesso!";
    } else {
        $vagaMessage = "Erro ao excluir a vaga: " . $mysqli->error;
    }
}

// Buscar todas as vagas
$vagaQuery = "SELECT * FROM vagas";
$vagaResult = $mysqli->query($vagaQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Vagas</title>
    <link rel="stylesheet" href="../css/main.css">
    <style>
        .button-wrapper {
            text-align: center;
        }
        .button-wrapper button {
            margin: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="login_container">
        <div class="login_css">
            <?php if (!empty($vagaMessage)): ?>
                <div class="button-wrapper">
                    <p><?php echo $vagaMessage; ?></p>
                </div>
            <?php endif; ?>

            <h1>GERENCIAR VAGAS</h1>

            <?php if ($vagaResult->num_rows > 0): ?>
                <table>
                    <tr>
                        <th>Vaga ID</th>
                        <th>Título da Vaga</th>
                        <th>Curso ID</th>
                        <th>Empresa</th>
                        <th>Descrição</th>
                        <th>Faixa Salarial</th>
                        <th>Ações</th>
                    </tr>
                    <?php while ($vaga = $vagaResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $vaga['id_vaga']; ?></td>
                            <td><?php echo $vaga['titulo']; ?></td>
                            <td><?php echo $vaga['id_curso']; ?></td>
                            <td><?php echo $vaga['empresa']; ?></td>
                            <td><?php echo $vaga['descricao']; ?></td>
                            <td><?php echo $vaga['faixa_salarial']; ?></td>
                            <td>
                                <a href="edt_vaga_emp.php?id=<?php echo $vaga['id_vaga']; ?>">Editar</a>
                                <a href="?excluir_vaga=<?php echo $vaga['id_vaga']; ?>">Excluir</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            <?php else: ?>
                <p>Nenhuma vaga encontrada.</p>
            <?php endif; ?>
            </div>
    </div>
    <a href="../empresa.html" class="btn-voltar">Voltar</a>
</body>
</html>
