<?php
// de/about.php

// CSS für diese Seite
$pageCss = 'terms.css';
$pageTitle       = 'Über uns';            // e.g. “Kontakt”
$pageDescription = 'Erfahren Sie mehr über unsere Erfahrung, unsere Partnerschaften und warum Nauticstore24 die erste Adresse für Bootszubehör ist.';  // optional

// Header lädt bereits $lang, $baseUrl und $t (Übersetzungen)
require __DIR__ . '/../inc/header.php';
?>

<main class="terms-page container">
  <h1 class="page-title"><?= htmlspecialchars($t['about_us'] ?? 'Über uns') ?></h1>

  <section class="terms-content">
    <p>
      Als offizieller Vertragspartner vieler international renommierter Hersteller haben wir hier für Sie eine Online-Plattform geschaffen, auf der Sie alle Ihre Wünsche und Bedürfnisse rund ums Bootfahren abdecken können.
    </p>

    <p>
      Als erfahrene Bootstechniker, die auch gerne privat mit dem eigenen Boot am Wasser unterwegs sind, können wir Ihnen viele Produkte präsentieren, die wir persönlich getestet und/oder verbaut haben.
    </p>

    <p>
      Natürlich sprengen unsere umfangreichen Liefermöglichkeiten den Rahmen eines solchen Shops, daher können Sie uns jederzeit über unser Kontaktformular, telefonisch, per WhatsApp oder per E-Mail kontaktieren, um ein unverbindliches Angebot zu bekommen. Gerne stellen wir Ihnen auch ein Servicepaket, abgestimmt auf Ihren Motor und aktuellen Betriebsstunden zusammen, wo wir aufgrund unserer jahrzehntelangen Erfahrung genau bestimmen können, was wirklich benötigt wird.
    </p>
  </section>

  <section class="terms-content partners">
    <h2>Yachtservice Dall</h2>
    <p>Weitere Informationen und Services finden Sie direkt auf der Webseite von Yachtservice Dall:</p>
    <a href="https://yachtservice-dall.at/home" target="_blank" class="partner-link">
      <img src="<?= htmlspecialchars($baseUrl . '/assets/img/partners/yachtservice-dall001.jpg') ?>"
           alt="YachtService Dall" class="partner-img">
      <img src="<?= htmlspecialchars($baseUrl . '/assets/img/partners/yachtservice-dall002.jpg') ?>"
           alt="Werkstatt & Service YachtService Dall" class="partner-img">
    </a><br>
    <a href="https://yachtservice-dall.at/home" target="_blank" class="btn-download" download>Zur Website von Yachtservice Dall</a>
  </section>
</main>

<?php
require __DIR__ . '/../inc/footer.php';
?>
