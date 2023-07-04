<?php
session_start();
require_once('credenciais_professor.php');


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $texto = $_POST["texto"];
    $disciplina = $_POST["disciplina"];
    
    // Salvar a pergunta no arquivo pergunta.txt
    file_put_contents("pergunta.txt", $texto);

    // Redirecionar para a página "resposta_aluno.php" com os dados do formulário
    header("Location: resposta_professor.php?texto=" . urlencode($texto) . "&disciplina=" . urlencode($disciplina));
    sleep(3);

    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Chat GPT</title>
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
    <h1>Área do professor</h1>
    <form onsubmit="return validateForm()" action="" method="POST">
      <div class="jumbotron rounded card">
        <label for="texto">Digite seu texto (limite de 10000 caracteres):</label>
        <textarea class="form-control" id="texto" name="texto" rows="5" maxlength="10000"></textarea>
      </div>
      <div class="form-group">
        <label for="disciplina">Selecione uma disciplina:</label>
        <select class="form-control" id="disciplina" name="disciplina">
          <option value="">Selecione...</option>
          <option value="matematica">Matemática</option>
          <option value="portugues">Português</option>
          <option value="historia">História</option>
          <option value="geografia">Geografia</option>
          <option value="ciencias">Ciências</option>
          <option value="fisica">Física</option>
          <option value="biologia">Biologia</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Enviar</button>
      <div id="alertMsg" class="alert alert-danger d-none">
        Por favor, digite um texto com pelo menos 30 caracteres e selecione uma disciplina.
        <button type="button" class="close" onclick="closeAlert()">&times;</button>
      </div>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($resposta_chatgpt)) {
        echo "<div class='jumbotron rounded card mt-4'>";
        echo "<h4>Resposta do ChatGPT:</h4>";
        echo "<p>" . $resposta_chatgpt . "</p>";
        echo "</div>";
    }
    ?>

  </div>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    function validateForm() {
      var texto = document.getElementById("texto").value;
      var disciplina = document.getElementById("disciplina").value;

      if (texto.length < 30 || disciplina === "") {
        document.getElementById("alertMsg").classList.remove("d-none");
        return false;
      }

      return true;
    }

    function closeAlert() {
      document.getElementById("alertMsg").classList.add("d-none");
    }
  </script>
</body>
</html>
