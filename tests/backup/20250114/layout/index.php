<?php
// ------------------------------------------------------------------
// NEUE KATEGORIEN-DATENSTRUKTUR MIT SUBKATEGORIEN FÜR NAV & ÜBERSICHT
// ------------------------------------------------------------------
$categories = [
    [
        'name' => 'Ankern & Belegen',
        'image' => 'kategorie01.png',
        'link'  => '#',
        'subcategories' => [
            'Anker',
            'Ankerketten',
            'Fender & Bojen',
            'Festmacher',
        ]
    ],
    [
        'name' => 'Bekleidung',
        'image' => 'kategorie02.png',
        'link'  => '#',
        'subcategories' => [
            'Jacken & Westen',
            'Hosen',
            'Schuhe',
            'Zubehör',
        ]
    ],
    [
        'name' => 'Elektrik',
        'image' => 'kategorie03.png',
        'link'  => '#',
        'subcategories' => [
            'Batterien',
            'Kabel & Leitungen',
            'Schalter & Sicherungen',
        ]
    ],
    [
        'name' => 'Elektronik',
        'image' => 'kategorie04.png',
        'link'  => '#',
        'subcategories' => [
            'Echolote & Geber',
            'Funkgeräte & Antennen',
            'Navigationssysteme',
        ]
    ],
    [
        'name' => 'Ersatzteile',
        'image' => 'kategorie05.png',
        'link'  => '#',
        'subcategories' => [
            'Filter & Dichtungen',
            'Propeller',
            'Motorersatzteile',
        ]
    ],
    [
        'name' => 'Funsport & SUPs',
        'image' => 'kategorie06.png',
        'link'  => '#',
        'subcategories' => [
            'Stand-Up-Paddling',
            'Wasserski & Wakeboard',
            'Wasserspielzeug',
        ]
    ],
    [
        'name' => 'Motoren',
        'image' => 'kategorie07.png',
        'link'  => '#',
        'subcategories' => [
            'Außenborder',
            'Innenborder',
            'Elektromotoren',
        ]
    ],
    [
        'name' => 'Pflegemittel',
        'image' => 'kategorie08.png',
        'link'  => '#',
        'subcategories' => [
            'Reinigungsmittel',
            'Polituren & Wachse',
            'Lacke & Farben',
        ]
    ],
    [
        'name' => 'Schlauchboote',
        'image' => 'kategorie09.png',
        'link'  => '#',
        'subcategories' => [
            'Festboden-Schlauchboote',
            'Hochdruck-Boden',
            'Zubehör & Paddel',
        ]
    ],
    [
        'name' => 'Trailer',
        'image' => 'kategorie10.png',
        'link'  => '#',
        'subcategories' => [
            'Trailer-Ersatzteile',
            'Winden & Gurte',
            'Trailer-Zubehör',
        ]
    ],
    [
        'name' => 'Zubehör',
        'image' => 'kategorie11.png',
        'link'  => '#',
        'subcategories' => [
            'Rettungswesten',
            'Tauwerk & Seile',
            'Kompass & Navigation',
        ]
    ],
    [
        'name' => 'Aktionen',
        'image' => 'kategorie12.png',
        'link'  => '#',
        'subcategories' => [
            'Sale',
            'Abverkauf',
            'Saison-Rabatte',
        ]
    ]
];
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ersatzteile- & Zubehör-Shop für Boote, Yachten und Motoren - Nauticstore24</title>
    <link rel="stylesheet" href="style.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Font Awesome für Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
    <!-- ============================= HEADER ============================== -->
    <header>
        <!-- Top-Bar mit drei Abschnitten -->
        <div class="top-bar">
            <div class="container">
                <div class="left-info">Alles rund um Boote, Yachten, Motoren, Ersatzteile und Zubehör</div>
                <div class="middle-info"><i class="fa-solid fa-truck-fast"></i> Kostenlose Lieferung nach AT und DE ab € 170,- Bestellwert*</div>
                <div class="right-info"><i class="fa-regular fa-envelope"></i> Kontakt: shop@nauticstore24.at</div>
            </div>
        </div>

        <!-- Hauptheader -->
        <div class="main-header">
            <div class="container">
                <div class="logo">
                    <a href="index.php">
                        <img src="logo.png" alt="Webshop Logo">
                    </a>
                </div>
                <div class="search-bar">
                    <form action="search.php" method="get" role="search" aria-label="Produktsuche">
                        <input type="text" name="q" placeholder="Produkte suchen..." aria-label="Suchfeld">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                <!-- Anmelden neben dem Warenkorb -->
                <div class="user-actions">
                    <a href="login.php" class="login"><i class="fas fa-sign-in-alt"></i> Anmelden</a>
                </div>
                <div class="cart">
                    <a href="cart.php" aria-label="Warenkorb">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-text">0 Artikel | € 0,00</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- =============== NEUE NAVIGATION (Desktop + Mobile) =============== -->
        <nav class="nav-wrapper">
            <!-- ---------- Desktop-Mega-Menü ---------- -->
            <div class="nav-desktop container">
                <ul class="nav-links-desktop">
                    <!-- Alle Hauptkategorien mit Megamenü-Unterkategorien -->
                    <?php foreach ($categories as $catIndex => $catData): ?>
                    <li class="has-megamenu">
                        <a href="<?= htmlspecialchars($catData['link']) ?>">
                            <?= htmlspecialchars($catData['name']) ?>
                        </a>
                        <!-- Megamenü, das auf Hover sichtbar wird -->
                        <div class="mega-menu">
                            <div class="mega-menu-content">
                                <h3><?= htmlspecialchars($catData['name']) ?></h3>
                                <ul class="subcat-list">
                                    <?php
                                    if (isset($catData['subcategories'])) {
                                        foreach ($catData['subcategories'] as $subcat) {
                                            echo "<li><a href='#'>" . htmlspecialchars($subcat) . "</a></li>";
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <?php endforeach; ?>

                    <!-- Weitere statische Links -->
                    <li><a href="#">Angebote</a></li>
                    <li><a href="#">Service</a></li>
                    <li><a href="#">Über uns</a></li>
                </ul>
            </div>

            <!-- ---------- MOBILE TOP-BAR (Burger + Suche) ---------- -->
            <div class="nav-mobile-topbar">
                <div class="container">
                    <div class="mobile-menu-left">
                        <button id="mobile-burger-btn" aria-label="Menü öffnen">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                    <div class="mobile-title">
                        <a href="index.php">Nauticstore24</a>
                    </div>
                    <div class="mobile-menu-right">
                        <button id="mobile-search-btn" aria-label="Suche öffnen">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- ---------- MOBILE OFFCANVAS-MENÜ ---------- -->
            <div class="nav-mobile-overlay" id="nav-mobile-overlay">
                <div class="nav-mobile-header">
                    <button id="mobile-close-btn" aria-label="Menü schließen">
                        <i class="fas fa-times"></i>
                    </button>
                    <span>Menü</span>
                </div>
                <!-- Hauptkategorien-Übersicht mit Bildern (Zalando-like) -->
                <div class="mobile-main-categories" id="mobile-main-categories">
                    <h2>Hauptkategorien</h2>
                    <ul class="mobile-cat-grid">
                        <?php foreach ($categories as $catIndex => $catData): ?>
                        <li>
                            <button class="mobile-cat-btn" data-cat-index="<?= $catIndex ?>">
                                <div class="cat-image-wrap">
                                    <img src="<?= htmlspecialchars($catData['image']) ?>" 
                                         alt="<?= htmlspecialchars($catData['name']) ?>">
                                </div>
                                <span><?= htmlspecialchars($catData['name']) ?></span>
                            </button>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <!-- Weitere (statische) Links -->
                    <div class="mobile-other-links">
                        <ul>
                            <li><a href="#">Angebote</a></li>
                            <li><a href="#">Service</a></li>
                            <li><a href="#">Über uns</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Unterkategorien-Ansicht (wird per JS eingeblendet) -->
                <div class="mobile-subcategories" id="mobile-subcategories">
                    <div class="subcat-header">
                        <button id="mobile-subcat-back" aria-label="Zurück">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        <h2 id="mobile-subcat-title">Unterkategorien</h2>
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
        <div class="container">
            <!-- Hero-Banner -->
            <section class="hero-banner">
                <div class="hero-content">
                    <h1>Willkommen auf Nauticstore24</h1>
                    <p>Entdecken Sie unsere exklusiven Angebote!</p>
                    <a href="#featured-products" class="btn-primary">Jetzt entdecken</a>
                </div>
            </section>

            <!-- Kategorienübersicht -->
            <section class="categories-overview">
                <!-- <h2>Unsere Kategorien</h2> -->
                <div class="categories-grid" id="categories-grid">
                    <?php
                    // Wir nehmen hier dieselben $categories wie in der Navigation.
                    // Jede Hauptkategorie wird als "Kachel" dargestellt.
                    foreach ($categories as $category) {
                        echo '<a href="' . htmlspecialchars($category['link']) . '" class="category-item" style="background-image: url(\'' . htmlspecialchars($category['image']) . '\');">';
                        echo '    <h3>' . htmlspecialchars($category['name']) . '</h3>';
                        echo '    <div class="overlay">Jetzt einkaufen</div>';
                        echo '</a>';
                    }
                    ?>
                </div>
                <!-- <a href="kategorien.php" class="all-categories-link">Alle Kategorien anzeigen</a> -->
            </section>

            <!-- Marken-Slider -->
            <section class="brand-slider">
                <button class="slider-arrow left-arrow" aria-label="Zurück">
                    &#10094;
                </button>
                <div class="brand-slider-container">
                    <div class="brand-slide"><a href="#" target="_blank"><img src="volvo-penta.png" alt="Volvo Penta"></a></div>
                    <div class="brand-slide"><a href="#" target="_blank"><img src="mercury.png" alt="Mercury"></a></div>
                    <div class="brand-slide"><a href="#" target="_blank"><img src="suzuki-marine.png" alt="Suzuki Marine"></a></div>
                    <div class="brand-slide"><a href="#" target="_blank"><img src="allroundmarin.png" alt="Allroundmarin"></a></div>
                    <div class="brand-slide"><a href="#" target="_blank"><img src="garmin.png" alt="Garmin"></a></div>
                    <div class="brand-slide"><a href="#" target="_blank"><img src="quicksilver.png" alt="Quicksilver"></a></div>
                    <div class="brand-slide"><a href="#" target="_blank"><img src="epropulsion.png" alt="ePropulsion"></a></div>
                    <div class="brand-slide"><a href="#" target="_blank"><img src="raymarine.png" alt="Raymarine"></a></div>
                    <div class="brand-slide"><a href="#" target="_blank"><img src="sigma.png" alt="Sigma"></a></div>
                    <div class="brand-slide"><a href="#" target="_blank"><img src="zodiac.png" alt="Zodiac"></a></div>
                    <div class="brand-slide"><a href="#" target="_blank"><img src="bombard.png" alt="Bombard"></a></div>
                    <div class="brand-slide"><a href="#" target="_blank"><img src="yachtservice-dall.png" alt="Yachtservice Dall"></a></div>
                </div>
                <button class="slider-arrow right-arrow" aria-label="Weiter">
                    &#10095;
                </button>
            </section>

            <!-- Sonderangebote (Featured Products) -->
            <section class="featured-products" id="featured-products">
                <h2>Aktionen</h2>
                <div class="products-grid">
                    <?php
                    // Beispielhafte Produkte
                    $products = [
                        ["name" => "Einwinterungsaktion - bis zu -20% auf Einwinterungsartikel", "price" => "",       "image" => "aktion01.png", "link" => "#", "discount" => "20"],
                        ["name" => "Einwinterungsaktion - bis zu -20% auf Einwinterungsartikel", "price" => "149.99", "image" => "aktion01.png", "link" => "#", "discount" => "20"],
                        ["name" => "Einwinterungsaktion - bis zu -20% auf Einwinterungsartikel", "price" => "199.99", "image" => "aktion01.png", "link" => "#", "discount" => "20"],
                        ["name" => "Einwinterungsaktion - bis zu -20% auf Einwinterungsartikel", "price" => "249.99", "image" => "aktion01.png", "link" => "#", "discount" => "20"],
                    ];

                    foreach ($products as $product) {
                        echo '<div class="product-item">';
                        echo '    <div class="discount-label">-' . htmlspecialchars($product['discount']) . '%</div>';
                        echo '    <a href="' . htmlspecialchars($product['link']) . '">';
                        echo '        <img src="' . htmlspecialchars($product['image']) . '" alt="' . htmlspecialchars($product['name']) . '" loading="lazy">';
                        echo '        <h3>' . htmlspecialchars($product['name']) . '</h3>';
                        echo '    </a>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </section>

            <!-- Top Seller -->
            <section class="top-seller" id="top-seller">
                <h2>Top Seller</h2>
                <div class="products-grid">
                    <?php
                    // Beispielhafte Produktanzeige mit Stattpreis
                    $products = [
                        ["name" => "Lalizas Signalhorn Set 380ml 4",  "price" => "299.99", "old_price" => "349.99", "image" => "product01.png", "link" => "#", "discount" => "14", "description" => ""],
                        ["name" => "Lalizas Signalhorn Set 380ml 3",  "price" => "199.99", "old_price" => "229.99", "image" => "product01.png", "link" => "#", "discount" => "13", "description" => ""],
                        ["name" => "Lalizas Signalhorn Set 380ml 4",  "price" => "299.99", "old_price" => "349.99", "image" => "product01.png", "link" => "#", "discount" => "14", "description" => ""],
                        ["name" => "Lalizas Signalhorn Set 380ml 4",  "price" => "249.99", "old_price" => "299.99", "image" => "product01.png", "link" => "#", "discount" => "20", "description" => ""],
                        ["name" => "Lalizas Signalhorn Set 380ml 5",  "price" => "549.99", "old_price" => "599.99", "image" => "product01.png", "link" => "#", "discount" => "10", "description" => ""],
                        ["name" => "Lalizas Signalhorn Set 380ml für etwas Besonderes 6", "price" => "49.99", "old_price" => "69.99", "image" => "product01.png", "link" => "#", "discount" => "30", "description" => ""],
                    ];

                    foreach ($products as $product) {
                        echo '<div class="product-item">';
                        echo '    <div class="discount-label">-' . htmlspecialchars($product['discount']) . '%</div>';
                        echo '    <a href="' . htmlspecialchars($product['link']) . '">';
                        echo '        <img src="' . htmlspecialchars($product['image']) . '" alt="' . htmlspecialchars($product['name']) . '" loading="lazy">';
                        echo '        <h3>' . htmlspecialchars($product['name']) . '</h3>';
                        echo '        <p class="description">' . htmlspecialchars($product['description']) . '</p>';
                        echo '        <div class="price-container">';
                        echo '            <span class="current-price">ab € ' . htmlspecialchars($product['price']) . '</span>';
                        echo '            <span class="old-price">statt: € ' . htmlspecialchars($product['old_price']) . '</span>';
                        echo '        </div>';
                        echo '    </a>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </section>
        </div>
    </main>

    <div class="divider-blue"></div>

    <!-- ============================= FOOTER ============================== -->
    <footer>
        <div class="footer-wrapper">
            <!-- Erster Bereich: 4 Spalten -->
            <div class="footer-container">
                <!-- Spalte 1: Kontakt -->
                <div class="footer-section">
                    <h4>KONTAKT</h4>
                    <p>
                        Nauticstore24<br>
                        Thomas Dall<br>
                        Unterhart 3<br>
                        4113 St. Martin, Österreich<br>
                        Österreich
                    </p>
                    <p>
                        <strong>Telefon:</strong> <a href="tel:+436605198793">+43 660 5198793</a><br>
                        <strong>WhatsApp:</strong> <a href="https://wa.me/436605198793">+43 660 5198793</a><br>
                        <strong>E-Mail:</strong> <a href="mailto:shop@nauticstore24.at">shop@nauticstore24.at</a><br>
                        <strong>Web:</strong> <a href="https://www.nauticstore24.at" target="_blank">www.nauticstore24.at</a>
                    </p>
                    <p>Geschäftsinhaber: Thomas Dall<br>UID: ATU 651 665 44</p>
                </div>

                <!-- Spalte 2: Produktkategorien -->
                <div class="footer-section">
                    <h4>PRODUKTKATEGORIEN</h4>
                    <ul>
                        <li><a href="#">Ankern &amp; Belegen</a></li>
                        <li><a href="#">Bekleidung</a></li>
                        <li><a href="#">Elektrik</a></li>
                        <li><a href="#">Elektronik</a></li>
                        <li><a href="#">Ersatzteile</a></li>
                        <li><a href="#">Funsport &amp; SUPs</a></li>
                        <li><a href="#">Motoren</a></li>
                        <li><a href="#">Pflegemittel</a></li>
                        <li><a href="#">Schlauchboote</a></li>
                        <li><a href="#">Trailer</a></li>
                        <li><a href="#">Zubehör</a></li>
                        <li><a href="#">Aktionen</a></li>
                    </ul>
                </div>

                <!-- Spalte 3: Mein Konto + Kataloge -->
                <div class="footer-section">
                    <h4>MEIN KONTO</h4>
                    <ul>
                        <li><a href="#">Meine Daten</a></li>
                        <li><a href="#">Anmelden/Registrieren</a></li>
                        <li><a href="#">Meine Bestellungen</a></li>
                        <li><a href="#">Meine Gutscheine</a></li>
                    </ul>

                    <h4>KATALOGE DOWNLOADS</h4>
                    <ul>
                        <li><a href="#">zum Downloadbereich</a></li>
                        <li><a href="#">Online Ersatzteilkataloge</a></li>
                    </ul>
                </div>

                <!-- Spalte 4: Service & Information -->
                <div class="footer-section">
                    <h4>AGB</h4>
                    <ul>
                        <li><a href="#">Allgemeine Geschäftsbedingungen</a></li>
                        <li><a href="#">Versandbestimmungen</a></li>
                        <li><a href="#">Rückgabe- und Retouren</a></li>
                    </ul>
                    <h4>SERVICE &amp; INFORMATION</h4>
                    <p><strong>Erreichbarkeit</strong><br>Mo.-Do. 09:00 - 15:00 Uhr</p>
                    <p>Sie finden uns auch auf:</p>
                    <div class="social-icons">
                        <a href="#"><img src="facebook.png" alt="Facebook"></a>
                        <a href="#"><img src="twitter.png" alt="Twitter"></a>
                        <a href="#"><img src="instagram.png" alt="Instagram"></a>
                    </div>
                </div>
            </div>

            <!-- Trennlinie (optional) -->
            <div class="divider-black"></div>

            <!-- Zahlungs- und Versandarten -->
            <div class="footer-payment-shipping container">
                <div class="payment-methods">
                    <img src="paypal.png" alt="PayPal">
                    <img src="visa.png" alt="Visa">
                    <img src="mastercard.png" alt="Mastercard">
                    <img src="stripe.png" alt="Stripe">
                </div>
                <div class="shipping-methods">
                    <img src="post.png" alt="Österreichische Post">
                    <img src="ups.png" alt="UPS">
                    <img src="dhl.png" alt="DHL">
                </div>
            </div>

            <!-- Copyright -->
            <div class="copyright">
                <p>&copy; <?php echo date("Y"); ?> Nauticstore24. Alle Rechte vorbehalten.</p>
            </div>
        </div>
    </footer>

    <!-- ============================= SCRIPTS ============================== -->

    <!-- 1) Klick auf mobile Suche: Suchleiste umschalten -->
    <script>
    document.getElementById('mobile-search-btn').addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector('.search-bar').classList.toggle('active');
    });
    </script>

    <!-- 2) Mobile-Offcanvas-Menü öffnen/schließen & Subkategorien anzeigen -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileBurgerBtn   = document.getElementById('mobile-burger-btn');
        const mobileCloseBtn    = document.getElementById('mobile-close-btn');
        const navMobileOverlay  = document.getElementById('nav-mobile-overlay');
        const mainCatsView      = document.getElementById('mobile-main-categories');
        const subCatsView       = document.getElementById('mobile-subcategories');
        const subCatBackBtn     = document.getElementById('mobile-subcat-back');
        const subCatList        = document.getElementById('mobile-subcat-list');
        const subCatTitle       = document.getElementById('mobile-subcat-title');

        // Kategorien aus PHP in JS übertragen
        const categoriesJS = <?php echo json_encode($categories); ?>;

        // Overlay öffnen
        mobileBurgerBtn.addEventListener('click', () => {
            navMobileOverlay.classList.add('active');
            // auf Hauptkategorien-Ansicht zurücksetzen
            mainCatsView.style.display = 'block';
            subCatsView.style.display  = 'none';
        });

        // Overlay schließen
        mobileCloseBtn.addEventListener('click', () => {
            navMobileOverlay.classList.remove('active');
        });

        // Zurück zu Hauptkategorien
        subCatBackBtn.addEventListener('click', () => {
            mainCatsView.style.display = 'block';
            subCatsView.style.display  = 'none';
            subCatList.innerHTML = '';
        });

        // Klick auf eine Hauptkategorie
        const catButtons = document.querySelectorAll('.mobile-cat-btn');
        catButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const catIndex = btn.dataset.catIndex;
                const selectedCat = categoriesJS[catIndex];
                if (!selectedCat) return;

                // Titel setzen
                subCatTitle.textContent = selectedCat.name;
                // Liste leeren und neu füllen
                subCatList.innerHTML = '';

                if (selectedCat.subcategories) {
                    selectedCat.subcategories.forEach(subcat => {
                        let li   = document.createElement('li');
                        let link = document.createElement('a');
                        link.href = '#'; // später anpassen
                        link.textContent = subcat;
                        li.appendChild(link);
                        subCatList.appendChild(li);
                    });
                }
                // Anzeigen der Subcats, Hauptcats ausblenden
                mainCatsView.style.display = 'none';
                subCatsView.style.display  = 'block';
            });
        });
    });
    </script>

    <!-- 3) Brand-Slider-Autoplay (unverändert aus deinem Code) -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const sliderContainer = document.querySelector('.brand-slider-container');
        const slides = document.querySelectorAll('.brand-slide');
        const leftArrow = document.querySelector('.left-arrow');
        const rightArrow = document.querySelector('.right-arrow');
        const slideCount = slides.length;
        const slideWidth = slides[0].clientWidth;
        let currentIndex = 0;

        // Dupliziere die Logos am Anfang und Ende für nahtloses Scrollen
        sliderContainer.insertAdjacentHTML('beforeend', sliderContainer.innerHTML);
        sliderContainer.insertAdjacentHTML('afterbegin', sliderContainer.innerHTML);

        // Funktion zum Aktualisieren der Slider-Position
        function updateSliderPosition() {
            sliderContainer.style.transition = 'transform 0.5s ease-in-out';
            sliderContainer.style.transform = `translateX(-${(currentIndex + slideCount) * slideWidth}px)`;
        }

        // Setze initiale Position
        sliderContainer.style.transform = `translateX(-${slideCount * slideWidth}px)`;

        // Event Listener für die Pfeile
        leftArrow.addEventListener('click', () => {
            if (currentIndex <= -slideCount) {
                sliderContainer.style.transition = 'none';
                currentIndex = slideCount - 1;
                sliderContainer.style.transform = `translateX(-${(currentIndex + slideCount) * slideWidth}px)`;
                setTimeout(() => updateSliderPosition(), 50);
            } else {
                currentIndex--;
                updateSliderPosition();
            }
        });

        rightArrow.addEventListener('click', () => {
            if (currentIndex >= slideCount) {
                sliderContainer.style.transition = 'none';
                currentIndex = 0;
                sliderContainer.style.transform = `translateX(-${(currentIndex + slideCount) * slideWidth}px)`;
                setTimeout(() => updateSliderPosition(), 50);
            } else {
                currentIndex++;
                updateSliderPosition();
            }
        });

        // Automatisches Scrollen alle 3 Sekunden
        setInterval(() => {
            rightArrow.click();
        }, 3000);
    });
    </script>
</body>
</html>
