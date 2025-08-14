<?php
// en/faq.php

// CSS for this page
$pageCss = 'faq.css';
$pageTitle       = 'FAQ - Frequently asked questions';            // e.g. “Kontakt”
$pageDescription = 'Answers to frequently asked questions about spare parts, deliveries and returns at Nauticstore24.';  // optional

// Load header (provides $lang, $baseUrl, $t etc.)
require __DIR__ . '/../inc/header.php';
?>

<main class="faq-page container">
  <h1 class="page-title"><?= htmlspecialchars($t['faq'] ?? 'FAQ') ?></h1>

  <section class="faq-content">
    <h2>I need spare parts or accessories that I can’t find in your shop. Can I still order them from you?</h2>
    <p>
      We are happy to add items that are not yet available in our shop so you can order them,
      provided we can source them through our suppliers. Please send us a request via our
      <a href="<?= htmlspecialchars(url('contact')) ?>">contact form</a>.
    </p>
  </section>

  <section class="faq-content">
    <h2>I received a package, but not all ordered items were inside. Where is the rest?</h2>
    <p>
      Some items are shipped directly from our suppliers, so orders may be split into multiple
      packages. Part of your order may arrive earlier, and the remainder 1–2 business days later.
    </p>
  </section>

  <section class="faq-content">
    <h2>Where can I find the return form if I want to send something back?</h2>
    <p>
      You can download the return form <a
        href="<?= htmlspecialchars($baseUrl . '/assets/docs/RETURNS-NOTE.pdf') ?>"
        class="btn-inline" download>here</a>.<br>
      Please send your return to the address indicated on the form.
    </p>
  </section>
</main>

<?php
require __DIR__ . '/../inc/footer.php';
?>
