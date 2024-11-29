<!doctype html>
<html lang="pt-BR">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Atividade 26/11</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-light">

    <div class="container my-5">
        <h1 class="text-center mb-4">Cadastro de Usuários</h1>
        <form method="POST" class="border p-4 bg-white rounded shadow-sm">
            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Digite seu nome" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Telefone</label>
                <input type="tel" id="phone" name="phone" class="form-control" placeholder="Digite seu telefone" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu email" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Enviar</button>
            <button type="submit" class="btn btn-primary w-100">Excluir</button>
        </form>
    </div>

    <div class="container my-5">
        <h2 class="text-center mb-4">Usuários Cadastrados</h2>
        <?php
        session_start(); //iniciando a sessão

        if (isset($_GET['limpar'])) { //verificando se limpar é passado via get
            session_destroy(); //destruindo a sessão 
            header("Location: index.php");
            exit(); //para de executar
        }

        require("users.php"); //chamada do arquivo users.php

        if (!isset($_SESSION['users'])) { //se não existir, ele cria
            $_SESSION['users'] = [];
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') { //pegando os campos do form
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];

            $_SESSION['users'][] = ['name' => $name, 'phone' => $phone, 'email' => $email]; //inserindo na sessão
        }

        if (!empty($_SESSION['users'])) { //se não está vazio 
            echo '<table class="table table-striped table-bordered">';
            echo '<thead class="table-dark">';
            echo '<tr><th>Nome</th><th>Telefone</th><th>Email</th></tr>';
            echo '</thead><tbody>';

            foreach ($_SESSION['users'] as $user) { //percorrendo a sessão 
                echo '<tr>';
                echo "<td>{$user['name']}</td>";
                echo "<td>{$user['phone']}</td>";
                echo "<td>{$user['email']}</td>";
                echo '</tr>';
            }

            echo '</tbody></table>'; //fim da table
        } else {
            echo '<p class="text-center text-muted">Nenhum usuário cadastrado.</p>'; //caso não tenha nenhum usuário cadastrado 
        }
        ?>
        <div class="text-center mt-4">
            <a href="index.php?limpar=1" class="btn btn-danger">Limpar Todos os Usuários</a> <!-- Limpar os usuários-->
        </div>                                                                               <!-- Passando via GET 
                                                                                             um parametro 'limpar=1 -->     
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>
