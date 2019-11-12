<?php
require_once '../library/database.php';
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];
    if($id != '') {
        $dbConnection = getDbConnection();
        $command = $dbConnection->prepare('SELECT * FROM generos WHERE id = :id');
        $command->execute([':id' => $id]);
        $genero = $command->fetch(\PDO::FETCH_ASSOC);
    }
} else if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    if($id != '' && $nome != '') {
        $dbConnection = getDbConnection();
        $command = $dbConnection->prepare('UPDATE generos SET nome = :nome WHERE id = :id');
        $command->execute([':nome' => $nome, ':id' => $id]);
    }
    header('Location:/generos/list.php');
    exit();
}
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Editar Gênero</title>
    </head>
    <body>
        <h1>Editar Gênero</h1>
        <form action="/generos/update.php" method="post">
            <input type="hidden" name="id" value="<?= $genero['id'] ?>" />
            <label for="nome">Nome</label>
            <input type="text" name="nome" value="<?= $genero['nome'] ?>" />
            <button type="submit">Salvar</button>
        </form>
    </body>
</html>