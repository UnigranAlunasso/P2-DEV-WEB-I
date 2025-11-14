<?php
include_once '../config/database.php';
include_once '../templates/header.php';

$user_id = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM tarefas WHERE user_id = ? ORDER BY data_criacao DESC");
    $stmt->execute([$user_id]);
    $tarefas = $stmt->fetchAll();
} catch (PDOException $e) {
    echo '<p class="error">Erro ao buscar tarefas: ' . $e->getMessage() . '</p>';
}
?>

<h2>Minhas Tarefas</h2>
<?php if (isset($_GET['success'])) { echo '<p class="success">' . htmlspecialchars($_GET['success']) . '</p>'; } ?>
<table>
    <thead>
        <tr>
            <th>Titulo</th>
            <th>Descricao</th>
            <th>Data de Criacao</th>
            <th>Status</th>
            <th>Acoes</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tarefas as $tarefa): ?>
            <tr class="<?php echo $tarefa['concluida'] ? 'concluida' : ''; ?>">
                <td><?php echo htmlspecialchars($tarefa['titulo']); ?></td>
                <td><?php echo htmlspecialchars($tarefa['descricao']); ?></td>
                <td><?php echo date('d/m/Y H:i', strtotime($tarefa['data_criacao'])); ?></td>
                <td><?php echo $tarefa['concluida'] ? 'Concluida' : 'Pendente'; ?></td>
                <td>
                    <a href="update.php?id=<?php echo $tarefa['id']; ?>">Editar</a>
                    <a href="delete.php?id=<?php echo $tarefa['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir esta tarefa?');">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include_once '../templates/footer.php'; ?>