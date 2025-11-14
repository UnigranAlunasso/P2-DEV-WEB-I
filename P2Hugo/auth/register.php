<?php
include_once '../config/database.php';

$error = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    if (empty($nome) || empty($email) || empty($senha)) {
        $error = 'Todos os campos são obrigatórios.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Formato de email inválido.';
    } else {
        try {
            // Verificar se o email ja existe
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $error = 'Este email já está cadastrado.';
            } else {
                // Inserir novo usuario
                $hashed_senha = password_hash($senha, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (nome, email, senha) VALUES (?, ?, ?)");
                $stmt->execute([$nome, $email, $hashed_senha]);
                $success = true; // Flag para mostrar mensagem de sucesso
            }
        } catch (PDOException $e) {
            $error = 'Erro no banco de dados: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - To-Do List</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
    <div class="container auth-container">
        <h1>Crie sua Conta</h1>

        <?php if ($success): ?>
            <div class="success">
                <p>Registro realizado com sucesso!</p>
                <p><a href="../index.php">Clique aqui para fazer login</a></p>
            </div>
        <?php else: ?>
            <?php if ($error): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <form action="register.php" method="post">
                <label for="nome">Nome:</label>
                <input type="text" name="nome" required>
                <label for="email">Email:</label>
                <input type="email" name="email" required>
                <label for="senha">Senha:</label>
                <input type="password" name="senha" required>
                <button type="submit">Registrar</button>
            </form>
            <div class="secondary-action">
                <p>Já tem uma conta? <a href="../index.php">Faça login</a></p>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>