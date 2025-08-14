<?php
// product-item.php

function renderProductItem_backup($product, $translations, $lang, $baseUrl, $isSmall = false) {
    // 0) Stelle sicher, dass die Session schon läuft:
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // 1) User‐/Session‐ID
    $userId    = $_SESSION['user_id'] ?? null;
    $sessionId = session_id();

    // 2) PDO‐Handle (muss vorher z.B. in index.php als $pdo global bereitstehen)
    global $pdo;

    // Prüfen, ob dieses Produkt schon in der Wishlist ist
    $stmt = $pdo->prepare("
        SELECT 1
        FROM wishlist_items
        WHERE product_id = :pid
          AND (
                (user_id = :uid)
             OR (user_id IS NULL AND session_id = :sid)
          )
        LIMIT 1
    ");
    $stmt->execute([
        'pid' => (int)$product['id'],
        'uid' => $userId,
        'sid' => $sessionId
    ]);
    $bookmarked = (bool) $stmt->fetchColumn();
    //echo $bookmarked ? '<p>Bookmarked</p>' : '<p>Not Bookmarked'.(int)$product['id'].'|'.$sessionId.'</p>';

    // Bestimme die CSS-Klassen basierend auf der Größe
    $productItemClass = $isSmall ? 'product-item-small' : 'product-item';
    $discountLabelClass = $isSmall ? 'discount-label-small' : 'discount-label';
    $productImageClass = $isSmall ? 'product-image-small' : 'product-image';
    $productNameClass = $isSmall ? 'product-name-small' : '';
    $productDescriptionClass = $isSmall ? 'product-description-small' : '';
    
    // Zusätzliche Klassen für den Image-Container
    $imageContainerClasses = 'image-container';
    if (!$isSmall) {
        $imageContainerClasses .= ' desktop-image-link';
    }

    ob_start();
    ?>
    <div class="<?= htmlspecialchars($productItemClass) ?>">
        <!-- Rabatt-Label falls vorhanden -->
        <?php if (!empty($product['discount'])): ?>
            <div class="<?= htmlspecialchars($discountLabelClass) ?>">
                -<?= htmlspecialchars($product['discount']) ?>%
            </div>
        <?php endif; ?>


        <!-- Bookmark-Icon -->
        <a href="javascript:void(0)"
           class="bookmark"
           data-product-id="<?= (int)$product['id'] ?>"
           <?= !empty($product['variant_id'])
                ? 'data-variant-id="'.(int)$product['variant_id'].'"' 
                : '' ?>
           aria-label="<?= htmlspecialchars($bookmarked 
                ? $translations['bookmark_remove'] 
                : $translations['bookmark_add']) ?>"
           title="<?= htmlspecialchars($bookmarked 
                ? $translations['bookmark_remove'] 
                : $translations['bookmark_add']) ?>">
            <i class="<?= $bookmarked ? 'fas' : 'fa-regular' ?> fa-bookmark"></i>
        </a>


        <!-- Produktbild verlinkt zum Produkt -->
        <a href="<?= htmlspecialchars($product['link']) ?>" class="<?= htmlspecialchars($imageContainerClasses) ?>">
            <img 
                src="<?= htmlspecialchars($baseUrl . '' . ($isSmall ? (isset($product['image']) ? $product['image'] : $product['images'][0]) : $product['images'][0])) ?>" 
                alt="<?= htmlspecialchars($product['name']) ?>" 
                class="<?= htmlspecialchars($productImageClass) ?>" 
                loading="lazy"
            >
            <?php if (!$isSmall || $isSmall): ?>
                <!-- Thumbnails (auch für Small-Varianten) -->
                <div class="thumbnails-container">
                    <?php foreach ($product['images'] as $index => $image): ?>
                        <img 
                            src="<?= htmlspecialchars($baseUrl . '' . $image) ?>" 
                            alt="<?= htmlspecialchars($product['name']) ?>" 
                            class="thumbnail <?= $index === 0 ? 'active' : '' ?>"
                            data-fullsrc="<?= htmlspecialchars($baseUrl . '' . $image) ?>"
                        >
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </a>

        <?php if (!$true): ?>
            <!-- Mobiler Bild-Slider (Swipe) -->
            <div class="mobile-image-slider swiper-container">
                <div class="swiper-wrapper">
                    <?php foreach ($product['images'] as $img): ?>
                        <div class="swiper-slide">
                            <a href="<?= htmlspecialchars($product['link']) ?>">
                                <img 
                                    src="<?= htmlspecialchars($baseUrl . '' . $img) ?>" 
                                    alt="<?= htmlspecialchars($product['name']) ?>"
                                    loading="lazy"
                                >
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- Pagination (Dots) -->
                <div class="swiper-pagination"></div>
            </div>
        <?php endif; ?>

        <!-- Produktname verlinkt zum Produkt -->
        <h3 class="<?= htmlspecialchars($productNameClass) ?>">
            <a href="<?= htmlspecialchars($product['link']) ?>">
                <?= htmlspecialchars($product['name']) ?>
            </a>
        </h3>

        <?php if (!$isSmall): ?>
            <p class="description <?= htmlspecialchars($productDescriptionClass) ?>">
                <?= htmlspecialchars($product['description']) ?>
            </p>
        <?php endif; ?>

        <div class="price-container">
            <span class="current-price">
                <?= htmlspecialchars($translations['from']) ?> <?= htmlspecialchars($product['price']) ?>
            </span>

            <?php if (!empty($product['old_price'])): ?>
                <span class="old-price">
                    <?= htmlspecialchars($translations['instead']) ?> <?= htmlspecialchars($product['old_price']) ?>
                </span>
            <?php endif; ?>
        </div>

        <!-- Lagerstand-Anzeige -->
        <div class="stock-status">
            <?php 
                if (!empty($product['variants']) && $product['variants'] > 1) {
                    // Zeige Anzahl der Varianten an
                    echo sprintf($translations['variants_available'], $product['variants']);
                } else {
                    // Zeige Lagerstand an, falls keine Varianten vorhanden sind
                    if (!empty($product['stock']) && $product['stock'] > 100) {
                        echo '<span class="status-dot green"></span> ' . htmlspecialchars($translations['stock_available_over_100']);
                    } elseif (!empty($product['stock']) && $product['stock'] > 50) {
                        echo '<span class="status-dot green"></span> ' . htmlspecialchars($translations['stock_available_over_50']);
                    } elseif (!empty($product['stock']) && $product['stock'] > 10) {
                        echo '<span class="status-dot green"></span> ' . htmlspecialchars($translations['stock_available_over_10']);
                    } elseif (!empty($product['stock']) && $product['stock'] <= 10 && $product['stock'] > 0) {
                        echo '<span class="status-dot green"></span> ' . sprintf($translations['stock_available'], $product['stock']);
                    } elseif ($product['stock'] === "0" || empty($product['stock'])) {
                        echo '<span class="status-dot red"></span> ' . htmlspecialchars($translations['not_in_stock']);
                    }
                }
            ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
