<?php
session_start();
include_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    try {
        $stmt = $pdo->prepare("SELECT id, senha FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($senha, $user['senha'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: ../crud/read.php');
            exit;
        } else {
            header('Location: ../index.php?error=Email ou senha invalidos');
            exit;
        }
    } catch (PDOException $e) {
        header('Location: ../index.php?error=Erro no banco de dados');
        exit;
    }
}
