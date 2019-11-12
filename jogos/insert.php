<?php
require_once '../library/database.php';
require_once '../library/files.php';

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $genero = $_POST['genero'];
    $plataformas = [];
    foreach($_POST as $variable => $value) {
        if(substr($variable, 0, 11) == 'plataforma-') {
            $plataformas[] = $value;
        }
    }

    if($titulo != '' && $genero != '') {
        $dbConnection = getDbConnection();
        $file = fileUpload('images', 'imagem');
        $command = $dbConnection->prepare('INSERT INTO jogos(titulo, generos_id, imagem) VALUES (:titulo, :genero, :imagem)');
        $command->execute([':titulo' => $titulo, ':genero' => $genero, ':imagem' => $file]);
        $jogo_id = $dbConnection->lastInsertId();
        foreach($plataformas as $p) {
            $dbConnection = getDbConnection();
            $command = $dbConnection->prepare('INSERT INTO plataformas_executam_jogos(jogos_id, plataformas_id) VALUES (:jogo, :plataforma)');
            $command->execute([':jogo' => $jogo_id, ':plataforma' => $p]);    
        }
        header('Location:/jogos/list.php');
        exit();
    }
} else {
    $dbConnection = getDbConnection();
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
        <form action="/jogos/insert.php" method="post" enctype="multipart/form-data">
            <label for="nome">Título</label>
            <input type="text" name="titulo" />
            <label for="genero">Gênero</label>
            <select name="genero">
            <?php foreach($generos as $g): ?>
                <option value="<?= $g['id'] ?>"><?= $g['nome'] ?></option>
            <?php endforeach ?>
            </select>
            <label for="plataformas">Plataforma(s)</label>
            <?php foreach($plataformas as $p): ?>
                <input type="checkbox" name="plataforma-<?= $p['id'] ?>" value="<?= $p['id'] ?>" id="<?= $p['id'] ?>" /><?= $p['nome'] ?>
            <?php endforeach ?>
            <label for="imagem">Imagem</label>
            <input type="file" name="imagem" id="fileToUpload">
            <button type="submit">Salvar</button>
        </form>
    </body>
</html>