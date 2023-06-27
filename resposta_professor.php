<?php
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $texto = isset($_GET["texto"]) ? $_GET["texto"] : "";
    $resposta_chatgpt = isset($_GET["resposta_chatgpt"]) ? $_GET["resposta_chatgpt"] : "Sem resposta do ChatGPT";


    // Verificar se o cookie com o id_user está definido
    session_start();
    require_once('credenciais_professor.php');


      if (isset($_SESSION['iduser']) && isset($_SESSION['cargo'])) {
        $id_user = $_SESSION['iduser'];
        $disciplina = $_SESSION['cargo'];

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

        // Inserir os dados na tabela "pesquisa"
        $sql = "INSERT INTO pesquisa (pergunta, resposta, iduser, materia) VALUES ('$texto', '$resposta_chatgpt', '$id_user', '$disciplina')";

        if ($conn->query($sql) === TRUE) {
            echo "Dados inseridos no banco de dados com sucesso!";
        } else {
            echo "Ocorreu um erro ao inserir os dados no banco de dados.";
        }

        $conn->close();
    } else {
        echo "ID do usuário não encontrado.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Resposta do ChatGPT</title>
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
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
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
    <h1>Resposta do ChatGPT</h1>
    <div class="jumbotron rounded card">
      <?php
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $texto = isset($_GET["texto"]) ? $_GET["texto"] : "";
            $resposta_chatgpt = isset($_GET["resposta_chatgpt"]) ? $_GET["resposta_chatgpt"] : "";
            $disciplina = $_SESSION['cargo'];

            echo "<h4>Resposta do Professor:</h4>";
            echo "<p>$texto</p>";

            echo "<h4>Disciplina:</h4>";
            echo "<p>$disciplina</p>";

            if (!empty($resposta_chatgpt)) {
                echo "<h4>Resposta do ChatGPT:</h4>";
                echo "<p>$resposta_chatgpt</p>";
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

