<?php
// ------------------------------------------------------------------
// product-detail.php (Detailseite – Datenbank-Version)
// ------------------------------------------------------------------

// 1. Header einbinden
require_once __DIR__ . '/../inc/header.php';
require_once __DIR__ . '/../inc/db.php';  // Hier wird z. B. der PDO-Connector $pdo bereitgestellt

// Es wird angenommen, dass $prodId in der index.php bereits ermittelt wurde.
// Falls nicht, als Fallback:
if (!isset($prodId) || $prodId <= 0) {
    $prodId = isset($_GET['prodId']) ? intval($_GET['prodId']) : 123;
}

// Sprache und Base-URL (in der index.php ermittelt)
$lang = isset($lang) ? $lang : 'de';  // Standard: Deutsch
// $baseUrl wird in der index.php gesetzt

// ------------------------------------------------------------------
// 2. Produktdaten aus der Tabelle products_products laden
$sql = "SELECT * FROM products_products WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $prodId]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$product) {
    die(($lang === 'en') ? "Product not found." : "Produkt nicht gefunden.");
}

// Für die Anzeige (im Deutschen) verwenden wir die _de-Spalten
$productData = [];
$productData['name']              = $product['name_de'];
$productData['sku']               = $product['sku'];
$productData['unit']              = $product['unit'];
$productData['brand']             = $product['brand'] ?? 'LALIZAS';
$productData['short_description'] = $product['short_description_de'];
$productData['description']       = $product['description_de'];

// ------------------------------------------------------------------
// 3. Bilder laden (products_images) – immer als Array, sortiert nach sort_order
$sql = "SELECT image_path FROM products_images WHERE product_id = :prodId ORDER BY sort_order ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute(['prodId' => $prodId]);
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);
$productData['images'] = [];
if ($images) {
    foreach ($images as $img) {
        $productData['images'][] = $img['image_path'];
    }
} else {
    // Fallback, falls keine Bilder vorhanden sind
    $productData['images'][] = '/assets/img/product_placeholder.png';
}

// ------------------------------------------------------------------
// 4. Varianten laden (products_variants)
$sql = "SELECT * FROM products_variants WHERE product_id = :prodId ORDER BY variant_id ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute(['prodId' => $prodId]);
$variants = $stmt->fetchAll(PDO::FETCH_ASSOC);
$productData['variants'] = [];
foreach ($variants as $variant) {
    // Die Spalte "article_number" entspricht dem 'number' aus dem Array
    $productData['variants'][] = [
        'label'     => $variant['label'],
        'stock'     => $variant['stock'],
        'number'    => $variant['article_number'],
        // Preise werden separat über products_prices geladen
    ];
}

// Standardmäßig aktive Variante ermitteln (über GET-Parameter "number")
$selectedArticleNumber = $_GET['number'] ?? null;
$selectedVariant = null;
foreach ($productData['variants'] as $index => $variant) {
    if ($selectedArticleNumber !== null && $selectedArticleNumber === $variant['number']) {
        $selectedVariant = $variant;
        break;
    } elseif ($selectedArticleNumber === null && $index === 0) {
        $selectedVariant = $variant;
        break;
    }
}
if (!$selectedVariant) {
    $selectedVariant = $productData['variants'][0];
}
$defaultVariantArticleNumber = $selectedVariant['number'];

