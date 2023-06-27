<?php
session_start();

$credenciais = parse_ini_file("credenciais_banco.txt");
$endereco = $credenciais["host"];
$usuario = $credenciais["username"];
$senha = $credenciais["password"];
$banco = $credenciais["dbname"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario_entrada = addslashes($_POST["usuario"]);
    $senha_entrada = addslashes($_POST["senha"]);

    $pdo = new PDO("mysql:dbname=".$banco.";host=".$endereco, $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    try {
        $sql = "SELECT iduser, senha_criptografada, nivel, cargo FROM usuarios WHERE usuario = :usuario";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':usuario', $usuario_entrada);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            if (password_verify($senha_entrada, $row['senha_criptografada'])) {
                // Senha correta, usuário autenticado
                $_SESSION['usuario'] = $usuario_entrada;
                $_SESSION['iduser'] = $row['iduser'];
                $_SESSION['cargo'] = $row['cargo'];
                $_SESSION['nivel'] = $row['nivel'];

                // Verificar o nível do usuário e redirecionar para a página correspondente
                $nivel = $row['nivel'];
                if ($nivel == 1) {
                    header("Location: home_aluno.php");
                } elseif ($nivel == 2) {
                    header("Location: home_professor.php");
                } else {
                    // Nível inválido
                    echo "<script>alert('Nível de usuário inválido.');</script>";
                }
                exit();
            } else {
                // Senha incorreta
                echo "<script>alert('Senha incorreta.');</script>";
            }
        } else {
            // Usuário não encontrado
            echo "<script>alert('Usuário não encontrado.');</script>";
        }
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
}
?>




<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>    
    <form class="form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="card">
            <div class="card_top">
                <h1 class="titulo">Seja bem-vindo ao sistema!</h1>
                <p class="texto1">Digite seu usuário e senha</p>
            </div>
            <div class="texto2">
                <label>Usuário:</label>
                <input type='text' name='usuario' placeholder="Digite seu usuário">
            </div>
            <div class="texto2">
                <label>Senha:</label>
                <input type='password' name='senha' placeholder="Digite sua senha">
            </div>
            <div class="texto2">
                <label><input type="checkbox"> Lembre-me</label>
            </div>
            <div class="texto2 btn">
                <button type='submit'>Continuar</button>
            </div>
        </div>
    </form>
</body>
</html>
