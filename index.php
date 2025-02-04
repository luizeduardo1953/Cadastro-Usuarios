<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <title>Cadastro de Pessoas</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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


      $bancodedados = mysqli_connect($servidor, $usuario, $senha);

      if(!$bancodedados){
        echo "<script>alert('Erro ao conectar com o banco de dados: " . mysqli_connect_error() . "');</script>";
      }

      $nomedobanco = "cadastro";

      mysqli_select_db($bancodedados, $nomedobanco);

      if (isset($_GET['opcao'])) {
        if ($_GET['opcao'] == 'excluir') {
          $codpessoa = $_GET['codpessoa'];
          $sql = "delete from pessoas where codpessoa = $codpessoa";
          mysqli_query($bancodedados, $sql);
          echo "Dados excluidos com sucesso!";
          echo "<script>window.location.href = 'index.php';</script>"; //mudando para a página index.php
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
        <input class="form-control" type="text" id="nome" name="nome" value="<?php if (isset($pessoa))
          echo $pessoa['nome']; ?>"><br>
        <label for="telefone">telefone: </label>
        <input class="form-control campomenor" type="phone" id="telefone" name="telefone" value="<?php if (isset($pessoa))
          echo $pessoa['telefone']; ?>"><br>
        <label for="email">E-mail: </label>
        <input class="form-control" type="email" id="email" name="email" value="<?php if (isset($pessoa))
          echo $pessoa['email']; ?>"><br>
        <?php
        if (isset($pessoa)) {
          echo "<input type='hidden' name='codpessoa' value=". $pessoa['codpessoa']. ">";
        }
        ?>
        <input type="submit" value="Inserir">
      </form>

      <?php

      if (isset($_POST['nome'])) {
        $nome = $_POST['nome'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];

        if (isset($_POST['codpessoa'])) 
        {
          $codpessoa = 'codpessoa';
          $sql = "Update pessoas set nome = '$nome', telefone = '$telefone', email = '$email' where codpessoa = $codpessoa";
          mysqli_query($bancodedados, $sql);
          echo "Dados alterados com sucesso!";

        } else {
          $sql = "insert into pessoas (nome,telefone,email) values('$nome','$telefone','$email')";

          if (mysqli_query($bancodedados, $sql))
            echo "Dados inseridos com sucesso!";
          else {
            echo "Erro ao inserir dados.";
          }
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