<?php
// de/terms.php

// CSS for this page
$pageCss = 'terms.css';
$pageTitle       = 'AGB';            // e.g. “Kontakt”
$pageDescription = 'Hier finden Sie die Allgemeinen Geschäftsbedingungen (AGB) von Nauticstore24: Geltungsbereich, Vertragsabschluss, Rücktritt, Versand, Rückgabe und mehr.';  // optional

// Load header (provides $lang, $baseUrl, $t etc.)
require __DIR__ . '/../inc/header.php';
?>

<main class="terms-page container">
  <h1 class="page-title">Allgemeine Geschäftsbedingungen (AGB)</h1>
  <a href="<?= htmlspecialchars($baseUrl . '/assets/docs/AGB_2024-01-22.pdf') ?>"
     class="btn-download" download>AGB herunterladen (2024-01-22)</a>

  <section class="agb-content">
    <h2>1. Geltungsbereich</h2>
    <p>Für die Geschäftsbeziehung zwischen NAUTICSTORE24 und dem Besteller gelten die nachfolgenden
    Allgemeinen Geschäftsbedingungen in ihrer zum Zeitpunkt der Bestellung gültigen Fassung. Abweichende
    Bedingungen des Bestellers erkennt NAUTICSTORE24 nicht an, es sei denn, NAUTICSTORE24 hätte
    ausdrücklich schriftlich ihrer Geltung zugestimmt.</p>

    <h2>2. Vertragspartner, Kundendienst</h2>
    <p>Der Kaufvertrag kommt mit der Firma Thomas Dall, im Nachfolgenden als NAUTICSTORE24 bezeichnet,
    zustande. Nähere Informationen zu uns sind in unserem Impressum zu finden. Für Fragen,
    Reklamationen und Beanstandungen können Sie unseren Kundendienst Mo–Fr 8:00 – 14:00 Uhr unter der
    Telefonnummer <a href="tel:+43723238888">0043 7232 38888</a> kontaktieren.</p>

    <h2>3. Vertragsschluss und Rücktritt</h2>
    <p>Mit Einstellung der Produkte auf NAUTICSTORE24 geben wir ein verbindliches Angebot zum
    Vertragsschluss über diese Artikel ab. Der Vertrag kommt zustande, indem Sie durch Anklicken des
    Bestellbuttons das Angebot über die im Warenkorb enthaltenen Waren annehmen. Unmittelbar nach dem
    Absenden der Bestellung erhalten Sie noch einmal eine Bestätigung per E-Mail. Bei Schreib-, Druck- und
    Rechenfehlern auf der Website ist NAUTICSTORE24 zum Rücktritt berechtigt. Alle Angebote sind gültig
    solange der Vorrat reicht. Falls der Lieferant von NAUTICSTORE24 trotz vertraglicher Verpflichtung
    NAUTICSTORE24 nicht mit der bestellten Ware beliefert, ist NAUTICSTORE24 ebenfalls zum Rücktritt
    berechtigt. In diesem Fall wird der Besteller unverzüglich darüber informiert, dass das bestellte Produkt
    nicht zur Verfügung steht. Der bereits bezahlte Kaufpreis wird unverzüglich erstattet.</p>

    <h2>4. Bezahlung</h2>
    <p>Die Zahlung erfolgt per:</p>
    <ul>
      <li><strong>Vorauskasse</strong><br>
          Wir nennen Ihnen unsere Bankverbindung in der Auftragsbestätigung und liefern die Ware nach Zahlungseingang.</li>
      <li><strong>Kreditkarte</strong><br>
          Die Belastung Ihrer Kreditkarte erfolgt mit Abschluss der Zahlung.</li>
      <li><strong>PayPal</strong><br>
          Sie bezahlen über PayPal — Ihr Konto wird unmittelbar nach Bestellung belastet.</li>
      <li><strong>Sofortüberweisung</strong><br>
          Sie werden zu Ihrem Online-Banking weitergeleitet und bestätigen die Überweisung via PIN/TAN.</li>
      <li><strong>Barzahlung bei Abholung</strong><br>
          Barzahlung an einem unserer Standorte.</li>
    </ul>

    <h2>5. Versand/Versandkosten</h2>
    <p>Lieferungen nach Österreich und Deutschland erfolgen ab einem Bestellwert von € 170 völlig
    versandkostenfrei. Für Bestellungen unter € 170,- fallen Versandkosten von € 7,10 nach Österreich
    und € 9,10 nach Deutschland an. Die übrigen Versandkosten finden Sie
    <a href="versand" target="_blank">hier</a>.</p>
    <p>Manche Artikel werden in mehreren Paketen verschickt, da sie aus externen Lagern/Streckengeschäften
    kommen. Teilweise kann es zu längeren Lieferzeiten kommen.</p>

    <h2>6. Lieferung</h2>
    <p>Sofern nicht anders vereinbart, erfolgt die Lieferung ab Lager an die vom Besteller angegebene
    Lieferadresse. Die Gefahr geht auf den Besteller über, sobald der Paket- oder Postdienst die Ware
    übergibt.</p>

    <h2>7. Verzug</h2>
    <p>Kommt der Besteller in Zahlungsverzug, kann NAUTICSTORE24 Verzugszinsen in Höhe von 4 % über dem
    ÖNB-Basiszinssatz p.a. verlangen. Höhere Schäden können nachgewiesen geltend gemacht werden. Zahlungen
    sind spätestens 7 Tage nach Zahlungsaufforderung fällig.</p>

    <h2>8. Eigentumsvorbehalt</h2>
    <p>Bis zur vollständigen Begleichung aller Ansprüche bleibt die Ware im Eigentum von NAUTICSTORE24.</p>

    <h2>9. Aufrechnung, Zurückbehaltung</h2>
    <p>Ein Aufrechnungsrecht besteht nur bei rechtskräftig festgestellten oder schriftlich anerkannten
    Gegenansprüchen. Zurückbehaltung ist nur bei gleichem Vertragsverhältnis zulässig.</p>

    <h2>10. Mängelgewährleistung und Haftung</h2>
    <p>Bei Mängeln ist NAUTICSTORE24 nach Wahl zur Nachbesserung oder Ersatzlieferung berechtigt. Schlägt dies
    fehl, kann der Besteller Rücktritt oder Minderung verlangen. Weitere Ansprüche, insb. entgangener Gewinn,
    sind ausgeschlossen.</p>

    <h2>11. Transportschäden</h2>
    <p>Offensichtliche Transportschäden reklamieren Sie bitte sofort beim Zusteller und informieren uns.</p>

    <h2>12. Widerrufsbelehrung</h2>
    <h3>Widerrufsrecht</h3>
    <p>Sie können binnen 14 Tagen ohne Angabe von Gründen in Textform (E-Mail an
    <a href="mailto:shop@nauticstore24.at">shop@nauticstore24.at</a>) oder durch Rücksendung der Ware
    widerrufen. Das Formular können Sie <a href="<?= htmlspecialchars($baseUrl . '/assets/docs/RETOURENSCHEIN.pdf') ?>"
    class="btn-inline" download>hier herunterladen</a>.</p>
    <p>Die Frist beginnt nach Erhalt dieser Belehrung und der Ware. Zur Fristwahrung genügt die Absendung.</p>

    <h3>Widerrufsfolgen</h3>
    <p>Wir erstatten alle Zahlungen einschließlich Standardlieferkosten innerhalb von 14 Tagen nach
    Widerruf. Rücksendekosten trägt der Kunde. Wertminderungen aufgrund nicht notwendiger Nutzung
    gehen zu Lasten des Bestellers.</p>

    <h3>Ausschluss des Widerrufsrechts</h3>
    <p>Kein Widerrufsrecht bei massgefertigten/individuell zugeschnittenen Artikeln sowie entsiegelten
    Datenträgern (Audio/Video/Software).</p>

    <h2>13. Anwendbares Recht und Gerichtsstand</h2>
    <p>Es gilt österreichisches Recht. Gerichtsstand ist Rohrbach, Oberösterreich.</p>

    <h2>14. Vertragstextspeicherung</h2>
    <p>Wir speichern den Vertragstext und senden Ihnen Bestelldaten und AGB per E-Mail. Vergangene
    Bestellungen sind im Kunden-Login einsehbar.</p>

    <h2>15. Vertragssprache</h2>
    <p>Vertragssprache ist Deutsch.</p>

    <h2>16. Streitschlichtung</h2>
    <p>Die EU stellt eine Plattform zur Online-Streitbeilegung bereit:
    <a href="https://ec.europa.eu/consumers/odr/" target="_blank">https://ec.europa.eu/consumers/odr/</a>.</p>
  </section>
</main>

<?php
require __DIR__ . '/../inc/footer.php';
?>
