<?php
// en/contact.php
session_start();

$pageCss         = 'contact.css';
$pageTitle       = 'Contact';
$pageDescription = 'Contact us via form, phone, WhatsApp or email. We are happy to help.';

require __DIR__ . '/../inc/header.php';
require __DIR__ . '/../scripts/PHPMailer/Exception.php';
require __DIR__ . '/../scripts/PHPMailer/PHPMailer.php';
require __DIR__ . '/../scripts/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$errors  = [];
$success = false;

// Always (re)generate captcha + timestamp when showing the form
function regenCaptcha() {
    $_SESSION['captcha_a'] = rand(1,10);
    $_SESSION['captcha_b'] = rand(1,10);
    $_SESSION['contact_form_time'] = time();
}

// On first GET…
if ($_SERVER['REQUEST_METHOD']==='GET') {
    regenCaptcha();
}

// Handle POST…
if ($_SERVER['REQUEST_METHOD']==='POST') {
    // 1) Honeypot
    if (!empty($_POST['website'])) {
        $errors[] = 'Spam suspected.';
    }
    // 2) Timing check
    $loadedAt    = intval($_POST['form_time'] ?? 0);
    if ($loadedAt>0 && (time()-$loadedAt)<5) {
        $errors[] = 'Please take at least 5 seconds to fill out the form.';
    }
    // 3) Captcha
    $expected = ($_SESSION['captcha_a'] ?? 0) + ($_SESSION['captcha_b'] ?? 0);
    if (!isset($_POST['captcha']) || intval($_POST['captcha'])!==$expected) {
        $errors[] = 'Please solve the simple math question correctly.';
    }
    // 4) Fields
    $name    = trim($_POST['name']    ?? '');
    $email   = trim($_POST['email']   ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    if ($name==='' )   $errors[]='Please enter your name.';
    if (!filter_var($email,FILTER_VALIDATE_EMAIL)) $errors[]='Please enter a valid email.';
    if ($subject==='') $errors[]='Please enter a subject.';
    if ($message==='') $errors[]='Please enter your message.';

    // 5) If no errors → send mail
    if (empty($errors)) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = $config->smtpHost;
            $mail->SMTPAuth   = true;
            $mail->Username   = $config->smtpUser;
            $mail->Password   = $config->smtpPass;
            $mail->SMTPSecure = $config->smtpSecure==='ssl'
                ? PHPMailer::ENCRYPTION_SMTPS
                : PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = $config->smtpPort;

            $mail->setFrom($config->smtpFromEmail, $config->smtpFromName);
            $mail->addReplyTo($email, $name);
            $mail->addAddress($config->contactFromEmail, $config->contactFromName);

            $mail->isHTML(false);
            $mail->Subject = $subject;
            $mail->Body    = "Name: $name\r\nEmail: $email\r\nSubject: $subject\r\n\n$message";

            $mail->send();
            $success = true;
            // clear form on success
            $name=$email=$subject=$message='';
        } catch (Exception $e) {
            $errors[] = 'Error sending message: '.$mail->ErrorInfo;
        }
    }

    // If we had errors, regenerate a fresh captcha for re-display:
    if (!empty($errors)) {
        regenCaptcha();
    }
}
?>

<main class="contact-page container">
  <h1 class="page-title">Contact</h1>

  <?php if ($success): ?>
    <div class="alert alert-success">Thank you! Your message has been sent.</div>
  <?php elseif ($errors): ?>
    <div class="alert alert-error">
      <ul>
        <?php foreach($errors as $e): ?>
          <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach ?>
      </ul>
    </div>
  <?php endif ?>

  <div class="contact-grid">

    <!-- Contact Info -->
    <section class="card contact-info">
      <h2>Our Contact Details</h2>
      <address>
        <strong>Nauticstore24</strong><br>
        Thomas Dall<br>
        Unterhart 3<br>
        4113 St. Martin, Austria
      </address>
      <dl>
        <dt>Phone</dt>
        <dd><a href="tel:+436605198793">+43 660 5198793</a></dd>
        <dt>WhatsApp</dt>
        <dd><a href="https://wa.me/436605198793" target="_blank">+43 660 5198793</a></dd>
        <dt>Email</dt>
        <dd><a href="mailto:shop@nauticstore24.at">shop@nauticstore24.at</a></dd>
        <dt>Web</dt>
        <dd><a href="<?= htmlspecialchars($baseUrl) ?>" target="_blank"><?= htmlspecialchars(parse_url($baseUrl, PHP_URL_HOST)) ?></a></dd>
      </dl>
      <p>Managing Director: Thomas Dall<br>VAT ID: ATU 651 665 44</p>

      <div class="service-info">
        <h4><?= htmlspecialchars($t['service_information']) ?></h4>
        <p><strong><?= htmlspecialchars($t['availability']) ?></strong><br>Mon–Thu 09:00 AM – 03:00 PM</p>
        <p>You can also find us on:</p>
        <div class="social-icons">
          <a href="https://www.facebook.com/nauticstore24/" target="_blank"><img src="<?= htmlspecialchars($baseUrl . '/assets/img/icons/facebook.png') ?>" alt="Facebook"></a>
          <a href="https://twitter.com/nauticstore24/" target="_blank"><img src="<?= htmlspecialchars($baseUrl . '/assets/img/icons/twitter.png') ?>" alt="Twitter"></a>
          <a href="https://www.instagram.com/nauticstore24/" target="_blank"><img src="<?= htmlspecialchars($baseUrl . '/assets/img/icons/instagram.png') ?>" alt="Instagram"></a>
        </div>
      </div>
    </section>

    <section class="card contact-form">
      <h2>Send a Message</h2>
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
          <label for="email">Email *</label>
          <input type="email" id="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required>
        </div>

        <div class="form-row">
          <label for="subject">Subject *</label>
          <input type="text" id="subject" name="subject" value="<?= htmlspecialchars($subject ?? '') ?>" required>
        </div>

        <div class="form-row">
          <label for="message">Message *</label>
          <textarea id="message" name="message" rows="5" required><?= htmlspecialchars($message ?? '') ?></textarea>
        </div>

        <!-- Math captcha: always blank -->
        <div class="form-row">
          <label for="captcha">
            What is <?= intval($_SESSION['captcha_a']) ?> + <?= intval($_SESSION['captcha_b']) ?> ?
          </label>
          <input
            type="number"
            id="captcha"
            name="captcha"
            required
            value=""
            style="width:4rem;"
          >
        </div>

        <button type="submit" class="btn-primary">Send</button>
      </form>
    </section>

  </div>
</main>

<?php require __DIR__ . '/../inc/footer.php'; ?>
