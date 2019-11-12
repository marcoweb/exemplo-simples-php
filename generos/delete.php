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
    if($id != '') {
        $dbConnection = getDbConnection();
        $command = $dbConnection->prepare('DELETE FROM generos WHERE id = :id');
        $command->execute([':id' => $id]);
    }
    header('Location:/generos/list.php');
    exit();
}
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Remover Gênero</title>
    </head>
    <body>
        <h1>Remover Gênero</h1>
        <p>Tem certeza que deseja remover o gênero "<?= $genero['nome'] ?>"?</p>
        <form action="/generos/delete.php" method="post">
            <input type="hidden" name="id" value="<?= $genero['id'] ?>" />
            <button type="submit">Excluir</button>
        </form>
    </body>
</html>