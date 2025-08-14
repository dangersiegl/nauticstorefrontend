<?php
/**
 * config.php
 * Allgemeine Konfigurationen, einschließlich Domain-Sprachzuordnung und Base-URLs.
 */

class Config {
    private static $instance = null;
    public $domainConfigMap;
    public $defaultLanguage;
    public $dbHost;
    public $dbName;
    public $dbUser;
    public $dbPass;

    private function __construct() {
        // Domain-Sprachzuordnung und Base-URLs
        $this->domainConfigMap = [
            // Testumgebung
            'nauticstore24.jackydoo.at'      => [
                'lang' => 'de',
                'base_url' => 'https://nauticstore24.jackydoo.at'
            ],
            'nauticstore24.jackydoo.com'   => [
                'lang' => 'en',
                'base_url' => 'https://nauticstore24.jackydoo.com'
            ],

            // Produktionsumgebung
            'nauticstore24.at'                 => [
                'lang' => 'de',
                'base_url' => 'https://nauticstore24.at'
            ],
            'nauticstore24.com'                => [
                'lang' => 'en',
                'base_url' => 'https://nauticstore24.com'
            ],
            
            // Weitere Domains können hier hinzugefügt werden
            // 'anotherdomain.de' => ['lang' => 'de', 'base_url' => 'https://anotherdomain.de'],
            // 'anotherdomain.com' => ['lang' => 'en', 'base_url' => 'https://anotherdomain.com'],
        ];

        // Standard-Sprache
        $this->defaultLanguage = 'de';

        // Datenbankkonfiguration
        $this->dbHost = 'localhost';
        $this->dbName = 'd042e965';
        $this->dbUser = 'd042e965';
        $this->dbPass = 'hUbLTgbPNe2jURM9bxY9';

        // SMTP-Mail Konfiguration
        $this->smtpHost = 'w01bfc76.kasserver.com'; // z.B. smtp.gmail.com
        $this->smtpUser = 'nauticstore24@jackydoo.at';
        $this->smtpPass = '.U5d9s6f41!';
        $this->smtpPort = 587; // oder 465 bei SMTPS
        $this->smtpSecure = 'tls'; // oder 'ssl' für SMTPS
        $this->smtpFromEmail = 'nauticstore24@jackydoo.at';
        $this->smtpFromName = 'Nauticstore24';
        $this->smtpReplyToEmail = 'nauticstore24@jackydoo.at';
        $this->smtpReplyToName = 'Nauticstore24';
        $this->contactFromEmail = 'nauticstore24@jackydoo.at';
        $this->contactFromName = 'Nauticstore24';

        // Google Analytics ID deutsch/englisch
        $this->gaIdDe   = 'UA-YOUR_DE_ID';
        $this->gaIdEn   = 'UA-YOUR_EN_ID';
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Config();
        }
        return self::$instance;
    }
}
?>