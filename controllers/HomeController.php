<?php
// controllers/HomeController.php

class HomeController {
    private $lang;
    private $baseUrl;

    public function __construct($lang, $baseUrl) {
        $this->lang = $lang;
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    public function index() {
        // Setze $lang, $baseUrl und $pdo als globale Variablen
        global $lang, $baseUrl, $pdo;
        $lang = $this->lang;
        $baseUrl = $this->baseUrl;

        // Header einbinden
        require_once __DIR__ . '/../inc/header.php';

        // Sprachspezifische Inhalte laden
        $viewFile = ($this->lang === 'en') ? __DIR__ . '/../en/home.php' : __DIR__ . '/../de/home.php';

        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            echo ($this->lang === 'en') ? "Content not found." : "Inhalt nicht gefunden.";
        }

        // Footer einbinden
        require_once __DIR__ . '/../inc/footer.php';
    }
}
