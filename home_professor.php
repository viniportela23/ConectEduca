<!DOCTYPE html>
<html>
<head>
  <title>Pagina do Professor</title>
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

  <div class="container">
    <div class="jumbotron rounded card">
      <h1 class="display-4">Bem-vindo ao Sistema</h1>
      <p class="lead">O Portal Estudantil Mais Bem Otimizado e Lindo.</p>
      <hr class="my-4">
      <p>Recadinhos da Paroquia.</p>
      <a class="btn btn-primary btn-lg" href="editor_noticias.php" role="button">Saiba mais</a>
    </div>
  </div>
  <div class="container mt-4">
    <h3>Últimas Pesquisas</h3>
    <ul class="list-group">
      <?php
      session_start();

      // Verificar se o usuário está autenticado e tem nível igual a 1
      require_once('credenciais_professor.php');


      // Verificar se o cookie com o id_user está definido
      if (isset($_SESSION['iduser']) && isset($_SESSION['cargo'])) {
          $id_user = $_SESSION['iduser'];
          $cargo = $_SESSION['cargo'];

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

          // Consultar as últimas pesquisas associadas ao cargo do usuário
          $sql_pesquisas = "SELECT pergunta, resposta FROM pesquisa WHERE materia = '$cargo' ORDER BY idpesquisa DESC LIMIT 10";
          $result_pesquisas = $conn->query($sql_pesquisas);

          // Exibir as pesquisas
          if ($result_pesquisas && $result_pesquisas->num_rows > 0) {
              while ($row_pesquisa = $result_pesquisas->fetch_assoc()) {
                  $pergunta = $row_pesquisa['pergunta'];
                  $resposta = $row_pesquisa['resposta'];

                  echo "<li class='list-group-item'><strong>Pergunta:</strong> $pergunta</li>";
                  echo "<li class='list-group-item'><strong>Resposta:</strong> $resposta</li>";
                  echo "<hr>";
              }
          } else {
              echo "<li class='list-group-item'>Nenhuma pesquisa encontrada.</li>";
          }

          $conn->close();
      } else {
          echo "<li class='list-group-item'>ID do usuário ou cargo não encontrado.</li>";
      }
      ?>
    </ul>
  </div>
</body>
</html>
