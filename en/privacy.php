<?php
// en/privacy.php

// CSS for this page
$pageCss        = 'terms.css';
$pageTitle      = 'Privacy Policy';
$pageDescription= 'Learn how we handle your data: storage, deletion, access, sharing and protection measures at Nauticstore24.';

// Header loads $lang, $baseUrl, $t and your cookie-consent include
require __DIR__ . '/../inc/header.php';
?>

<main class="terms-page container">
  <h1 class="page-title">Privacy Policy</h1>

  <section class="section-privacy">
    <h2>Our Data Protection Principles</h2>
    <ul>
      <li>We strive to collect only the data we really need to provide our services.</li>
      <li>We operate our own cloud for encrypted data exchange within our organization.</li>
      <li>Insecure communications (e.g. email) are migrated to secure channels (cloud/encrypted chat) as soon as possible.</li>
      <li>All portable hard drives are encrypted. Unencrypted USB sticks are used sparingly and only for public data (e.g. presentations, drivers).</li>
      <li>All mobile devices are encrypted wherever technically possible.</li>
      <li>Facilities that cannot be encrypted for technical reasons are locked away from public access.</li>
      <li>Coordinated Vulnerability Disclosure (CVD) / Report a security issue</li>
    </ul>

    <h2>Collection</h2>
    <p>Your data is collected either directly by our staff or by you through this portal.</p>

    <h2>Storage</h2>
    <p>In the active system, data is stored on servers we control.</p>
    <p>In our archive systems, your data resides on encrypted disks and locked servers without regular staff access.</p>

    <h2>Access & Use</h2>
    <p>Our employees access your data only through secure, 2-factor-protected portal interfaces.</p>

    <h2>Deletion & Archiving</h2>
    <p>You can request deletion of your data from the active system at any time. Data is also deleted automatically when you close your account.</p>
    <p>In archives, data is kept for up to 10 years. Individual records cannot be removed from backups for technical reasons and are only accessible by authorized persons after internal training.</p>
    <p>Backups are used solely for recovery, debugging, or compliance with lawful requests. They are never used for marketing or restoring data you asked to delete.</p>
    <p>Any data disclosure to courts or authorities only occurs after consulting our Data Protection Officer. If legally permissible, we will inform you in advance.</p>
    <ul>
      <li>Portal backups: up to 10 years</li>
      <li>Invoice data: up to 10 years</li>
      <li>Log files: up to 90 days</li>
      <li>IP addresses of login attempts: up to 90 days</li>
      <li>Browser info on login attempts: up to 90 days</li>
      <li>Other backups: up to 90 days</li>
    </ul>

    <h2>Data Sharing within the EU</h2>
    <p>We share your data for:</p>
    <ul>
      <li>Communication (mail, email, phone)</li>
      <li>Contract fulfillment (e.g. bank details)</li>
      <li>Lawful court or official requests</li>
    </ul>
    <p>Disclosure to courts/authorities only after consulting our DPO, and we will inform you if legally allowed.</p>

    <h2>Transfers to Third Countries</h2>
    <p>No planned transfers to non-EU countries, except at your request (e.g. shipping address abroad).</p>

    <h2>Cookies & External Services</h2>
    <p>We use cookies, Cloudflare and hCaptcha to ensure functionality, improve service and protect against attacks.</p>
    <p>The following essential cookies are set on visit:</p>
    <ul>
      <li><strong>XSRF-TOKEN:</strong> Prevents CSRF attacks</li>
      <li><strong>laravel_token:</strong> CSRF protection</li>
      <li><strong>portal_name_session:</strong> Encrypted session storage</li>
      <li><strong>remember_web_<em>random</em>:</strong> Set when “remember me” is checked</li>
      <li><strong>browser_authentication:</strong> Reduces CAPTCHA prompts</li>
    </ul>
    <p>
      <strong>When needed:</strong><br>
      <strong>Cloudflare:</strong> DDoS protection<br>
      <strong>hCaptcha:</strong> Prevents automated login attacks<br>
      <strong>Vimeo & YouTube:</strong> Cookies for video loading<br>
      <strong>__stripe_mid:</strong> Fraud prevention by Stripe<br>
      <strong>Matomo:</strong> Analytics cookies for anonymized stats (see Matomo docs)
    </p>

    <h2>Privacy Tips for Browsing</h2>
    <p>
      To block tracking cookies, use DuckDuckGo (app or extension) or Privacy Badger with Do Not Track. Note: this may limit functionality.
    </p>

    <h2>Your Settings</h2>
    <!-- Cookie-Status Toggle -->
    <div class="cookie-status">
      <label for="cookie-toggle">Accept only essential cookies</label>
      <input type="checkbox" id="cookie-toggle">
    </div>
  </section>
</main>

<script>
(function(){
  const toggle = document.getElementById('cookie-toggle');
  const saved  = localStorage.getItem('cookie_consent') || 'necessary';

  // initial state: checked = necessary-only
  toggle.checked = (saved === 'necessary');

  toggle.addEventListener('change', () => {
    if (toggle.checked) {
      localStorage.setItem('cookie_consent','necessary');
      console.log('Essential cookies only');
      // you could reload or disable analytics here
    } else {
      localStorage.setItem('cookie_consent','all');
      console.log('All cookies accepted');
      // loadAnalytics(); // if you have the GA loader function globally
    }
  });
})();
</script>

<?php
require __DIR__ . '/../inc/footer.php';
