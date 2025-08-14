<!-- ============================= MAIN CONTENT ============================== -->
<div class="container">
    <!-- Hero-Banner -->
    <section class="hero-banner">
        <div class="hero-slider">
            <?php
            // Nur DE-Hero-Slides auslesen, alle aktiven Banner
            $stmt = $pdo->prepare("
                SELECT *
                FROM home_hero_banner
                WHERE channel_de = b'1'
                ORDER BY rownum ASC
            ");
            $stmt->execute();
            $slides = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($slides as $slide):
                // Wähle je nach Sprache
                $title = ($lang === 'en' && $slide['title_en'] !== '')
                    ? $slide['title_en']
                    : $slide['title_de'];
                $text  = ($lang === 'en' && $slide['text_en'] !== '')
                    ? $slide['text_en']
                    : $slide['text_de'];

                $imgUrl = htmlspecialchars("{$baseUrl}/assets/img/stock/{$slide['image']}");
                $link = ($lang === 'en' && !empty($slide['link_en']))
                    ? $slide['link_en']
                    : $slide['link_de'];
            ?>
                <div class="hero-slide"
                    style="background-image: url('<?= $imgUrl ?>');">
                    <div class="hero-content">
                        <h1><?= htmlspecialchars($title) ?></h1>
                        <p><?= nl2br(htmlspecialchars($text)) ?></p>
                        <a href="<?= $link ?>" class="btn-primary">
                            <?= ($lang === 'en') ? 'Learn more' : 'Mehr erfahren' ?>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- Navigation -->
        <div class="hero-navigation">
            <button class="prev-slide">&#10094;</button>
            <button class="next-slide">&#10095;</button>
        </div>
    </section>
    
    <!-- Sonderangebote (Featured Products) -->
    <section class="featured-products" id="featured-products">
        <div class="products-grid">
            <?php
            // 1) Alle Banner in der gewünschten Reihenfolge auslesen
            $stmt = $pdo->prepare("
                SELECT *
                FROM home_promotion_banner
                WHERE channel_de = 1
                ORDER BY rownum ASC
            ");
            $stmt->execute();
            $banners = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($banners as $banner):
                // Titel je nach Sprache (falls title_en befüllt wird)
                $title = ($lang === 'en' && !empty($banner['title_en']))
                        ? $banner['title_en']
                        : $banner['title_de'];

                // Preis formatieren (falls vorhanden)
                $priceHtml = '';
                if ($banner['price'] !== null) {
                    $formatted = number_format($banner['price'], 2, ',', '.');
                    $priceHtml = "<p class=\"price\">€ {$formatted}</p>";
                }

                // Rabatt-Label
                $discountHtml = '';
                if ($banner['discount'] !== null && $banner['discount'] > 0) {
                    $discountHtml = "<div class=\"discount-label\">-{$banner['discount']}%</div>";
                }

                // Bild-URL
                $imgUrl = htmlspecialchars("{$baseUrl}/assets/img/stock/{$banner['image']}");

                // Link
                $link = ($lang === 'en' && !empty($banner['link_en']))
                         ? $banner['link_en']
                         : $banner['link_de'];
            ?>
                <div class="product-item">
                    <?= $discountHtml ?>
                    <a href="<?= $link ?>">
                        <img src="<?= $imgUrl ?>" alt="<?= htmlspecialchars($title) ?>" loading="lazy">
                        <h3><?= htmlspecialchars($title) ?></h3>
                        <?= $priceHtml ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Kategorienübersicht -->
    <section class="categories-overview">
        <h2 class="featured-products">Unsere Kategorien</h2>
        <div class="categories-grid" id="categories-grid">
            <?php
            // Jede Hauptkategorie wird als "Kachel" dargestellt.
            foreach ($categories as $category) {
                echo '<a href="' . htmlspecialchars($category['link']) . '" class="category-item" data-lang="'. $currentLang .'" style="background-image: url(\'' . htmlspecialchars($category['image']) . '\');">';
                echo '    <h3>' . htmlspecialchars($category['name']) . '</h3>';
                echo '    <div class="overlay">Jetzt einkaufen</div>';
                echo '</a>';
            }
            ?>
        </div>
    </section>

    <h2 class="brand-slide-h2">Unsere Markenwelt</h2>
    <!-- Marken-Slider -->
    <section class="brand-slider" id="brands">
        <button class="slider-arrow left-arrow" aria-label="Zurück">
            &#10094;
        </button>
        <div class="brand-slider-container">
            <div class="brand-slide"><a href="#" target="_blank"><img src="<?php echo $baseUrl; ?>/assets/img/brands/volvo-penta.png" alt="Volvo Penta"></a></div>
            <div class="brand-slide"><a href="#" target="_blank"><img src="<?php echo $baseUrl; ?>/assets/img/brands/mercury.png" alt="Mercury"></a></div>
            <div class="brand-slide"><a href="#" target="_blank"><img src="<?php echo $baseUrl; ?>/assets/img/brands/suzuki-marine.png" alt="Suzuki Marine"></a></div>
            <div class="brand-slide"><a href="#" target="_blank"><img src="<?php echo $baseUrl; ?>/assets/img/brands/allroundmarin.png" alt="Allroundmarin"></a></div>
            <div class="brand-slide"><a href="#" target="_blank"><img src="<?php echo $baseUrl; ?>/assets/img/brands/garmin.png" alt="Garmin"></a></div>
            <div class="brand-slide"><a href="#" target="_blank"><img src="<?php echo $baseUrl; ?>/assets/img/brands/quicksilver.png" alt="Quicksilver"></a></div>
            <div class="brand-slide"><a href="#" target="_blank"><img src="<?php echo $baseUrl; ?>/assets/img/brands/epropulsion.png" alt="ePropulsion"></a></div>
            <div class="brand-slide"><a href="#" target="_blank"><img src="<?php echo $baseUrl; ?>/assets/img/brands/raymarine.png" alt="Raymarine"></a></div>
            <div class="brand-slide"><a href="#" target="_blank"><img src="<?php echo $baseUrl; ?>/assets/img/brands/sigma.png" alt="Sigma"></a></div>
            <div class="brand-slide"><a href="#" target="_blank"><img src="<?php echo $baseUrl; ?>/assets/img/brands/zodiac.png" alt="Zodiac"></a></div>
            <div class="brand-slide"><a href="#" target="_blank"><img src="<?php echo $baseUrl; ?>/assets/img/brands/bombard.png" alt="Bombard"></a></div>
            <div class="brand-slide"><a href="#" target="_blank"><img src="<?php echo $baseUrl; ?>/assets/img/brands/yachtservice-dall.png" alt="Yachtservice Dall"></a></div>
        </div>
        <button class="slider-arrow right-arrow" aria-label="Weiter">
            &#10095;
        </button>
    </section>

    <!-- Top Seller -->
    <?php
    // 1) die 6 Produkte mit den meisten Verkäufen holen
    $stmt = $pdo->prepare("
        SELECT p.id, p.name_de, p.name_en, p.url_de, p.url_en,
            p.short_description_de, p.short_description_en
        FROM products_products p
        INNER JOIN (
            SELECT product_id, SUM(sales) AS total_sold
            FROM products_variants
            GROUP BY product_id
        ) v ON v.product_id = p.id
        ORDER BY v.total_sold DESC
        LIMIT 6
    ");
    $stmt->execute();
    $topProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <section class="top-seller" id="top-seller">
    <h2><?= htmlspecialchars($translations_product_item[$lang]['top_sellers']) ?></h2>
    <div class="products-grid">
        <?php foreach ($topProducts as $row): ?>
            <?= renderProductItemNew(
                   (int)$row['id'],   // product_id
                   null,              // variant_id (hier keine)
                   $translations_product_item[$lang],
                   $lang,
                   $baseUrl,
                   false              // $isSmall
               ) ?>
        <?php endforeach; ?>
    </div>
</section>


    <!-- About -->
    <section class="featured-products" id="featured-products">
        <br><h2 class="featured-products">Über uns</h2>
        <div class="products-grid">
            <?php
            // Example Products
            $products = [
                ["name" => "", "price" => "", "image" => "/assets/img/partners/banner-nauticstore24-about.png", "link" => "ueber-uns", "discount" => "0"],
                ["name" => "", "price" => "", "image" => "/assets/img/partners/banner-yachtservice-dall-leistungen.png", "link" => "https://www.yachtservice-dall.at", "discount" => "0"],
                //["name" => "Winterizing Promotion - up to -20% on winterizing items", "price" => "199.99", "image" => "aktion01.png", "link" => "#", "discount" => "20"],
                //["name" => "Winterizing Promotion - up to -20% on winterizing items", "price" => "249.99", "image" => "aktion01.png", "link" => "#", "discount" => "20"],
            ];

            foreach ($products as $product) {
                echo '<div class="product-item">';
                if($product['discount'] != "" && $product['discount'] > 0) {
                    echo '    <div class="discount-label">-' . htmlspecialchars($product['discount']) . '%</div>';
                }
                echo '    <a href="' . htmlspecialchars($product['link']) . '">';
                echo '        <img src="' . htmlspecialchars($baseUrl . '' . $product['image']) . '" alt="' . htmlspecialchars($product['name']) . '" loading="lazy">';
                echo '        <h3>' . htmlspecialchars($product['name']) . '</h3>';
                echo '    </a>';
                echo '</div>';
            }
            ?>
        </div>
    </section>
</div>