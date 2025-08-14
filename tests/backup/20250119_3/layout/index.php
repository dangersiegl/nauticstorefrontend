<?php
// ------------------------------------------------------------------
// NEUE KATEGORIEN-DATENSTRUKTUR MIT SUBKATEGORIEN FÜR NAV & ÜBERSICHT
// ------------------------------------------------------------------
$categories = [
    [
        'name' => 'Ankern & Belegen',
        'image' => 'kategorie01.png',
        'link'  => '#', // Link zur Hauptkategorie
        'subcategories' => [
            [
                'name' => 'Anker',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Bügelanker','link' => '#'],
                    ['name' => 'Plattenanker','link' => '#'],
                    ['name' => 'Faltanker','link' => '#'],
                ]
            ],
            [
                'name' => 'Ankerketten',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Edelstahlketten','link' => '#'],
                    ['name' => 'Feuerverzinkte Ketten','link' => '#'],
                ]
            ],
            [
                'name' => 'Fender & Bojen',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Zylindrische Fender','link' => '#'],
                    ['name' => 'Kugelfender','link' => '#'],
                    ['name' => 'Bojen','link' => '#'],
                ]
            ],
            // ... Mehrfaches Beispiel (im echten Code ggf. verkürzen) ...
            [
                'name' => 'Anker',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Bügelanker','link' => '#'],
                    ['name' => 'Plattenanker','link' => '#'],
                    ['name' => 'Faltanker','link' => '#'],
                ]
            ],
            [
                'name' => 'Ankerketten',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Edelstahlketten','link' => '#'],
                    ['name' => 'Feuerverzinkte Ketten','link' => '#'],
                ]
            ],
            [
                'name' => 'Fender & Bojen',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Zylindrische Fender','link' => '#'],
                    ['name' => 'Kugelfender','link' => '#'],
                    ['name' => 'Bojen','link' => '#'],
                ]
            ],
        ]
    ],
    [
        'name' => 'Bekleidung',
        'image' => 'kategorie02.png',
        'link'  => '#',
        'subcategories' => [
            [
                'name' => 'Jacken & Westen',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Wasserdichte Jacken','link' => '#'],
                    ['name' => 'Winddichte Westen','link' => '#'],
                    ['name' => 'Isolierte Jacken','link' => '#'],
                ]
            ],
            [
                'name' => 'Hosen',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Shorts','link' => '#'],
                    ['name' => 'Lange Hosen','link' => '#'],
                    ['name' => 'Sporthosen','link' => '#'],
                ]
            ],
            [
                'name' => 'Schuhe',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Bootsschuhe','link' => '#'],
                    ['name' => 'Wassersport-Sneakers','link' => '#'],
                    ['name' => 'Sandalen','link' => '#'],
                ]
            ],
            [
                'name' => 'Zubehör',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Schuheinlagen','link' => '#'],
                    ['name' => 'Gürtel','link' => '#'],
                    ['name' => 'Mützen & Caps','link' => '#'],
                ]
            ],
        ]
    ],
    [
        'name' => 'Elektrik',
        'image' => 'kategorie03.png',
        'link'  => '#',
        'subcategories' => [
            [
                'name' => 'Batterien',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Blei-Säure-Batterien','link' => '#'],
                    ['name' => 'Lithium-Batterien','link' => '#'],
                    ['name' => 'AGM-Batterien','link' => '#'],
                ]
            ],
            [
                'name' => 'Kabel & Leitungen',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Kupferkabel','link' => '#'],
                    ['name' => 'Isolierte Leitungen','link' => '#'],
                    ['name' => 'Datenkabel','link' => '#'],
                ]
            ],
            [
                'name' => 'Schalter & Sicherungen',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Hochleistungs-Schalter','link' => '#'],
                    ['name' => 'Sicherungskasten','link' => '#'],
                    ['name' => 'Automatische Sicherungen','link' => '#'],
                ]
            ],
        ]
    ],
    [
        'name' => 'Elektronik',
        'image' => 'kategorie04.png',
        'link'  => '#',
        'subcategories' => [
            [
                'name' => 'Echolote & Geber',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Navigations-Echoloten','link' => '#'],
                    ['name' => 'Ankergeber','link' => '#'],
                    ['name' => 'Fischfinder','link' => '#'],
                ]
            ],
            [
                'name' => 'Funkgeräte & Antennen',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Handfunkgeräte','link' => '#'],
                    ['name' => 'Wellenfunkgeräte','link' => '#'],
                    ['name' => 'Satellitenantennen','link' => '#'],
                ]
            ],
            [
                'name' => 'Navigationssysteme',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'GPS-Empfänger','link' => '#'],
                    ['name' => 'Radar-Systeme','link' => '#'],
                    ['name' => 'Kartenplotter','link' => '#'],
                ]
            ],
        ]
    ],
    [
        'name' => 'Ersatzteile',
        'image' => 'kategorie05.png',
        'link'  => '#',
        'subcategories' => [
            [
                'name' => 'Filter & Dichtungen',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Ölfilter','link' => '#'],
                    ['name' => 'Wasserfilter','link' => '#'],
                    ['name' => 'Dichtungsringe','link' => '#'],
                ]
            ],
            [
                'name' => 'Propeller',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Standardpropeller','link' => '#'],
                    ['name' => 'Leistungspropeller','link' => '#'],
                    ['name' => 'Sportpropeller','link' => '#'],
                ]
            ],
            [
                'name' => 'Motorersatzteile',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Kolben','link' => '#'],
                    ['name' => 'Zylinderköpfe','link' => '#'],
                    ['name' => 'Ventile','link' => '#'],
                ]
            ],
        ]
    ],
    [
        'name' => 'Funsport & SUPs',
        'image' => 'kategorie06.png',
        'link'  => '#',
        'subcategories' => [
            [
                'name' => 'Stand-Up-Paddling',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'SUP Boards','link' => '#'],
                    ['name' => 'Paddel','link' => '#'],
                    ['name' => 'Zubehör','link' => '#'],
                ]
            ],
            [
                'name' => 'Wasserski & Wakeboard',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Wasserski','link' => '#'],
                    ['name' => 'Wakeboards','link' => '#'],
                    ['name' => 'Bindings','link' => '#'],
                ]
            ],
            [
                'name' => 'Wasserspielzeug',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Tauchgeräte','link' => '#'],
                    ['name' => 'Schwimmreifen','link' => '#'],
                    ['name' => 'Taucherbrillen','link' => '#'],
                ]
            ],
        ]
    ],
    [
        'name' => 'Motoren',
        'image' => 'kategorie07.png',
        'link'  => '#',
        'subcategories' => [
            [
                'name' => 'Außenborder',
                'link' => '#',
                'subcategories' => [
                    ['name' => '4-Takt Außenborder','link' => '#'],
                    ['name' => '2-Takt Außenborder','link' => '#'],
                    ['name' => 'Elektro-Außenborder','link' => '#'],
                ]
            ],
            [
                'name' => 'Innenborder',
                'link' => '#',
                'subcategories' => [
                    ['name' => '4-Takt Innenborder','link' => '#'],
                    ['name' => '2-Takt Innenborder','link' => '#'],
                    ['name' => 'Turbo Innenborder','link' => '#'],
                ]
            ],
            [
                'name' => 'Elektromotoren',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Batteriebetriebene Motoren','link' => '#'],
                    ['name' => 'Solarbetriebene Motoren','link' => '#'],
                    ['name' => 'Hybrid-Motoren','link' => '#'],
                ]
            ],
        ]
    ],
    [
        'name' => 'Pflegemittel',
        'image' => 'kategorie08.png',
        'link'  => '#',
        'subcategories' => [
            [
                'name' => 'Reinigungsmittel',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Schiffsreiniger','link' => '#'],
                    ['name' => 'Scheibenreiniger','link' => '#'],
                    ['name' => 'Innenraumreiniger','link' => '#'],
                ]
            ],
            [
                'name' => 'Polituren & Wachse',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Lackpolitur','link' => '#'],
                    ['name' => 'Metallpolitur','link' => '#'],
                    ['name' => 'Holzwachs','link' => '#'],
                ]
            ],
            [
                'name' => 'Lacke & Farben',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Wasserfeste Lacke','link' => '#'],
                    ['name' => 'Anti-Rost-Farben','link' => '#'],
                    ['name' => 'Deckfarben','link' => '#'],
                ]
            ],
        ]
    ],
    [
        'name' => 'Schlauchboote',
        'image' => 'kategorie09.png',
        'link'  => '#',
        'subcategories' => [
            [
                'name' => 'Festboden-Schlauchboote',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Seilbefestigte Boote','link' => '#'],
                    ['name' => 'Schlammschlepp-Boote','link' => '#'],
                    ['name' => 'Transport-Boote','link' => '#'],
                ]
            ],
            [
                'name' => 'Hochdruck-Boden',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Robo-Boden','link' => '#'],
                    ['name' => 'Punch-Boden','link' => '#'],
                    ['name' => 'Hybrid-Boden','link' => '#'],
                ]
            ],
            [
                'name' => 'Zubehör & Paddel',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Paddel','link' => '#'],
                    ['name' => 'Aufblasventile','link' => '#'],
                    ['name' => 'Paddelhebel','link' => '#'],
                ]
            ],
        ]
    ],
    [
        'name' => 'Trailer',
        'image' => 'kategorie10.png',
        'link'  => '#',
        'subcategories' => [
            [
                'name' => 'Trailer-Ersatzteile',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Bremsen','link' => '#'],
                    ['name' => 'Lichtanlagen','link' => '#'],
                    ['name' => 'Stoßdämpfer','link' => '#'],
                ]
            ],
            [
                'name' => 'Winden & Gurte',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Rollenwinden','link' => '#'],
                    ['name' => 'Hydraulikwinden','link' => '#'],
                    ['name' => 'Gurte & Seile','link' => '#'],
                ]
            ],
            [
                'name' => 'Trailer-Zubehör',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Abdeckungen','link' => '#'],
                    ['name' => 'Polsterungen','link' => '#'],
                    ['name' => 'Aufstellhilfen','link' => '#'],
                ]
            ],
        ]
    ],
    [
        'name' => 'Zubehör',
        'image' => 'kategorie11.png',
        'link'  => '#',
        'subcategories' => [
            [
                'name' => 'Rettungswesten',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Kinderrettungswesten','link' => '#'],
                    ['name' => 'Erwachsenrettungswesten','link' => '#'],
                    ['name' => 'Sicherheitswesten','link' => '#'],
                ]
            ],
            [
                'name' => 'Tauwerk & Seile',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Drahtseile','link' => '#'],
                    ['name' => 'Naturfaserseile','link' => '#'],
                    ['name' => 'Kunstfaserseile','link' => '#'],
                ]
            ],
            [
                'name' => 'Kompass & Navigation',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Magnetkompasse','link' => '#'],
                    ['name' => 'GPS-Kompass','link' => '#'],
                    ['name' => 'Navigationssoftware','link' => '#'],
                ]
            ],
        ]
    ],
    [
        'name' => 'Aktionen',
        'image' => 'kategorie12.png',
        'link'  => '#',
        'subcategories' => [
            [
                'name' => 'Sale',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Schnäppchen','link' => '#'],
                    ['name' => 'Rabattaktionen','link' => '#'],
                    ['name' => 'Blitzangebote','link' => '#'],
                ]
            ],
            [
                'name' => 'Abverkauf',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Letzte Stücke','link' => '#'],
                    ['name' => 'Ende der Saison','link' => '#'],
                    ['name' => 'Clearance Sales','link' => '#'],
                ]
            ],
            [
                'name' => 'Saison-Rabatte',
                'link' => '#',
                'subcategories' => [
                    ['name' => 'Sommer-Rabatte','link' => '#'],
                    ['name' => 'Winter-Rabatte','link' => '#'],
                    ['name' => 'Herbst-Rabatte','link' => '#'],
                ]
            ],
        ]
    ]
];

