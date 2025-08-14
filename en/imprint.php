<?php
// en/imprint.php

// CSS for this page
$pageCss = 'imprint.css';
$pageTitle       = 'Imprint';            // e.g. “Kontakt”
$pageDescription = 'Legal information about Nauticstore24, owner, UID, place of jurisdiction, contact options and more.';  // optional

// Header already provides $lang, $baseUrl and $t (translations)
require __DIR__ . '/../inc/header.php';
?>

<main class="imprint-page container">
  <h1 class="page-title">Imprint</h1>

  <section class="imprint-content">
    <h2>Nauticstore24</h2>
    <address>
      Thomas Dall<br>
      Unterhart 3<br>
      4113 St. Martin<br>
      Austria
    </address>

    <dl>
      <dt>Phone:</dt>
      <dd><a href="tel:+43723238888">+43 7232 38888</a></dd>
      <dt>WhatsApp:</dt>
      <dd><a href="https://wa.me/43723238888" target="_blank">+43 7232 38888</a></dd>
      <dt>Email:</dt>
      <dd><a href="mailto:shop@nauticstore24.at">shop@nauticstore24.at</a></dd>
      <dt>Website:</dt>
      <dd><a href="https://www.nauticstore24.at" target="_blank">www.nauticstore24.at</a></dd>
    </dl>

    <p><strong>Owner:</strong> Thomas Dall<br>
    <strong>VAT ID:</strong> ATU 651 665 44</p>

    <p><strong>Legal Form:</strong><br>
    Sole Proprietorship<br>
    Boat Building & Trade</p>

    <p><strong>Jurisdiction:</strong> Rohrbach, Upper Austria<br>
    <strong>Applicable Law:</strong> Austrian Law</p>

    <p>Member of the Austrian Economic Chamber (WKO)</p>
  </section>
</main>

<?php
require __DIR__ . '/../inc/footer.php';
?>
