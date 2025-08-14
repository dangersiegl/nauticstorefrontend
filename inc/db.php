<?php
// db.php
require_once __DIR__ . '/config.php';

try {
    $pdo = new PDO(
        'mysql:host=' . Config::getInstance()->dbHost . ';dbname=' . Config::getInstance()->dbName . ';charset=utf8',
        Config::getInstance()->dbUser,
        Config::getInstance()->dbPass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    // Im Live-Betrieb sollte keine detaillierte Fehlermeldung angezeigt werden
    if (Config::getInstance()->defaultLanguage === 'de') {
        die('Verbindungsfehler: Bitte kontaktieren Sie den Administrator.');
    } else {
        die('Connection error: Please contact the administrator.');
    }
}
