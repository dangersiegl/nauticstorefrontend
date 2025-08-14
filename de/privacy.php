<?php
// de/privacy.php

// CSS für diese Seite
$pageCss = 'terms.css';
$pageTitle       = 'Datenschutzerklärung';            // e.g. “Kontakt”
$pageDescription = 'Erfahren Sie, wie wir mit Ihren Daten umgehen: Speicherung, Löschung, Zugriff, Weitergabe und Schutzmaßnahmen auf Nauticstore24.';  // optional

// Header lädt bereits $lang, $baseUrl und $t (Übersetzungen)
require __DIR__ . '/../inc/header.php';
?>

<main class="terms-page container">
  <h1 class="page-title">Datenschutzerklärung</h1>

  <section class="section-privacy">
    <h2>Unsere Datenschutzprinzipien</h2>
    <ul>
      <li>Wir bemühen uns, nur die Daten zu sammeln, die wir tatsächlich für die Bereitstellung unserer Services benötigen.</li>
      <li>Wir betreiben für unsere Zwecke eine eigene Cloud zum verschlüsselten Austausch von Daten im Betrieb.</li>
      <li>Unsichere Kommunikation (z. B. per E-Mail) wird so bald wie möglich auf sichere Kommunikationsmittel (z. B. eigene Cloud / verschlüsselte Chats) umgeleitet.</li>
      <li>Alle mobilen Festplatten sind verschlüsselt. Unverschlüsselte USB-Sticks werden nur sparsam und nur für öffentliche Daten eingesetzt (z. B. für Vorträge, Präsentationen, Gerätetreiber).</li>
      <li>Alle mobilen Endgeräte sind, soweit technisch möglich, verschlüsselt. Jedenfalls sind alle Datenträger, auf denen Daten systematisch gespeichert werden, verschlüsselt.</li>
      <li>Einrichtungen, die sich aus technischen Gründen nicht verschlüsseln lassen, sind außerhalb der von Betriebsfremden zugänglichen Bereiche versperrt.</li>
      <li>Coordinated Vulnerability Disclosure (CVD) / Sicherheitslücke melden</li>
    </ul>

    <h2>Sammlung</h2>
    <p>
      Ihre Daten werden von unseren Mitarbeiter:innen persönlich oder von Ihnen über dieses Portal erfasst.
    </p>

    <h2>Speicherung</h2>
    <p>
      Im Aktivsystem sind die Daten auf von uns kontrollierten Servern gespeichert.
    </p>
    <p>
      In unseren Archivsystemen sind Ihre Daten auf verschlüsselten Festplatten und versperrten Servern gespeichert, auf die Mitarbeiter:innen im Regelbetrieb keinen direkten Zugriff haben.
    </p>

    <h2>Zugriff und Nutzung</h2>
    <p>
      Unsere Mitarbeiter:innen können über zugriffsgeschützte, zwei-faktor-authentifizierte Portaloberflächen auf Ihre Daten zugreifen.
    </p>

    <h2>Löschung und Archiv</h2>
    <p>
      Aus dem Aktivsystem werden Ihre Daten jederzeit auf Anfrage gelöscht. Ihre Daten werden automatisch gelöscht, wenn Sie Ihren Account bei uns schließen.
    </p>
    <p>
      In den Archivsystemen werden Ihre Daten bis zu 10 Jahre aufbewahrt (siehe unten). Ihre individuellen Daten können aus (Datenbank-)Sicherungen aufgrund technischer Einschränkungen nicht gelöscht werden. Ausschließlich benannte Personen des Verantwortlichen und der Datenverarbeiter, mit speziellen Berechtigungen und nachdem diese eine interne Datenschutzschulung absolviert haben, können auf diese Sicherungen zugreifen.
    </p>
    <p>
      Sicherungen werden ausschließlich genutzt, um Dienste wiederherzustellen, Fehler zu finden oder um Daten für zumutbare und rechtsgültige Anfragen durch Gerichte und Behörden bereitzustellen. Keinesfalls werden Sicherungen genutzt, um Marketinganalysen durchzuführen oder um Daten wiederherzustellen, die Sie gelöscht haben wollten.
    </p>
    <p>
      Wenn Daten an Gerichte und Behörden übermittelt werden, geschieht dies nur in Rücksprache mit unserem Datenschutzbeauftragten. Sofern es uns nicht gesetzlich verboten ist, werden wir Sie zuvor kontaktieren, um Sie über diese Datenweitergabe zu informieren.
    </p>
    <ul>
      <li>Datenbanksicherungen des Portals: bis zu 10 Jahre</li>
      <li>Rechnungsdaten: bis zu 10 Jahre</li>
      <li>Log-Files des Portals: bis zu 90 Tage</li>
      <li>IP-Adressen erfolgreicher und fehlgeschlagener Anmeldeversuche: bis zu 90 Tage</li>
      <li>Browser-Plattformen, -Namen und -Versionen bei Anmeldeversuchen: bis zu 90 Tage</li>
      <li>Sonstige Sicherungen des Portals: bis zu 90 Tage</li>
    </ul>

    <h2>Datenweitergabe innerhalb von EU-Mitgliedsstaaten</h2>
    <p>
      Ihre Daten werden von uns zu folgenden Zwecken weitergegeben:
    </p>
    <ul>
      <li>Kommunikation (z. B. Post, E-Mail, Telefon)</li>
      <li>Vertragserfüllung (z. B. Bankverbindung)</li>
      <li>Auf zumutbare und rechtsgültige gerichtliche oder amtliche Aufforderung</li>
    </ul>
    <p>
      Wenn Daten an Gerichte und Behörden übermittelt werden, geschieht dies nur in Rücksprache mit unserem Datenschutzbeauftragten. Sofern es uns nicht gesetzlich verboten ist, werden wir Sie zuvor kontaktieren, um Sie über diese Datenweitergabe zu informieren.
    </p>

    <h2>Datenweitergabe zu Drittstaaten</h2>
    <p>
      Es findet keine geplante Weitergabe Ihrer Daten an Drittstaaten oder internationale Organisationen statt. Ausnahmen sind Ihre persönlichen Anforderungen (z. B. Kontaktadresse im EU-Ausland).
    </p>

    <h2>Cookies und externe Dienste</h2>
    <p>
      Diese Onlineanwendung nutzt Cookies, Cloudflare und hCaptcha, um Funktionen bereitzustellen, den Service zu verbessern und das Portal vor Angriffen zu schützen.
    </p>
    <p>
      Beim Besuch unseres Portals werden folgende Cookies gesetzt, die für den Betrieb notwendig sind:
    </p>
    <ul>
      <li><strong>XSRF-TOKEN:</strong> Bekämpfung von Cross-Site-Request-Forgery.</li>
      <li><strong>laravel_token:</strong> Unterstützung bei Cross-Site-Request-Forgery.</li>
      <li><strong>portal_name_session:</strong> Sichere, verschlüsselte Speicherung Ihrer aktuellen Sitzungsdaten.</li>
      <li><strong>remember_web_<em>Zufallszeichen</em>:</strong> Wird gesetzt, wenn Sie „Dauerhaft anmelden“ aktivieren.</li>
      <li><strong>browser_authentication:</strong> Reduziert CAPTCHA-Anfragen im aktuellen Browser.</li>
    </ul>
    <p>
      <strong>Im Bedarfsfall:</strong><br>
      <strong>Cloudflare:</strong> Abwehr von DDoS-Angriffen bei sensiblen Diensten.<br>
      <strong>hCaptcha:</strong> Diese Cookies werden beim Anzeigen eines Anmeldeformulars gesetzt und schützen vor automatisierten Passwortangriffen.<br>
      <strong>Vimeo & YouTube:</strong> Setzen Cookies, wenn Video-Inhalte geladen werden.<br>
      <strong>__stripe_mid:</strong> Betrugsprävention durch Stripe.<br>
      <strong>Matomo:</strong> Für Analyse-Cookies, um anonyme Besucher-Statistiken zu ermöglichen (Details bei Matomo).
    </p>

    <h2>Tipps für Privatsphäre beim Browsen</h2>
    <p>
      Um Tracking-Cookies zu blockieren, empfehlen wir die Verwendung von DuckDuckGo (App und Browser-Erweiterung) oder der Privacy Badger-Erweiterung, die auf Wunsch „Do Not Track“ sendet. Ein externes DNT-Signal kann jedoch zu eingeschränkter Funktionalität führen.
    </p>

    <h2>Ihre Einstellungen</h2>
    <!-- Cookie-Status Toggle -->
    <div class="cookie-status">
        <label for="cookie-toggle">Akzeptieren Sie nur notwendige Cookies</label>
        <input type="checkbox" id="cookie-toggle">
    </div>
  </section>
</main>

<script>
(function(){
  const toggle = document.getElementById('cookie-toggle');
  const saved = localStorage.getItem('cookie_consent') || 'necessary';

  // Schalterstellung initial setzen
  toggle.checked = (saved === 'necessary');

  // Wenn der Benutzer den Schalter umlegt:
  toggle.addEventListener('change', () => {
    if (toggle.checked) {
      // nur notwendige Cookies
      localStorage.setItem('cookie_consent', 'necessary');
      // ggf. Analytics deinitialisieren oder Seite neu laden:
      console.log('Nur notwendige Cookies aktiviert');
    } else {
      // alle Cookies akzeptieren
      localStorage.setItem('cookie_consent', 'all');
      // Analytics nachladen
      loadAnalytics();
      console.log('Alle Cookies akzeptiert');
    }
  });
})();
</script>


<?php
require __DIR__ . '/../inc/footer.php';
?>
