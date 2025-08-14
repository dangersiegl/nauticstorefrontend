<?php
// /de/category-sub-not-found.php
require_once __DIR__ . '/../inc/header.php'; // Optional: Gemeinsamer Header

?>
<div class="error-page">
    <h1>404 - Subkategorie nicht gefunden</h1>
    <p>Die von Ihnen angeforderte Kategorie existiert nicht oder wurde entfernt.</p>
    <a href="<?= htmlspecialchars($baseUrl); ?>">Zurück zur Startseite</a>
</div>
<?php
require_once __DIR__ . '/../inc/footer.php'; // Optional: Gemeinsamer Footer
?>
