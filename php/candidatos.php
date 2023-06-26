<?php
session_start();
include('connect.php');

// Verifica se a empresa está logada
if (!isset($_SESSION['ID'])) {
    header("Location: index.php");
    exit;
}

$empresaId = $_SESSION['ID'];
function getCandidatos()
{
    global $mysqli, $empresaId;
    
    $query = "SELECT * FROM vagas WHERE id_empresa = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $empresaId);
    $stmt->execute();
    $result = $stmt->get_result();

    $candidatos = [];

    while ($row = $result->fetch_assoc()) {
        $vagaId = $row['id_vaga'];
        $query = "SELECT u.email, n.nota 
                  FROM usuarios u 
                  INNER JOIN notas n ON u.ID = n.id_aluno 
                  WHERE u.vaga_id = ? AND n.id_curso = u.curso_atual AND n.nota > 7";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("i", $vagaId);
        $stmt->execute();
        $result2 = $stmt->get_result();

        $candidatosVaga = [];

        while ($row2 = $result2->fetch_assoc()) {
            $candidatosVaga[] = $row2;
        }

        $candidatos[$vagaId] = $candidatosVaga;
    }

    return $candidatos;
}

$candidatos = getCandidatos();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Candidatos</title>
    <link rel="stylesheet" href="../css/main.css">
    <style>
        .cand_css {
            border-radius: 20px;
            border: 1px solid #000000;
            background-color: #c3e6f9;
            text-align: center;
            padding: 20px;
            margin-bottom: 20px;
        }

    </style>
</head>
<body>
    <h1>Candidatos Inscritos</h1>

    <div class="login_container">
        <?php if (!empty($candidatos)): ?>
            <?php foreach ($candidatos as $vagaId => $candidatosVaga): ?>
                <?php
                    // Obter informações da vaga
                    $query = "SELECT titulo FROM vagas WHERE id_vaga = ?";
                    $stmt = $mysqli->prepare($query);
                    $stmt->bind_param("i", $vagaId);
                    $stmt->execute();
                    $result3 = $stmt->get_result();
                    $vaga = $result3->fetch_assoc();
                    $tituloVaga = $vaga['titulo'];
                ?>
                <div class="cand_css">
                    <h2>Vaga: <?php echo $tituloVaga; ?></h2>
                    <?php if (!empty($candidatosVaga)): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Email</th>
                                    <th>Nota</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($candidatosVaga as $candidato): ?>
                                    <tr>
                                        <td><?php echo $candidato['email']; ?></td>
                                        <td><?php echo $candidato['nota']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>Nenhum candidato inscrito para esta vaga.</p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhuma vaga com candidatos inscritos.</p>
        <?php endif; ?>
    </div>

    <a href="../empresa.html" class="btn-voltar">Voltar</a>
</body>
</html>
