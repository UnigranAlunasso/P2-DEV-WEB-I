<?php
include_once '../config/database.php';
include_once '../templates/header.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = trim($_POST['titulo']);
    $descricao = trim($_POST['descricao']);
    $user_id = $_SESSION['user_id'];

    if (empty($titulo)) {
        $error = 'O titulo da tarefa é obrigatorio.';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO tarefas (titulo, descricao, user_id) VALUES (?, ?, ?)");
            $stmt->execute([$titulo, $descricao, $user_id]);
            $success = 'Tarefa criada com sucesso!';
        } catch (PDOException $e) {
            $error = 'Erro ao criar tarefa: ' . $e->getMessage();
        }
    }
}
?>

<h2>Nova Tarefa</h2>
<?php if ($error) {
    echo '<p class="error">' . $error . '</p>';
} ?>
<?php if ($success) {
    echo '<p class="success">' . $success . '</p>';
} ?>
<form action="create.php" method="post">
    <label for="titulo">Titulo:</label>
    <input type="text" name="titulo" required>
    <label for="descricao">Descricao:</label>
    <textarea name="descricao"></textarea>
    <button type="submit">Criar</button>
</form>

<?php include_once '../templates/footer.php'; ?>