<?php
session_start();

// Verificar se o usuário está autenticado e tem nível igual a 1
require_once('credenciais_aluno.php');


// Verificar se o cookie com o id_user está definido
if (isset($_SESSION['iduser'])) {
    $id_user = $_SESSION['iduser'];

    // Conectar ao banco de dados
    $credenciais = parse_ini_file("credenciais_banco.txt");
    $host = $credenciais['host'];
    $username = $credenciais['username'];
    $password = $credenciais['password'];
    $dbname = $credenciais['dbname'];

    $conn = new mysqli($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Obter os recados de todos os usuários
    $sql_recados = "SELECT * FROM recadinhos_da_paroquia";
    $result_recados = $conn->query($sql_recados);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Recadinhos da Paroquia</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Logo</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="home_aluno.php">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="chatgpt_aluno.php">Chat GPT</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contato</a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container mt-4">
    <h1>Recadinhos da Paroquia</h1>

    <?php
    if ($result_recados->num_rows > 0) {
        while ($row_recado = $result_recados->fetch_assoc()) {
            $id_user_recado = $row_recado['iduser'];
            $recado = $row_recado['recado'];
            echo "<div class='alert alert-info'>ID do Usuário: $id_user_recado<br>Recado: $recado</div>";
        }
    } else {
        echo "<p>Nenhum recado encontrado.</p>";
    }
    ?>

  </div>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
  $conn->close();
} else {
  echo "ID do usuário não encontrado.";
}
?>
