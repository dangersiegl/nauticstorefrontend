<?php
// views/account/login.php

$pageCss        = 'account.css';
$pageTitle      = ($lang==='en') ? 'Login / Register' : 'Anmelden / Registrieren';
$pageDescription= '';

require __DIR__ . '/../../inc/header.php';

// $activeTab muss im Controller gesetzt werden auf 'login' oder 'register'
// Fallback-Logik, wenn der Controller es doch mal nicht tut:
$activeTab = $activeTab 
    ?? (!empty($loginErrors)   ? 'login'
        : (!empty($errorsRegister) ? 'register'
                                    : 'login'));

// Länder-Liste vom Controller:
// $countries = [ ['code'=>'AT','name_de'=>'Österreich','name_en'=>'Austria'], ... ];
?>
<main class="account-page container">

  <!-- Tab-Schalter -->
  <div class="account-tabs">
    <button
      type="button"
      class="tab-button <?= $activeTab==='login'? 'active':''?>"
      data-target="#login-tab"
    ><?= $lang==='en'? 'Login':'Anmelden'?></button>
    <button
      type="button"
      class="tab-button <?= $activeTab==='register'? 'active':''?>"
      data-target="#register-tab"
    ><?= $lang==='en'? 'Register':'Registrieren'?></button>
  </div>

  <div class="tab-content">

    <!-- ===== LOGIN ===== -->
    <section
    id="login-tab"
    class="tab-panel <?= $activeTab==='login'? 'active':''?>"
    >
    <?php if (!empty($requireTotp)): ?>
        <h2><?= $lang==='en'? 'Two-Factor Authentication' : 'Zwei-Faktor-Authentifizierung' ?></h2>

        <?php if(!empty($loginErrors)): ?>
        <div class="alert alert-error">
            <ul>
            <?php foreach($loginErrors as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach ?>
            </ul>
        </div>
        <?php endif ?>

        <form method="post" action="<?= url('account/login') ?>">
        <input type="hidden" name="action" value="login_totp">
        <div class="form-row">
            <label for="totp-code">
            <?= $lang==='en'? 'Authentication code':'Authentifizierungscode' ?> *
            </label>
            <input
            type="text"
            id="totp-code"
            name="totp_code"
            required
            maxlength="6"
            pattern="\d{6}"
            autocomplete="one-time-code"
            autofocus
            >
        </div>
        <button type="submit" class="btn-primary">
            <?= $lang==='en'? 'Verify':'Verifizieren' ?>
        </button>
        <p><?= $lang==='en'? 'If you no longer have access to your MFA, <a href=contact>contact us</a>.':'Sollten Sie keinen Zugriff mehr auf Ihre MFA haben, <a href=kontakt>kontaktieren Sie uns</a>.'; ?></p>
        </form>

    <?php else: ?>
        <h2><?= $lang==='en'? 'Login':'Anmelden'?></h2>

        <?php if(!empty($loginErrors)): ?>
        <div class="alert alert-error">
            <ul>
            <?php foreach($loginErrors as $e): ?>
                <li><?= htmlspecialchars($e) ?></li>
            <?php endforeach ?>
            </ul>
        </div>
        <?php endif ?>

        <form method="post" action="<?= url('account/login') ?>">
        <input type="hidden" name="action" value="login_password">
        <div class="form-row">
            <label for="login-email">
            <?= $lang==='en'? 'Email':'E-Mail'?> *
            </label>
            <input
            type="email"
            id="login-email"
            name="email"
            required
            value="<?= htmlspecialchars($loginEmail ?? '') ?>"
            autofocus
            >
        </div>
        <div class="form-row">
            <label for="login-password">
            <?= $lang==='en'? 'Password':'Passwort'?> *
            </label>
            <input
            type="password"
            id="login-password"
            name="password"
            required
            >
        </div>
        <button type="submit" class="btn-primary">
            <?= $lang==='en'? 'Login':'Anmelden'?>
        </button>
        </form>

        <p class="forgot-link">
        <a href="<?= url('account/forgotpassword')?>"
            id="forgot-password-link">
            <?= $lang==='en'? 'Forgot password?':'Passwort vergessen?'?>
        </a>
        &nbsp;|&nbsp;
        <a href="#" class="open-register"
            id="switch-to-register">
            <?= $lang==='en'? 'Register':'Registrieren'?>
        </a>
        </p>
    <?php endif; ?>
    </section>


    <!-- ===== REGISTER ===== -->
    <section
      id="register-tab"
      class="tab-panel <?= $activeTab==='register'? 'active':''?>"
    >
      <h2><?= $lang==='en'? 'Register':'Registrieren'?></h2>

      <p><?= $lang==='en'? 'Already registered?':'Bereits registriert?'?> <a href="#" class="open-login">
    <?= $lang==='en'? 'Login':'Anmelden'?>
  </a></p>

      <?php if(!empty($errorsRegister)): ?>
        <div class="alert alert-error"><ul>
          <?php foreach($errorsRegister as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
          <?php endforeach ?>
        </ul></div>
      <?php endif ?>

      <form method="post" action="<?= url('account/register') ?>">

        <!-- Anrede / Title -->
        <div class="form-row">
        <label><?= $lang==='en'?'Title':'Anrede' ?> *</label>
        <?php foreach([
            'male'    => $lang==='en'?'Mr.':'Herr',
            'female'  => $lang==='en'?'Mrs.':'Frau',
            'none'    => $lang==='en'?'No title':'ohne Angabe',
            'company' => $lang==='en'?'Company':'Firma',
          ] as $val => $lbl): ?>
          <label class="radio-inline">
            <input 
              type="radio" 
              name="title" 
              value="<?= $val ?>" 
              <?= ($regTitle === $val) ? 'checked' : '' ?>
              required
            >
            <?= $lbl ?>
          </label>
        <?php endforeach; ?>
      </div>

        <!-- Firmen-Felder -->
        <div id="company-fields" class="form-group"
             style="display:<?= ($regTitle??'')==='company'?'block':'none'?>;">
          <div class="form-row">
            <label><?= $lang==='en'? 'Company':'Firma'?> *</label>
            <input
              type="text"
              name="company"
              value="<?= htmlspecialchars($regCompany ?? '')?>"
            >
          </div>
          <div class="form-row">
            <label><?= $lang==='en'? 'VAT-ID':'Ust-ID-Nr.'?></label>
            <input
              type="text"
              name="vat_id"
              value="<?= htmlspecialchars($regVatId ?? '')?>"
            >
          </div>
        </div>

        <!-- Privat-Felder -->
        <div class="form-row">
          <label><?= $lang==='en'? 'First name':'Vorname'?> *</label>
          <input
            type="text"
            name="first_name"
            required
            value="<?= htmlspecialchars($regFirstName ?? '')?>"
          >
        </div>
        <div class="form-row">
          <label><?= $lang==='en'? 'Last name':'Nachname'?> *</label>
          <input
            type="text"
            name="last_name"
            required
            value="<?= htmlspecialchars($regLastName ?? '')?>"
          >
        </div>

        <!-- Adresse -->
        <div class="form-row street-row">
          <div>
            <label><?= $lang==='en'? 'Street':'Straße'?> *</label>
            <input
              type="text"
              name="street"
              required
              value="<?= htmlspecialchars($regStreet ?? '')?>"
            >
          </div>
          <div>
            <label><?= $lang==='en'? 'No.':'Nr.'?> *</label>
            <input
              type="text"
              name="street_number"
              required
              value="<?= htmlspecialchars($regStreetNr ?? '')?>"
            >
          </div>
        </div>
        <div class="form-row">
          <label><?= $lang==='en'? 'Address addition':'Adresszusatz'?></label>
          <input
            type="text"
            name="address_addition"
            value="<?= htmlspecialchars($regAddressAdd ?? '')?>"
          >
        </div>
        <div class="form-row zip-city-row">
          <div>
            <label><?= $lang==='en'? 'Postal code':'Postleitzahl'?> *</label>
            <input
              type="text"
              name="postal_code"
              required
              value="<?= htmlspecialchars($regPostalCode ?? '')?>"
            >
          </div>
          <div>
            <label><?= $lang==='en'? 'City':'Ort'?> *</label>
            <input
              type="text"
              name="city"
              required
              value="<?= htmlspecialchars($regCity ?? '')?>"
            >
          </div>
        </div>

        <!-- Country -->
        <div class="form-row">
          <label><?= $lang==='en'? 'Country':'Land'?> *</label>
          <select name="country_code" required>
            <?php foreach($countries as $c): ?>
            <option
              value="<?= $c['code']?>"
              <?= ($regCountry??'')===$c['code']? 'selected':''?>
            ><?= $lang==='en'? $c['name_en']:$c['name_de']?></option>
            <?php endforeach ?>
          </select>
        </div>

            <!-- Checkbox: Abweichende Lieferadresse -->
    <div class="form-row">
      <label>
        <input 
          type="checkbox" 
          id="use-shipping" 
          name="use_shipping"
          <?= !empty($regUseShipping)? 'checked':'' ?>
        >
        <?= $lang==='en'
            ? 'Ship to a different address'
            : 'Abweichende Lieferadresse angeben' ?>
      </label>
    </div>

    <!-- Shipping Address Fields (initial versteckt) -->
    <div id="shipping-fields" style="display:<?= !empty($regUseShipping)?'block':'none' ?>; margin-left:1rem; border-left:2px solid #ddd; padding-left:1rem;">
      <h3><?= $lang==='en'?'Shipping Address':'Lieferadresse' ?></h3>

      <div class="form-row">
        <label><?= $lang==='en'?'First name':'Vorname' ?> *</label>
        <input type="text" name="ship_first_name" value="<?= htmlspecialchars($regShipFirstName??'') ?>">
      </div>
      <div class="form-row">
        <label><?= $lang==='en'?'Last name':'Nachname' ?> *</label>
        <input type="text" name="ship_last_name" value="<?= htmlspecialchars($regShipLastName??'') ?>">
      </div>
      <div class="form-row street-row">
        <div>
          <label><?= $lang==='en'?'Street':'Straße' ?> *</label>
          <input type="text" name="ship_street" value="<?= htmlspecialchars($regShipStreet??'') ?>">
        </div>
        <div>
          <label><?= $lang==='en'?'No.':'Nr.' ?> *</label>
          <input type="text" name="ship_street_number" value="<?= htmlspecialchars($regShipStreetNr??'') ?>">
        </div>
      </div>
      <div class="form-row">
        <label><?= $lang==='en'?'Address addition':'Adresszusatz' ?></label>
        <input type="text" name="ship_adressadd" value="<?= htmlspecialchars($regShipAddressAdd??'') ?>">
      </div>
      <div class="form-row zip-city-row">
        <div>
          <label><?= $lang==='en'?'Postal code':'Postleitzahl' ?> *</label>
          <input type="text" name="ship_postal_code" value="<?= htmlspecialchars($regShipPostalCode??'') ?>">
        </div>
        <div>
          <label><?= $lang==='en'?'City':'Ort' ?> *</label>
          <input type="text" name="ship_city" value="<?= htmlspecialchars($regShipCity??'') ?>">
        </div>
      </div>
      <div class="form-row">
        <label><?= $lang==='en'?'Country':'Land' ?> *</label>
        <select name="ship_country_code">
          <?php foreach($countries as $c): ?>
          <option
             value="<?= $c['code'] ?>"
             <?= ( ($regShipCountry??'')===$c['code'] )?'selected':'' ?>>
            <?= $lang==='en'? $c['name_en'] : $c['name_de'] ?>
          </option>
          <?php endforeach ?>
        </select>
      </div>
    </div>


        <!-- Login-Daten -->
        <div class="form-row">
          <label for="reg-email">
            <?= $lang==='en'? 'Email':'E-Mail'?> *
          </label>
          <input
            type="email"
            id="reg-email"
            name="email"
            required
            value="<?= htmlspecialchars($regEmail ?? '')?>"
          >
          <div id="email-check-msg" class="email-check-msg"></div>
        </div>
        <div class="form-row">
          <label for="reg-password">
            <?= $lang==='en'? 'Password':'Passwort'?> *
          </label>
          <input
            type="password"
            id="reg-password"
            name="password"
            required
          >
        </div>
        <div class="form-row">
          <label for="reg-password2">
            <?= $lang==='en'? 'Confirm Password':'Passwort wiederholen'?> *
          </label>
          <input
            type="password"
            id="reg-password2"
            name="password2"
            required
          >
        </div>

        <!-- Opt-Ins -->
        <div class="form-row">
          <label>
            <input
              type="checkbox"
              name="newsletter_opt_in"
              <?= !empty($regNewsletter)? 'checked':''?>
            > <?= $lang==='en'?
               'Yes, I’d like to stay on board and receive the free newsletter by email (unsubscribe anytime).':
               'Ja, ich möchte an Bord bleiben und den kostenlosen Newsletter per E-Mail erhalten (jederzeit abbestellbar).'?>
          </label>
        </div>
        <div class="form-row">
          <label>
            <input
              type="checkbox"
              name="terms_agreed"
              required
            > <?= $lang==='en'
               ? 'I agree to the <a href="'.$baseUrl.'/terms">Terms & Conditions</a> and <a href="'.$baseUrl.'/privacy">Privacy&nbsp;Policy</a>.'
               : 'Ich stimme den <a href="'.$baseUrl.'/agb">AGB</a> und der <a href="'.$baseUrl.'/datenschutz">Datenschutzerklärung</a> zu.'?>
          </label>
        </div>

        <button type="submit" class="btn-primary">
          <?= $lang==='en'? 'Register now':'Jetzt registrieren'?>
        </button>
      </form>
    </section>

  </div>
</main>

<?php require __DIR__ . '/../../inc/footer.php'; ?>

<!-- Tab-Wechsel -->
<script>
  document.querySelectorAll('.tab-button').forEach(btn=>{
    btn.addEventListener('click',()=>{
      document.querySelectorAll('.tab-button').forEach(b=>b.classList.remove('active'));
      document.querySelectorAll('.tab-panel').forEach(p=>p.classList.remove('active'));
      btn.classList.add('active');
      document.querySelector(btn.dataset.target).classList.add('active');
    });
  });
  // Company-Felder umschalten
  document.querySelectorAll('input[name="title"]').forEach(radio=>{
    radio.addEventListener('change',()=>{
      document.getElementById('company-fields').style.display =
        radio.value==='company' ? 'block':'none';
    });
  });
  // Wenn man auf „Registrieren“ klickt, aktiviere das Registrieren-Tab
document.querySelector('.open-register').addEventListener('click', function(e){
  e.preventDefault();
  // 1) Tab-Button umschalten
  var btn = document.querySelector('.tab-button[data-target="#register-tab"]');
  btn.click();
});
  // Wenn man auf Login klickt, aktiviere das Login-Tab
document.querySelector('.open-login').addEventListener('click', function(e){
  e.preventDefault();
  // 1) Tab-Button umschalten
  var btn = document.querySelector('.tab-button[data-target="#login-tab"]');
  btn.click();
});

</script>
<!-- am Ende von views/account/login.php, direkt vor </body> bzw. vor deinem bestehenden Tab-Script -->
<script>
document.addEventListener('DOMContentLoaded', function(){
  // 1) On load: check hash, activate matching tab
  const hash = window.location.hash;
  if(hash) {
    const targetBtn = document.querySelector(`.tab-button[data-target="${hash}"]`);
    if(targetBtn) {
      targetBtn.click();
    }
  }

  // 2) Attach click handlers
  document.querySelectorAll('.tab-button').forEach(btn => {
    btn.addEventListener('click', () => {
      // Switch URL hash (without adding to history twice)
      if(window.location.hash !== btn.dataset.target) {
        history.replaceState(null, '', btn.dataset.target);
      }

      // Activate tabs/panels (you probably already have this)
      document.querySelectorAll('.tab-button').forEach(b=>b.classList.remove('active'));
      btn.classList.add('active');
      document.querySelectorAll('.tab-panel').forEach(p=>p.classList.remove('active'));
      document.querySelector(btn.dataset.target).classList.add('active');
    });
  });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function(){
  // Referenzen
  const emailInput  = document.getElementById('login-email');
  const forgotLink  = document.getElementById('forgot-password-link');
  const registerBtn = document.getElementById('switch-to-register');

  // Hilfsfunktion: updatet href auf /account/forgot-password?email=...
  function updateForgotHref() {
    const mail = encodeURIComponent(emailInput.value.trim());
    forgotLink.href = '<?= $baseUrl ?>/account/forgotpassword' + (mail ? '?email=' + mail : '');
  }

  // Beim Tippen E-Mail updaten
  emailInput.addEventListener('input', updateForgotHref);
  // initial setzen
  updateForgotHref();

  // Registrieren-Link öffnet den Register-Tab
  registerBtn.addEventListener('click', function(e){
    e.preventDefault();
    // setze URL-Hash auf #register-tab
    history.replaceState(null,'','#register-tab');
    // simuliere Tab-Klick
    document.querySelector('.tab-button[data-target="#register-tab"]').click();
  });
});
// Shipping-Section umschalten
document.getElementById('use-shipping').addEventListener('change', function(){
  document.getElementById('shipping-fields').style.display =
    this.checked ? 'block' : 'none';
});

</script>
<script>
document.addEventListener('DOMContentLoaded', function(){
  const emailInput = document.getElementById('reg-email');
  const msgDiv     = document.getElementById('email-check-msg');
  let timer;

  emailInput.addEventListener('input', function(){
    clearTimeout(timer);
    msgDiv.style.display = 'none';
    msgDiv.classList.remove('ok');

    const email = emailInput.value.trim();
    if (!email || !email.includes('@')) {
      return;
    }

    timer = setTimeout(()=>{
      fetch(`<?= $baseUrl ?>/account/checkemail?email=${encodeURIComponent(email)}`)
        .then(r => r.json())
        .then(data => {
          if (data.exists) {
            msgDiv.innerHTML = `
              <?= $lang==='en'
                ? "This email is already registered. <a href='</account/login'>Login</a>"
                : "Diese E-Mail ist bereits registriert. <a href='/account/login'>Anmelden</a>"
              ?>`;
            msgDiv.classList.remove('ok');
            msgDiv.style.display = 'block';
          } else {
            msgDiv.innerHTML = `
              <?= $lang==='en'
                ? "Email is available!"
                : "E-Mail verfügbar!"
              ?>`;
            msgDiv.classList.add('ok');
            msgDiv.style.display = 'none';
          }
        });
    }, 500);
  });
});
</script>
