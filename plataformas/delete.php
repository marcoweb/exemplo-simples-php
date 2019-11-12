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
    if($id != '') {
        $dbConnection = getDbConnection();
        $command = $dbConnection->prepare('DELETE FROM plataformas WHERE id = :id');
        $command->execute([':id' => $id]);
    }
    header('Location:/plataformas/list.php');
    exit();
}
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Remover Plataforma</title>
    </head>
    <body>
        <h1>Remover Plataforma</h1>
        <p>Tem certeza que deseja remover a plataforma "<?= $plataforma['nome'] ?>"?</p>
        <form action="/plataformas/delete.php" method="post">
            <input type="hidden" name="id" value="<?= $plataforma['id'] ?>" />
            <button type="submit">Excluir</button>
        </form>
    </body>
</html>