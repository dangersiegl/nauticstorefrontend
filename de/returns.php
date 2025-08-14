<?php
// de/returns.php

// CSS für diese Seite
$pageCss = 'terms.css';
$pageTitle       = 'Retouren & Widerruf';            // e.g. “Kontakt”
$pageDescription = 'Informationen zur Rücksendung von Artikeln, Ihrem Widerrufsrecht und dem Ablauf bei Nauticstore24.';  // optional

// Header lädt bereits $lang, $baseUrl und $t (Übersetzungen)
require __DIR__ . '/../inc/header.php';
?>

<main class="terms-page container">
  <h1 class="page-title">Retouren</h1>

  <section class="terms-content">
    <h2>Wie Sie einen Artikel zurücksenden</h2>
    <p>Wenn Sie einen Artikel zurücksenden möchten, gehen Sie bitte wie folgt vor:</p>
    <ol>
      <li>Laden Sie den Rücksendeschein <a href="<?= htmlspecialchars($baseUrl . '/assets/docs/RETOURENSCHEIN.pdf') ?>" class="btn-inline" download>hier herunter</a>.</li>
      <li>Füllen Sie das Formular mit Ihren Bestelldaten und dem Rücksendegrund aus.</li>
    </ol>
  </section>

  <section class="terms-content">
    <h2>Rücksendeadresse</h2>
    <p>Bitte senden Sie den ausgefüllten Rücksendeschein zusammen mit dem Artikel an folgende Adresse:</p>
    <address>
      NAUTICSTORE24<br>
      Thomas Dall<br>
      Unterhart 3<br>
      4113 St. Martin<br>
      Österreich
    </address>
  </section>

  <section class="terms-content">
    <h2>Widerrufsrecht</h2>
    <p>
      Sie können binnen 14 Tagen ohne Angabe von Gründen in Textform (E-Mail an
      <a href="mailto:shop@nauticstore24.at">shop@nauticstore24.at</a>) oder durch Rücksendung der Ware
      von diesem Vertrag zurücktreten. Das Widerrufsformular können Sie <a href="<?= htmlspecialchars($baseUrl . '/assets/docs/RETOURENSCHEIN.pdf') ?>" class="btn-inline" download>hier herunterladen</a>.
      Die Widerrufsfrist beginnt mit dem Erhalt dieser Belehrung und der Ware. Zur Fristwahrung genügt die rechtzeitige Absendung des Widerrufs oder der Ware.
    </p>
  </section>

  <section class="terms-content">
    <h2>Folgen des Widerrufs</h2>
    <p>
      Wir erstatten alle Zahlungen, einschließlich der Standard-Versandkosten, innerhalb von 14 Tagen nach dem Widerruf.
      Die Kosten der Rücksendung trägt der Kunde. Eine Wertminderung der Ware durch Prüfung, die über das zur
      Prüfung der Beschaffenheit, Eigenschaften und Funktionsweise erforderliche Maß hinausgeht, geht zu Lasten des Kunden.
    </p>
  </section>

  <section class="terms-content">
    <h2>Ausschluss des Widerrufsrechts</h2>
    <p>
      Das Widerrufsrecht besteht nicht bei kundenspezifisch angefertigten oder personalisierten Waren
      sowie bei entsiegelten Audio-, Video- oder Softwareprodukten.
    </p>
  </section>

  <section class="section-return-form">
    <h2>Rücksendeformular</h2>
    <a href="<?= htmlspecialchars($baseUrl . '/assets/docs/RETOURENSCHEIN.pdf') ?>" class="btn-download" download>
      Rücksendeschein herunterladen
    </a>
  </section>
</main>

<?php
require __DIR__ . '/../inc/footer.php';
?>
