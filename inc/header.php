<?php
// inc/header.php

global $lang, $pdo;

// Stelle sicher, dass die Session läuft
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1) Aktuelle User-ID und Session-ID holen
$userId    = $_SESSION['user_id'] ?? null;
$sessionId = session_id();

// ------------------------------------------------------------------
// Sprachen-Links und Sprachwechsel
// ------------------------------------------------------------------
require_once 'inc/translations.php';

// ------------------------------------------------------------------
// Rendern der Product-Items
// ------------------------------------------------------------------
require_once 'inc/productitem.php';

// config.php einbinden und Config-Instanz abrufen
require_once 'inc/config.php';
$config = Config::getInstance();

// Aktuelle Domain und Sprache bestimmen
$currentDomain = $_SERVER['HTTP_HOST'];
$currentConfig = $config->domainConfigMap[$currentDomain] ?? null;

if ($currentConfig) {
    $currentLang = $currentConfig['lang'];
    $currentBaseUrl = $currentConfig['base_url'];

    // Ermitteln, ob die aktuelle Domain zur Test- oder Produktionsumgebung gehört
    $testDomains = array_keys(array_filter($config->domainConfigMap, function($key) {
        return strpos($key, 'jackydoo') !== false;
    }, ARRAY_FILTER_USE_KEY));

    $prodDomains = array_keys(array_filter($config->domainConfigMap, function($key) use ($testDomains) {
        return !in_array($key, $testDomains);
    }, ARRAY_FILTER_USE_KEY));

    $isTestEnvironment = in_array($currentDomain, $testDomains);

    // Ziel-URLs für die andere Sprache, basierend auf der aktuellen Umgebung
    $otherLanguageUrls = [];
    foreach ($config->domainConfigMap as $domain => $settings) {
        $isSameEnvironment = ($isTestEnvironment && in_array($domain, $testDomains)) || (!$isTestEnvironment && in_array($domain, $prodDomains));
        
        if ($settings['lang'] !== $currentLang && $isSameEnvironment) {
            $otherLanguageUrls[$settings['lang']] = $settings['base_url'];
        }
    }
} else {
    // Fallback für nicht konfigurierte Domains
    $currentLang = $config->defaultLanguage;
    $currentBaseUrl = '/';
    $otherLanguageUrls = [];
}

