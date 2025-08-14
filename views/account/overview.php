<?php
// views/account/overview.php
$pageCss   = 'account.css';
$pageTitle = ($lang==='en') ? 'My Account' : 'Mein Konto';
require __DIR__ . '/../../inc/header.php';
?>

<main class="account-overview container">
  <?php
  require __DIR__ . '/sidebar.php';
  ?>

  <!-- Main Content -->
  <section class="account-main">

    <!-- Welcome + Recent Orders -->
     <div class="overview-card welcome-card">
      <h2>
        <?= $lang==='en' ? 'Welcome' : 'Willkommen' ?> 
        <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?>
      </h2>
      <h3 class="section-title">
        <?= $lang==='en'?'Recent Orders':'Meine letzten Bestellungen' ?>
      </h3>
      <?php if (empty($orders)): ?>
        <div class="empty-box">
          <?= $lang==='en'
               ? 'You have no orders yet.'
               : 'Keine früheren Bestellungen' ?>
        </div>
        <br>
        <a href="<?= url('') ?>" class="btn-primary">
          <?= $lang==='en'?'Shop Now':'Jetzt einkaufen!' ?>
        </a>
      <?php else: ?>
        <table class="orders-table">
          <thead>
            <tr>
              <th><?= $lang==='en'?'Order #':'Bestell-Nr.' ?></th>
              <th><?= $lang==='en'?'Date':'Datum' ?></th>
              <th><?= $lang==='en'?'Total':'Gesamt' ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($orders as $o): ?>
            <tr>
              <td><?= htmlspecialchars($o['id']) ?></td>
              <td>
                <?= date(
                    $lang==='en'?'m/d/Y':'d.m.Y',
                    strtotime($o['order_date'])
                  ) ?>
              </td>
              <td>€ <?= number_format($o['total_amount'],2,',','.') ?></td>
            </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>

    <!-- Addresses & Newsletter -->
    <div class="overview-grid">
      <?php
        // $billing und $shipping kommen aus dem Controller
        $map = [
          'billing'  => [
            'title' => $lang==='en' ? 'Billing Address'    : 'Rechnungsadresse',
            'icon'  => 'fa-star',
            'addr'  => $billing
          ],
          'shipping' => [
            'title' => $lang==='en' ? 'Shipping Address'   : 'Lieferanschrift',
            'icon'  => 'fa-truck',
            'addr'  => $shipping
          ]
        ];

        foreach($map as $type => $cfg):
          $addr = $cfg['addr'];
      ?>
        <div class="address-card">
          <div class="card-header">
            <h4><?= $cfg['title'] ?></h4>
            <i class="fa <?= $cfg['icon'] ?>"></i>
          </div>

          <?php if($type==='billing' && !$addr): ?>
            <p class="empty-box">
              <?= $lang==='en'
                  ? 'No default billing address set.'
                  : 'Keine Standard-Rechnungsadresse festgelegt.' ?>
            </p>

          <?php elseif($type==='shipping' && !$addr): ?>
            <p class="empty-box">
              <?= $lang==='en'
                  ? 'Same as billing address.'
                  : 'Gleich Rechnungsadresse.' ?>
            </p>

          <?php else: ?>
            <p>
              <?= htmlspecialchars($addr['first_name'] . ' ' . $addr['last_name']) ?><br>
              <?= htmlspecialchars($addr['street'] . ' ' . $addr['street_number']) ?><br>
              <?php if(!empty($addr['address_addition'])): ?>
                <?= htmlspecialchars($addr['address_addition']) ?><br>
              <?php endif ?>
              <?= htmlspecialchars($addr['postal_code'] . ' ' . $addr['city']) ?><br>
              <?= htmlspecialchars(
                  $lang==='en'
                    ? $addr['country_name_en']
                    : $addr['country_name_de']
                ) ?>
            </p>
          <?php endif; ?>

          <a href="<?= url('account/data') ?>" class="card-link">
            <?= $lang==='en' ? 'Edit ›' : 'Bearbeiten ›' ?>
          </a>
        </div>
      <?php endforeach; ?>

      <!-- Newsletter-Opt-In -->
      <div class="newsletter-card">
        <h4><?= $lang==='en'?'Subscribe to newsletter':'Newsletter anmelden' ?></h4>
        <form method="post" action="<?= url('account/addnewsletter') ?>">
          <label for="newsletter-email">
            <?= $lang==='en'?'E-mail Newsletter':'E-Mail-Adresse hinzufügen' ?>
          </label>
          <input
            type="email"
            id="newsletter-email"
            name="email"
            value="<?= htmlspecialchars($_SESSION['user_email'] ?? '') ?>"
            required
          >
          <button type="submit" class="btn-primary small">
            <?= $lang==='en'?'Update':'Speichern' ?>
          </button>
        </form>
        <a href="<?= url('account/newsletter') ?>" class="card-link">
          <?= $lang==='en'
               ? 'Your subscriptions ›'
               : 'Ihre Anmeldungen ›' ?>
        </a>
      </div>

    </div>
  </section>
</main>

<?php require __DIR__ . '/../../inc/footer.php'; ?>
