<?php
session_start();

// Se o usuario ja esta logado, redireciona para a lista de tarefas
if (isset($_SESSION['user_id'])) {
    header('Location: crud/read.php');
    exit;
}

$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - To-Do List</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <div class="container auth-container">
        <h1>Bem-vindo!</h1>
        <p>Faça login para continuar.</p>

        <?php if ($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p class="success"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>

        <form action="auth/login.php" method="post">
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            <label for="senha">Senha:</label>
            <input type="password" name="senha" required>
            <button type="submit">Entrar</button>
        </form>

        <div class="secondary-action">
            <p>Não tem uma conta? <a href="auth/register.php">Registre-se</a></p>
        </div>
    </div>
</body>

</html>