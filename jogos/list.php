<?php
require_once '../library/database.php';

$dbConnection = getDbConnection();
$command = $dbConnection->prepare('SELECT * FROM jogos');
$command->execute();
$jogos = $command->fetchAll(\PDO::FETCH_ASSOC);
for($i = 0;$i < count($jogos);$i++) {
    $command = $dbConnection->prepare('SELECT * FROM generos WHERE id = :id');
    $command->execute([':id' => $jogos[$i]['generos_id']]);
    $jogos[$i]['genero'] = $command->fetch(\PDO::FETCH_ASSOC);
    $command = $dbConnection->prepare(
        'SELECT p.id, p.nome FROM plataformas_executam_jogos as pej LEFT JOIN plataformas AS p ON pej.plataformas_id = p.id WHERE pej.jogos_id = :id');
    $command->execute(['id' => $jogos[$i]['id']]);
    $jogos[$i]['plataformas'] = $command->fetchAll(\PDO::FETCH_ASSOC);
}
?>

<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Jogos</title>
    </head>
    <body>
        <?php include('../includes/template_header.php') ?>
        <h1>Jogos</h1>
        <a href="/jogos/insert.php">Novo Jogo</a>
        <table>
            <tr>
                <th>Id</th>
                <th>Título</th>
                <th>Gênero</th>
                <th>Plataformas</th>
                <th></th>
                <th>&nbsp;</th>
            <tr>
            <?php foreach($jogos as $j): ?>
            <tr>
                <td><?= $j['id'] ?></td>
                <td><?= $j['titulo'] ?></td>
                <td><?= $j['genero']['nome'] ?></td>
                <td>
                    <?php for($i = 0;$i < count($j['plataformas']);$i++): if($i > 0) echo ' / ' ?>
                    <?= $j['plataformas'][$i]['nome'] ?>
                    <?php endfor ?>
                </td>
                <th>
                    <img width="100px" src="<?= $j['imagem'] ?>" />
                </th>
                <td>
                    <a href="/jogos/update.php?id=<?= $j['id'] ?>">Editar</a>
                    <a href="/jogos/delete.php?id=<?= $j['id'] ?>">Remover</a>
                </td>
            </tr>
            <?php endforeach ?>
        </table>
        <?php include('../includes/template_footer.php') ?>
    </body>
</html>