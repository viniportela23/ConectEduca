<?php
session_start();
require_once('credenciais_aluno.php');

// Função para ler a resposta do arquivo resposta.txt
function lerRespostaChatGPT() {
    $resposta_chatgpt = file_get_contents("resposta.txt");
    return $resposta_chatgpt;
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $texto = isset($_GET["texto"]) ? $_GET["texto"] : "";
    $disciplina = isset($_GET["disciplina"]) ? $_GET["disciplina"] : "";

    // Verificar se o cookie com o id_user está definidolo
    if (isset($_SESSION['iduser'])) {
        $id_user = $_SESSION['iduser'];

        // Conectar ao banco de dados (você precisa implementar essa parte)
        $credenciais = parse_ini_file("credenciais_banco.txt");
        $host = $credenciais['host'];
        $username = $credenciais['username'];
        $password = $credenciais['password'];
        $dbname = $credenciais['dbname'];

        $conn = new mysqli($host, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Erro na conexão com o banco de dados: " . $conn->connect_error);
        }

        // Inserir os dados na tabela "pesquisa" (você precisa implementar essa parte)
        $resposta_chatgpt = lerRespostaChatGPT();
        $sql = "INSERT INTO pesquisa (pergunta, resposta, iduser, materia) VALUES ('$texto', '$resposta_chatgpt', '$id_user', '$disciplina')";

        if ($conn->query($sql) === TRUE) {
            echo "Dados inseridos com sucesso no banco de dados.";
        } else {
            echo "Erro ao inserir os dados no banco de dados: " . $conn->error;
        }

        $conn->close();
    } else {
        echo "Cookie com o id_user não definido.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Resposta do ChatGPT</title>
  <meta charset="UTF-8">
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
    <h1>Resposta do ChatGPT</h1>
    <div class="jumbotron rounded card">
      <?php
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $texto = isset($_GET["texto"]) ? $_GET["texto"] : "";
            $disciplina = isset($_GET["disciplina"]) ? $_GET["disciplina"] : "";

            echo "<h4>Resposta do Aluno:</h4>";
            echo "<p>" . htmlspecialchars($texto) . "</p>";

            echo "<h4>Disciplina:</h4>";
            echo "<p>" . htmlspecialchars($disciplina) . "</p>";

            $resposta_chatgpt = lerRespostaChatGPT();

            if (!empty($resposta_chatgpt)) {
                echo "<h4>Resposta do ChatGPT:</h4>";
                echo "<p>" . nl2br(htmlspecialchars($resposta_chatgpt)) . "</p>";
                echo "<button class='btn btn-primary' onclick='voltar()'>Voltar</button>";
            } else {
                echo "<h4>Resposta do ChatGPT:</h4>";
                echo "<p>Sem resposta do ChatGPT</p>";
                echo "<button class='btn btn-primary' onclick='voltar()'>Voltar</button>";
            }
        }
      ?>
    </div>
  </div>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    function voltar() {
      window.history.back();
    }
  </script>
</body>
</html>

