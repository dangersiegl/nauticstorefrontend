<?php
// inc/cookie-consent-banner.php
// Hier gehen wir davon aus, dass $lang und $config bereits durch Deinen Header
// zur Verfügung stehen (z.B. in inc/header.php geladen).

// Zwei verschiedene GA-Measurement-IDs in Deiner config.php hinterlegen:
//   $this->gaIdDe = 'GA-MEASUREMENT-ID-DE';
//   $this->gaIdEn = 'GA-MEASUREMENT-ID-EN';
$gaId = ($lang === 'en')
    ? ($config->gaIdEn ?? 'GA_MEASUREMENT_ID_EN')
    : ($config->gaIdDe ?? 'GA_MEASUREMENT_ID_DE');
?>
<style>
  #cookie-banner {
    position: fixed;
    bottom: 0; left: 0; right: 0;
    background: #004974;
    color: #fff;
    font-family: sans-serif;
    padding: 1rem;
    box-shadow: 0 -2px 6px rgba(0,0,0,0.3);
    display: none;
    z-index: 10000;
  }
  #cookie-banner h4 {
    margin: 0 0 0.5rem;
    font-size: 1.1rem;
  }
  #cookie-banner p {
    margin: 0 0 0.75rem;
    font-size: 0.95rem;
    line-height: 1.4;
  }
  #cookie-banner a {
    color: #fff;
    text-decoration: underline;
  }
  #cookie-banner .actions {
    text-align: right;
  }
  #cookie-banner .actions button,
  #cookie-banner .actions a {
    display: inline-block;
    margin-left: 0.5rem;
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
    border-radius: 3px;
    text-decoration: none;
    cursor: pointer;
    border: none;
  }
  #cookie-banner .actions .btn-secondary {
    background: #073763;
    color: #fff;
  }
  #cookie-banner .actions .btn-primary {
    background: #fff;
    color: #073763;
  }
</style>

<div id="cookie-banner">
  <!--<h4>
    <?= $lang === 'en'
         ? 'We use cookies on this website'
         : 'Auf unserer Website werden Cookies verwendet' ?>
  </h4>
  <p>
    <?= $lang === 'en'
         ? 'We use cookies to make your shopping experience as easy and pleasant as possible. By continuing to browse, you agree to our use of cookies.'
         : 'Wir nutzen Cookies, um Ihnen den Einkauf so einfach und angenehm wie möglich zu gestalten. Mit der Nutzung unserer Seite erklären Sie sich damit einverstanden, dass wir Cookies setzen.' ?>-->

    <h4>
    <?= $lang === 'en'
        ? 'Cookies on board – for smooth sailing while shopping!'
        : 'Cookies an Deck – für ruhige See beim Einkaufen!' ?>
    </h4>
    <p>
    <?= $lang === 'en'
        ? 'We use cookies to make your visit as pleasant as possible. By continuing to use the site, you agree to the use of cookies.'
        : 'Wir setzen Cookies ein, um Ihnen den Aufenthalt bei uns so angenehm wie möglich zu machen. Mit der Nutzung der Seite erklären Sie sich einverstanden.' ?>

    <br>
    <a href="#" id="cookie-decline">
      <?= $lang === 'en'
           ? 'Accept only necessary'
           : 'Nur notwendige akzeptieren' ?>
    </a>
  </p>
  <div class="actions">
    <a href="<?= $baseUrl . '/' . ($lang === 'en' ? 'privacy' : 'datenschutz') ?>"
       class="btn-secondary"
       id="cookie-more">
      <?= $lang === 'en'
           ? 'Learn more…'
           : 'Erfahren Sie mehr…' ?>
    </a>
    <button class="btn-primary" id="cookie-accept">
      <?= $lang === 'en'
           ? 'Accept all'
           : 'Akzeptieren' ?>
    </button>
  </div>
</div>

<script>
(function(){
  var banner  = document.getElementById('cookie-banner');
  var consent = localStorage.getItem('cookie_consent');

  if (!consent) {
    banner.style.display = 'block';
  } else if (consent === 'all') {
    loadAnalytics();
  }

  document.getElementById('cookie-accept').onclick = function(){
    localStorage.setItem('cookie_consent','all');
    banner.style.display = 'none';
    loadAnalytics();
  };

  document.getElementById('cookie-decline').onclick = function(e){
    e.preventDefault();
    localStorage.setItem('cookie_consent','necessary');
    banner.style.display = 'none';
    // kein Analytics laden
  };

  document.getElementById('cookie-more').onclick = function(e){
    // Link geht direkt auf die Datenschutz-Seite
    // Default-Verhalten zulassen oder per JS umleiten
  };

  function loadAnalytics(){
    if (window.gaLoaded) return;
    window.gaLoaded = true;
    window.dataLayer = window.dataLayer || [];
    function gtag(){ dataLayer.push(arguments); }
    gtag('js', new Date());
    gtag('config','<?= $gaId ?>',{ 'anonymize_ip': true });

    var s = document.createElement('script');
    s.async = true;
    s.src   = 'https://www.googletagmanager.com/gtag/js?id=<?= $gaId ?>';
    document.head.appendChild(s);
  }
})();
</script>
