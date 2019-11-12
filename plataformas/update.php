<?php
require_once '../library/database.php';
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];
    if($id != '') {
        $dbConnection = getDbConnection();
        $command = $dbConnection->prepare('SELECT * FROM plataformas WHERE id = :id');
        $command->execute([':id' => $id]);
        $plataforma = $command->fetch(\PDO::FETCH_ASSOC);
    }
} else if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    if($id != '' && $nome != '') {
        $dbConnection = getDbConnection();
        $command = $dbConnection->prepare('UPDATE plataformas SET nome = :nome WHERE id = :id');
        $command->execute([':nome' => $nome, ':id' => $id]);
    }
    header('Location:/plataformas/list.php');
    exit();
}
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Editar Plataforma</title>
    </head>
    <body>
        <h1>Editar Plataforma</h1>
        <form action="/plataformas/update.php" method="post">
            <input type="hidden" name="id" value="<?= $plataforma['id'] ?>" />
            <label for="nome">Nome</label>
            <input type="text" name="nome" value="<?= $plataforma['nome'] ?>" />
            <button type="submit">Salvar</button>
        </form>
    </body>
</html>