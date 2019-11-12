<?php
require_once '../library/database.php';

$dbConnection = getDbConnection();
$command = $dbConnection->prepare('SELECT * FROM plataformas');
$command->execute();
$plataformas = $command->fetchAll(\PDO::FETCH_ASSOC);
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Plataformas</title>
    </head>
    <body>
        <?php include('../includes/template_header.php') ?>
        <h1>Plataformas</h1>
        <a href="/plataformas/insert.php">Nova Plataforma</a>
        <table>
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>&nbsp;</th>
            <tr>
            <?php foreach($plataformas as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= $p['nome'] ?></td>
                <td>
                    <a href="/plataformas/update.php?id=<?= $p['id'] ?>">Editar</a>
                    <a href="/plataformas/delete.php?id=<?= $p['id'] ?>">Remover</a>
                </td>
            </tr>
            <?php endforeach ?>
        </table>
        <?php include('../includes/template_footer.php') ?>
    </body>
</html>