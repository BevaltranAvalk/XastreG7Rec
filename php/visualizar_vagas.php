<?php
session_start();
include('connect.php');

// Verifica login
if (!isset($_SESSION['ID'])) {
    header("Location: index.php");
    exit;
}

if (!isset($_SESSION['vaga'])) {
    header("Location: cria_vaga.php");
    exit;
}

$vaga = $_SESSION['vaga'];
$vagaCriada = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirmar'])) {
        $titulo = $vaga['titulo'];
        $empresa = $vaga['empresa'];
        $descricao = $vaga['descricao'];
        $requisitos = $vaga['requisitos'];
        $faixa_salarial = $vaga['faixa_salarial'];
        $cursoNome = $vaga['curso'];

        $query = "SELECT id FROM curso WHERE nome_comercial = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("s", $cursoNome);
        $stmt->execute();
        $result = $stmt->get_result();
        $curso = $result->fetch_assoc();
        $cursoId = $curso['id'];

        $empresaId = $_SESSION['ID'];

        // Salvar a vaga no banco de dados
        $query = "INSERT INTO vagas (titulo, empresa, descricao, requisitos, faixa_salarial, id_curso, id_empresa) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("ssssiii", $titulo, $empresa, $descricao, $requisitos, $faixa_salarial, $cursoId, $empresaId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $message = "Vaga criada com sucesso!";
            $vagaCriada = true;
            unset($_SESSION['vaga']);
        } else {
            $message = "Erro ao criar a vaga.";
        }
    } elseif (isset($_POST['editar'])) {
        header("Location: cria_vaga.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Visualizar Vagas</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #8ac4ff;
            color: #000;
        }

        .vaga_container {
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

        .vaga_item {
            margin-bottom: 20px;
            text-align: center;
        }

        .vaga_item label {
            font-weight: bold;
            display: block;
        }

        .vaga_item p {
            margin-bottom: 10px;
        }

        .vaga_item input[type="submit"] {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .vaga_item input[type="submit"]:hover {
            background-color: #555;
        }

        .message {
            color: #333;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }

        .btn-voltar {
            position: fixed;
            bottom: 20px;
            right: 20px;
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
    <div class="vaga_container">
        <h1>Vaga</h1>
        <?php if (isset($message) && $message !== "") : ?>
            <div class="message success"><?php echo $message; ?></div>
        <?php endif; ?>
        <?php if (isset($vagaCriada) && $vagaCriada) : ?>
            <div class="message success">Volte ao menu</div>
        <?php else : ?>
            <div class="vaga_item">
                <label for="titulo">Título da Vaga:</label>
                <p><?php echo $vaga['titulo']; ?></p>
            </div>
            <div class="vaga_item">
                <label for="empresa">Empresa:</label>
                <p><?php echo $vaga['empresa']; ?></p>
            </div>
            <div class="vaga_item">
                <label for="descricao">Descrição:</label>
                <p><?php echo $vaga['descricao']; ?></p>
            </div>
            <div class="vaga_item">
                <label for="requisitos">Requisitos:</label>
                <p><?php echo $vaga['requisitos']; ?></p>
            </div>
            <div class="vaga_item">
                <label for="faixa_salarial">Faixa Salarial:</label>
                <p><?php echo $vaga['faixa_salarial']; ?></p>
            </div>
            <div class="vaga_item">
                <label for="curso">Curso necessário:</label>
                <p><?php echo $vaga['curso']; ?></p>
            </div>
            <div class="vaga_item">
                <form method="POST">
                    <input type="submit" name="confirmar" value="Confirmar">
                    <input type="submit" name="editar" value="Editar">
                </form>
            </div>
        <?php endif; ?>
    </div>
    <a href="../empresa.html" class="btn-voltar">Voltar</a>
</body>
</html>
