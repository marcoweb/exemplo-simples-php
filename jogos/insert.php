<?php
require_once '../library/database.php';

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
        $command = $dbConnection->prepare('INSERT INTO jogos(titulo, generos_id) VALUES (:titulo, :genero)');
        $command->execute([':titulo' => $titulo, ':genero' => $genero]);
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
        <form action="/jogos/insert.php" method="post">
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
            <button type="submit">Salvar</button>
        </form>
    </body>
</html>