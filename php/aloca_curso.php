<?php
include('connect.php');

// Consulta os cursos
$cursosQuery = "SELECT * FROM curso";
$cursosResult = $mysqli->query($cursosQuery);

// Consulta todas as questões
$questoesQuery = "SELECT * FROM quiz";
$questoesResult = $mysqli->query($questoesQuery);

// Processa o envio do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cursoSelecionado = $_POST["curso"];
    $questoesSelecionadas = $_POST["questoes"];

    // Limpa as questões
    $limparQuery = "UPDATE quiz SET curso_id = NULL WHERE curso_id = '$cursoSelecionado'";
    $mysqli->query($limparQuery);

    // Associa as novas questões selecionadas ao curso atual
    foreach ($questoesSelecionadas as $questao) {
        $associarQuery = "UPDATE quiz SET curso_id = '$cursoSelecionado' WHERE id = '$questao'";
        $mysqli->query($associarQuery);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Administração</title>
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
    <div class="login_container">


        <div class="curso-container">
            <h2 class="curso-title">Define Cursos</h2>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                echo '<div class="mensagem">Alteração feita!</div>';
            }
            ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form-wrapper">
                <label for="curso">Selecione um curso:</label>
                <select id="curso" name="curso" required>
                    <option value="" disabled selected>Selecione um curso</option>
                    <?php while ($curso = $cursosResult->fetch_assoc()): ?>
                        <option value="<?php echo $curso['id']; ?>"><?php echo $curso['nome_comercial']; ?></option>
                    <?php endwhile; ?>
                </select>

                <label for="questoes">Selecione as questões:</label>
                <?php while ($questao = $questoesResult->fetch_assoc()): ?>
                    <label>
                        <input type="checkbox" name="questoes[]" value="<?php echo $questao['id']; ?>">
                        <?php echo $questao['pergunta']; ?>
                    </label>
                <?php endwhile; ?>

                <input type="submit" value="Alterar curso">
            </form>
        </div>
    </div>
    <a href="../admin.html" class="btn-voltar">Voltar</a>
</body>
</html>
