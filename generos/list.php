<?php
require_once '../library/database.php';

$dbConnection = getDbConnection();
$command = $dbConnection->prepare('SELECT * FROM generos');
$command->execute();
$generos = $command->fetchAll(\PDO::FETCH_ASSOC);
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Gêneros</title>
    </head>
    <body>
        <?php include('../includes/template_header.php') ?>
        <h1>Gêneros</h1>
        <a href="/generos/insert.php">Novo Gênero</a>
        <table>
            <tr>
                <th>Id</th>
                <th>Nome</th>
                <th>&nbsp;</th>
            <tr>
            <?php foreach($generos as $g): ?>
            <tr>
                <td><?= $g['id'] ?></td>
                <td><?= $g['nome'] ?></td>
                <td>
                    <a href="/generos/update.php?id=<?= $g['id'] ?>">Editar</a>
                    <a href="/generos/delete.php?id=<?= $g['id'] ?>">Remover</a>
                </td>
            </tr>
            <?php endforeach ?>
        </table>
        <?php include('../includes/template_footer.php') ?>
    </body>
</html>