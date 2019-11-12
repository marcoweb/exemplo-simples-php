<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    if($nome != '') {
        require_once '../library/database.php';
        $dbConnection = getDbConnection();
        $command = $dbConnection->prepare('INSERT INTO plataformas(nome) VALUES (:nome)');
        $command->execute([':nome' => $nome]);
        header('Location:/plataformas/list.php');
        exit();
    }
}
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Nova Plataforma</title>
    </head>
    <body>
        <h1>Nova Plataforma</h1>
        <form action="/plataformas/insert.php" method="post">
            <label for="nome">Nome</label>
            <input type="text" name="nome" />
            <button type="submit">Salvar</button>
        </form>
    </body>
</html>