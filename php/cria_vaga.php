<?php
session_start();
include('connect.php');

// Verifica login
if (!isset($_SESSION['ID'])) {
    header("Location: index.php");
    exit;
}

// Variáveis de mensagem
$message = "";
$success = false;

// Obter a lista de cursos do banco de dados
$query = "SELECT * FROM curso";
$result = $mysqli->query($query);

if ($result) {
    $cursos = $result->fetch_all(MYSQLI_ASSOC);
} else {
    // Exibir mensagem de erro
    echo "Erro ao obter a lista de cursos.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obter os dados do formulário
    $titulo = $_POST['titulo'];
    $empresa = $_POST['empresa'];
    $descricao = $_POST['descricao'];
    $requisitos = $_POST['requisitos'];
    $faixa_salarial = $_POST['faixa_salarial'];
    $cursoNome = $_POST['curso'];

    // Obter o ID do curso selecionado
    $query = "SELECT id FROM curso WHERE nome_comercial = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $cursoNome);
    $stmt->execute();
    $result = $stmt->get_result();
    $curso = $result->fetch_assoc();
    $cursoId = $curso['id'];

    // Obter o ID da empresa
    $empresaId = $_SESSION['ID'];

    // Salvar a vaga no banco de dados com o ID do curso e ID da empresa
    $query = "INSERT INTO vagas (titulo, empresa, descricao, requisitos, faixa_salarial, id_curso, id_empresa) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("ssssiii", $titulo, $empresa, $descricao, $requisitos, $faixa_salarial, $cursoId, $empresaId);
    $stmt->execute();

    // Verificar se a vaga foi inserida com sucesso
    if ($stmt->affected_rows > 0) {
        $success = true;
        $message = "Vaga criada com sucesso!";
    } else {
        $message = "Erro ao criar a vaga.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Criar Vaga</title>
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

        .form_container {
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

        .form_item {
            margin-bottom: 20px;
            text-align: center;
        }

        .form_item label {
            font-weight: bold;
            display: block;
        }

        .form_item input[type="text"], .form_item textarea, .form_item input[type="number"] {
            width: 100%;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #000000;
        }

        .form_item input[type="submit"] {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form_item input[type="submit"]:hover {
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
    <div class="form_container">
        <h1>Criar Vaga</h1>
        <?php if ($message !== "") : ?>
            <div class="message <?php echo $success ? 'success' : 'error'; ?>"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form_item">
                <label for="titulo">Título da Vaga:</label>
                <input type="text" id="titulo" name="titulo" required>
            </div>
            <div class="form_item">
                <label for="empresa">Empresa:</label>
                <input type="text" id="empresa" name="empresa" required>
            </div>
            <div class="form_item">
                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" rows="4" required></textarea>
            </div>
            <div class="form_item">
                <label for="requisitos">Requisitos:</label>
                <textarea id="requisitos" name="requisitos" rows="4" required></textarea>
            </div>
            <div class="form_item">
                <label for="faixa_salarial">Faixa Salarial:</label>
                <input type="number" id="faixa_salarial" name="faixa_salarial" required>
            </div>
            <div class="form_item">
                <label for="curso">Curso necessário:</label>
                <select id="curso" name="curso" required>
                    <?php foreach ($cursos as $curso) : ?>
                        <option value="<?php echo $curso['nome_comercial']; ?>"><?php echo $curso['nome_comercial']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form_item">
                <input type="submit" value="Criar Vaga">
            </div>
        </form>
    </div>
    <a href="../empresa.html" class="btn-voltar">Voltar</a>
</body>
</html>
