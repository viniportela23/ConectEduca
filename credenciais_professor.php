<?php
// Verificar se o usuário está autenticado e tem nível igual a 1
if (!isset($_SESSION['iduser']) || $_SESSION['nivel'] != 2) {
    // Redirecionar o usuário para a página de login ou exibir uma mensagem de erro
    header("Location: login.php");
    exit;
}
?>