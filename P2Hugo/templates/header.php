<?php
session_start();

// Proteger a pagina: se o usuario nao estiver logado, redireciona para o login
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php?error=Voce precisa estar logado para acessar.');
    exit;
}

$user_name = $_SESSION['user_name'] ?? 'Usuario';

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
    <div class="container">
        <header>
            <h1>Minhas Tarefas</h1>
            <nav>
                <span>Olá, <?php echo htmlspecialchars($user_name); ?>!</span>
                <a href="create.php">Nova Tarefa</a>
                <a href="read.php">Minhas Tarefas</a>
                <a href="../auth/logout.php">Sair</a>
            </nav>
        </header>
        <main>