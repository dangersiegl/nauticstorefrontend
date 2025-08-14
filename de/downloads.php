<?php
// de/downloads.php

// CSS für diese Seite
$pageCss = 'terms.css';
$pageTitle       = 'Downloads / Ersatzteilkataloge';            // e.g. “Kontakt”
$pageDescription = 'Online-Ersatzteilkataloge führender Marken wie Mercury Marine, Volvo Penta, allpa, Allroundmarin, ePropulsion u.v.m. – direkt herunterladen oder im Shop anfragen.';  // optional

// Header lädt bereits $lang, $baseUrl und $t (Übersetzungen)
require __DIR__ . '/../inc/header.php';
?>

<main class="terms-page container">
  <h1 class="page-title">Downloads / Ersatzteilkataloge</h1>

  <section class="terms-content">
    <h2>Ersatzteile</h2>
    <p>Hier finden Sie Online-Ersatzteil-Kataloge einiger Marken. Finden Sie die Ersatzteile, die Sie für Ihren Motor benötigen.</p>
    <ul>
      <li>
        <a href="https://public-mercurymarine.sysonline.com/Default.aspx?sysname=NorthAmerica&company=Guest&NA_KEY=NA_KEY_VALUE&langIF=eng&langDB=eng"
           target="_blank" class="btn-inline">
          Ersatzteilkatalog Mercury Marine
        </a>
      </li>
      <li>
        <a href="https://www.volvopenta.com/shop/0"
           target="_blank" class="btn-inline">
          Ersatzteilkatalog Volvo Penta
        </a>
      </li>
    </ul>
    <p>Wenn Sie die Teile in unserem Webshop nicht finden, weil diese noch nicht angelegt wurden, senden Sie uns bitte eine Anfrage. Wir bestellen diese Teile gerne für Sie, sofern verfügbar:</p>
    <ul>
      <li><a href="kontakt">Online Kontaktformular</a></li>
      <li>Telefon: <a href="tel:+436643831509">+43 664 3831509</a></li>
      <li>WhatsApp: <a href="https://wa.me/436643831509" target="_blank">+43 664 3831509</a></li>
      <li>E-Mail: <a href="mailto:shop@nauticstore24.at">shop@nauticstore24.at</a></li>
    </ul>
  </section>

  <section class="terms-content">
    <h2>Weitere Kataloge</h2>
    <p>Dies sind die Kataloge unserer Lieferanten:</p>
    <ul>
      <li>
        <a href="https://www.allpa.de/files/allpa-de-2024lr.pdf"
           target="_blank" class="btn-inline" download>
          allpa Ersatzteilkatalog (PDF)
        </a>
      </li>
      <li>
        <a href="https://www.allroundmarin.at/pub/media/flipping_book/KatalogA-2022-2023/index.html"
           target="_blank" class="btn-inline">
          Allroundmarin Katalog A
        </a>
      </li>
      <li>
        <a href="https://www.allroundmarin.at/pub/media/flipping_book/KatalogF_2021/index.html"
           target="_blank" class="btn-inline">
          Allroundmarin Katalog F
        </a>
      </li>
      <li>
        <a href="https://www.allroundmarin.at/pub/media/flipping_book/ePropulsion-2024/index.html"
           target="_blank" class="btn-inline">
          ePropulsion Katalog
        </a>
      </li>
      <li>
        <a href="https://issuu.com/ascherl/docs/web_ascherl_katalog_2023b?fr=sMWJmYzU3NzA1NjU"
           target="_blank" class="btn-inline">
          Ascherl Katalog
        </a>
      </li>
      <li>
        <a href="https://www.garmin.com/de-DE/marine/brochures/"
           target="_blank" class="btn-inline">
          Garmin Marine Broschüren
        </a>
      </li>
      <li>
        <a href="https://www.lindemann-kg.de/de/produkte"
           target="_blank" class="btn-inline">
          Lindemann Produktübersicht
        </a>
      </li>
      <li>
        <a href="https://marine.suzuki.de/service-kauf/kataloge-preise"
           target="_blank" class="btn-inline">
          Suzuki Marine Katalog & Preise
        </a>
      </li>
    </ul>
    <p>Sollten Sie etwas benötigen, was nicht in unserem Online-Shop gelistet ist, nehmen wir Ihre Wünsche gerne entgegen:</p>
    <ul>
      <li><a href="kontakt">Online Kontaktformular</a></li>
      <li>Telefon: <a href="tel:+436643831509">+43 664 3831509</a></li>
      <li>WhatsApp: <a href="https://wa.me/436643831509" target="_blank">+43 664 3831509</a></li>
      <li>E-Mail: <a href="mailto:shop@nauticstore24.at">shop@nauticstore24.at</a></li>
    </ul>
  </section>

  <section class="section-return-form">
    <h2>Retour-/Rücksendeschein</h2>
    <a href="<?= htmlspecialchars($baseUrl . '/assets/docs/RETOURENSCHEIN.pdf') ?>"
       class="btn-download" download>Retourenschein herunterladen</a>
  </section>
</main>

<?php
require __DIR__ . '/../inc/footer.php';
?>
