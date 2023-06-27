<?php
session_start();

// Verificar se o usuário está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

// Verificar o nível do usuário e redirecionar para a página correspondente
$nivel = $_SESSION['nivel'];
if ($nivel == 1) {
    header("Location: home_aluno.php");
    exit();
} elseif ($nivel == 2) {
    header("Location: home_professor.php");
    exit();
} else {
    // Nível inválido
    header("Location: tente-novamente.php");
    exit();
}
?>
