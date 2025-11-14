<?php
session_start();
include_once '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

$id = $_GET['id'] ?? null;
$user_id = $_SESSION['user_id'];

if ($id) {
    try {
        // Adicional: verificar se a tarefa pertence ao usuario antes de deletar
        $stmt = $pdo->prepare("DELETE FROM tarefas WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $user_id]);
    } catch (PDOException $e) {
        // Tratar o erro, talvez redirecionar com uma mensagem de erro
    }
}

header('Location: read.php?success=Tarefa excluida com sucesso!');
exit;
?>