// ------------------------------------------------------------------
// Wishlist-Count abfragen
if ($userId) {
    $stmt = $pdo->prepare("
      SELECT COUNT(*) 
      FROM wishlist_items
      WHERE user_id = :uid
    ");
    $stmt->execute(['uid' => $userId]);
} else {
    $stmt = $pdo->prepare("
      SELECT COUNT(*)
      FROM wishlist_items
      WHERE user_id IS NULL
        AND session_id = :sid
    ");
    $stmt->execute(['sid' => $sessionId]);
    echo $userId;
}
$wishlistCount = (int)$stmt->fetchColumn();

// ------------------------------------------------------------------

// ------------------------------------------------------------------
// NEUE KATEGORIEN-DATENSTRUKTUR MIT SUBKATEGORIEN FÜR NAV & ÜBERSICHT
// ------------------------------------------------------------------

// Bestimmen Sie die sprachspezifischen Felder für Kategorien
$titleField = ($lang === 'en') ? 'title_en' : 'title_de';
$urlField = ($lang === 'en') ? 'url_en' : 'url_de';

// Initialisieren Sie das Kategorien-Array
$categories = [];

// Sicherstellen, dass $pdo verfügbar ist
if (!isset($pdo)) {
    die(($lang === 'en') ? "Database connection is not available." : "Datenbankverbindung ist nicht verfügbar.");
}

// Hauptkategorien abfragen basierend auf der aktuellen Sprache
$stmt = $pdo->prepare("SELECT id, {$titleField} AS name, CONCAT({$urlField}, '-c', id, '.html') AS link, CONCAT({$urlField}, '-c', id) AS bild FROM products_categories ORDER BY rownum");
$stmt->execute();
$categoriesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($categoriesData as $category) {
    $categoryId = $category['id'];
    $categoryUrl = $category['link'];
    $categoryImage = $category['bild'];

    // Dynamisches Bild erzeugen
    $imagePath = file_exists("assets/img/categories/{$categoryImage}.png")
        ? "assets/img/categories/{$categoryImage}.png"
        : "assets/img/categories/default.png";

    // Subkategorien für diese Hauptkategorie abrufen basierend auf der aktuellen Sprache
    $stmtSub = $pdo->prepare("SELECT id, {$titleField} AS name, CONCAT({$urlField}, '-sc', id, '.html') AS link, CONCAT({$urlField}, '-c', id) AS bild FROM products_categories_subcategories WHERE category_id = ? ORDER BY rownum");
    $stmtSub->execute([$categoryId]);
    $subcategoriesData = $stmtSub->fetchAll(PDO::FETCH_ASSOC);

    $subcategories = [];
    foreach ($subcategoriesData as $subcategory) {
        $subcategoryId = $subcategory['id'];

        // Sub-Subkategorien für diese Subkategorie abrufen basierend auf der aktuellen Sprache
        $stmtSubSub = $pdo->prepare("SELECT {$titleField} AS name, CONCAT({$urlField}, '-ssc', id, '.html') AS link, CONCAT({$urlField}, '-c', id) AS bild FROM products_categories_sub_subcategories WHERE subcategory_id = ? ORDER BY rownum");
        $stmtSubSub->execute([$subcategoryId]);
        $subSubcategoriesData = $stmtSubSub->fetchAll(PDO::FETCH_ASSOC);

        $subcategories[] = [
            'id'   => $subcategory['id'],  
            'name' => $subcategory['name'],
            'link' => $subcategory['link'],
            'subcategories' => $subSubcategoriesData,
        ];
    }

    $categories[] = [
        'name' => $category['name'],
        'link' => $category['link'],
        'image' => $imagePath, // Dynamisches Bild
        'subcategories' => $subcategories,
    ];
}

// Sicherstellen, dass $lang und $baseUrl definiert sind
if (!isset($lang)) {
    $config = Config::getInstance();
    $lang = $config->defaultLanguage;
}

if (!isset($baseUrl)) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' 
        || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $baseUrl = $protocol . $_SERVER['HTTP_HOST'];
}

$config = Config::getInstance(); // Zugriff auf die Konfigurationsinstanz
?>

<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($lang); ?>">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    $defaultTitle = ($lang === 'en')
        ? 'Spare parts & accessories store for boats, yachts and engines'
        : 'Ersatzteile- & Zubehör-Shop für Boote, Yachten und Motoren';

    // if a page set $pageTitle, prefix it (and add the hyphen)
    $fullTitle = (isset($pageTitle) && $pageTitle !== '')
        ? htmlspecialchars($pageTitle) . ' – ' . $defaultTitle
        : $defaultTitle;
    ?>
    <title><?= $fullTitle ?> – NauticStore24</title>
    <link rel="stylesheet" href="<?php echo $baseUrl; ?>/assets/css/style.css">
    <?php
    $defaultDescription = ($lang==='en')
        ? 'Your online store for nautical spare parts and accessories for boats, yachts and engines'
        : 'Ihr Onlineshop für nautische Ersatzteile und Zubehör für Boote, Yachten und Motoren';

    $description = isset($pageDescription) && $pageDescription !== ''
        ? $pageDescription
        : $defaultDescription;
    ?>
    <meta name="description" content="<?= htmlspecialchars($description) ?>">
    <?php
    // wenn $pageCss gesetzt ist, binde es ein
    if (!empty($pageCss)): ?>
      <link rel="stylesheet" href="<?php echo $baseUrl; ?>/assets/css/<?php echo htmlspecialchars($pageCss); ?>">
    <?php endif; ?>
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Font Awesome für Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="<?php echo $baseUrl; ?>/assets/img/favicon/favicon.ico" type="image/x-icon">
</head>
<body>
    <!-- ============================= HEADER ============================== -->
    <header>
        <!-- Top-Bar mit drei Abschnitten -->
        <div class="top-bar" id="topBar">
            <div class="container">
                <div class="left-info">
                    <?php echo ($lang === 'en') 
                        ? 'Everything for boats, yachts, engines, spare parts, and accessories' 
                        : 'Alles rund um Boote, Yachten, Motoren, Ersatzteile und Zubehör'; ?>
                </div>
                <div class="middle-info">
                    <i class="fa-solid fa-truck-fast"></i> 
                    <?php echo ($lang === 'en') 
                        ? 'Free shipping to AT and DE for orders over €170*' 
                        : 'Kostenlose Lieferung nach AT und DE ab € 170,- Bestellwert*'; ?>
                </div>
                <div class="right-info">
                    <i class="fa-regular fa-envelope"></i> 
                    <?php echo ($lang === 'en') 
                        ? 'Contact: <a href="mailto:shop@nauticstore24.com">shop@nauticstore24.com</a>' 
                        : 'Kontakt: <a href="mailto:shop@nauticstore24.at">shop@nauticstore24.at</a>'; ?>
                </div>
            </div>
        </div>

        <!-- Hauptheader -->
        <div class="main-header" id="mainHeader">
            <div class="container">
                <div class="logo">
                    <a href="<?php echo $baseUrl; ?>">
                        <img src="<?php echo $baseUrl; ?>/assets/img/logo.png" alt="Webshop Logo">
                    </a>
                </div>
                <div class="search-bar">
                    <!-- Suchformular -->
                    <form action="<?php echo url('search'); ?>" method="get" role="search" aria-label="<?= ($currentLang === 'en') ? 'product search' : 'Produktsuche'; ?>">
                        <input type="text" name="q" placeholder="<?= ($currentLang === 'en') ? 'Search for products...' : 'Produkte suchen...'; ?>" aria-label="Suchfeld">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <!-- Language Switcher außerhalb von user-actions -->
                <div class="language-switcher">
                    <button type="button" class="lang-btn" aria-label="<?= ($currentLang === 'en') ? 'Change Language' : 'Sprache wechseln'; ?>">
                        <img src="<?= htmlspecialchars($currentBaseUrl); ?>/assets/img/flags/<?= ($currentLang === 'en') ? 'en.png' : 'de.png'; ?>" alt="<?= ($currentLang === 'en') ? 'English' : 'Deutsch'; ?>">
                    </button>
                    <ul class="lang-dropdown">
                        <li class="lang-dropdown-header">
                            <?= ($currentLang === 'en') ? 'Change Language' : 'Sprache wechseln'; ?>
                        </li>
                        <?php if (isset($otherLanguageUrls['de'])): ?>
                            <li><a href="<?= htmlspecialchars($otherLanguageUrls['de']); ?>"><img src="<?= htmlspecialchars($currentBaseUrl); ?>/assets/img/flags/de.png" alt="Deutsch"> Deutsch</a></li>
                        <?php endif; ?>
                        <?php if (isset($otherLanguageUrls['en'])): ?>
                            <li><a href="<?= htmlspecialchars($otherLanguageUrls['en']); ?>"><img src="<?= htmlspecialchars($currentBaseUrl); ?>/assets/img/flags/en.png" alt="English"> English</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="user-actions">
                <?php if (!empty($_SESSION['user_id'])): ?>
                    <a href="<?php echo url('account'); ?>" class="user-account">
                    <i class="fas fa-user-circle"></i>
                    <span class="user-actions-text">
                        <?= ($lang === 'en') ? 'My Account' : 'Mein Konto'; ?>
                    </span>
                    </a>
                <?php else: ?>
                    <a href="<?php echo url('account/login'); ?>" class="login">
                    <i class="fas fa-sign-in-alt"></i>
                    <span class="user-actions-text">
                        <?= ($lang === 'en') ? 'Login' : 'Anmelden'; ?>
                    </span>
                    </a>
                <?php endif; ?>
                </div>
                <div class="wishlist">
                <a href="<?php echo url('account/wishlist'); ?>" aria-label="<?= ($lang==='en')?'Wishlist':'Wunschliste' ?>">
                    <i class="fas fa-bookmark"></i>
                    <span class="cart-text">
                    <?= $wishlistCount ?>
                    </span>
                </a>
                </div>

                <div class="cart">
                    <a href="<?php echo url('cart'); ?>" aria-label="Warenkorb">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-text">0 <span class="hide-in-mobile"><?= ($currentLang === 'en') ? 'Items' : 'Artikel'; ?> </span>| € 0,00</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- =============== NEUE NAVIGATION (Desktop + Mobile) =============== -->
        <nav class="nav-wrapper">
            <!-- ---------- Desktop-Mega-Menü ---------- -->
            <div class="nav-desktop">
                <div class="nav-desktop container">
                    <ul class="nav-links-desktop">
                        <!-- Alle Hauptkategorien mit Megamenü-Unterkategorien -->
                        <?php foreach ($categories as $catIndex => $catData): ?>
                            <li class="has-megamenu">
                                <a href="<?= htmlspecialchars($catData['link']) ?>">
                                    <?= htmlspecialchars($catData['name']) ?>
                                </a>
                                <!-- Mega-Menü -->
                                <div class="mega-menu">
                                    <div class="mega-menu-content three-col-layout">
                                        
                                        <!-- Spalte 1: Unterkategorien-Liste (2. Ebene) -->
                                        <div class="mega-menu-left">
                                            <ul class="subcat-list-left">
                                                <?php if (!empty($catData['subcategories']) && is_array($catData['subcategories'])): ?>
                                                    <?php $subIndex = 0; ?>
                                                    <?php foreach ($catData['subcategories'] as $subcat): ?>
                                                        <?php
                                                            $subName = $subcat['name'];
                                                            $subLink = $subcat['link'];
                                                            $liClass = ($subIndex === 0) ? 'active' : '';
                                                            $hasSubmenu = !empty($subcat['subcategories']) ? 'has-submenu' : '';
                                                        ?>
                                                        <li class="<?= htmlspecialchars($liClass) ?> <?= $hasSubmenu ?>" data-subindex="<?= $subIndex ?>">
                                                            <a href="<?= htmlspecialchars($subLink) ?>">
                                                                <?= htmlspecialchars($subName) ?>
                                                            </a>
                                                        </li>
                                                        <?php $subIndex++; ?>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </ul>
                                        </div>

                                        <!-- Spalte 2: Unter-Unterkategorien (3. Ebene) -->
                                        <div class="mega-menu-middle">
                                            <?php
                                            if (!empty($catData['subcategories']) && is_array($catData['subcategories'])):
                                                $subIndex2 = 0;
                                                foreach ($catData['subcategories'] as $subcat):
                                                    $isActive = ($subIndex2 === 0) ? 'active' : '';
                                                    
                                                    if (!empty($subcat['subcategories'])) {
                                                        ?>
                                                        <div class="sub-subcat-box <?= htmlspecialchars($isActive) ?>" data-subindex="<?= $subIndex2 ?>">
                                                            <div class="sub-subcat">
                                                                <a href="<?= htmlspecialchars($subcat['link']) ?>"><b><?= htmlspecialchars($subcat['name']) ?></b></a>
                                                                <?php foreach ($subcat['subcategories'] as $thirdItem): ?>
                                                                    <a href="<?= htmlspecialchars($thirdItem['link']) ?>">
                                                                        <?= htmlspecialchars($thirdItem['name']) ?>
                                                                    </a>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    $subIndex2++;
                                                endforeach;
                                            endif;
                                            ?>
                                        </div>

                                        <!-- Spalte 3: Featured-Product pro Unterkategorie -->
                                        <div class="mega-menu-right">
                                            <?php
                                            if (!empty($catData['subcategories']) && is_array($catData['subcategories'])):
                                                $subIndex3 = 0;
                                                foreach ($catData['subcategories'] as $subcat):
                                                    $isActive = ($subIndex3 === 0) ? 'active' : '';

                                                    // Produkt für den Top Deal aus der Datenbank abrufen:
                                                    $stmtTopDeal = $pdo->prepare("
                                                        SELECT *
                                                        FROM products_products
                                                        WHERE top_deal_category_id = :subcatId
                                                        LIMIT 1
                                                    ");
                                                    // 1) Top-Deal aus Feld top_deal_category_id
                                                    $stmtTopDeal = $pdo->prepare("
                                                        SELECT *
                                                        FROM products_products
                                                        WHERE top_deal_category_id = :subcatId
                                                        LIMIT 1
                                                    ");
                                                    $stmtTopDeal->execute(['subcatId' => (int)$subcat['id']]);
                                                    $topDealProduct = $stmtTopDeal->fetch(PDO::FETCH_ASSOC);

                                                    // 2) Falls keiner definiert ist, echten Bestseller ermitteln
                                                    if (!$topDealProduct) {
                                                        $stmtBestSeller = $pdo->prepare("
                                                            SELECT p.id, SUM(oi.quantity) AS total_sold
                                                            FROM products_products p
                                                            JOIN products_variants pv ON pv.product_id = p.id
                                                            JOIN order_items oi       ON oi.variant_id = pv.variant_id
                                                            WHERE p.category_id = :subcatId
                                                            GROUP BY p.id
                                                            ORDER BY total_sold DESC
                                                            LIMIT 1
                                                        ");
                                                        $stmtBestSeller->execute(['subcatId' => (int)$subcat['id']]);
                                                        $best = $stmtBestSeller->fetch(PDO::FETCH_ASSOC);
                                                        if ($best) {
                                                            $topDealProduct = ['id' => $best['id']];
                                                        }
                                                    }

                                                    // 3) Ausgabe via neue Funktion
                                                    if (!empty($topDealProduct['id'])): ?>
                                                        <div class="subcat-topdeal-box <?= htmlspecialchars($isActive) ?>" data-subindex="<?= $subIndex3 ?>">
                                                            <h3>Top Deal</h3>
                                                            <?= renderProductItemNew(
                                                                (int)$topDealProduct['id'],
                                                                null,  // erste Variante oder null
                                                                $translations_product_item[$lang],
                                                                $lang,
                                                                $baseUrl,
                                                                false  // keine Small-Ansicht
                                                            ); ?>
                                                        </div>
                                                    <?php endif; ?>

                                                    <?php
                                                    $subIndex3++;
                                                endforeach;
                                            endif;
                                            ?>
                                        </div>


                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <!-- ---------- MOBILE TOP-BAR (Burger + Suche) ---------- -->
            <div class="nav-mobile-topbar" id="navMobileTopbar">
                <div class="container">
                    <div class="mobile-menu-left">
                        <button id="mobile-burger-btn" aria-label="<?php echo ($lang === 'en') ? 'Open menu' : 'Menü öffnen'; ?>">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                    <!-- Suchleiste -->
                    <div class="search-bar-mobile">
                        <form action="<?php echo url('search'); ?>" method="get" role="search" aria-label="<?php echo ($lang === 'en') ? 'Product search' : 'Produktsuche'; ?>">
                            <input type="text" name="q" placeholder="<?php echo ($lang === 'en') ? 'Search for products...' : 'Produkte suchen...'; ?>" aria-label="<?php echo ($lang === 'en') ? 'Product search' : 'Produktsuche'; ?>">
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- ---------- MOBILE OFFCANVAS-MENÜ ---------- -->
            <div class="nav-mobile-overlay" id="nav-mobile-overlay">
                <div class="nav-mobile-header">
                    <button id="mobile-close-btn" aria-label="Menü schließen">
                        <i class="fas fa-times"></i>
                    </button>
                    <span><?php echo ($lang === 'en') ? 'Menu' : 'Menü'; ?></span>
                </div>
                <!-- Hauptkategorien-Übersicht mit Bildern (Zalando-like) -->
                <div class="mobile-main-categories" id="mobile-main-categories">
                    <h2><?php echo ($lang === 'en') ? 'Our categories' : 'Hauptkategorien'; ?></h2>
                    <ul class="mobile-cat-grid">
                        <?php foreach ($categories as $catIndex => $catData): ?>
                        <li>
                            <button class="mobile-cat-btn" data-cat-index="<?= $catIndex ?>">
                                <div class="cat-image-wrap">
                                    <img src="<?= htmlspecialchars($catData['image']) ?>" alt="<?= htmlspecialchars($catData['name']) ?>">
                                </div>
                                <span><?= htmlspecialchars($catData['name']) ?></span>
                            </button>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <!-- Weitere (statische) Links -->
                    <div class="mobile-other-links">
                        <ul>
                            <li><a href="<?= url('my-data'); ?>"><?php echo ($lang === 'en') ? 'My Account' : 'Mein Konto'; ?></a></li>
                            <li><a href="<?= url('my-data'); ?>"><?php echo ($lang === 'en') ? 'Wishlist' : 'Merkliste'; ?></a></li>
                            <li><a href="<?= url('my-data'); ?>"><?php echo ($lang === 'en') ? 'Cart' : 'Warenkorb'; ?></a></li>
                            <li><a href="<?= url('my-data'); ?>"><?php echo ($lang === 'en') ? 'About us' : 'Über uns'; ?></a></li>
                        </ul>
                    </div>
                </div>

                <!-- Unterkategorien-Ansicht (wird per JS eingeblendet) -->
                <div class="mobile-subcategories" id="mobile-subcategories" style="display: none;">
                    <div class="subcat-header">
                        <button id="mobile-subcat-back" aria-label="Zurück">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        <h2 id="mobile-subcat-title"><?php echo ($lang === 'en') ? 'Sub categories' : 'Unterkategorien'; ?></h2>
                    </div>
                    <ul class="mobile-subcat-list" id="mobile-subcat-list">
                        <!-- Hier baut das JS die Unterkategorie-Links ein -->
                    </ul>
                </div>
            </div>

        </nav>
    </header>

    <!-- ============================= MAIN ============================== -->
    <main>
