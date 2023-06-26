<?php
session_start();
include('connect.php');

// Verifica se o aluno está logado
if (!isset($_SESSION['ID'])) {
    header("Location: index.php");
    exit;
}

$alunoId = $_SESSION['ID'];

// Verifica se o aluno já passou no teste de aptidão
$query = "SELECT aptidao FROM usuarios WHERE ID = '$alunoId'";
$result = $mysqli->query($query) or die("Falha na consulta SQL");
$row = $result->fetch_assoc();
$aptidao = $row['aptidao'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Processar as respostas do teste de aptidão
    $respostas = $_POST['respostas'];
    $nota = 0;

    // Verifica as respostas
    if ($respostas[0] === 'Brasília') {
        $nota++;
    }
    if ($respostas[1] === '4') {
        $nota++;
    }
    if ($respostas[2] === 'Mercúrio') {
        $nota++;
    }
    if ($respostas[3] === 'Leonardo da Vinci') {
        $nota++;
    }

    // Calcula a nota final
    $notaFinal = ($nota / 4) * 10;

    // Atualiza a aptidão do aluno no banco de dados
    if ($notaFinal >= 5) {
        $query = "UPDATE usuarios SET aptidao = 1 WHERE ID = '$alunoId'";
        $mysqli->query($query) or die("Falha ao atualizar a aptidão do aluno");
        $aptidao = 1; // Atualiza a variável de aptidão
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teste de Aptidão</title>
    <link rel="stylesheet" href="../css/main.css">
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

        .teste_container {
            width: 400px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            border-radius: 20px;
            border: 1px solid #000000;
            background-color: #c3e6f9;
            text-align: center;
            padding: 20px;
            display: inline-block;
            color: #000000;
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
    <div class="teste_container">
        <h1>Teste de Aptidão</h1>

        <?php if ($aptidao === 1): ?>
            <p>Você já passou no teste de aptidão. Prossiga para o teste.</p>
            <a href="teste.php" class="btn-voltar">Prossiga para o Teste</a>
        <?php else: ?>
            <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
                <?php if ($notaFinal >= 5): ?>
                    <p>Parabéns! Você passou no teste de aptidão. Prossiga para o teste.</p>
                    <a href="teste.php" class="btn-voltar">Prossiga para o Teste</a>
                <?php else: ?>
                    <p>Você não passou no teste de aptidão. Tente novamente.</p>
                    <a href="test_apt.php" class="btn-voltar">Tentar Novamente</a>
                <?php endif; ?>
            <?php else: ?>
                <form method="post" action="">
                    <div class="pergunta_css">
                        <h2>Qual é a capital do Brasil?</h2>
                        <div class="opcoes">
                            <label class="opcao">
                                <input type="radio" name="respostas[0]" value="São Paulo">
                                São Paulo
                            </label>
                            <label class="opcao">
                                <input type="radio" name="respostas[0]" value="Rio de Janeiro">
                                Rio de Janeiro
                            </label>
                            <label class="opcao">
                                <input type="radio" name="respostas[0]" value="Brasília">
                                Brasília
                            </label>
                        </div>
                    </div>

                    <div class="pergunta_css">
                        <h2>Quanto é 2 + 2?</h2>
                        <div class="opcoes">
                            <label class="opcao">
                                <input type="radio" name="respostas[1]" value="3">
                                3
                            </label>
                            <label class="opcao">
                                <input type="radio" name="respostas[1]" value="4">
                                4
                            </label>
                            <label class="opcao">
                                <input type="radio" name="respostas[1]" value="5">
                                5
                            </label>
                        </div>
                    </div>

                    <div class="pergunta_css">
                        <h2>Qual é o planeta mais próximo do Sol?</h2>
                        <div class="opcoes">
                            <label class="opcao">
                                <input type="radio" name="respostas[2]" value="Vênus">
                                Vênus
                            </label>
                            <label class="opcao">
                                <input type="radio" name="respostas[2]" value="Marte">
                                Marte
                            </label>
                            <label class="opcao">
                                <input type="radio" name="respostas[2]" value="Mercúrio">
                                Mercúrio
                            </label>
                        </div>
                    </div>

                    <div class="pergunta_css">
                        <h2>Quem pintou a Mona Lisa?</h2>
                        <div class="opcoes">
                            <label class="opcao">
                                <input type="radio" name="respostas[3]" value="Pablo Picasso">
                                Pablo Picasso
                            </label>
                            <label class="opcao">
                                <input type="radio" name="respostas[3]" value="Leonardo da Vinci">
                                Leonardo da Vinci
                            </label>
                            <label class="opcao">
                                <input type="radio" name="respostas[3]" value="Salvador Dalí">
                                Salvador Dalí
                            </label>
                        </div>
                    </div>

                    <button type="submit">Enviar Respostas</button>
                </form>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
