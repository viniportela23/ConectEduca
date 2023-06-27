<?php
session_start();

require_once('credenciais_professor.php');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuário Nâo Criado</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Estilos adicionais para a página usuário_criado */
        .card_top {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <form class="form" action="home_professor.php">
        <div class="card">
            <div class="card_top">
                <h1 class="titulo">Usuário não pode ser criado corretamente!</h1>
            </div>
            <div class="texto2 btn">
                <button type="submit">Home</button>
            </div>
        </div>
    </form>
</body>
</html>
