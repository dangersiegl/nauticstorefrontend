<?php
// views/account/confirm-email.php
$pageCss   = 'account.css';
$pageTitle = $status==='success'
  ? ($lang==='en' ? 'Email Confirmed' : 'E-Mail bestätigt')
  : ($lang==='en' ? 'Confirmation Error'  : 'Bestätigung fehlgeschlagen');
require __DIR__ . '/../../inc/header.php';
?>
<main class="container" style="padding:2rem 1rem; max-width:600px; margin:auto;">
  <div class="alert <?= $status==='success' ? 'alert-success':'alert-error' ?>">
    <?= htmlspecialchars($message) ?>
  </div>
  <p style="text-align:center; margin-top:1.5rem;">
    <a href="<?= $targetUrl ?>" class="btn-primary">
      <?= $status==='success'
          ? ($lang==='en' ? 'Continue' : 'Weiter')
          : ($lang==='en' ? 'Back to Login' : 'Zurück zum Login') ?>
    </a>
  </p>
</main>
<?php require __DIR__ . '/../../inc/footer.php'; ?>
