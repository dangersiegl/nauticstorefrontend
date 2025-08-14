<?php
// views/account/wishlist.php
$pageCss   = 'account.css';
$pageTitle = ($lang==='en') ? 'My Wishlist' : 'Meine Wunschliste';
require __DIR__ . '/../../inc/header.php';
?>

<?php
// kurze Helfer-Funktion oder Session-Check
function isLoggedIn() {
    return !empty($_SESSION['user_id']);
}
?>

<main class="container <?= isLoggedIn() ? 'account-overview' : '' ?>">

  <?php if (isLoggedIn()): ?>
    <!-- Sidebar nur wenn eingeloggt -->
    <aside class="account-sidebar">
      <?php include __DIR__ . '/sidebar.php'; ?>
    </aside>
  <?php endif; ?>

  <!-- Hauptbereich: section statt main, damit gleiche Styles greifen -->
  <section class="<?= isLoggedIn() ? 'account-main wishlist-content' : 'wishlist-fullwidth' ?>">
    <h1><?= htmlspecialchars($pageTitle) ?></h1>

  <?php if (empty($items)): ?>
    <p class="wl-empty">
      <?= $lang==='en'
          ? 'Your wishlist is empty.'
          : 'Ihre Wunschliste ist leer.' ?>
    </p>
  <?php else: ?>
    <div class="wishlist-list">
      <?php foreach($items as $it):
        // Basis‐Daten
        $url      = ($lang==='en' ? $it['url_en'] : $it['url_de'])
                    . '-' . $it['product_id'] . '.html';
        $addedAt  = date('d.m.Y H:i', strtotime($it['added_at']));
        $priceAdd = number_format($it['price_at_added'], 2, ',', '.');
        $priceNow = number_format($it['current_price'],   2, ',', '.');
        $changed  = ($it['current_price'] != $it['price_at_added']);
        $available = ( ($it['stock'] ?? 0) > 0 );

        // Produkt‐Array für renderProductItem (small‐Variante)
        $prodArr = [
          'id'          => $it['product_id'],
          'name'        => $lang==='en'? $it['name_en'] : $it['name_de'],
          'price'       => $priceNow,
          'old_price'   => '',
          'images'      => [$it['image_path'] ?? '/assets/img/placeholder.png'],
          'link'        => $baseUrl.'/'.$url,
          'discount'    => '',
          'description' => '',
          'stock'       => (string)($it['stock'] ?? 0),
          'variants'    => ''
        ];
      ?>
      <div class="wl-item-row"
           data-added="<?= strtotime($it['added_at']) ?>"
           data-price-changed="<?= $changed?1:0 ?>"
           data-available="<?= $available?1:0 ?>">
        <!-- linke Spalte: kleines Produkt-Tile -->
        <div class="wl-col product-col">
            <?= renderProductItemNew(
            (int)$it['product_id'],
            isset($it['variant_id']) ? (int)$it['variant_id'] : null,
            $translations_product_item[$lang],
            $lang,
            $baseUrl,
            true
            ); ?>
        </div>


        <!-- mittlere Spalte: Details -->
        <div class="wl-col details-col">
          <h3 class="wl-name">
            <a href="<?= $baseUrl.'/'.$url ?>">
              <?= htmlspecialchars($lang==='en'? $it['name_en']:$it['name_de']) ?>
            </a>
          </h3>

          <ul class="wl-meta">
            <li>
              <?= $lang==='en'?'Added on':'Hinzugefügt am' ?>: 
              <strong><?= $addedAt ?></strong>
            </li>
            <?php if($changed): ?>
            <li class="wl-price-changed">
              <span class="was-price">
                <?= $lang==='en'?'Was':'War' ?> <?= $priceAdd ?> €
              </span>
              <span class="now-price">
                <?= $lang==='en'?'Now':'Jetzt' ?> <?= $priceNow ?> €
              </span>
            </li>
            <?php else: ?>
            <li>
              <?= $lang==='en'?'Price':'Preis' ?>: 
              <strong><?= $priceNow ?> €</strong>
            </li>
            <?php endif ?>
            <li>
              <?= $lang==='en'?'Availability':'Verfügbarkeit' ?>:
              <?php if($available): ?>
                <span class="status-dot green"></span>
                <strong><?= $lang==='en'?'In stock':'Verfügbar' ?></strong>
              <?php else: ?>
                <span class="status-dot red"></span>
                <strong><?= $lang==='en'?'Out of stock':'Nicht verfügbar' ?></strong>
              <?php endif ?>
            </li>
          </ul>

          <div class="wl-notes">
            <label for="note-<?= $it['wish_id'] ?>">
              <?= $lang==='en'?'Your note':'Ihre Notiz' ?>:
            </label>
            <textarea id="note-<?= $it['wish_id'] ?>"
                      name="notes[<?= $it['wish_id'] ?>]"
                      rows="3"
                      placeholder="<?= $lang==='en'?'Add a personal note…':'Persönliche Notiz…' ?>"><?= 
                      htmlspecialchars($it['notes'] ?? '') ?></textarea>
            <button class="btn-save-note" data-id="<?= $it['wish_id'] ?>">
              <?= $lang==='en'?'Save note':'Notiz speichern' ?>
            </button>
          </div>

          <div class="wl-actions">
            <button class="btn-remove" data-id="<?= $it['wish_id'] ?>">
              <?= $lang==='en'?'Remove':'Entfernen' ?>
            </button>
            <?php if($available): ?>
            <input type="number" class="wl-qty" value="1" min="1">
            <button class="btn-addcart"
                    data-product="<?= $it['product_id'] ?>"
                    data-variant="<?= $it['variant_id'] ?>">
              <?= $lang==='en'?'Add to cart':'In Warenkorb' ?>
            </button>
            <?php endif ?>
          </div>
        </div>
      </div>
      <?php endforeach ?>
    </div>
  <?php endif ?>


  <!-- ============================================ -->
  <!-- Abschnitt: Zuletzt angesehene Produkte -->
  <?php if (!empty($recently)): ?>
  <section class="wl-recently-section">
    <h2 class="wl-section-title">
      <?= $lang==='en'
          ? 'Recently Viewed'
          : 'Zuletzt angesehene Produkte' ?>
    </h2>
    <div class="wl-slider recently-slider">
      <?php foreach($recently as $rv): 
        $urlRv = ($lang==='en' ? $rv['url_en'] : $rv['url_de'])
                 . '-' . $rv['product_id'] . '.html';
      ?>
      <div class="wl-slider-item">
        <?= renderProductItemNew(
        (int)$rv['product_id'],
        null,
        $translations_product_item[$lang],
        $lang,
        $baseUrl,
        true
        ); ?>
    </div>
      <?php endforeach ?>
    </div>
  </section>
  <?php endif ?>


  <!-- ============================================ -->
  <!-- Abschnitt: Zufällige Produkte -->
  <?php if (!empty($randoms)): ?>
  <section class="wl-random-section">
    <h2 class="wl-section-title">
      <?= $lang==='en'
          ? 'You might also like'
          : 'Zufällige Produkte' ?>
    </h2>
    <div class="wl-slider randoms-slider">
      <?php foreach($randoms as $rp): 
        $urlRp = ($lang==='en' ? $rp['url_en'] : $rp['url_de'])
                 . '-' . $rp['product_id'] . '.html';
      ?>
      <div class="wl-slider-item">
        <?= renderProductItemNew(
            (int)$rp['product_id'],
            null,
            $translations_product_item[$lang],
            $lang,
            $baseUrl,
            true
            ); ?>
        </div>

      <?php endforeach ?>
    </div>
  </section>
  <?php endif ?>
</main>

<script src="<?= $baseUrl ?>/assets/js/wishlist.js"></script>
<?php require __DIR__ . '/../../inc/footer.php'; ?>
