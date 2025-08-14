<?php 
// views/account/newsletter.php
$pageCss   = 'account.css';
$pageTitle = ($lang==='en'?'Newsletter':'Newsletter verwalten');
require __DIR__.'/../../inc/header.php';
?>

<main class="account-overview container">
  <?php include __DIR__.'/sidebar.php'; ?>

  <section class="account-main">
    <?php if(!empty($flash)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($flash) ?></div>
      <?php endif ?>
<h2><?= htmlspecialchars($pageTitle) ?></h2>

    <div class="overview-card account-card">
      <h3><?= $lang==='en'
              ? 'My account E-Mail'
              : 'Meine Haupt-E-Mail' ?></h3>

        <!-- 1) Haupt-E-Mail Toggle -->
        <form method="post" action="<?= url('account/togglenewsletter') ?>" class="newsletter-toggle-form" onsubmit="return confirmNewsletterToggle(<?= $user['newsletter_opt_in'] ? 'true' : 'false' ?>)">
            <div class="newsletter-status">
                <?php if ($user['newsletter_opt_in']): ?>
                    <p>
                        <?= $lang === 'en'
                            ? 'You are currently subscribed to our newsletter. This means you receive the latest updates, exclusive offers, and important information directly via email.'
                            : 'Sie sind derzeit für unseren Newsletter angemeldet. Das bedeutet, Sie erhalten regelmäßig aktuelle Informationen, exklusive Angebote und wichtige Neuigkeiten per E-Mail.' ?>
                    </p>
                    <button type="submit" class="btn-primary">
                        <?= $lang === 'en' ? 'Unsubscribe from Newsletter' : 'Vom Newsletter abmelden' ?>
                    </button>
                <?php else: ?>
                    <p>
                        <?= $lang === 'en'
                            ? 'You are currently not subscribed to our newsletter. Stay up to date and don’t miss out on special promotions and news – simply click the button below to subscribe.'
                            : 'Sie sind aktuell nicht für unseren Newsletter angemeldet. Bleiben Sie informiert und verpassen Sie keine Aktionen oder Neuigkeiten – klicken Sie einfach auf den Button, um sich anzumelden.' ?>
                    </p>
                    <button type="submit" class="btn-primary">
                        <?= $lang === 'en' ? 'Subscribe to Newsletter' : 'Für den Newsletter anmelden' ?>
                    </button>
                <?php endif; ?>
            </div>
        </form>

        <script>
            function confirmNewsletterToggle(isSubscribed) {
                if (isSubscribed) {
                    return confirm("<?= $lang === 'en'
                        ? 'Are you sure you want to unsubscribe from the newsletter? You will no longer receive updates and offers via email.'
                        : 'Möchten Sie sich wirklich vom Newsletter abmelden? Sie erhalten dann keine Neuigkeiten und Angebote mehr per E-Mail.' ?>");
                }
                return true;
            }
        </script>
    </div>

      

<div class="overview-card account-card">
      <!-- 2) Formular für neue Adresse -->
      <h3><?= $lang==='en'?'Add another email':'Weitere E-Mail hinzufügen' ?></h3>
      <p>
        <?= $lang === 'en'
            ? 'Add another email address to receive our newsletter and stay informed about promotions and news – unsubscribe at any time.'
            : 'Fügen Sie eine weitere E-Mail-Adresse hinzu, um unseren Newsletter zu erhalten und keine Aktionen oder Neuigkeiten mehr zu verpassen – jederzeit kündbar.' ?>
    </p>

      <form method="post" action="<?= url('account/addnewsletter') ?>">
        <div class="form-row">
          <label for="newsletter-email">
            <?= $lang==='en'
                ? 'New email address'
                : 'E-Mail-Adresse' ?> *
          </label>
          <input
            type="email"
            id="newsletter-email"
            name="email"
            required
          >
        </div>
        <button class="btn-primary" type="submit">
          <?= $lang==='en'?'Subscribe':'Anmelden' ?>
        </button>
      </form>
    </div>

<!-- 3) Zusätzliche Adressen -->
    <div class="overview-card account-card">
      <h3><?= $lang==='en'?'Additional subscriptions':'Weitere Anmeldungen' ?></h3>
      <?php if(count($subs)): ?>
        <ul style="list-style:none;padding:0">
          <?php foreach($subs as $s): ?>
          <li>
            <?= htmlspecialchars($s['email']) ?>
            &nbsp;
            <a href="<?= url('account/removenewsletter?sub='.$s['id']) ?>"
               style="color:#c00;"
               onclick="return confirm('<?= $lang==='en'
                   ? 'Remove this subscription?'
                   : 'Diese Anmeldung entfernen?' ?>')">
               <?= $lang==='en'?'Remove':'Entfernen' ?>
            </a>
          </li>
          <?php endforeach ?>
        </ul>
      <?php else: ?>
        <p class="empty-box">
          <?= $lang==='en'
            ? 'No additional subscriptions.'
            : 'Keine weiteren Anmeldungen.' ?>
        </p>
      <?php endif ?>
      </div>

  </section>
</main>

<?php require __DIR__.'/../../inc/footer.php'; ?>
