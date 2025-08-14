<?php
// en/terms.php

// CSS for this page
$pageCss = 'terms.css';
$pageTitle       = 'Shipping & delivery';            // e.g. “Kontakt”
$pageDescription = 'Shipping & DeliveryInformation on shipping costs, delivery times, international deliveries and returns at Nauticstore24.';  // optional

// Load header (provides $lang, $baseUrl, $t etc.)
require __DIR__ . '/../inc/header.php';
?>

<main class="terms-page container">
  <h1 class="page-title">Shipping terms</h1>

  <section class="section-shipping">
    <h2>Shipping Policy</h2>
    <p>Free shipping on orders over € 170 to Austria &amp; Germany! Orders placed on Nauticstore24 within Austria and Germany totaling at least € 170 will be delivered free of charge (except for items requiring freight shipping). For orders under € 170, shipping costs are € 7.56 within Austria and € 11.64 within Germany (freight-only items excluded).</p>
    <p>Unless otherwise agreed, delivery is ex-stock to your provided address. Risk passes to the buyer once the carrier hands the parcel to the customer.</p>
  </section>

  <section class="section-international">
    <h2>Shipping Costs Outside Austria &amp; Germany</h2>
    <ul>
      <li>Croatia: € 17.40</li>
      <li>Belgium, Italy, Luxembourg, Netherlands, Slovakia, Slovenia, Czech Republic, Hungary: € 27.10</li>
      <li>Denmark, Finland, France, Poland, Sweden: € 33.84</li>
      <li>Switzerland: € 65.00</li>
      <li>Bulgaria, Estonia, Greece, Ireland, Latvia, Lithuania, Malta, Portugal, Romania, Spain, Cyprus: € 57.84</li>
      <li>Iceland: € 241.20</li>
    </ul>
    <p>Some items may incur extra freight surcharges.</p>
    <p>Please note that certain regions (e.g. islands) have weight limits. Overweight parcels may be redirected to a mainland pick-up point or returned to us.</p>
  </section>

  <section class="section-delivery-time">
    <h2>Delivery Times</h2>
    <p>Our processing times are shown on each product page (subject to supplier stock issues). If you need items urgently, please contact us before ordering to avoid unexpected delays.</p>
    <h3>By Post</h3>
    <p>Parcels within Austria are typically delivered in 1–2 business days; to Germany in 2–3 days; rest of Europe in 3–5 days.</p>
    <p>Occasionally deliveries may take longer, especially for supplier-direct shipments.</p>
  </section>

  <section class="section-issues">
    <h2>Problems with Delivery?</h2>
    <p>If you experience any delivery issues, please contact us at:</p>
    <p>Email: <a href="mailto:shop@nauticstore24.at">shop@nauticstore24.at</a><br>
    Phone: <a href="tel:+436643831509">+43 664 3831509</a></p>
  </section>

  <section class="section-tracking">
    <h2>Track Your Package</h2>
    <p>Use the tracking number we email you to follow your order’s status online at any time.</p>
  </section>

  <section class="section-lost">
    <h2>Missing Package?</h2>
    <p>If your package hasn’t arrived after one week and was not delivered to neighbours, please reach out. We will investigate and, if necessary, file a trace request.</p>
  </section>

  <section class="section-return-form">
    <h2>Return Form</h2>
    <a href="<?= htmlspecialchars($baseUrl . '/assets/docs/RETURNS-NOTE.pdf') ?>"
       class="btn-download" download>Download Return Form</a>
  </section>
</main>

<?php
require __DIR__ . '/../inc/footer.php';
