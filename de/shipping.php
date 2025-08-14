<?php
// de/terms.php

// CSS for this page
$pageCss = 'terms.css';
$pageTitle       = 'Versand & Lieferung';            // e.g. “Kontakt”
$pageDescription = 'Informationen zu Versandkosten, Lieferzeiten, internationalen Lieferungen und Rücksendungen bei Nauticstore24.';  // optional

// Load header (provides $lang, $baseUrl, $t etc.)
require __DIR__ . '/../inc/header.php';
?>

<main class="terms-page container">
  <h1 class="page-title">Versandbestimmungen</h1>

  <section class="section-shipping">
    <h2>Versandbestimmungen</h2>
    <p>Ab € 170,- Bestellwert liefern wir versandkostenfrei nach Österreich & Deutschland! Bestellungen auf Nauticstore24 werden innerhalb von Österreich und Deutschland ab einem Bestellwert von € 170,- völlig versandkostenfrei zugestellt (mit Ausnahme von Artikeln, die per Speditionsversand verschickt werden müssen). Für alle Bestellungen unter einem Bestellwert von € 170,- fallen nach Österreich € 7,56 und nach Deutschland € 11,64 Versandkosten an (mit Ausnahme von Artikeln, die per Speditionsversand verschickt werden müssen).</p>
    <p>Sofern nicht anders vereinbart, erfolgt die Lieferung ab Lager an Ihre angegebene Lieferadresse. Die Gefahr geht auf den Besteller über, sobald die Lieferung vom zustellenden Paket- oder Postdienst dem Kunden übergeben wird.</p>
  </section>

  <section class="section-international">
    <h2>Versandkosten außerhalb Österreich & Deutschland</h2>
    <ul>
      <li>Kroatien: € 17,40</li>
      <li>Belgien, Italien, Luxemburg, Niederlande, Slowakei, Slowenien, Tschechien, Ungarn: € 27,10</li>
      <li>Dänemark, Finnland, Frankreich, Polen, Schweden: € 33,84</li>
      <li>Schweiz: € 65,00</li>
      <li>Bulgarien, Estland, Griechenland, Irland, Lettland, Litauen, Malta, Portugal, Rumänien, Spanien, Zypern: € 57,84</li>
      <li>Island: € 241,20</li>
    </ul>
    <p>Bei manchen Artikeln kann ein Aufschlag für einen Speditionsversand hinzukommen.</p>
    <p>Bitte beachten Sie, dass es in manchen Gebieten (z. B. Inseln) ein begrenztes Gewicht gibt. Sollte eine Ware das Gewicht überschreiten, kann es sein, dass das Paket entweder an eine Festland-Adresse umgeleitet werden muss oder an uns zurückgeht.</p>
  </section>

  <section class="section-delivery-time">
    <h2>Lieferdauer</h2>
    <p>Die Bearbeitungszeit entnehmen Sie bitte der jeweiligen Artikelseite (Irrtümer durch Lieferengpässe unserer Lieferanten vorbehalten). Sollten Sie Artikel dringend benötigen, kontaktieren Sie uns bitte vor der Bestellung, um ungewollte Lieferverzögerungen zu vermeiden.</p>
    <h3>Postweg</h3>
    <p>Pakete innerhalb Österreichs werden in der Regel innerhalb von 1–2 Werktagen zugestellt, Sendungen nach Deutschland nach 2–3 Werktagen und in den Rest Europas nach 3–5 Werktagen.</p>
    <p>Vereinzelt kann es zu längeren Lieferzeiten kommen, insbesondere wenn Artikel direkt durch einen Lieferanten versendet werden.</p>
  </section>

  <section class="section-issues">
    <h2>Probleme mit der Lieferung?</h2>
    <p>Bei Lieferproblemen wenden Sie sich bitte an uns:</p>
    <p>E-Mail: <a href="mailto:shop@nauticstore24.at">shop@nauticstore24.at</a><br>
    Telefon: <a href="tel:+436643831509">+43 664 3831509</a></p>
  </section>

  <section class="section-tracking">
    <h2>Paketverfolgung</h2>
    <p>Mit der Trackingnummer, die Sie per E-Mail erhalten, können Sie den Versandstatus Ihrer Bestellung jederzeit online verfolgen.</p>
  </section>

  <section class="section-lost">
    <h2>Vermisstes Paket?</h2>
    <p>Ist Ihr Paket nach einer Woche nicht angekommen und wurde nicht bei Nachbarn abgegeben, kontaktieren Sie uns bitte. Wir prüfen den Verbleib und stellen bei Bedarf einen Nachforschungsauftrag.</p>
  </section>

  <section class="section-return-form">
    <h2>Retour-/Rücksendeschein</h2>
    <a href="<?= htmlspecialchars($baseUrl . '/assets/docs/RETOURENSCHEIN.pdf') ?>" class="btn-download" download>Retourenschein herunterladen</a>
  </section>
</main>

<?php
require __DIR__ . '/../inc/footer.php';
?>