?>


<?php
// neuer Teil

function renderProductItemNew(
    int    $productId,
    ?int   $variantId,
    array  $translations,
    string $lang,
    string $baseUrl,
    bool   $isSmall = false
) {
    // 0) Session starten
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $userId    = $_SESSION['user_id'] ?? null;
    $sessionId = session_id();

    // 1) PDO-Handle
    global $pdo;

    // 2) Produkt-Grunddaten aus Tabelle `products`
    $stmt = $pdo->prepare("
        SELECT 
            name_de, name_en,
            short_description_de, short_description_en,
            url_de, url_en
        FROM products_products
        WHERE id = :pid
        LIMIT 1
    ");
    $stmt->execute(['pid' => $productId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$row) {
        return '<!-- Produkt ' . htmlspecialchars($productId) . ' nicht gefunden -->';
    }

    // 3) Preise (wie bisher)
    $stmt = $pdo->prepare("
        SELECT 
            MIN(CAST(REPLACE(price, ',', '.') AS DECIMAL(10,2)))    AS min_price,
            MIN(CAST(REPLACE(old_price, ',', '.') AS DECIMAL(10,2))) AS min_old_price
        FROM products_prices
        WHERE product_id = :pid
          AND price_type = 'list'
    ");
    $stmt->execute(['pid' => $productId]);
    $pr = $stmt->fetch(PDO::FETCH_ASSOC);
    $price    = $pr['min_price']    !== null
                ? number_format($pr['min_price'],    2, ',', '.') : '0,00';
    $oldPrice = ($pr['min_old_price'] ?? 0) > $pr['min_price']
                ? number_format($pr['min_old_price'], 2, ',', '.') : '';
    $discount = '';
    if (($pr['min_old_price'] ?? 0) > $pr['min_price']) {
        $discount = round((($pr['min_old_price'] - $pr['min_price']) / $pr['min_old_price']) * 100);
    }

    // 4) Varianten- und Lager-Logik
    if ($variantId) {
        // konkrete Variante ausgewählt → Stock & Artikelnummer laden
        $stmt = $pdo->prepare("
            SELECT stock, article_number
            FROM products_variants
            WHERE variant_id = :vid AND product_id = :pid
            LIMIT 1
        ");
        $stmt->execute([
            'vid' => $variantId,
            'pid' => $productId
        ]);
        $var = $stmt->fetch(PDO::FETCH_ASSOC);
        $variants = '';
        $stock    = (int)($var['stock'] ?? 0);
        $variantNumber = $var['article_number'] ?? null;
    } else {
        // Anzahl Varianten prüfen
        $stmt = $pdo->prepare("
            SELECT COUNT(*) AS cnt
            FROM products_variants
            WHERE product_id = :pid
        ");
        $stmt->execute(['pid' => $productId]);
        $cnt = (int)$stmt->fetchColumn();
        if ($cnt > 1) {
            $variants = $cnt . ' Varianten verfügbar';
            $stock    = '';
            $variantNumber = null;
        } else {
            $variants = '';
            $stmt = $pdo->prepare("
                SELECT stock, article_number
                FROM products_variants
                WHERE product_id = :pid
                LIMIT 1
            ");
            $stmt->execute(['pid' => $productId]);
            $v = $stmt->fetch(PDO::FETCH_ASSOC);
            $stock    = (int)($v['stock'] ?? 0);
            $variantNumber = $v['article_number'] ?? null;
        }
    }

    // 5) Bilder (bis zu 3)
    $stmt = $pdo->prepare("
        SELECT image_path
        FROM products_images
        WHERE product_id = :pid
        ORDER BY sort_order ASC
        LIMIT 3
    ");
    $stmt->execute(['pid' => $productId]);
    $imgs = $stmt->fetchAll(PDO::FETCH_COLUMN);
    if (!$imgs) {
        $imgs = ['assets/img/placeholder.png'];
    }

    // 6) Name, Beschreibung, Link
    $name = ($lang === 'de') ? $row['name_de'] : $row['name_en'];
    $desc = ($lang === 'de') 
            ? $row['short_description_de'] 
            : $row['short_description_en'];
    $url  = ($lang === 'de') ? $row['url_de'] : $row['url_en'];
    // Basis-Link + Variant-Query
    $link = $baseUrl . '/' . $url . '-' . $productId . '.html';
    if ($variantNumber) {
        $link .= '?number=' . urlencode($variantNumber);
    }

    // 7) Prüfen, ob gewünscht schon in Wunschliste
    $stmt = $pdo->prepare("
        SELECT 1
        FROM wishlist_items
        WHERE product_id = :pid
          AND (
                 (user_id    = :uid)
              OR (user_id IS NULL AND session_id = :sid)
          )
        LIMIT 1
    ");
    $stmt->execute([
        'pid' => $productId,
        'uid' => $userId,
        'sid' => $sessionId
    ]);
    $bookmarked = (bool)$stmt->fetchColumn();

    // 8) CSS-Klassen je nach Größe
    $cProd    = $isSmall ? 'product-item-small'          : 'product-item';
    $cDisc    = $isSmall ? 'discount-label-small'         : 'discount-label';
    $cImg     = $isSmall ? 'product-image-small'         : 'product-image';
    $cName    = $isSmall ? 'product-name-small'          : '';
    $cDesc    = $isSmall ? 'product-description-small'   : '';
    $cContImg = 'image-container' . (!$isSmall ? ' desktop-image-link' : '');

    // 9) Rendern (deine bestehende Markup-Logik bleibt hier unverändert)
    ob_start(); ?>
    <div class="<?= htmlspecialchars($cProd) ?>">
        <?php if ($discount !== ''): ?>
            <div class="<?= htmlspecialchars($cDisc) ?>">
                -<?= htmlspecialchars($discount) ?>%
            </div>
        <?php endif; ?>

        <a href="javascript:void(0)"
           class="bookmark"
           data-product-id="<?= $productId ?>"
           <?= $variantId ? 'data-variant-id="'.(int)$variantId.'"' : '' ?>
           aria-label="<?= htmlspecialchars(
                $bookmarked 
                  ? $translations['bookmark_remove'] 
                  : $translations['bookmark_add']
           ) ?>"
           title="<?= htmlspecialchars(
                $bookmarked 
                  ? $translations['bookmark_remove'] 
                  : $translations['bookmark_add']
           ) ?>">
            <i class="<?= $bookmarked ? 'fas' : 'fa-regular' ?> fa-bookmark"></i>
        </a>

        <a href="<?= htmlspecialchars($link) ?>" class="<?= htmlspecialchars($cContImg) ?>">
            <img 
                src="<?= htmlspecialchars($baseUrl . $imgs[0]) ?>" 
                alt="<?= htmlspecialchars($name) ?>" 
                class="<?= htmlspecialchars($cImg) ?>" 
                loading="lazy"
            >
            <div class="thumbnails-container">
                <?php foreach ($imgs as $i => $im): ?>
                    <img 
                        src="<?= htmlspecialchars($baseUrl . $im) ?>" 
                        alt="<?= htmlspecialchars($name) ?>" 
                        class="thumbnail <?= $i === 0 ? 'active' : '' ?>"
                        data-fullsrc="<?= htmlspecialchars($baseUrl . $im) ?>"
                    >
                <?php endforeach; ?>
            </div>
        </a>

        <h3 class="<?= htmlspecialchars($cName) ?>">
            <a href="<?= htmlspecialchars($link) ?>">
                <?= htmlspecialchars($name) ?>
            </a>
        </h3>

        <?php if (!$isSmall): ?>
            <p class="description <?= htmlspecialchars($cDesc) ?>">
                <?= htmlspecialchars($desc) ?>
            </p>
        <?php endif; ?>

        <div class="price-container">
            <span class="current-price">
                <?= htmlspecialchars($translations['from']) ?> <?= htmlspecialchars($price) ?>
            </span>
            <?php if ($oldPrice !== ''): ?>
                <span class="old-price">
                    <?= htmlspecialchars($translations['instead']) ?> <?= htmlspecialchars($oldPrice) ?>
                </span>
            <?php endif; ?>
        </div>

        <div class="stock-status">
            <?php
                if ($variants) {
                    echo '<span>' . htmlspecialchars($variants) . '</span>';
                } else {
                    // wie gehabt: farbige Punkte & Texte je nach $stock
                    if ($stock > 100) {
                        echo '<span class="status-dot green"></span> ' 
                             . htmlspecialchars($translations['stock_available_over_100']);
                    } elseif ($stock > 50) {
                        echo '<span class="status-dot green"></span> ' 
                             . htmlspecialchars($translations['stock_available_over_50']);
                    } elseif ($stock > 10) {
                        echo '<span class="status-dot green"></span> ' 
                             . htmlspecialchars($translations['stock_available_over_10']);
                    } elseif ($stock > 0) {
                        echo '<span class="status-dot green"></span> ' 
                             . sprintf($translations['stock_available'], $stock);
                    } else {
                        echo '<span class="status-dot red"></span> ' 
                             . htmlspecialchars($translations['not_in_stock']);
                    }
                }
            ?>
        </div>
    </div>
    <?php
    return ob_get_clean();
}
