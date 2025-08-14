<?php
// views/account/security.php
$pageCss   = 'account.css';
$pageTitle = ($lang==='en') ? 'Security - 2FA' : 'Sicherheit - 2FA';
require __DIR__ . '/../../inc/header.php';
?>
<main class="account-overview container">
  <?php include __DIR__ . '/sidebar.php'; ?>
  <section class="account-main">

    <div class="overview-card account-card">
      <h2><?= htmlspecialchars($pageTitle) ?></h2>

      <?php if (!empty($errors)): ?>
        <div class="alert alert-error"><ul>
        <?php foreach ($errors as $e): ?>
          <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach ?>
        </ul></div>
      <?php elseif ($success): ?>
        <div class="alert alert-success">
          <?= htmlspecialchars($success) ?>
        </div>
      <?php endif ?>

      <?php if ($user['totp_secret']): ?>
         <!-- 1) Bereits aktiviert: Deaktivieren -->
        <p>
            <?= $lang === 'en'
                ? 'Two-factor authentication (TOTP) is currently <strong>enabled</strong>.<br>If you wish to disable 2FA, please enter your current password and the TOTP authentication code.'
                : 'Zwei-Faktor-Authentifizierung (TOTP) ist derzeit <strong>aktiviert</strong>.<br>Wenn Sie 2FA deaktivieren möchten, geben Sie bitte Ihr aktuelles Passwort und den TOTP-Authentifizierungscode ein.' ?>
        </p>
        <form method="post" action="<?= url('account/security') ?>">
        <input type="hidden" name="action" value="disable_totp">

        <div class="form-row">
        <label for="current-password-disable">
            <?= $lang==='en'
                ? 'Current Password'
                : 'Aktuelles Passwort' ?> *
        </label>
        <input
            type="password"
            id="current-password-disable"
            name="current_password_disable"
            required
        >
        </div>

        <div class="form-row">
        <label for="totp-code-disable">
            <?= $lang==='en'
                ? 'Authentication code'
                : 'Authentifizierungscode' ?> *
        </label>
        <input
            type="text"
            id="totp-code-disable"
            name="totp_code_disable"
            required
            maxlength="6"
            pattern="\d{6}"
            autocomplete="one-time-code"
        >
        </div>
          <button type="submit" class="btn-primary"><?= $lang==='en'?'Disable 2FA':'2FA deaktivieren' ?></button>
        </form>

      <?php elseif (!empty($pendingSecret)): ?>
        <!-- 2) Neu generiertes Secret: QR + Bestätigung + Code zum Kopieren -->
        <?php
          // OTPAUTH-URL
          $label   = urlencode("Nauticstore24:{$user['email']}");
          $issuer  = urlencode('Nauticstore24');
          $otpAuth = "otpauth://totp/{$label}?secret={$pendingSecret}&issuer={$issuer}";
          // QR über kostenlose API
          $qrData  = urlencode($otpAuth);
          $qrUrl   = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={$qrData}";
        ?>
        <p><?= $lang==='en'
            ? 'Scan the QR code with your preferred authenticator app (or copy the key below and paste it manually):'
            : 'Scannen Sie den QR-Code mit Ihrer bevorzugten Authenticator-App (oder kopieren Sie alternativ den Schlüssel und fügen Sie ihn manuell ein):' ?>
        </p>
        <img src="<?= htmlspecialchars($qrUrl) ?>" alt="TOTP QR Code" width="200" height="200">

        <div class="form-row secret-container" style="margin-top:.5rem;">
        <label><?= $lang==='en'?'Secret key (copy/paste)':'Geheimschlüssel (kopieren)' ?></label>
        <input 
            type="text" 
            readonly 
            id="secret-key-input"
            value="<?= htmlspecialchars($pendingSecret) ?>"
            style="font-family:monospace;"
        >
        <button type="button" class="copy-btn" data-target="secret-key-input" title="<?= $lang==='en'?'Copy to clipboard':'In Zwischenablage kopieren' ?>">
            <!-- simple Clipboard SVG icon -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
            <path d="M16 1H4a2 2 0 00-2 2v14h2V3h12V1z"/>
            <path d="M19 5H8a2 2 0 00-2 2v14a2 2 0 002 2h11a2 2 0 002-2V7a2 2 0 00-2-2zm0 16H8V7h11v14z"/>
            </svg>
        </button>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function(){
        const btn = document.querySelector('.copy-btn');
        const input = document.getElementById('secret-key-input');
        btn.addEventListener('click', function(){
            // Inhalt markieren und kopieren
            input.select();
            navigator.clipboard.writeText(input.value)
            .then(() => {
                // Kurze Rückmeldung
                const msg = document.createElement('div');
                msg.textContent = <?= $lang==='en' 
                ? "'Copied to clipboard!'" 
                : "'In die Zwischenablage kopiert!'" ?>;
                msg.style.cssText = `
                position:fixed;
                top:5rem;
                right:1rem;
                background:#28a745;
                color:white;
                padding:.5rem 1rem;
                border-radius:4px;
                box-shadow:0 2px 6px rgba(0,0,0,.2);
                z-index:99000;
                `;
                document.body.appendChild(msg);
                setTimeout(()=> msg.remove(), 2000);
            })
            .catch(err => {
                console.error('Clipboard error', err);
            });
        });
        });
        </script>


        <form method="post" action="<?= url('account/security') ?>">
          <input type="hidden" name="action" value="confirm_totp">
          <div class="form-row">
            <label><?= $lang==='en'?'Authentication Code':'Authentifizierungs-Code' ?></label>
            <input type="text" name="totp_code" maxlength="6" required>
          </div>
          <button type="submit" class="btn-primary">
            <?= $lang==='en'?'Confirm and Enable':'Bestätigen & Aktivieren' ?>
          </button>
        </form>

      <?php else: ?>
        <!-- 3) Noch nicht aktiviert: Button generieren -->
        <p><?= $lang==='en'
            ? 'Two-factor authentication adds an extra layer of security to your account.'
            : 'Die Zwei-Faktor-Authentifizierung erhöht die Sicherheit Ihres Kontos.' ?>
        </p>
        <form method="post" action="<?= url('account/security') ?>">
          <input type="hidden" name="action" value="generate_totp">
          <button type="submit" class="btn-primary">
            <?= $lang==='en'?'Enable Two-Factor Authentication':'2FA aktivieren' ?>
          </button>
        </form>
      <?php endif; ?>

      <p><br>
        <?= $lang === 'en'
            ? 'If you want to change your password, go to your <a href="settings">personal settings</a>.'
            : 'Wenn Sie Ihr Passwort ändern möchten, gehen Sie zu Ihren <a href="settings">persönlichen Einstellungen</a>.' ?>
    </p>

    </div>
  </section>
</main>
<?php require __DIR__ . '/../../inc/footer.php'; ?>

