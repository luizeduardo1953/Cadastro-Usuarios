<html>

<head>
  <title>Cadastro de Pessoas</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <main role="main">
    <div class="jumbotron">
      <div class="container">
        <h1 class="display-6">Cadastro de Pessoas</h1>
      </div>
    </div>
    <div class="container">

      <?php

      //Conexão com o servidor do banco de dados
      $servidor = "localhost";
      $usuario = "root";
      $senha = "";

      if ($bancodedados = mysqli_connect($servidor, $usuario, $senha))
        echo "Conexão realizada!";
      else {
        echo "Erro ao conectar com o banco de dados";
      }

      $nomedobanco = "cadastro";

      mysqli_select_db($bancodedados, $nomedobanco);

      if (isset($_GET['opcao'])) {
        if ($_GET['opcao'] == 'excluir') {
          $codpessoa = $_GET['codpessoa'];
          $sql = "delete from pessoas where codpessoa = $codpessoa";
          mysqli_query($bancodedados, $sql);
        }
        if ($_GET['opcao'] == 'alterar') {
          $codpessoa = $_GET['codpessoa'];
          $sql = "select * from pessoas where codpessoa = $codpessoa";
          $pessoa = mysqli_query($bancodedados, $sql);
          $pessoa = mysqli_fetch_array($pessoa);
        }
      }
      ?>

      <form action="index.php" method="POST">
        <label for="nome">Nome: </label>
        <input class="form-control" type="text" id="nome" name="nome"
          value="<?php if (isset($pessoa))
            echo $pessoa['nome']; ?>"><br>
        <label for="telefone">telefone: </label>
        <input class="form-control campomenor" type="phone" id="telefone" name="telefone"
          value="<?php if (isset($pessoa))
            echo $pessoa['telefone']; ?>"><br>
        <label for="email">E-mail: </label>
        <input class="form-control" type="email" id="email" name="email"
          value="<?php if (isset($pessoa))
            echo $pessoa['email']; ?>"><br>
        <input type="submit" value="Inserir">
      </form>

      <?php

      if (isset($_POST['nome'])) {
        $nome = $_POST['nome'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];


        $sql = "insert into pessoas (nome,telefone,email) values('$nome','$telefone','$email')";

        if (mysqli_query($bancodedados, $sql))
          echo "Dados inseridos com sucesso!";
        else {
          echo "Erro ao inserir dados.";
        }

      }


      echo "<h1>Pessoas cadastradas</h1>";
      echo "<table class='table'><tr><th>Nome</th><th>Telefone</th><th>E-mail</th><th>Alterar</th><th>Excluir</th></tr>";
      $sql = "select * from pessoas";
      $registros = mysqli_query($bancodedados, $sql);
      while ($linha = mysqli_fetch_array($registros)) {
        echo "<tr><td>" . $linha['nome'] . "</td>";
        echo "<td>" . $linha['telefone'] . "</td>";
        echo "<td>" . $linha['email'] . "</td>";
        echo "<td><a href='index.php?opcao=alterar&codpessoa=" . $linha['codpessoa'] . "'>
                  <img src='imagens/iconeeditar.png' width='40px'>
              </a></td>";
        echo "<td><a href='index.php?opcao=excluir&codpessoa=" . $linha['codpessoa'] . "'>
                <img src='imagens/delete.png' width='50px'>
              </td>
              </tr>";
      }
      echo "</table>";
      ?>
    </div>

  </main>
</body>

</html>