// ------------------------------------------------------------------
// 5. Den Listenpreis für die aktive Variante laden (products_prices, price_type = 'list')
// Wir nehmen an, dass für jede Variante ein entsprechender Datensatz existiert.
$sql = "SELECT price, old_price 
        FROM products_prices 
        WHERE product_id = :prodId 
          AND variant_id = (SELECT variant_id FROM products_variants 
                            WHERE product_id = :prodId AND article_number = :number LIMIT 1)
          AND price_type = 'list'
        ORDER BY price_id LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute([
    'prodId' => $prodId,
    'number' => $defaultVariantArticleNumber
]);
$priceData = $stmt->fetch(PDO::FETCH_ASSOC);
if ($priceData) {
    // Umrechnung von Preis und altem Preis (als String mit Komma)
    $defaultPriceFloat    = floatval(str_replace(',', '.', $priceData['price']));
    $defaultOldPriceFloat = floatval(str_replace(',', '.', $priceData['old_price']));
    $defaultVariantPrice    = number_format($defaultPriceFloat, 2, ',', '.');
    $defaultVariantOldPrice = number_format($defaultOldPriceFloat, 2, ',', '.');

    if ($defaultOldPriceFloat > $defaultPriceFloat) {
        $defaultSavings         = $defaultOldPriceFloat - $defaultPriceFloat;
        $defaultSavingsPercent  = ($defaultSavings / $defaultOldPriceFloat) * 100;
        $defaultSavingsFormatted       = number_format($defaultSavings, 2, ',', '.');
        $defaultSavingsPercentFormatted = round($defaultSavingsPercent);
    } else {
        $defaultSavingsFormatted       = '';
        $defaultSavingsPercentFormatted = '';
    }
} else {
    $defaultVariantPrice = '0,00';
    $defaultVariantOldPrice = '0,00';
    $defaultSavingsFormatted = '';
    $defaultSavingsPercentFormatted = '';
}

