<?php
// de/imprint.php

// CSS für diese Seite
$pageCss = 'imprint.css';
$pageTitle       = 'Impressum';            // e.g. “Kontakt”
$pageDescription = 'Rechtliche Informationen über Nauticstore24, Inhaber, UID, Gerichtsstand, Kontaktmöglichkeiten und mehr.';  // optional

// Header lädt bereits $lang, $baseUrl und $t (Übersetzungen)
require __DIR__ . '/../inc/header.php';
?>

<main class="imprint-page container">
  <h1 class="page-title">Impressum</h1>

  <section class="imprint-content">
    <h2>Nauticstore24</h2>
    <address>
      Thomas Dall<br>
      Unterhart 3<br>
      4113 St. Martin<br>
      Österreich
    </address>

    <dl>
      <dt>Telefon:</dt>
      <dd><a href="tel:+43723238888">+43 7232 38888</a></dd>
      <dt>WhatsApp:</dt>
      <dd><a href="https://wa.me/43723238888" target="_blank">+43 7232 38888</a></dd>
      <dt>E-Mail:</dt>
      <dd><a href="mailto:shop@nauticstore24.at">shop@nauticstore24.at</a></dd>
      <dt>Web:</dt>
      <dd><a href="https://www.nauticstore24.at" target="_blank">www.nauticstore24.at</a></dd>
    </dl>

    <p><strong>Geschäftsinhaber:</strong> Thomas Dall<br>
    <strong>UID:</strong> ATU 651 665 44</p>

    <p><strong>Rechtsform:</strong><br>
    Einzelunternehmen<br>
    Bootbauer &amp; Handel</p>

    <p><strong>Gerichtsstand:</strong> Rohrbach, Oberösterreich<br>
    <strong>Anwendbares Recht:</strong> Österreichisches Recht</p>

    <p>Mitglied der WKO</p>
  </section>
</main>

<?php
require __DIR__ . '/../inc/footer.php';
?>