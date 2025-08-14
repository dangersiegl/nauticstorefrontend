<?php
// views/account/settings.php
$pageCss    = 'account.css';
$pageTitle  = ($lang==='en') ? 'Settings' : 'Persönliche Einstellungen';
require __DIR__ . '/../../inc/header.php';
?>

<main class="account-page account-overview container">


  <?php include __DIR__ . '/sidebar.php'; ?>

  <!-- Main Content -->
  <section class="account-main">
    <h2><?= htmlspecialchars($pageTitle) ?></h2>

    <!-- 1) Namens-Änderung -->
    <div class="overview-card account-card" id="form-name">
      <h2><?= $lang==='en'?'Name':'Name ändern' ?></h2>
      <?php if(!empty($errorsName)): ?>
        <div class="alert alert-error"><ul>
          <?php foreach($errorsName as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
          <?php endforeach ?>
        </ul></div>
      <?php elseif(!empty($successName)): ?>
        <div class="alert alert-success">
          <?= ($lang==='en'?'Your name has been updated.':'Ihr Name wurde aktualisiert.') ?>
        </div>
      <?php endif ?>

      <form method="post" action="<?= url('account/settings') ?>">
        <input type="hidden" name="action" value="change_name">
        <div class="form-row">
          <label><?= $lang==='en'?'First name':'Vorname' ?> *</label>
          <input type="text" name="first_name" required
                 value="<?= htmlspecialchars($user['first_name']) ?>">
        </div>
        <div class="form-row">
          <label><?= $lang==='en'?'Last name':'Nachname' ?> *</label>
          <input type="text" name="last_name" required
                 value="<?= htmlspecialchars($user['last_name']) ?>">
        </div>
        <button type="submit" class="btn-primary">
          <?= $lang==='en'?'Save name':'Name speichern' ?>
        </button>
      </form>
    </div>

    <!-- 2) Passwort-Änderung -->
    <div class="overview-card account-card" id="form-password">
      <h2><?= $lang==='en'?'Password':'Passwort ändern' ?></h2>
      <?php if(!empty($errorsPassword)): ?>
        <div class="alert alert-error"><ul>
          <?php foreach($errorsPassword as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
          <?php endforeach ?>
        </ul></div>
      <?php elseif(!empty($successPassword)): ?>
        <div class="alert alert-success">
          <?= ($lang==='en'?'Your password has been updated.':'Ihr Passwort wurde aktualisiert.') ?>
        </div>
      <?php endif ?>

      <form method="post" action="<?= url('account/settings') ?>">
        <input type="hidden" name="action" value="change_password">
          <div class="form-row">
            <label><?= $lang==='en'?'Current password':'Aktuelles Passwort' ?> *</label>
            <input type="password" name="current_password" required>
          </div>
          <div class="form-row">
            <label><?= $lang==='en'?'New password':'Neues Passwort' ?> *</label>
            <input type="password" name="new_password" required>
          </div>
          <div class="form-row">
            <label><?= $lang==='en'?'Confirm new password':'Neues Passwort wiederholen' ?> *</label>
            <input type="password" name="new_password2" required>
          </div>
        <button type="submit" class="btn-primary">
          <?= $lang==='en'?'Save password':'Passwort speichern' ?>
        </button>
      </form>
    </div>

    <!-- 3) E-Mail-Änderung -->
    <div class="overview-card account-card" id="form-email">
      <h2><?= $lang==='en'?'Email':'E-Mail-Adresse ändern' ?></h2>
      <?php if(!empty($errorsEmail)): ?>
        <div class="alert alert-error"><ul>
          <?php foreach($errorsEmail as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
          <?php endforeach ?>
        </ul></div>
      <?php elseif(!empty($successEmail)): ?>
        <div class="alert alert-success">
          <?= ($lang==='en'?'Confirmation email sent.':'Bestätigungs-Mail wurde versandt.') ?>
        </div>
      <?php endif ?>

      <form method="post" action="<?= url('account/settings') ?>">
        <input type="hidden" name="action" value="change_email">
          <div class="form-row">
            <label>
              <?= $lang==='en'
                ? 'Your current email address:'
                : 'Ihre aktuelle E-Mail-Adresse:' ?>
            </label>
            <input type="email" value="<?= htmlspecialchars($user['email']) ?>" readonly>
          </div>

          <div class="form-row">
            <label><?= $lang==='en'?'New email address:':'Neue E-Mail-Adresse:' ?> *</label>
            <input type="email" name="new_email" required>
          </div>

          <div class="form-row">
            <label><?= $lang==='en'?'Confirm new email address:':'Neue E-Mail-Adresse wiederholen:' ?> *</label>
            <input type="email" name="new_email2" required>
          </div>

          <div class="form-row">
            <label>
              <?= $lang==='en'
                ? 'Confirm with your password:'
                : 'Bitte bestätigen Sie die Änderung mit Ihrem Passwort:' ?> *
            </label>
            <input type="password" name="email_password" required>
          </div>

        <button type="submit" class="btn-primary">
          <?= $lang==='en'?'Change email':'E-Mail ändern' ?>
        </button>
      </form>
    </div>

  </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function(){
  // Wenn ein Fehler oder Erfolg im jeweiligen Array steckt, scroll zum passenden Formular
  <?php if (!empty($errorsName) || $successName): ?>
    document.getElementById('form-name').scrollIntoView({ behavior: 'smooth' });
  <?php elseif (!empty($errorsPassword) || $successPassword): ?>
    document.getElementById('form-password').scrollIntoView({ behavior: 'smooth' });
  <?php elseif (!empty($errorsEmail) || $successEmail): ?>
    document.getElementById('form-email').scrollIntoView({ behavior: 'smooth' });
  <?php endif; ?>
});
</script>


<?php require __DIR__ . '/../../inc/footer.php'; ?>
