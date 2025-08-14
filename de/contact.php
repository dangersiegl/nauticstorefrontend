<?php
// de/contact.php
session_start();

$pageCss         = 'contact.css';
$pageTitle       = 'Kontakt';
$pageDescription = 'Nehmen Sie Kontakt mit uns auf – per Formular, Telefon, WhatsApp oder E-Mail. Wir helfen Ihnen gerne weiter.';

require __DIR__ . '/../inc/header.php';
require __DIR__ . '/../scripts/PHPMailer/Exception.php';
require __DIR__ . '/../scripts/PHPMailer/PHPMailer.php';
require __DIR__ . '/../scripts/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$errors  = [];
$success = false;

// Captcha und Timestamp generieren
function regenCaptcha() {
    $_SESSION['captcha_a'] = rand(1, 10);
    $_SESSION['captcha_b'] = rand(1, 10);
    $_SESSION['contact_form_time'] = time();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    regenCaptcha();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1) Honeypot-Feld
    if (!empty($_POST['website'])) {
        $errors[] = 'Spam-Verdacht erkannt.';
    }
    // 2) Zeitprüfung
    $loadedAt = intval($_POST['form_time'] ?? 0);
    if ($loadedAt > 0 && (time() - $loadedAt) < 5) {
        $errors[] = 'Bitte nehmen Sie sich mindestens 5 Sekunden Zeit zum Ausfüllen.';
    }
    // 3) Captcha
    $expected = ($_SESSION['captcha_a'] ?? 0) + ($_SESSION['captcha_b'] ?? 0);
    if (!isset($_POST['captcha']) || intval($_POST['captcha']) !== $expected) {
        $errors[] = 'Bitte lösen Sie die Rechenaufgabe korrekt.';
    }
    // 4) Formularfelder validieren
    $name    = trim($_POST['name']    ?? '');
    $email   = trim($_POST['email']   ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    if ($name === '')    $errors[] = 'Bitte geben Sie Ihren Namen an.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Bitte geben Sie eine gültige E-Mail-Adresse ein.';
    if ($subject === '') $errors[] = 'Bitte geben Sie einen Betreff ein.';
    if ($message === '') $errors[] = 'Bitte geben Sie Ihre Nachricht ein.';

    // 5) Bei keinen Fehlern: Mail versenden
    if (empty($errors)) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = $config->smtpHost;
            $mail->SMTPAuth   = true;
            $mail->Username   = $config->smtpUser;
            $mail->Password   = $config->smtpPass;
            $mail->SMTPSecure = $config->smtpSecure === 'ssl'
                ? PHPMailer::ENCRYPTION_SMTPS
                : PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = $config->smtpPort;

            $mail->setFrom($config->smtpFromEmail, $config->smtpFromName);
            $mail->addReplyTo($email, $name);
            $mail->addAddress($config->contactFromEmail, $config->contactFromName);

            $mail->isHTML(false);
            $mail->Subject = $subject;
            $mail->Body    = "Name: $name\r\nE-Mail: $email\r\nBetreff: $subject\r\n\n$message";

            $mail->send();
            $success = true;
            // Formularfelder leeren
            $name = $email = $subject = $message = '';
        } catch (Exception $e) {
            $errors[] = 'Fehler beim Versand: ' . $mail->ErrorInfo;
        }
    }

    // Bei Fehlern neuen Captcha erzeugen
    if (!empty($errors)) {
        regenCaptcha();
    }
}
?>

<main class="contact-page container">
  <h1 class="page-title">Kontakt</h1>

  <?php if ($success): ?>
    <div class="alert alert-success">Vielen Dank! Ihre Nachricht wurde versandt.</div>
  <?php elseif ($errors): ?>
    <div class="alert alert-error">
      <ul>
        <?php foreach ($errors as $e): ?>
          <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach ?>
      </ul>
    </div>
  <?php endif ?>

  <div class="contact-grid">

    <!-- Kontakt-Information -->
    <section class="card contact-info">
      <h2>Unsere Kontaktdaten</h2>
      <address>
        <strong>Nauticstore24</strong><br>
        Thomas Dall<br>
        Unterhart 3<br>
        4113 St. Martin, Austria
      </address>
      <dl>
        <dt>Telefon</dt>
        <dd><a href="tel:+436605198793">+43 660 5198793</a></dd>
        <dt>WhatsApp</dt>
        <dd><a href="https://wa.me/436605198793" target="_blank">+43 660 5198793</a></dd>
        <dt>E-Mail</dt>
        <dd><a href="mailto:shop@nauticstore24.at">shop@nauticstore24.at</a></dd>
        <dt>Web</dt>
        <dd><a href="<?= htmlspecialchars($baseUrl) ?>" target="_blank"><?= htmlspecialchars(parse_url($baseUrl, PHP_URL_HOST)) ?></a></dd>
      </dl>
      <p>Geschäftsführer: Thomas Dall<br>UID: ATU 651 665 44</p>

      <div class="service-info">
        <h4><?= htmlspecialchars($t['service_information']) ?></h4>
        <p><strong><?= htmlspecialchars($t['availability']) ?></strong><br>Mo.–Do. 09:00 – 15:00 Uhr</p>
        <p>Sie finden uns auch auf:</p>
        <div class="social-icons">
          <a href="https://www.facebook.com/nauticstore24/" target="_blank"><img src="<?= htmlspecialchars($baseUrl . '/assets/img/icons/facebook.png') ?>" alt="Facebook"></a>
          <a href="https://twitter.com/nauticstore24/" target="_blank"><img src="<?= htmlspecialchars($baseUrl . '/assets/img/icons/twitter.png') ?>" alt="Twitter"></a>
          <a href="https://www.instagram.com/nauticstore24/" target="_blank"><img src="<?= htmlspecialchars($baseUrl . '/assets/img/icons/instagram.png') ?>" alt="Instagram"></a>
        </div>
      </div>
    </section>

    <!-- Kontakt-Formular -->
    <section class="card contact-form">
      <h2>Nachricht senden</h2>
      <form action="" method="post" novalidate>
        <!-- Honeypot -->
        <div style="position:absolute; left:-9999px; top:-9999px;" aria-hidden="true">
          <label for="website">Website</label>
          <input type="text" id="website" name="website">
        </div>
        <!-- Timestamp -->
        <input type="hidden" name="form_time" value="<?= htmlspecialchars($_SESSION['contact_form_time'] ?? '') ?>">

        <div class="form-row">
          <label for="name">Name *</label>
          <input type="text" id="name" name="name" value="<?= htmlspecialchars($name ?? '') ?>" required>
        </div>

        <div class="form-row">
          <label for="email">E-Mail *</label>
          <input type="email" id="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required>
        </div>

        <div class="form-row">
          <label for="subject">Betreff *</label>
          <input type="text" id="subject" name="subject" value="<?= htmlspecialchars($subject ?? '') ?>" required>
        </div>

        <div class="form-row">
          <label for="message">Nachricht *</label>
          <textarea id="message" name="message" rows="5" required><?= htmlspecialchars($message ?? '') ?></textarea>
        </div>

        <!-- Mathematische Abfrage -->
        <div class="form-row">
          <label for="captcha">Wieviel ist <?= intval($_SESSION['captcha_a']) ?> + <?= intval($_SESSION['captcha_b']) ?> ?</label>
          <input type="number" id="captcha" name="captcha" required value="" style="width:4rem;">
        </div>

        <button type="submit" class="btn-primary">Absenden</button>
      </form>
    </section>

  </div>
</main>

<?php require __DIR__ . '/../inc/footer.php'; ?>
