<?php
// views/account/data.php

$pageCss   = 'account.css';
$pageTitle = ($lang==='en') ? 'My Addresses' : 'Meine Adressen';
require __DIR__ . '/../../inc/header.php';
?>

<main class="account-overview container">
  <?php include __DIR__ . '/sidebar.php'; ?>

  <section class="account-main">
        <?php if(!empty($flashSuccess)): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($flashSuccess) ?>
        </div>
        <?php endif; ?>
    <h2><?= htmlspecialchars($pageTitle) ?></h2>

    <div class="overview-grid">
      <!-- Rechnungsadresse -->
      <div class="address-card">
        <div class="card-header">
          <h4><?= $lang==='en' ? 'Billing Address' : 'Rechnungsadresse' ?> (Standard)</h4>
          <i class="fa fa-star"></i>
        </div>

        <?php if ($billing): ?>
          <p>
            <?= htmlspecialchars($billing['first_name'] . ' ' . $billing['last_name']) ?><br>
            <?= htmlspecialchars($billing['street'] . ' ' . $billing['street_number']) ?><br>
            <?php if ($billing['address_addition']): ?>
              <?= htmlspecialchars($billing['address_addition']) ?><br>
            <?php endif; ?>
            <?= htmlspecialchars($billing['postal_code'] . ' ' . $billing['city']) ?><br>
            <?= htmlspecialchars($lang==='en'
                ? $billing['name_en']
                : $billing['name_de']) ?>
          </p>
          <a href="<?= url('account/dataedit?addr='.$billing['id']) ?>" class="card-link">
          <?= $lang==='en' ? 'Edit ›' : 'Bearbeiten ›' ?>
        </a><br>
        <a href="<?= url('account/dataedit?addr=type=billing'); ?>" class="card-link">
          <?= $lang==='en' ? 'Add new address ›' : 'Neue Adresse anlegen ›' ?>
        </a>
        <?php else: ?>
          <p class="empty-box">
            <?= $lang==='en'
                ? 'No standard billing address saved.'
                : 'Keine Standard-Rechnungsadresse hinterlegt.' ?>
          </p>
          <a href="<?= url('account/dataedit?type=billing'); ?>" class="card-link">
          <?= $lang==='en' ? 'Add new address ›' : 'Neue Adresse anlegen ›' ?>
        </a>
        <?php endif; ?>       
      </div>

      <!-- Lieferanschrift -->
      <div class="address-card">
        <div class="card-header">
          <h4><?= $lang==='en' ? 'Shipping Address' : 'Lieferanschrift' ?> (Standard)</h4>
          <i class="fa fa-truck"></i>
        </div>

        <?php if ($shipping): ?>
          <p>
            <?= htmlspecialchars($shipping['first_name'] . ' ' . $shipping['last_name']) ?><br>
            <?= htmlspecialchars($shipping['street'] . ' ' . $shipping['street_number']) ?><br>
            <?php if ($shipping['address_addition']): ?>
              <?= htmlspecialchars($shipping['address_addition']) ?><br>
            <?php endif; ?>
            <?= htmlspecialchars($shipping['postal_code'] . ' ' . $shipping['city']) ?><br>
            <?= htmlspecialchars($lang==='en'
                ? $shipping['name_en']
                : $shipping['name_de']) ?>
          </p>
          <a href="<?= url('account/dataedit?addr='.$shipping['id']) ?>" class="card-link">
          <?= $lang==='en' ? 'Edit ›' : 'Bearbeiten ›' ?>
        </a><br>
        <a href="<?= url('account/dataedit?type=shipping'); ?>" class="card-link">
          <?= $lang==='en' ? 'Add new address ›' : 'Neue Adresse anlegen ›' ?>
        </a><br>
        <a href="<?= url('account/unsetdefault?type=shipping'); ?>" class="card-link">
          <?= $lang==='en' ? 'Set billing address as shipping address ›' : 'Rechnungsadresse als Lieferadresse setzen ›' ?>
        </a>
        <?php else: ?>
          <p class="empty-box">
            <?= $lang==='en'
                ? 'Same as billing address.'
                : 'Gleich wie Rechnungsadresse.' ?>
          </p>
          <a href="<?= url('account/dataedit?type=shipping'); ?>" class="card-link">
          <?= $lang==='en' ? 'Add new address ›' : 'Neue Adresse anlegen ›' ?>
        </a>
        <?php endif; ?>

        
      </div>
    </div>
    <!-- 2) Weitere Adressen -->
    <div style="margin-top:2rem">
      <div style="display:flex; justify-content:space-between; align-items:center;">
        <h3><?= $lang==='en' ? 'Other Addresses' : 'Weitere Adressen' ?></h3>
        <a href="<?= url('account/dataedit') ?>" class="btn-primary small">
          <?= $lang==='en' ? 'Add New Address' : 'Neue Adresse anlegen' ?>
        </a>
      </div>

      <?php if (count($others)): ?>
      <div class="overview-grid" style="margin-top:1rem">
        <?php foreach($others as $addr): ?>
        <div class="address-card">
            <div class="card-header">
            <h4>
                <?= $lang==='en'
                    ? ($addr['address_type']==='billing'?'Billing Address':'Shipping Address')
                    : ($addr['address_type']==='billing'?'Rechnungsadresse':'Lieferanschrift') ?>
            </h4>
            <i class="fa <?= $addr['address_type']==='billing' ? 'fa-star' : 'fa-truck' ?>"></i>
            </div>
            <p>
            <?= htmlspecialchars($addr['first_name'].' '.$addr['last_name']) ?><br>
            <?= htmlspecialchars($addr['street'].' '.$addr['street_number']) ?><br>
            <?php if ($addr['address_addition']): ?>
                <?= htmlspecialchars($addr['address_addition']) ?><br>
            <?php endif; ?>
            <?= htmlspecialchars($addr['postal_code'].' '.$addr['city']) ?><br>
            <?= htmlspecialchars($lang==='en' ? $addr['name_en'] : $addr['name_de']) ?>
            </p>
            <div style="display:flex;gap:1rem;">

            <?php if( !$addr['standard'] ): ?>
            <a href="<?= url('account/setdefault?addr='.$addr['id']) ?>"
                class="card-link"
                onclick="return confirm('<?= $lang==='en'?'Set this as your default '.($addr['address_type']==='billing'?'billing':'shipping').' address?':'Diese Adresse als Standard-'.($addr['address_type']==='billing'?'Rechnungs':'Liefer').'adresse festlegen?'?>')">
                <?= $lang==='en'
                    ? 'Set as default ›'
                    : 'Als Standard festlegen ›' ?>
            </a></div>
            <div style="display:flex;gap:1rem;">
            <a href="<?= url('account/dataedit?addr='.$addr['id']) ?>" class="card-link">
                <?= $lang==='en' ? 'Edit ›' : 'Bearbeiten ›' ?>
            </a>
            <a href="<?= url('account/datadelete?addr='.$addr['id']) ?>"
                class="card-link" style="color:#c00;"
                onclick="return confirm('<?= $lang==='en'?'Delete this address?':'Adresse wirklich löschen?'?>')">
                <?= $lang==='en'?'Delete ›':'Löschen ›' ?>
            </a>
            <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>

      </div>
      <?php else: ?>
        <p class="empty-box" style="margin-top:1rem">
          <?= $lang==='en' ? 'No additional addresses.' : 'Keine weiteren Adressen vorhanden.' ?>
        </p>
      <?php endif; ?>
    </div>
  </section>
</main>

<?php require __DIR__ . '/../../inc/footer.php'; ?>