// ------------------------------------------------------------------
// NEUER ARRAY MIT PRODUKTEN FÜR JEDE UNTERKATEGORIE (2. EBENE)
// ------------------------------------------------------------------
$categoryProducts = [
    'Anker' => [
        'name' => 'Anker Deluxe 2.0',
        'price' => '89,99',
        'old_price' => '109,99',
        'image' => 'anker.jpg',
        'discount' => '18',
        'description' => 'Perfekt für Segelboote und Yachten.'
    ],
    'Ankerketten' => [
        'name' => 'Hochfeste Ankerkette',
        'price' => '159,99',
        'old_price' => '199,99',
        'image' => 'anker.jpg',
        'discount' => '20',
        'description' => 'Feuerverzinkt mit hoher Bruchlast.'
    ],
    'Fender & Bojen' => [
        'name' => 'Fender-Set 4-teilig',
        'price' => '74,99',
        'old_price' => '99,99',
        'image' => 'anker.jpg',
        'discount' => '25',
        'description' => 'Mit Gratis-Boje für die Saison.'
    ],

    // Beispiel für Bekleidung-Unterkategorien
    'Jacken & Westen' => [
        'name' => 'Profi-Segeljacke Offshore',
        'price' => '299,99',
        'old_price' => '349,99',
        'image' => 'segeljacke.jpg',
        'discount' => '14',
        'description' => 'Robust, wasserdicht & atmungsaktiv.'
    ],
    'Hosen' => [
        'name' => 'Segelhose Performance',
        'price' => '79,99',
        'old_price' => '99,99',
        'image' => 'segeljacke.jpg',
        'discount' => '20',
        'description' => 'Perfekter Sitz und spritzwassergeschützt.'
    ],
    // ... usw. für andere Unterkategorien
];

