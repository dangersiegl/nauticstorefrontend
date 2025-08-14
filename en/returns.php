<?php
// en/returns.php

// CSS for this page
$pageCss = 'terms.css';
$pageTitle       = 'Returns & Revocation';            // e.g. “Kontakt”
$pageDescription = 'Information on returning items, your right of withdrawal and the procedure at Nauticstore24.';  // optional

// Load header (provides $lang, $baseUrl, $t etc.)
require __DIR__ . '/../inc/header.php';
?>

<main class="terms-page container">
  <h1 class="page-title">Returns</h1>

  <section class="terms-content">
    <h2>How to Return an Item</h2>
    <p>If you need to return an item, please follow these steps:</p>
    <ol>
      <li>Download the return form <a href="<?= htmlspecialchars($baseUrl . '/assets/docs/RETURNS-NOTE.pdf') ?>" class="btn-inline" download>here</a>.</li>
      <li>Fill out the form with your order details and reason for return.</li>
    </ol>
  </section>

  <section class="terms-content">
    <h2>Return Address</h2>
    <p>Please send the completed return form along with the item to the following address:</p>
    <address>
      NAUTICSTORE24<br>
      Thomas Dall<br>
      Unterhart 3<br>
      4113 St. Martin<br>
      Austria
    </address>
  </section>

  <section class="terms-content">
    <h2>Withdrawal Right</h2>
    <p>
      You may withdraw from this contract within 14 days without giving reasons in text form
      (e-mail to <a href="mailto:shop@nauticstore24.at">shop@nauticstore24.at</a>) or by returning the goods.
      You can download the withdrawal form <a href="<?= htmlspecialchars($baseUrl . '/assets/docs/RETURNS-NOTE.pdf') ?>" class="btn-inline" download>here</a>.
      The withdrawal period begins upon receipt of this notice and the goods. Timely dispatch of the
      withdrawal or goods is sufficient to meet the deadline.
    </p>
  </section>

  <section class="terms-content">
    <h2>Consequences of Withdrawal</h2>
    <p>
      We will refund all payments, including standard shipping costs, within 14 days of withdrawal.
      You bear return shipping costs. Diminution in value due to handling beyond what is necessary
      to examine the goods is your responsibility.
    </p>
  </section>

  <section class="terms-content">
    <h2>Exclusion of Withdrawal</h2>
    <p>
      The right of withdrawal does not apply to custom-made or personalized goods, or unsealed
      audio, video, or software products.
    </p>
  </section>

  <section class="section-return-form">
    <h2>Return Form</h2>
    <a href="<?= htmlspecialchars($baseUrl . '/assets/docs/RETURNS-NOTE.pdf') ?>" class="btn-download" download>
      Download Return Form
    </a>
  </section>
</main>

<?php
require __DIR__ . '/../inc/footer.php';
?>
