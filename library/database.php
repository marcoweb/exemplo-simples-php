<?php
function getDbConnection() {
    $host       = 'localhost';
    $port       = '3306';
    $dbname     = 'games';
    $user       = 'root';
    $password   = 'MySQL#Root';
    $charset    = 'utf8';

    return new \PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=$charset", $user, $password);
}