// OPTIONAL: Standardprodukt, das angezeigt wird, falls kein Eintrag im obigen Array vorhanden ist:
$defaultTopDeal = [
    'name' => 'Beispielprodukt Standard',
    'price' => '49,99',
    'old_price' => '59,99',
    'image' => 'product01.png',
    'discount' => '20',
    'description' => 'Kurzbeschreibung des Standardprodukts.'
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
        <div class="top-bar" id="topBar">
            <div class="container">
                <div class="left-info">Alles rund um Boote, Yachten, Motoren, Ersatzteile und Zubehör</div>
                <div class="middle-info"><i class="fa-solid fa-truck-fast"></i> Kostenlose Lieferung nach AT und DE ab € 170,- Bestellwert*</div>
                <div class="right-info"><i class="fa-regular fa-envelope"></i> Kontakt: shop@nauticstore24.at</div>
            </div>
        </div>

        <!-- Hauptheader -->
        <div class="main-header" id="mainHeader">
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
                                            // Wir erzeugen für jede Subkategorie ein eigenes DIV,
                                            // das (per JS) beim Hover über die entsprechende Subkategorie aktiv wird.
                                            if (!empty($catData['subcategories']) && is_array($catData['subcategories'])):
                                                $subIndex3 = 0;
                                                foreach ($catData['subcategories'] as $subcat):
                                                    $isActive = ($subIndex3 === 0) ? 'active' : '';

                                                    // Name der Unterkategorie
                                                    $subcatName = $subcat['name'];
                                                    // Passenden Top-Deal holen, sonst Standardprodukt
                                                    $product = $categoryProducts[$subcatName] ?? $defaultTopDeal;
                                                    ?>
                                                    <div class="subcat-topdeal-box <?= htmlspecialchars($isActive) ?>" data-subindex="<?= $subIndex3 ?>">
                                                        <h3>Top Deal</h3>
                                                        <div class="product-item product-item-small">
                                                            <div class="discount-label-small">-<?= htmlspecialchars($product['discount']) ?>%</div>
                                                            <a href="<?= htmlspecialchars($product['link'] ?? '#') ?>">
                                                                <img src="<?= htmlspecialchars($product['image']) ?>"
                                                                    alt="<?= htmlspecialchars($product['name']) ?>"
                                                                    loading="lazy"
                                                                    class="product-image-small">
                                                                <h3 class="product-name-small"><?= htmlspecialchars($product['name']) ?></h3>
                                                                <p class="description product-description-small"><?= htmlspecialchars($product['description']) ?></p>
                                                                <div class="price-container">
                                                                    <span class="current-price">ab € <?= htmlspecialchars($product['price']) ?></span>
                                                                    <span class="old-price">statt: € <?= htmlspecialchars($product['old_price']) ?></span>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    $subIndex3++;
                                                endforeach;
                                            endif;
                                            ?>
                                        </div>
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
                        <button id="mobile-burger-btn" aria-label="Menü öffnen">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                    <!-- Suchleiste -->
                    <div class="search-bar-mobile">
                        <form action="search.php" method="get" role="search" aria-label="Produktsuche">
                            <input type="text" name="q" placeholder="Produkte suchen..." aria-label="Suchfeld">
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
                <div class="mobile-subcategories" id="mobile-subcategories" style="display: none;">
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
                <div class="hero-slider">
                    <!-- Slide 1 -->
                    <div class="hero-slide">
                        <div class="hero-content">
                            <h1>Willkommen auf Nauticstore24</h1>
                            <p>Entdecken Sie unsere exklusiven Angebote!</p>
                            <a href="#featured-products" class="btn-primary">Jetzt entdecken</a>
                        </div>
                    </div>
                    <!-- Slide 2 -->
                    <div class="hero-slide">
                        <div class="hero-content">
                            <h1>Exklusive Aktionen</h1>
                            <p>Sichern Sie sich jetzt Rabatte auf ausgewählte Produkte!</p>
                            <a href="#aktionen" class="btn-primary">Mehr erfahren</a>
                        </div>
                    </div>
                    <!-- Slide 3 -->
                    <div class="hero-slide">
                        <div class="hero-content">
                            <h1>Top-Marken für Sie</h1>
                            <p>Von Volvo Penta bis Garmin - Qualität garantiert!</p>
                            <a href="#brands" class="btn-primary">Jetzt entdecken</a>
                        </div>
                    </div>
                </div>
                <!-- Navigation (optional) -->
                <div class="hero-navigation">
                    <button class="prev-slide">&#10094;</button>
                    <button class="next-slide">&#10095;</button>
                </div>
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

            <!-- Kategorienübersicht -->
            <section class="categories-overview">
                <h2 class="featured-products">Unsere Kategorien</h2>
                <div class="categories-grid" id="categories-grid">
                    <?php
                    // Jede Hauptkategorie wird als "Kachel" dargestellt.
                    foreach ($categories as $category) {
                        echo '<a href="' . htmlspecialchars($category['link']) . '" class="category-item" style="background-image: url(\'' . htmlspecialchars($category['image']) . '\');">';
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

            <!-- Top Seller -->
            <section class="top-seller" id="top-seller">
                <h2>Top Seller</h2>
                <div class="products-grid">
                    <?php
                    // Beispielhafte Produktanzeige
                    $products = [
                        ["name" => "Lalizas Signalhorn Set 380ml 4",  "price" => "299.99", "old_price" => "349.99", "image" => "product01.png", "link" => "#", "discount" => "14", "description" => ""],
                        ["name" => "Lalizas Signalhorn Set 380ml 3",  "price" => "199.99", "old_price" => "229.99", "image" => "product01.png", "link" => "#", "discount" => "13", "description" => ""],
                        ["name" => "Lalizas Signalhorn Set 380ml 4",  "price" => "299.99", "old_price" => "349.99", "image" => "product01.png", "link" => "#", "discount" => "14", "description" => ""],
                        ["name" => "Lalizas Signalhorn Set 380ml 4",  "price" => "249.99", "old_price" => "299.99", "image" => "product01.png", "link" => "#", "discount" => "20", "description" => ""],
                        ["name" => "Lalizas Signalhorn Set 380ml 5",  "price" => "549.99", "old_price" => "599.99", "image" => "product01.png", "link" => "#", "discount" => "10", "description" => ""],
                        ["name" => "Lalizas Signalhorn Set 380ml 6",  "price" => "49.99",  "old_price" => "69.99",  "image" => "product01.png", "link" => "#", "discount" => "30", "description" => ""],
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
                <div class="copyright-container">
                    <span>&copy; <?php echo date("Y"); ?> Nauticstore24.at</span>
                    <div class="copyright-links">
                        <a href="#">Kontakt</a>
                        <a href="#">Impressum</a>
                        <a href="#">Allgemeine Geschäftsbedingungen</a>
                        <a href="#">Datenschutz</a>
                        <a href="#">Versandbedingungen</a>
                        <a href="#">FAQ</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <button id="scrollTopBtn" aria-label="Nach oben scrollen" title="Nach oben scrollen">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- ============================= SCRIPTS ============================== -->

    <!-- Mobile-Offcanvas-Menü öffnen/schließen & Subkategorien anzeigen -->
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
            // Auf Hauptkategorien-Ansicht zurücksetzen
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

        // Klick auf eine Hauptkategorie (zeigt die Unterkategorien)
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

                if (selectedCat.subcategories && Array.isArray(selectedCat.subcategories)) {
                    selectedCat.subcategories.forEach(subcat => {
                        let li   = document.createElement('li');
                        let link = document.createElement('a');
                        link.href = subcat.link ? subcat.link : '#';
                        link.textContent = subcat.name;
                        li.appendChild(link);

                        // Falls dritte Ebene vorhanden
                        if (subcat.subcategories && Array.isArray(subcat.subcategories)) {
                            let nestedUl = document.createElement('ul');
                            subcat.subcategories.forEach(subsubcat => {
                                let nestedLi = document.createElement('li');
                                let nestedLink = document.createElement('a');
                                nestedLink.href = subsubcat.link ? subsubcat.link : '#';
                                nestedLink.textContent = subsubcat.name;
                                nestedLi.appendChild(nestedLink);
                                nestedUl.appendChild(nestedLi);
                            });
                            li.appendChild(nestedUl);
                        }
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

    <!-- Hero-Slider-Autoplay -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const slider = document.querySelector('.hero-slider');
        const slides = document.querySelectorAll('.hero-slide');
        const prevButton = document.querySelector('.prev-slide');
        const nextButton = document.querySelector('.next-slide');
        let currentIndex = 0;
        const slideCount = slides.length;
        const slideInterval = 7000; // Wechsel alle 7 Sekunden

        function updateSlider() {
            slider.style.transform = `translateX(-${currentIndex * 100}%)`;
        }

        function showNextSlide() {
            currentIndex = (currentIndex + 1) % slideCount;
            updateSlider();
        }

        function showPrevSlide() {
            currentIndex = (currentIndex - 1 + slideCount) % slideCount;
            updateSlider();
        }

        // Event Listener für Navigation
        nextButton.addEventListener('click', showNextSlide);
        prevButton.addEventListener('click', showPrevSlide);

        // Automatischer Wechsel
        setInterval(showNextSlide, slideInterval);
    });
    </script>

    <!-- Brand-Slider-Autoplay -->
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

        function updateSliderPosition() {
            sliderContainer.style.transition = 'transform 0.5s ease-in-out';
            sliderContainer.style.transform = `translateX(-${(currentIndex + slideCount) * slideWidth}px)`;
        }

        // Setze initiale Position
        sliderContainer.style.transform = `translateX(-${slideCount * slideWidth}px)`;

        // Arrow events
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

        // Automatisches Scrollen
        setInterval(() => {
            rightArrow.click();
        }, 3000);
    });
    </script>

    <!-- Scroll-to-Top Button -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const scrollTopBtn = document.getElementById('scrollTopBtn');

        window.addEventListener('scroll', function () {
            if (window.scrollY > 50) {
                scrollTopBtn.style.display = 'flex';
            } else {
                scrollTopBtn.style.display = 'none';
            }
        });

        scrollTopBtn.addEventListener('click', function () {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });
    </script>

    <!-- Mega-Menü: Hover-Effekt für Subkategorien (2. und 3. Spalte + Top Deal) -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const navLinks = document.querySelectorAll('.nav-links-desktop > li.has-megamenu');
        const leftItems = document.querySelectorAll('.subcat-list-left li[data-subindex]');

        navLinks.forEach(navLink => {
            navLink.addEventListener('mouseenter', () => {
                navLink.querySelectorAll('.subcat-list-left li').forEach(li => li.classList.remove('active'));
                navLink.querySelectorAll('.sub-subcat-box').forEach(box => box.classList.remove('active'));
                navLink.querySelectorAll('.subcat-topdeal-box').forEach(box => box.classList.remove('active'));

                const firstSubcat = navLink.querySelector('.subcat-list-left li');
                const firstIndex = firstSubcat ? firstSubcat.getAttribute('data-subindex') : null;

                if (firstSubcat) {
                    firstSubcat.classList.add('active');
                }
                if (firstIndex !== null) {
                    const firstBox = navLink.querySelector(`.sub-subcat-box[data-subindex="${firstIndex}"]`);
                    const firstDealBox = navLink.querySelector(`.subcat-topdeal-box[data-subindex="${firstIndex}"]`);
                    if (firstBox) firstBox.classList.add('active');
                    if (firstDealBox) firstDealBox.classList.add('active');
                }
            });
        });

        // Hover-Logik
        leftItems.forEach(item => {
            item.addEventListener('mouseenter', () => {
                const parentMenu = item.closest('.mega-menu');
                parentMenu.querySelectorAll('.subcat-list-left li').forEach(li => li.classList.remove('active'));
                parentMenu.querySelectorAll('.sub-subcat-box').forEach(box => box.classList.remove('active'));
                parentMenu.querySelectorAll('.subcat-topdeal-box').forEach(box => box.classList.remove('active'));

                item.classList.add('active');
                const index = item.getAttribute('data-subindex');
                const targetSubSubcat = parentMenu.querySelector(`.sub-subcat-box[data-subindex="${index}"]`);
                const targetTopDeal = parentMenu.querySelector(`.subcat-topdeal-box[data-subindex="${index}"]`);
                if (targetSubSubcat) targetSubSubcat.classList.add('active');
                if (targetTopDeal) targetTopDeal.classList.add('active');
            });
        });
    });
    </script>

    <!-- ============= NEU: Scroll/Sticky-Verhalten Desktop & Mobile ============= -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
        const topBar = document.getElementById('topBar');          
        const mainHeader = document.getElementById('mainHeader');  
        const navMobileTopbar = document.getElementById('navMobileTopbar');

        let lastScrollY = window.scrollY;

        // Funktion zur dynamischen Höhenberechnung
        function getHeights() {
            const mainHeaderHeight = mainHeader.offsetHeight || 0;
            const topBarHeight = topBar.offsetHeight || 0;
            return { mainHeaderHeight, topBarHeight };
        }

        function updateScroll() {
            const currentScroll = window.scrollY;
            const windowWidth = window.innerWidth;
            const { mainHeaderHeight, topBarHeight } = getHeights();

            if (windowWidth > 1023) {
                // Desktop-Verhalten
                if (currentScroll > topBarHeight) {
                    mainHeader.classList.add('desktop-sticky');
                    // Body Padding einfügen, damit nichts springt
                    document.body.style.paddingTop = mainHeaderHeight + topBarHeight + 'px';
                } else {
                    mainHeader.classList.remove('desktop-sticky');
                    document.body.style.paddingTop = '0';
                }
            } else {
                // Mobile-Verhalten
                if (currentScroll > lastScrollY && currentScroll > 30) {
                    // Scrollen nach unten und über dem Schwellenwert
                    topBar.classList.add('mobile-hidden');
                    mainHeader.classList.add('mobile-hidden');
                    navMobileTopbar.classList.add('mobile-fixed-navtopbar');
                    navMobileTopbar.style.top = "0px";
                } else if (currentScroll < lastScrollY) {
                    // Scrollen nach oben
                    mainHeader.classList.remove('mobile-hidden');
                    //navMobileTopbar.classList.remove('mobile-fixed-navtopbar');

                    if (currentScroll > topBarHeight) {
                        //navMobileTopbar.style.top = mainHeaderHeight + "px";
                    } else {
                        navMobileTopbar.style.top = (mainHeaderHeight + topBarHeight) + "px";
                    }

                    if (currentScroll <= 30) {
                        topBar.classList.remove('mobile-hidden');
                        navMobileTopbar.style.top = (mainHeaderHeight + topBarHeight) + "px";
                        mainHeader.style.marginBottom = "60px";
                    }
                }

                lastScrollY = currentScroll <= 0 ? 0 : currentScroll; // Für Mobile oder negatives Scrollen
            }
        }

        // Throttling der Scroll-Events mit requestAnimationFrame
        let ticking = false;
        window.addEventListener('scroll', () => {
            if (!ticking) {
                window.requestAnimationFrame(() => {
                    updateScroll();
                    ticking = false;
                });
                ticking = true;
            }
        });

        // Aktualisierung der Höhen bei Resize und Load
        window.addEventListener('resize', () => {
            updateScroll();
        });

        window.addEventListener('load', () => {
            updateScroll();
        });
    });
    </script>

</body>
</html>
