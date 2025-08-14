<?php
// en/terms.php

// CSS for this page
$pageCss = 'terms.css';
$pageTitle       = 'GTC';            // e.g. “Kontakt”
$pageDescription = 'Here you will find the General Terms and Conditions (GTC) of Nauticstore24: Scope of application, conclusion of contract, withdrawal, shipping, returns and more.';  // optional

// Load header (provides $lang, $baseUrl, $t etc.)
require __DIR__ . '/../inc/header.php';
?>

<main class="terms-page container">
  <h1 class="page-title">Terms & Conditions (T&amp;C)</h1>
  <a href="<?= htmlspecialchars($baseUrl . '/assets/docs/AGB_2024-01-22.pdf') ?>"
     class="btn-download" download>Download T&amp;C (2024-01-22 DE)</a>

  <section class="terms-content">
    <h2>1. Scope</h2>
    <p>These Terms &amp; Conditions apply to all legal relationships between NAUTICSTORE24 and the purchaser
    in the version valid at the time of the order. Deviating terms of the purchaser are not recognized
    unless NAUTICSTORE24 has expressly agreed to them in writing.</p>

    <h2>2. Contracting Party &amp; Customer Service</h2>
    <p>The purchase contract is concluded with Thomas Dall (hereinafter “NAUTICSTORE24”). Further
    information can be found in our imprint. For questions, complaints or claims please contact our
    customer service Mon–Fri 8:00 AM–2:00 PM at <a href="tel:+43723238888">+43 7232 38888</a>.</p>

    <h2>3. Conclusion of Contract &amp; Withdrawal</h2>
    <p>By listing products on NAUTICSTORE24 we make a binding offer to conclude a contract. The contract
    is concluded when you click the order button and thus accept the offer for the goods in your cart.
    You will immediately receive an order confirmation by e-mail. In case of typographical, printing or
    calculation errors on our website, NAUTICSTORE24 reserves the right to withdraw from the contract.
    All offers are valid while supplies last. If our supplier fails to deliver, we may withdraw from the
    contract and will promptly refund any purchase price paid.</p>

    <h2>4. Payment</h2>
    <p>We accept the following payment methods:</p>
    <ul>
      <li><strong>Advance Payment (Bank Transfer)</strong><br>
          Our bank details will be provided in the order confirmation; goods ship after receipt of payment.</li>
      <li><strong>Credit Card</strong><br>
          Your card will be charged upon order completion.</li>
      <li><strong>PayPal</strong><br>
          Payment via PayPal – your account is charged immediately.</li>
      <li><strong>Instant Bank Transfer (Sofortüberweisung)</strong><br>
          You are redirected to your online banking to confirm the transfer via PIN/TAN.</li>
      <li><strong>Cash on Collection</strong><br>
          Pay in cash at one of our locations.</li>
    </ul>

    <h2>5. Shipping &amp; Costs</h2>
    <p>We ship free of charge to Austria and Germany for orders over €170. For orders under €170, shipping
    costs are €7.10 to Austria and €9.10 to Germany. Other shipping rates are available
    <a href="shipping" target="_blank">here</a>.</p>
    <p>Some items may ship in multiple packages from external warehouses, which may extend delivery times.</p>

    <h2>6. Delivery</h2>
    <p>Unless agreed otherwise, delivery is made from stock to the address specified by the purchaser.
    Risk passes to the purchaser when the package is handed over by the carrier.</p>

    <h2>7. Default</h2>
    <p>If the purchaser defaults on payment, NAUTICSTORE24 may charge interest at 4 % above the Austrian
    National Bank base rate p.a. Higher damages may be claimed if proven. Payments are due no later
    than 7 days after invoice.</p>

    <h2>8. Retention of Title</h2>
    <p>Ownership of the goods remains with NAUTICSTORE24 until full payment of all claims.</p>

    <h2>9. Set-off &amp; Retention</h2>
    <p>You may only set off undisputed or legally established counterclaims. Rights of retention exist
    only for counterclaims from the same contract.</p>

    <h2>10. Defects Liability &amp; Limitation of Liability</h2>
    <p>If a defect attributable to NAUTICSTORE24 occurs, we may choose to remedy the defect or deliver
    a replacement. If this fails, you may withdraw or demand a price reduction. Further claims, especially
    for lost profit, are excluded.</p>

    <h2>11. Transport Damage</h2>
    <p>Please report visible transport damage immediately to the carrier and inform us without delay.</p>

    <h2>12. Right of Withdrawal</h2>
    <h3>Withdrawal Right</h3>
    <p>You may withdraw from this contract within 14 days without giving reasons in text form (e-mail to
    <a href="mailto:shop@nauticstore24.at">shop@nauticstore24.at</a>) or by returning the goods. You can
    download the withdrawal form
    <a href="<?= htmlspecialchars($baseUrl . '/assets/docs/RETURNS-NOTE.pdf') ?>"
       class="btn-inline" download>here</a>. The withdrawal period begins upon receipt of this notice
    and the goods. Timely dispatch of the withdrawal or goods is sufficient to meet the deadline.</p>

    <h3>Consequences of Withdrawal</h3>
    <p>We will refund all payments, including standard shipping costs, within 14 days of withdrawal. You bear
    return shipping costs. Diminution in value due to handling beyond what is necessary to examine the
    goods is your responsibility.</p>

    <h3>Exclusion of Withdrawal</h3>
    <p>The right of withdrawal does not apply to custom-made or personalized goods, or unsealed audio/video/
    software products.</p>

    <h2>13. Applicable Law &amp; Jurisdiction</h2>
    <p>Austrian law applies. Exclusive place of jurisdiction is Rohrbach, Upper Austria.</p>

    <h2>14. Storage of Contract Text</h2>
    <p>We store the contract text and will email you order data and these T&amp;C. Past orders are viewable
    in the customer login.</p>

    <h2>15. Contract Language</h2>
    <p>The language available for contract formation is German.</p>

    <h2>16. Dispute Resolution</h2>
    <p>The European Commission provides a platform for online dispute resolution at
    <a href="https://ec.europa.eu/consumers/odr/" target="_blank">https://ec.europa.eu/consumers/odr/</a>.</p>
  </section>
</main>

<?php
require __DIR__ . '/../inc/footer.php';
?>
