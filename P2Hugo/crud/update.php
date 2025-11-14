<?php
include_once '../config/database.php';
include_once '../templates/header.php';

$error = '';
$success = '';
$id = $_GET['id'] ?? null;
$user_id = $_SESSION['user_id'];

if (!$id) {
    header('Location: read.php');
    exit;
}

// Buscar a tarefa e verificar se pertence ao usuario
try {
    $stmt = $pdo->prepare("SELECT * FROM tarefas WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $user_id]);
    $tarefa = $stmt->fetch();

    if (!$tarefa) {
        header('Location: read.php'); // Tarefa nao encontrada ou nao pertence ao usuario
        exit;
    }
} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = trim($_POST['titulo']);
    $descricao = trim($_POST['descricao']);
    $concluida = isset($_POST['concluida']) ? 1 : 0;

    if (empty($titulo)) {
        $error = 'O titulo da tarefa e obrigatorio.';
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE tarefas SET titulo = ?, descricao = ?, concluida = ? WHERE id = ? AND user_id = ?");
            $stmt->execute([$titulo, $descricao, $concluida, $id, $user_id]);
            header('Location: read.php?success=Tarefa atualizada com sucesso!');
            exit;
        } catch (PDOException $e) {
            $error = 'Erro ao atualizar tarefa: ' . $e->getMessage();
        }
    }
}
?>

<h2>Editar Tarefa</h2>
<?php if ($error) { echo '<p class="error">' . $error . '</p>'; } ?>
<form action="update.php?id=<?php echo $id; ?>" method="post">
    <label for="titulo">Titulo:</label>
    <input type="text" name="titulo" value="<?php echo htmlspecialchars($tarefa['titulo']); ?>" required>
    <label for="descricao">Descricao:</label>
    <textarea name="descricao"><?php echo htmlspecialchars($tarefa['descricao']); ?></textarea>
    <label>
        <input type="checkbox" name="concluida" <?php echo $tarefa['concluida'] ? 'checked' : ''; ?>>
        Marcar como Concluida
    </label>
    <button type="submit">Atualizar</button>
</form>

<?php include_once '../templates/footer.php'; ?>