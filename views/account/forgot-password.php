<?php
// views/account/forgot-password.php
$pageCss   = 'account.css';
$pageTitle = $this->lang==='en' ? 'Forgot Password' : 'Passwort vergessen';
require __DIR__.'/../../inc/header.php';
?>

<main class="account-page container">
  <section class="account-card login-card">
    <h2><?= $this->lang==='en' ? 'Forgot your password?' : 'Passwort vergessen?' ?></h2>

    <?php if(isset($success) && $success): ?>
      <div class="alert alert-success">
        <?= $this->lang==='en'
            ? 'If that email is registered, you’ll receive a reset link shortly.'
            : 'Sollte diese E-Mail in unserem System existieren, erhalten Sie in Kürze einen Link zum Zurücksetzen des Passworts.' ?>
      </div>
    <?php else: ?>
      <?php if(!empty($errors)): ?>
        <div class="alert alert-error"><ul>
          <?php foreach($errors as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
          <?php endforeach ?>
        </ul></div>
      <?php endif ?>

     <?php 
      if (isset($_GET['email']) && $_GET['email'] !== '') {
          $email = htmlspecialchars($_GET['email']);
      }
      ?>
      <form method="post" action="<?= url('account/forgotpassword') ?>">
        <div class="form-row">
          <label for="fp-email"><?= $this->lang==='en' ? 'Email Address' : 'E-Mail-Adresse' ?> *</label>
          <input type="email" id="fp-email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required>
        </div>
        <button type="submit" class="btn-primary">
          <?= $this->lang==='en' ? 'Send Reset Link' : 'Link senden' ?>
        </button>
      </form>
    <?php endif; ?>
  </section>
</main>

<?php require __DIR__.'/../../inc/footer.php'; ?>
