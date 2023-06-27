<?php
session_start();
require_once('credenciais_professor.php');

// Verificar se o usuário está autenticado e tem nível igual a 1
require_once('credenciais_professor.php');

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

    // Verificar se o formulário de recados foi submetido
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $recado = $_POST["recado"];

        // Inserir o recado na tabela "recadinhos_da_paroquia"
        $sql = "INSERT INTO recadinhos_da_paroquia (iduser, recado) VALUES ('$id_user', '$recado')";

        if ($conn->query($sql) === TRUE) {
            echo "Recado inserido com sucesso!";
        } else {
            echo "Ocorreu um erro ao inserir o recado no banco de dados.";
        }
    }

    // Obter os recados associados ao usuário
    $sql_recados = "SELECT * FROM recadinhos_da_paroquia WHERE iduser = '$id_user'";
    $result_recados = $conn->query($sql_recados);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Editor Recadinhos da Paroquia</title>
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
          <a class="nav-link" href="lista_usuarios.php">Usuários</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="chatgpt_professor.php">Chat GPT</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contato</a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container mt-4">
    <h1>Editor Recadinhos da Paroquia</h1>
    <form onsubmit="return validateForm()" action="" method="POST">
      <div class="jumbotron rounded card">
        <label for="recado">Digite o recado:</label>
        <textarea class="form-control" id="recado" name="recado" rows="5"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Enviar Recado</button>
      <div id="alertMsg" class="alert alert-danger d-none">
        Por favor, digite um recado.
        <button type="button" class="close" onclick="closeAlert()">&times;</button>
      </div>
    </form>

    <h2>Recados:</h2>
    <?php
    if ($result_recados->num_rows > 0) {
        while ($row_recado = $result_recados->fetch_assoc()) {
            echo "<div class='alert alert-info'>Usuário: $id_user<br>Recado: {$row_recado['recado']}</div>";
        }
    } else {
        echo "<p>Nenhum recado encontrado.</p>";
    }
    ?>

  </div>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    function validateForm() {
      var recado = document.getElementById("recado").value;

      if (recado === "") {
        document.getElementById("alertMsg").classList.remove("d-none");
        return false;
      }
    }

    function closeAlert() {
      document.getElementById("alertMsg").classList.add("d-none");
    }
  </script>
</body>
</html>

<?php
  $conn->close();
} else {
  echo "ID do usuário não encontrado.";
}
?>

