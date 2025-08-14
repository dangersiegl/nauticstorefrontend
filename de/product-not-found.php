<?php
// /de/product-not-found.php
require_once __DIR__ . '/../inc/header.php'; // Optional: Gemeinsamer Header

?>
<div class="error-page">
    <h1>404 - Produkt nicht gefunden</h1>
    <p>Das von Ihnen angeforderte Produkt existiert nicht oder wurde entfernt.</p>
    <a href="<?= htmlspecialchars($baseUrl); ?>">Zurück zur Startseite</a>
</div>
<?php
require_once __DIR__ . '/../inc/footer.php'; // Optional: Gemeinsamer Footer
?>
