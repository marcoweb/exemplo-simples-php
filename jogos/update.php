<?php
require_once '../library/database.php';
require_once '../library/files.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $genero = $_POST['genero'];
    $plat_after = [];
    foreach($_POST as $variable => $value) {
        if(substr($variable, 0, 11) == 'plataforma-') {
            $plat_after[] = $value;
        }
    }

    if($titulo != '' && $genero != '') {
        $dbConnection = getDbConnection();
        $command = $dbConnection->prepare('UPDATE jogos SET titulo = :titulo, generos_id = :genero WHERE id = :id');
        $command->execute([':titulo' => $titulo, ':genero' => $genero, ':id' => $id]);
        if($_FILES['imagem']['name'] != ''){
            $file = fileUpload('images', 'imagem');
            $command = $dbConnection->prepare('UPDATE jogos SET imagem = :imagem WHERE id = :id');
            $command->execute([':imagem' => $file, ':id' => $id]);
        }
        $command = $dbConnection->prepare(
            'SELECT plataformas_id FROM plataformas_executam_jogos as pej WHERE pej.jogos_id = :id');
        $command->execute(['id' => $id]);
        $plat_before = [];
        while($p = $command->fetch(\PDO::FETCH_ASSOC))
            $plat_before[] = $p['plataformas_id'];
        foreach($plat_before as $p) {
            if(!in_array($p, $plat_after)) {
                $command = $dbConnection->prepare('DELETE FROM plataformas_executam_jogos WHERE jogos_id = :jogo AND plataformas_id = :plataforma');
                $command->execute([':jogo' => $id, ':plataforma' => $p]);
            }
        }
        foreach($plat_after as $p) {
            if(!in_array($p, $plat_before)) {
                echo $p;
                $command = $dbConnection->prepare('INSERT INTO plataformas_executam_jogos(plataformas_id, jogos_id) VALUES(:plataforma, :jogo)');
                $command->execute([':jogo' => $id, ':plataforma' => $p]);
            }
        }
        header('Location:/jogos/list.php');
        exit();
    }
} else {
    $id = $_GET['id'];
    $dbConnection = getDbConnection();
    $command = $dbConnection->prepare('SELECT * FROM jogos WHERE id = :id');
    $command->execute([':id' => $id]);
    $jogo = $command->fetch(\PDO::FETCH_ASSOC);
    $command = $dbConnection->prepare(
        'SELECT plataformas_id FROM plataformas_executam_jogos as pej WHERE pej.jogos_id = :id');
    $command->execute(['id' => $jogo['id']]);
    $jogo['plataformas'] = [];
    while($p = $command->fetch(\PDO::FETCH_ASSOC))
        $jogo['plataformas'][] = $p['plataformas_id'];

    $command = $dbConnection->prepare('SELECT * FROM generos');
    $command->execute();
    $generos = $command->fetchAll(\PDO::FETCH_ASSOC);
    $command = $dbConnection->prepare('SELECT * FROM plataformas');
    $command->execute();
    $plataformas = $command->fetchAll(\PDO::FETCH_ASSOC);
}
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Novo Jogo</title>
    </head>
    <body>
        <h1>Novo Jogo</h1>
        <form action="/jogos/update.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $jogo['id'] ?>"
            <label for="nome">Título</label>
            <input type="text" name="titulo" value="<?= $jogo['titulo'] ?>" />
            <label for="genero">Gênero</label>
            <select name="genero">
            <?php foreach($generos as $g): ?>
                <option <?= ($g['id'] == $jogo['generos_id']) ? 'selected' : '' ?> value="<?= $g['id'] ?>"><?= $g['nome'] ?></option>
            <?php endforeach ?>
            </select>
            <label for="plataformas">Plataforma(s)</label>
            <?php foreach($plataformas as $p): ?>
                <input type="checkbox" name="plataforma-<?= $p['id'] ?>" value="<?= $p['id'] ?>" id="<?= $p['id'] ?>" <?= in_array($p['id'], $jogo['plataformas']) ? 'checked' : '' ?> /><?= $p['nome'] ?>
            <?php endforeach ?>
            <label for="imagem">Imagem</label>
            <input type="file" name="imagem" id="fileToUpload">
            <button type="submit">Salvar</button>
        </form>
    </body>
</html>