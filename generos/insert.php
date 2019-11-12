<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    if($nome != '') {
        require_once '../library/database.php';
        $dbConnection = getDbConnection();
        $command = $dbConnection->prepare('INSERT INTO generos(nome) VALUES (:nome)');
        $command->execute([':nome' => $nome]);
        header('Location:/generos/list.php');
        exit();
    }
}
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Novo Gênero</title>
    </head>
    <body>
        <h1>Novo Gênero</h1>
        <form action="/generos/insert.php" method="post">
            <label for="nome">Nome</label>
            <input type="text" name="nome" />
            <button type="submit">Salvar</button>
        </form>
    </body>
</html>