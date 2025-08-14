<?php
// views/account/dataaddressform.php
$pageCss   = 'account.css';
$pageTitle = isset($addr['id'])
    ? ($lang==='en'?'Edit Address':'Adresse bearbeiten')
    : ($lang==='en'?'Add New Address':'Neue Adresse anlegen');
require __DIR__ . '/../../inc/header.php';
?>
<main class="account-overview container">
  <?php include __DIR__ . '/sidebar.php'; ?>

  <section class="account-main">
    <div class="address-card">
      <h2><?= htmlspecialchars($pageTitle) ?></h2>

      <?php if (!empty($errors)): ?>
      <div class="alert alert-error"><ul>
        <?php foreach($errors as $e): ?>
          <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach ?>
      </ul></div>
      <?php endif ?>

      <form method="post" action="">
        <!-- Typ (Rechnung / Lieferung) -->
        <div class="form-row">
          <label><?= $lang==='en'?'Type':'Typ' ?> *</label>
          <?php foreach(['billing','shipping'] as $type): ?>
            <label class="radio-inline">
              <input type="radio" name="address_type" value="<?= $type ?>"
                <?= ($addr['address_type']??'billing')===$type?'checked':'' ?>
                required
              >
              <?= $lang==='en'
                  ? ($type==='billing'?'Billing':'Shipping')
                  : ($type==='billing'?'Rechnungsadresse':'Lieferanschrift') ?>
            </label>
          <?php endforeach ?>
        </div>

        <!-- Als Standard setzen -->
        <div class="form-row">
          <label>
            <input type="checkbox" name="standard" value="1"
              <?= !empty($addr['standard'])?'checked':'' ?>
            >
            <?= $lang==='en'
                ? 'Set as default address'
                : 'Als Standardadresse setzen' ?>
          </label>
        </div>

        <!-- Anrede / Title -->
        <div class="form-row">
          <label><?= $lang==='en'?'Title':'Anrede' ?> *</label>
          <?php foreach([
            'male'    => $lang==='en'?'Mr.':'Herr',
            'female'  => $lang==='en'?'Mrs.':'Frau',
            'none'    => $lang==='en'?'No title':'ohne Angabe',
            'company' => $lang==='en'?'Company':'Firma',
          ] as $val=>$lbl): ?>
            <label class="radio-inline">
              <input
                type="radio"
                name="title"
                value="<?= $val ?>"
                <?= ($addr['title']??'male')===$val ? 'checked':'' ?>
                required
              > <?= $lbl ?>
            </label>
          <?php endforeach ?>
        </div>

        <!-- Firmen-Felder (nur bei title=company) -->
        <div id="company-fields" style="display:<?= ($addr['title']??'')==='company'?'block':'none'?>;">
          <div class="form-row">
            <label><?= $lang==='en'?'Company':'Firma' ?> *</label>
            <input type="text" name="company"
                   value="<?= htmlspecialchars($addr['company']??'') ?>">
          </div>
          <div class="form-row">
            <label><?= $lang==='en'?'VAT-ID':'Ust-ID-Nr.' ?></label>
            <input type="text" name="vat_id"
                   value="<?= htmlspecialchars($addr['vat_id']??'') ?>">
          </div>
        </div>

        <!-- Name -->
        <div class="form-row">
          <label><?= $lang==='en'?'First name':'Vorname' ?> *</label>
          <input type="text" name="first_name" required
                 value="<?= htmlspecialchars($addr['first_name']??'') ?>">
        </div>
        <div class="form-row">
          <label><?= $lang==='en'?'Last name':'Nachname' ?> *</label>
          <input type="text" name="last_name" required
                 value="<?= htmlspecialchars($addr['last_name']??'') ?>">
        </div>

        <!-- Straße / Nr -->
        <div class="form-row street-row">
          <div>
            <label><?= $lang==='en'?'Street':'Straße' ?> *</label>
            <input type="text" name="street" required
                   value="<?= htmlspecialchars($addr['street']??'') ?>">
          </div>
          <div>
            <label><?= $lang==='en'?'No.':'Nr.' ?> *</label>
            <input type="text" name="street_number" required
                   value="<?= htmlspecialchars($addr['street_number']??'') ?>">
          </div>
        </div>

        <!-- Adresszusatz -->
        <div class="form-row">
          <label><?= $lang==='en'?'Address addition':'Adresszusatz' ?></label>
          <input type="text" name="address_addition"
                 value="<?= htmlspecialchars($addr['address_addition']??'') ?>">
        </div>

        <!-- PLZ / Ort -->
        <div class="form-row zip-city-row">
          <div>
            <label><?= $lang==='en'?'Postal code':'Postleitzahl' ?> *</label>
            <input type="text" name="postal_code" required
                   value="<?= htmlspecialchars($addr['postal_code']??'') ?>">
          </div>
          <div>
            <label><?= $lang==='en'?'City':'Ort' ?> *</label>
            <input type="text" name="city" required
                   value="<?= htmlspecialchars($addr['city']??'') ?>">
          </div>
        </div>

        <!-- Country -->
        <div class="form-row">
          <label><?= $lang==='en'?'Country':'Land' ?> *</label>
          <select name="country_code" required>
            <?php foreach($countries as $c): ?>
            <option value="<?= $c['code'] ?>"
              <?= ($addr['country_code']??'')===$c['code']?'selected':'' ?>>
              <?= $lang==='en' ? $c['name_en'] : $c['name_de'] ?>
            </option>
            <?php endforeach ?>
          </select>
        </div>

        <button type="submit" class="btn-primary">
          <?= $lang==='en'?'Save':'Speichern' ?>
        </button>
        <a href="<?= url('account/data') ?>" class="btn-primary small" style="background:#666">
          <?= $lang==='en'?'Cancel':'Abbrechen' ?>
        </a>
      </form>
    </div>
  </section>
</main>
<?php require __DIR__ . '/../../inc/footer.php'; ?>

<script>
// Company-Felder toggeln
document.querySelectorAll('input[name="title"]').forEach(r=>{
  r.addEventListener('change',()=>{
    document.getElementById('company-fields').style.display =
      r.value==='company' ? 'block':'none';
  });
});
</script>
