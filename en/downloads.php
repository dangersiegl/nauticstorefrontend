<?php
// en/downloads.php

// CSS for this page
$pageCss = 'terms.css';
$pageTitle       = 'Downloads / Spare parts catalogs';            // e.g. “Kontakt”
$pageDescription = 'Online spare parts catalogs of leading brands such as Mercury Marine, Volvo Penta, allpa, Allroundmarin, ePropulsion and many more. - download them directly or request them in the store.';  // optional

// Load header (provides $lang, $baseUrl, $t etc.)
require __DIR__ . '/../inc/header.php';
?>

<main class="terms-page container">
  <h1 class="page-title">Downloads / Spare Parts Catalogs</h1>

  <section class="terms-content">
    <h2>Spare Parts</h2>
    <p>
      Here you can find online spare parts catalogs for various brands. Find the spare parts 
      you need for your engine.
    </p>
    <ul>
      <li>
        <a href="https://public-mercurymarine.sysonline.com/Default.aspx?sysname=NorthAmerica&company=Guest&NA_KEY=NA_KEY_VALUE&langIF=eng&langDB=eng"
           target="_blank" class="btn-inline">
          Mercury Marine Parts Catalog
        </a>
      </li>
      <li>
        <a href="https://www.volvopenta.com/shop/0"
           target="_blank" class="btn-inline">
          Volvo Penta Parts Catalog
        </a>
      </li>
    </ul>
    <p>
      If you cannot find the parts in our webshop because they have not yet been added, 
      please send us a request. We will be happy to order these parts for you, provided they 
      are available:
    </p>
    <ul>
      <li>
        <a href="<?= url('contact'); ?>">   
          Contact Form
        </a>
      </li>
      <li>Phone: <a href="tel:+436643831509">+43 664 3831509</a></li>
      <li>WhatsApp: <a href="https://wa.me/436643831509" target="_blank">+43 664 3831509</a></li>
      <li>Email: <a href="mailto:shop@nauticstore24.at">shop@nauticstore24.at</a></li>
    </ul>
  </section>

  <section class="terms-content">
    <h2>Additional Catalogs</h2>
    <p>These are the catalogs from our suppliers:</p>
    <ul>
      <li>
        <a href="https://www.allpa.de/files/allpa-de-2024lr.pdf"
           target="_blank" class="btn-inline" download>
          Allpa Spare Parts Catalog (PDF)
        </a>
      </li>
      <li>
        <a href="https://www.allroundmarin.at/pub/media/flipping_book/KatalogA-2022-2023/index.html"
           target="_blank" class="btn-inline">
          Allroundmarin Catalog A
        </a>
      </li>
      <li>
        <a href="https://www.allroundmarin.at/pub/media/flipping_book/KatalogF_2021/index.html"
           target="_blank" class="btn-inline">
          Allroundmarin Catalog F
        </a>
      </li>
      <li>
        <a href="https://www.allroundmarin.at/pub/media/flipping_book/ePropulsion-2024/index.html"
           target="_blank" class="btn-inline">
          ePropulsion Catalog
        </a>
      </li>
      <li>
        <a href="https://issuu.com/ascherl/docs/web_ascherl_katalog_2023b?fr=sMWJmYzU3NzA1NjU"
           target="_blank" class="btn-inline">
          Ascherl Catalog
        </a>
      </li>
      <li>
        <a href="https://www.garmin.com/de-DE/marine/brochures/"
           target="_blank" class="btn-inline">
          Garmin Marine Brochures
        </a>
      </li>
      <li>
        <a href="https://www.lindemann-kg.de/de/produkte"
           target="_blank" class="btn-inline">
          Lindemann Product Overview
        </a>
      </li>
      <li>
        <a href="https://marine.suzuki.de/service-kauf/kataloge-preise"
           target="_blank" class="btn-inline">
          Suzuki Marine Catalog & Prices
        </a>
      </li>
    </ul>
    <p>
      If you require something not listed in our online shop, we will be happy to fulfill your wishes:
    </p>
    <ul>
      <li>
        <a href="<?= url('contact'); ?>">
          Contact Form
        </a>
      </li>
      <li>Phone: <a href="tel:+436643831509">+43 664 3831509</a></li>
      <li>WhatsApp: <a href="https://wa.me/436643831509" target="_blank">+43 664 3831509</a></li>
      <li>Email: <a href="mailto:shop@nauticstore24.at">shop@nauticstore24.at</a></li>
    </ul>
  </section>

  <section class="section-return-form">
    <h2>Return Form</h2>
    <a href="<?= htmlspecialchars($baseUrl . '/assets/docs/RETOURENSCHEIN.pdf') ?>"
       class="btn-download" download>Download Return Form</a>
  </section>
</main>

<?php
require __DIR__ . '/../inc/footer.php';
?>
