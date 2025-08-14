<!-- ============================= MAIN CONTENT ============================== -->
<div class="container">
    <!-- Hero Banner -->
    <section class="hero-banner">
        <div class="hero-slider">
            <?php
            // Only EN hero slides, all active banners
            $stmt = $pdo->prepare("
                SELECT *
                FROM home_hero_banner
                WHERE channel_en = b'1'
                ORDER BY rownum ASC
            ");
            $stmt->execute();
            $slides = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($slides as $slide):
                // Choose title/text based on language
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
                <div class="hero-slide" style="background-image: url('<?= $imgUrl ?>');">
                    <div class="hero-content">
                        <h1><?= htmlspecialchars($title) ?></h1>
                        <p><?= nl2br(htmlspecialchars($text)) ?></p>
                        <a href="<?= $link ?>" class="btn-primary">
                            Learn more
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- Navigation -->
        <div class="hero-navigation">
            <button class="prev-slide" aria-label="Previous slide">&#10094;</button>
            <button class="next-slide" aria-label="Next slide">&#10095;</button>
        </div>
    </section>
    
    <!-- Featured Products -->
    <section class="featured-products" id="featured-products">
        <div class="products-grid">
            <?php
            // Fetch all active EN promotion banners
            $stmt = $pdo->prepare("
                SELECT *
                FROM home_promotion_banner
                WHERE channel_en = b'1'
                ORDER BY rownum ASC
            ");
            $stmt->execute();
            $banners = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($banners as $banner):
                $title = ($lang === 'en' && !empty($banner['title_en']))
                         ? $banner['title_en']
                         : $banner['title_de'];

                $priceHtml = '';
                if ($banner['price'] !== null) {
                    $formatted = number_format($banner['price'], 2, ',', '.');
                    $priceHtml = "<p class=\"price\">€ {$formatted}</p>";
                }

                $discountHtml = '';
                if ($banner['discount'] !== null && $banner['discount'] > 0) {
                    $discountHtml = "<div class=\"discount-label\">-{$banner['discount']}%</div>";
                }

                $imgUrl = htmlspecialchars("{$baseUrl}/assets/img/stock/{$banner['image']}");
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

    <!-- Categories Overview -->
    <section class="categories-overview">
        <h2>Our Categories</h2>
        <div class="categories-grid" id="categories-grid">
            <?php
            foreach ($categories as $category) {
                echo '<a href="' . htmlspecialchars($category['link']) . '" class="category-item" data-lang="'. $currentLang .'" style="background-image: url(\'' . htmlspecialchars($category['image']) . '\');">';
                echo '    <h3>' . htmlspecialchars($category['name']) . '</h3>';
                echo '    <div class="overlay">Shop now</div>';
                echo '</a>';
            }
            ?>
        </div>
    </section>

    <!-- Brand Slider -->
    <h2 class="brand-slide-h2">Our Brands</h2>
    <section class="brand-slider" id="brands">
        <button class="slider-arrow left-arrow" aria-label="Previous brand">&#10094;</button>
        <div class="brand-slider-container">
            <?php foreach (['volvo-penta','mercury','suzuki-marine','allroundmarin','garmin','quicksilver','epropulsion','raymarine','sigma','zodiac','bombard','yachtservice-dall'] as $brand): ?>
            <div class="brand-slide">
                <a href="#" target="_blank">
                    <img src="<?= htmlspecialchars("$baseUrl/assets/img/brands/{$brand}.png") ?>" alt="<?= ucfirst(str_replace('-', ' ', $brand)) ?>">
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        <button class="slider-arrow right-arrow" aria-label="Next brand">&#10095;</button>
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
            <?php foreach ($topProducts as $row): 
                // 2) Preise ermitteln (günstigster Listenpreis + old_price)
                $stmtPrice = $pdo->prepare("
                    SELECT 
                    MIN(CAST(REPLACE(price, ',', '.') AS DECIMAL(10,2)))    AS min_price,
                    MIN(CAST(REPLACE(old_price, ',', '.') AS DECIMAL(10,2))) AS min_old_price
                    FROM products_prices
                    WHERE product_id = :pid
                    AND price_type = 'list'
                ");
                $stmtPrice->execute(['pid' => $row['id']]);
                $pr = $stmtPrice->fetch(PDO::FETCH_ASSOC);
                $price    = $pr['min_price']    !== null ? number_format($pr['min_price'],    2, ',', '.') : '0,00';
                $oldPrice = $pr['min_old_price'] !== null && $pr['min_old_price'] > $pr['min_price']
                            ? number_format($pr['min_old_price'], 2, ',', '.') : '';
                // 3) Rabatt berechnen
                $discount = '';
                if ($pr['min_old_price'] > $pr['min_price'] && $pr['min_old_price'] > 0) {
                    $discount = round((($pr['min_old_price'] - $pr['min_price']) / $pr['min_old_price']) * 100);
                }
                // 4) Variantenanzahl & Lagerbestand
                $stmtVarCnt = $pdo->prepare("SELECT COUNT(*) FROM products_variants WHERE product_id = :pid");
                $stmtVarCnt->execute(['pid' => $row['id']]);
                $varCount = (int)$stmtVarCnt->fetchColumn();
                if ($varCount > 1) {
                    $variants = $varCount . ' Varianten verfügbar';
                    $stock    = '';
                } else {
                    $variants = '';
                    $stmtStock = $pdo->prepare("SELECT stock FROM products_variants WHERE product_id = :pid LIMIT 1");
                    $stmtStock->execute(['pid' => $row['id']]);
                    $stock    = (int)$stmtStock->fetchColumn();
                }
                // 5) Bilder (bis zu 3) laden
                $stmtImg = $pdo->prepare("
                    SELECT image_path
                    FROM products_images
                    WHERE product_id = :pid
                    ORDER BY sort_order ASC
                    LIMIT 3
                ");
                $stmtImg->execute(['pid' => $row['id']]);
                $imgs = $stmtImg->fetchAll(PDO::FETCH_COLUMN);
                if (!$imgs) $imgs = ['assets/img/placeholder.png'];
                // 6) Name, Link & Kurzbeschreibung je nach Sprache
                $productId = (int)$row['id'];
                $name = ($lang === 'de') ? $row['name_de'] : $row['name_en'];
                $desc = ($lang === 'de') ? $row['short_description_de'] : $row['short_description_en'];
                $url  = ($lang === 'de') ? $row['url_de'] : $row['url_en'];
                $link = $baseUrl . '/' . $url . '-' . $row['id'] . '.html';


                // Array für renderProductItem zusammenbauen
                $product = [
                    'id'          => $productId,
                    'name'        => $name,
                    'price'       => $price,
                    'old_price'   => $oldPrice,
                    'images'      => $imgs,
                    'link'        => $link,
                    'discount'    => (string)$discount,
                    'description' => $desc,
                    'stock'       => (string)$stock,
                    'variants'    => ($varCount > 1 ? (string)$varCount : '')
                ];
            ?>

                <?= renderProductItem($product, $translations_product_item[$lang], $lang, $baseUrl) ?>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- About Us -->
    <section class="featured-products" id="about-us">
        <h2>About Us</h2>
        <div class="products-grid">
            <?php
            $aboutBanners = [
              ['image'=>'/assets/img/partners/banner-nauticstore24-about-en.png','link'=>'about'],
              ['image'=>'/assets/img/partners/banner-yachtservice-dall-leistungen-en.png','link'=>'https://www.yachtservice-dall.at'],
            ];
            foreach ($aboutBanners as $b):
            ?>
            <div class="product-item">
                <a href="<?= htmlspecialchars($b['link']) ?>" target="_blank">
                    <img src="<?= htmlspecialchars($baseUrl . $b['image']) ?>" alt="" loading="lazy">
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
</div>
