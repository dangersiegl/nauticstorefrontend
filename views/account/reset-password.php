<?php
// views/account/reset-password.php
$pageCss   = 'account.css';
$pageTitle = $this->lang==='en' ? 'Reset Password' : 'Passwort zurücksetzen';
require __DIR__.'/../../inc/header.php';
?>

<main class="account-page container">
  <section class="account-card login-card">
    <h2><?= $this->lang==='en' ? 'Choose a new password' : 'Neues Passwort wählen' ?></h2>

    <?php if (!empty($errors)): ?>
      <div class="alert alert-error"><ul>
        <?php foreach($errors as $e): ?>
          <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach ?>
      </ul></div>
    <?php endif; ?>

    <?php if (isset($success) && $success): ?>
      <div class="alert alert-success">
        <?= $this->lang==='en'
            ? 'Your password has been updated. You may now log in.'
            : 'Ihr Passwort wurde erfolgreich geändert. Sie können sich nun anmelden.' ?>
      </div>
      <p><a href="<?= url('account/login') ?>" class="btn-primary">
        <?= $this->lang==='en' ? 'Back to Login' : 'Zurück zum Login' ?>
      </a></p>
    <?php else: ?>
      <form method="post" action="<?= url('account/resetpassword') ?>?token=<?= htmlspecialchars($token) ?>">
        <div class="form-row">
          <label for="rp-password"><?= $this->lang==='en' ? 'New Password' : 'Neues Passwort' ?> *</label>
          <input type="password" id="rp-password" name="password" required>
        </div>
        <div class="form-row">
          <label for="rp-password2"><?= $this->lang==='en' ? 'Confirm Password' : 'Passwort wiederholen' ?> *</label>
          <input type="password" id="rp-password2" name="password2" required>
        </div>
        <button type="submit" class="btn-primary">
          <?= $this->lang==='en' ? 'Set New Password' : 'Passwort setzen' ?>
        </button>
      </form>
    <?php endif; ?>
  </section>
</main>

<?php require __DIR__.'/../../inc/footer.php'; ?>
