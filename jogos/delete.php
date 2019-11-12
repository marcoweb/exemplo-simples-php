<?php
require_once '../library/database.php';
if($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];
    if($id != '') {
        $dbConnection = getDbConnection();
        $command = $dbConnection->prepare('SELECT * FROM jogos WHERE id = :id');
        $command->execute([':id' => $id]);
        $jogo = $command->fetch(\PDO::FETCH_ASSOC);
    }
} else if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    if($id != '') {
        $dbConnection = getDbConnection();
        $command = $dbConnection->prepare('DELETE FROM jogos WHERE id = :id');
        $command->execute([':id' => $id]);
    }
    header('Location:/jogos/list.php');
    exit();
}
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Remover Jogo</title>
    </head>
    <body>
        <h1>Remover Jogo</h1>
        <p>Tem certeza que deseja remover o jogo "<?= $jogo['titulo'] ?>"?</p>
        <form action="/jogos/delete.php" method="post">
            <input type="hidden" name="id" value="<?= $jogo['id'] ?>" />
            <button type="submit">Excluir</button>
        </form>
    </body>
</html>