// ------------------------------------------------------------------
// 6. Produktdetails laden (products_features)
// Erwartet werden Zeilen mit Spalten: detail, description_de
$sql = "SELECT name_de AS detail, value_de AS value FROM products_features WHERE product_id = :prodId";
$stmt = $pdo->prepare($sql);
$stmt->execute(['prodId' => $prodId]);
$productData['details'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

// ------------------------------------------------------------------
// 7. Empfehlungen laden
// Hier wählen wir 10 zufällige Produkte aus, die nicht das aktuelle Produkt sind
$sql = "SELECT * FROM products_products WHERE id != :prodId ORDER BY RAND() LIMIT 10";
$stmt = $pdo->prepare($sql);
$stmt->execute(['prodId' => $prodId]);
$recommendations = $stmt->fetchAll(PDO::FETCH_ASSOC);
$productData['recommendations'] = [];
foreach ($recommendations as $rec) {
    // Für jedes empfohlene Produkt das erste Bild laden
    $sql = "SELECT image_path FROM products_images WHERE product_id = :recId ORDER BY sort_order ASC LIMIT 1";
    $stmtImg = $pdo->prepare($sql);
    $stmtImg->execute(['recId' => $rec['id']]);
    $img = $stmtImg->fetch(PDO::FETCH_ASSOC);
    $image = $img ? $img['image_path'] : '/assets/img/product_placeholder.png';

    $productData['recommendations'][] = [
        'name'      => $rec['name_de'],
        'link'      => $baseUrl . '/' . $rec['url_de'] . '-' . $rec['id'] . '.html',
        'price'     => '',   // Preisangaben können hier noch ergänzt werden
        'old_price' => '',
        'images'    => [$image],
    ];
}

// ------------------------------------------------------------------
// 8. Accessoires laden
// Hier gehen wir davon aus, dass die Beziehung über die Tabelle products_accessories definiert ist
$sql = "SELECT pp.* 
        FROM products_accessories pa
        JOIN products_products pp ON pa.accessory_product_id = pp.id
        WHERE pa.product_id = :prodId AND pa.hide_in_accessories = 0
        ORDER BY pa.sort_order ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute(['prodId' => $prodId]);
$accessories = $stmt->fetchAll(PDO::FETCH_ASSOC);
$productData['accessories'] = [];
foreach ($accessories as $acc) {
    // Für das Accessoire das erste Bild laden
    $sql = "SELECT image_path FROM products_images WHERE product_id = :accId ORDER BY sort_order ASC LIMIT 1";
    $stmtImg = $pdo->prepare($sql);
    $stmtImg->execute(['accId' => $acc['id']]);
    $img = $stmtImg->fetch(PDO::FETCH_ASSOC);
    $image = $img ? $img['image_path'] : '/assets/img/product_placeholder.png';

    $productData['accessories'][] = [
        'name'      => $acc['name_de'],
        'price'     => number_format($acc['price'], 2, ',', '.'),
        'old_price' => (!empty($acc['old_price'])) ? number_format($acc['old_price'], 2, ',', '.') : '',
        'discount'  => $acc['discount'],
        'image'     => $image,
    ];
}

// ------------------------------------------------------------------
// 9. Bewertungen laden (products_ratings)
$sql = "SELECT user_name AS user, rating, review_date AS date, review_text AS comment 
        FROM products_ratings 
        WHERE product_id = :prodId 
        ORDER BY review_date DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute(['prodId' => $prodId]);
$productData['reviews'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="<?= $baseUrl; ?>/assets/css/product-detail.css">

<div class="container product-detail-page">
    <!-- ============ Breadcrumb ============ -->
    <nav class="product-detail-breadcrumb">
        <a href="<?= $baseUrl; ?>">Home</a> &gt;
        <a href="<?= $baseUrl; ?>/segelausruestung-c5.html">Segel &amp; Meer</a> &gt;
        <a href="<?= $baseUrl; ?>/segel-reparatur-sc12.html">Segel-Reparatur</a> &gt;
        <span><?= htmlspecialchars($productData['name']); ?></span>
    </nav>

    <!-- Wrapper für Hauptinhalt (Produktdetails) und Sidebar -->
    <div class="product-detail-wrapper">
        <!-- Linke Spalte: Produktdetails -->
        <div class="product-detail-main">
            <!-- ============ Produkt-Detail-Bereich (Bilder & Info) ============ -->
            <div class="product-detail-product-detail-top">
                <!-- Linke Spalte: Bilder (Desktop-Version) -->
                <div class="product-detail-product-gallery">
                    <!-- Großes Bild – Klick öffnet das Modal -->
                    <div class="product-detail-main-image" onclick="openModal(); showSlides(currentMainImageIndex);">
                        <img src="<?= htmlspecialchars($productData['images'][0]); ?>" alt="<?= htmlspecialchars($productData['name']); ?>">
                    </div>
                    <!-- Thumbnails (Desktop) -->
                    <div class="product-detail-thumbnail-row">
                        <?php foreach ($productData['images'] as $index => $img): ?>
                            <div class="thumb"
                                 onmouseover="document.querySelector('.product-detail-main-image img').src='<?= htmlspecialchars($img); ?>'; currentMainImageIndex = <?= $index + 1; ?>;"
                                 onclick="document.querySelector('.product-detail-main-image img').src='<?= htmlspecialchars($img); ?>'; currentMainImageIndex = <?= $index + 1; ?>;">
                                <img src="<?= htmlspecialchars($img); ?>" alt="thumbnail">
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Rechte Spalte: Produktinfos -->
                <div class="product-detail-product-info">
                    <!-- Header: Marke & Haupttitel -->
                    <div class="product-detail-info-header">
                        <div class="product-detail-product-brand">
                            <?= htmlspecialchars($productData['brand']); ?>
                        </div>
                        <h1 class="product-detail-product-title">
                            <?= htmlspecialchars($productData['name']); ?>
                        </h1>
                    </div>

                    <!-- Duplikat des Hauptbildes für Mobile (mit Modal-Klick) -->
                    <div class="product-detail-main-image-mobile" onclick="openModal(); showSlides(currentMainImageIndex);">
                        <img src="<?= htmlspecialchars($productData['images'][0]); ?>" alt="<?= htmlspecialchars($productData['name']); ?>">
                    </div>

                    <!-- Thumbnails für Mobile -->
                    <div class="product-detail-thumbnail-row-mobile">
                        <?php foreach ($productData['images'] as $img): ?>
                            <div class="thumb" onclick="document.querySelector('.product-detail-main-image-mobile img').src='<?= htmlspecialchars($img); ?>'">
                                <img src="<?= htmlspecialchars($img); ?>" alt="thumbnail">
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Kurzbeschreibung -->
                    <div class="product-detail-product-shortdesc">
                        <p><?= nl2br(htmlspecialchars($productData['short_description'])); ?></p>
                    </div>

                    <div class="product-detail-price-box">
                        <!-- Statt-Preis (durchgestrichen) -->
                        <div class="product-detail-old-price">
                            <span class="prefix">statt </span>
                            <span class="price">€ <?= $defaultVariantOldPrice; ?></span>
                        </div>
                        <!-- Preis und Einheit – Hier wird der Preis je nach aktiver Variante angezeigt -->
                        <div class="product-detail-product-price">
                            <span class="product-detail-price" id="productPrice">€ <?= $defaultVariantPrice; ?></span>
                            <span class="product-detail-price-unit">/ <?= htmlspecialchars($productData['unit']); ?></span>
                        </div>

                        <!-- Einsparungen -->
                        <div class="product-detail-savings" id="savingsInfo">
                            <?php if ($defaultSavingsFormatted !== ''): ?>
                                Sie sparen: € <?= $defaultSavingsFormatted; ?> (<?= $defaultSavingsPercentFormatted; ?>%)
                            <?php endif; ?>
                        </div>

                        <!-- Hinweis zu MwSt./Versand -->
                        <div class="product-detail-tax-shipping">
                            Inkl. MwSt. (Österreich), exkl. Versandkosten <i class="fa-solid fa-circle-info"></i>
                        </div>

                        <!-- Varianten-Auswahl als Buttons statt Dropdown -->
                        <div class="product-detail-product-variants">
                            <label>Durchmesser:<br></label>
                            <div class="variant-buttons">
                                <?php foreach ($productData['variants'] as $index => $variant): 
                                    // Für die Preisangaben der Varianten kann man alternativ noch extra Queries ausführen,
                                    // hier verwenden wir vorerst nur die über den aktiven Preis ermittelten Werte.
                                    $isActive = ($selectedArticleNumber !== null) 
                                                ? ($selectedArticleNumber === $variant['number']) 
                                                : ($index === 0);
                                    $stock = $variant['stock'] ?? 0;
                                    $disabled = ($stock == 0) ? 'disabled' : '';
                                ?>
                                    <button type="button" class="variant-button <?= $isActive ? 'active' : '' ?> <?= $disabled ? 'out-of-stock' : ''; ?>"
                                            data-variant-label="<?= htmlspecialchars($variant['label']); ?>"
                                            data-article-number="<?= htmlspecialchars($variant['number']); ?>"
                                            data-price="<?= number_format($defaultPriceFloat, 2, '.', ''); ?>"
                                            data-old-price="<?= number_format($defaultOldPriceFloat, 2, '.', ''); ?>"
                                            data-stock="<?= $stock; ?>"
                                            <?= $disabled; ?>>
                                        <?= htmlspecialchars($variant['label']); ?>
                                        <?php if ($stock == 0): ?>
                                            <span class="variant-unavailable">(nicht verfügbar)</span>
                                        <?php endif; ?>
                                    </button>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Mengenfeld -->
                        <div class="product-detail-quantity-box">
                            <label for="qty">Menge: </label>
                            <input type="number" id="qty" name="qty" value="1" min="1">
                            <label><?= htmlspecialchars($productData['unit']); ?></label>
                        </div>

                        <!-- Artikelnummer -->
                        <div class="product-detail-artikelnummer-box">
                            <label>Artikelnummer:</label>
                            <span id="artikelnummer"><?= htmlspecialchars($defaultVariantArticleNumber); ?></span>
                        </div>

                        <!-- Warenkorb-Button -->
                        <button class="product-detail-btn btn-primary add-to-cart">
                            <i class="fas fa-shopping-cart"></i> 
                            Zum Warenkorb hinzufügen
                        </button>

                        <!-- Verfügbarkeitsanzeige mit Button -->
                        <div class="stock-status-detail-container">
                            <div class="stock-status-detail" id="stockStatus">
                                <?php 
                                    $stock = $selectedVariant['stock'];
                                    if ($stock > 100) {
                                        echo '<span class="status-dot green"></span> Mehr als 100 Stück auf Lager';
                                    } elseif ($stock > 50) {
                                        echo '<span class="status-dot green"></span> Mehr als 50 Stück auf Lager';
                                    } elseif ($stock > 5) {
                                        echo '<span class="status-dot green"></span> Mehr als 5 Stück auf Lager';
                                    } elseif ($stock > 0) {
                                        echo '<span class="status-dot orange"></span> Nur noch ' . htmlspecialchars($stock) . ' Stück auf Lager';
                                    } else {
                                        echo '<span class="status-dot red"></span> Nicht auf Lager';
                                    }
                                ?>
                            </div>

                            <!-- Frage-zum-Artikel-Button -->
                            <a href=""><button type="button" class="question-button" id="askQuestionButton">
                                Frage zum Artikel
                            </button></a>
                        </div>
                    </div> <!-- /product-detail-price-box -->

                </div> <!-- /Produktinfos -->
            </div> <!-- /Produkt-Detail-Bereich -->
        </div> <!-- /product-detail-main -->

        <!-- Rechte Spalte: Sidebar (Weitere Produkte) -->
        <aside class="product-detail-sidebar">
            <div class="related-products-slider-container">
                <!-- Pfeil nach oben -->
                <button type="button" class="vertical-slider-arrow up-arrow" id="relatedUpBtn">&#9650;</button>
                
                <!-- Slider-Container: Hier werden Produkte aus der gleichen Kategorie angezeigt -->
                <div class="related-products-slider" id="relatedSlider">
                <?php
                // Kategorie des aktuellen Produkts
                $catId = $product['category_id'];
                // Lade 10 zufällige Produkte aus derselben Kategorie, die nicht das aktuelle Produkt sind
                $sql = "SELECT * FROM products_products WHERE category_id = :catId AND id != :prodId ORDER BY RAND() LIMIT 10";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['catId' => $catId, 'prodId' => $prodId]);
                $relatedProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($relatedProducts as $rp) {
                    // wir übergeben nur ID + keine Variante (null) + Übersetzungen + Lang + BaseUrl + small=true
                    echo renderProductItemNew(
                    (int)$rp['id'],
                    null,
                    $translations_product_item[$lang],
                    $lang,
                    $baseUrl,
                    true
                    );
                }
                ?>
                </div>
                
                <!-- Pfeil nach unten -->
                <button type="button" class="vertical-slider-arrow down-arrow" id="relatedDownBtn">&#9660;</button>
            </div>
        </aside>

    </div> <!-- /product-detail-wrapper -->

    <!-- Modal-Popup mit Image Slider -->
    <div id="imageModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <div class="modal-content">
            <?php foreach ($productData['images'] as $img): ?>
                <div class="mySlides">
                    <img src="<?= htmlspecialchars($img); ?>" alt="<?= htmlspecialchars($productData['name']); ?>">
                </div>
            <?php endforeach; ?>
            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>
    </div>

    <!-- Tabellarische Produktdetails (Features/Details) -->
    <div class="product-detail-product-data-table">
        <table>
            <tbody>
                <?php 
                $details = $productData['details'];
                // Wir verteilen die Details in Zweierspalten, wie im Beispiel
                for ($i = 0; $i < count($details); $i += 2): ?>
                    <tr>
                        <th><?= htmlspecialchars($details[$i]['detail']); ?></th>
                        <td><?= htmlspecialchars($details[$i]['value']); ?></td>
                        <?php if (isset($details[$i + 1])): ?>
                            <th><?= htmlspecialchars($details[$i + 1]['detail']); ?></th>
                            <td><?= htmlspecialchars($details[$i + 1]['value']); ?></td>
                        <?php else: ?>
                            <th></th><td></td>
                        <?php endif; ?>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </div>

    <!-- Empfehlungen als horizontal scrollbarer Slider -->
    <?php if (!empty($productData['recommendations'])): ?>
    <section class="product-recommendations-slider">
        <h3><?= ($lang === 'en') ? 'Recommended for this product:' : 'Empfohlen zu diesem Artikel:'; ?></h3>
        <div class="slider-container" id="recommendationsSliderContainer">
            <div class="slider-track" id="recommendationsSlider">
                <?php foreach ($recommendations as $rec): ?>
                    <div class="slider-item">
                        <?= renderProductItemNew(
                            (int)$rec['id'],
                            null,
                            $translations_product_item[$lang],
                            $lang,
                            $baseUrl,
                            true
                        ); ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- Navigationspfeile -->
            <button type="button" class="slider-arrow left-arrow" id="recLeftBtn">&#10094;</button>
            <button type="button" class="slider-arrow right-arrow" id="recRightBtn">&#10095;</button>
        </div>
    </section>
    <?php endif; ?>

    <!-- Produktbeschreibung & Dokumente -->
    <div class="product-detail-product-description">
        <h3><?= ($lang === 'en') ? 'Product Description' : 'Produktbeschreibung'; ?></h3>
        <p><?= nl2br($productData['description']); ?></p>
    </div>
    <div class="product-detail-product-safety">
        <h3><?= ($lang === 'en') ? 'Documents' : 'Dokumente'; ?></h3>
        <p><a href="#"><?= ($lang === 'en') ? 'Instructions.pdf' : 'Anleitung.pdf'; ?></a></p>
    </div>

    <!-- Zubehör-Slider (Accessoires: "Kunden, die diesen Artikel gekauft haben, kauften auch") -->
    <?php if (!empty($accessories)): ?>
    <div class="product-detail-product-accessories">
        <h3><?= ($lang === 'en') ? 'Customers also bought' : 'Kunden, die diesen Artikel gekauft haben, kauften auch'; ?></h3>
        <div class="product-detail-accessories-slider">
            <?php foreach ($accessories as $acc): ?>
            <?= renderProductItemNew(
                (int)$acc['id'],
                null,
                $translations_product_item[$lang],
                $lang,
                $baseUrl,
                true
                ); ?>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>  


    <!-- Kundenbewertungen -->
    <div class="product-detail-customer-reviews">
        <h3><?= ($lang === 'en') ? 'Customer Reviews' : 'Das sagen andere Kunden'; ?></h3>
        <div class="product-detail-review-summary">
            <p><strong>Zu 100% echte Bewertungen</strong></p>
            <label for="review-filter"><?= ($lang === 'en') ? 'Reviews:' : 'Bewertungen:'; ?></label>
            <select id="review-filter">
                <option value="all">Alle Bewertungen</option>
                <option value="5">5 Sterne</option>
                <option value="4">4 Sterne</option>
                <option value="3">3 Sterne</option>
            </select>
        </div>
        <div class="product-detail-review-list">
            <?php foreach ($productData['reviews'] as $review): ?>
            <div class="product-detail-review-item">
                <div class="product-detail-review-header">
                    <strong><?= htmlspecialchars($review['user']); ?></strong> |
                    <span><?= date('d.m.Y', strtotime($review['date'])); ?></span>
                </div>
                <div class="product-detail-review-rating">
                    <?php for ($r = 1; $r <= 5; $r++): ?>
                        <i class="fa-star <?= ($r <= $review['rating']) ? 'fas' : 'far'; ?>"></i>
                    <?php endfor; ?>
                </div>
                <div class="product-detail-review-comment">
                    <?= htmlspecialchars($review['comment']); ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

</div> <!-- /container -->

<!-- ============================= SCRIPTS ============================== -->
<script src="<?php echo $baseUrl; ?>/assets/js/product-detail.js"></script>
