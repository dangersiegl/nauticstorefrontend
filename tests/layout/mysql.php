<?php
$dsn = 'mysql:host=mysqlsvr80.world4you.com;dbname=2205303db10;charset=utf8';
$username = 'sql6483699';
$password = 'u@3gy668';

try {
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die('Datenbankverbindung fehlgeschlagen: ' . $e->getMessage());
}
?>