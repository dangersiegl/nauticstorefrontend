<?php
// de/faq.php

// CSS for this page
$pageCss = 'terms.css';
$pageTitle       = 'FAQ - Häufig gestellte Fragen';            // e.g. “Kontakt”
$pageDescription = 'Antworten auf häufige Fragen zu Ersatzteilen, Lieferungen und Retouren bei Nauticstore24.';  // optional

// Load header (provides $lang, $baseUrl, $t etc.)
require __DIR__ . '/../inc/header.php';
?>

<main class="terms-page container">
  <h1 class="page-title"><?= htmlspecialchars($t['faq'] ?? 'FAQ') ?></h1>

  <section class="terms-content">
    <h2>Ich benötige Ersatzteile oder Zubehör-Teile, die ich nicht in Ihrem Shop finde. Kann ich diese auch über Sie beziehen?</h2>
    <p>
      Gerne sind wir dazu bereit, Artikel, die aktuell noch nicht in unserem Shop zu finden sind,
      für Sie anzulegen, damit Sie diese bestellen können, sofern wir diese über unsere Lieferanten
      beziehen können. Senden Sie uns dafür einfach eine Anfrage über unser <a href="kontakt">Kontaktformular</a>.
    </p>
  </section>

  <section class="terms-content">
    <h2>Ich habe ein Paket bekommen, aber es waren nicht alle bestellten Artikel darin. Wo ist der Rest?</h2>
    <p>
      Da manche Artikel direkt von unseren Lieferanten versendet werden, kann es vorkommen, dass
      Bestellungen in mehrere Pakete aufgeteilt werden. Ein Teil der Bestellung kann daher früher
      ankommen und der Rest erst 1–2 Werktage später.
    </p>
  </section>

  <section class="terms-content">
    <h2>Wo finde ich den Retourenschein, wenn ich etwas zurückschicken möchte?</h2>
    <p>
      Den Retourenschein können Sie <a href="<?= htmlspecialchars($baseUrl . '/assets/docs/RETOURENSCHEIN.pdf') ?>"
      class="btn-inline" download>hier herunterladen</a>.<br>
      Bitte senden Sie die Retoure an die auf dem Retourenschein angegebene Adresse zurück!
    </p>
  </section>
</main>

<?php
require __DIR__ . '/../inc/footer.php';
?>
