<?php
// en/about.php

// CSS for this page
$pageCss = 'terms.css';
$pageTitle       = 'About Us';
$pageDescription = 'Find out more about our experience, our partnerships and why Nauticstore24 is the first port of call for boat accessories.';

// Header loads $lang, $baseUrl, $t (translations)
require __DIR__ . '/../inc/header.php';
?>

<main class="terms-page container">
  <h1 class="page-title"><?= htmlspecialchars($t['about_us'] ?? 'About Us') ?></h1>

  <section class="terms-content">
    <p>
      As an official partner of many internationally renowned manufacturers, we have created an online platform where you can cover all your boating needs.
    </p>

    <p>
      As experienced marine technicians who also enjoy boating in our private time, we present products that we have personally tested and/or installed.
    </p>

    <p>
      Our extensive supply network goes far beyond the scope of a typical shop. Feel free to contact us via our contact form, by phone, WhatsApp, or email to request a non-binding quote. We’ll also tailor a service package to your engine and current operating hours—drawing on our decades of experience to determine exactly what’s needed.
    </p>
  </section>

  <section class="terms-content partners">
    <h2>Yachtservice Dall</h2>
    <p>For more information and services, please visit Yachtservice Dall’s website:</p>
    <a href="https://yachtservice-dall.at/home" target="_blank" class="partner-link">
      <img src="<?= htmlspecialchars($baseUrl . '/assets/img/partners/yachtservice-dall001.jpg') ?>"
           alt="Yachtservice Dall" class="partner-img">
      <img src="<?= htmlspecialchars($baseUrl . '/assets/img/partners/yachtservice-dall002.jpg') ?>"
           alt="Yachtservice Dall Workshop & Service" class="partner-img">
    </a><br>
    <a href="https://yachtservice-dall.at/home" target="_blank" class="btn-download">Visit Yachtservice Dall Website</a>
  </section>
</main>

<?php
require __DIR__ . '/../inc/footer.php';
?>
