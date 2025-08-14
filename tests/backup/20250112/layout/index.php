<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dein Webshop</title>
    <link rel="stylesheet" href="style.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Font Awesome für Icons (aktualisiert auf die neueste stabile Version) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <!-- Top-Bar mit drei Abschnitten -->
        <div class="top-bar">
            <div class="container">
                <div class="left-info">Alles rund um Boote, Yachten, Motoren, Ersatzteile und Zubehör</div>
                <div class="middle-info"><i class="fa-solid fa-truck-fast"></i> Kostenlose Lieferung nach AT und DE ab € 170,- Bestellwert*</div>
                <div class="right-info"><i class="fa-regular fa-envelope"></i> Kontakt: shop@nauticstore24.at</div>
            </div>
        </div>
        <!-- Hauptheader ohne Fixierung -->
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
        <!-- Navigation mit Dropdown für zusätzliche Kategorien -->
        <nav>
            <div class="container">
                <ul class="nav-links">
                    <?php
                        // Array mit allen Kategorien (Name => Link)
                        $kategorien = array(
                            "Ankern & Belegen" => "#",
                            "Bekleidung" => "#",
                            "Elektrik" => "#",
                            "Elektronik" => "#",
                            "Ersatzteile" => "#",
                            "Funsport & SUPs" => "#",
                            "Motoren" => "#",
                            "Pflegemittel" => "#",
                            "Schlauchboote" => "#",
                            "Trailer" => "#",
                            "Zubehör" => "#",
                            "Aktionen" => "#"
                        );

                        // Anzahl der Kategorien, die direkt angezeigt werden sollen
                        $anzahlDirektAnzeigen = 4;

                        // Zähler für direkt angezeigte Kategorien
                        $direktAnzeigenCounter = 0;

                        // Ausgabe der direkten Kategorien
                        foreach ($kategorien as $name => $link) {
                            if ($direktAnzeigenCounter < $anzahlDirektAnzeigen) {
                                echo "<li><a href=\"$link\">$name</a></li>";
                                $direktAnzeigenCounter++;
                            } else {
                                // Restliche Kategorien kommen ins Dropdown
                                $restlicheKategorien[$name] = $link;
                            }
                        }
                    ?>
                    <li class="dropdown">
                        <a href="#">Alle Kategorien <i class="fas fa-chevron-down"></i></a>
                        <div class="dropdown-content">
                            <div class="dropdown-column">
                                <h4>Weitere Kategorien</h4>
                                <ul>
                                    <?php
                                        if (isset($restlicheKategorien)) {
                                            foreach ($restlicheKategorien as $name => $link) {
                                                echo "<li><a href=\"$link\">$name</a></li>";
                                            }
                                        }
                                    ?>
                                    <li><a href="kategorien.php">Alle Kategorien anzeigen</a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                    <li><a href="#">Angebote</a></li>
                    <li><a href="#">Service</a></li>
                    <li><a href="#">Über uns</a></li>
                    <li class="search-mobile">
                        <a href="#" id="mobile-search-toggle"><i class="fas fa-search"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
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
                <!--<h2>Unsere Kategorien</h2>-->
                <div class="categories-grid" id="categories-grid">
                    <?php
                        // Beispielhafte Kategorienanzeige, in der Realität sollten Kategorien aus einer Datenbank geladen werden
                        $categories = [
                            ["name" => "Ankern & Belegen", "image" => "kategorie01.png", "link" => "#"],
                            ["name" => "Bekleidung", "image" => "kategorie02.png", "link" => "#"],
                            ["name" => "Elektrik", "image" => "kategorie03.png", "link" => "#"],
                            ["name" => "Elektronik", "image" => "kategorie04.png", "link" => "#"],
                            ["name" => "Ersatzteile", "image" => "kategorie05.png", "link" => "#"],
                            ["name" => "Funsport & SUPs", "image" => "kategorie06.png", "link" => "#"],
                            ["name" => "Motoren", "image" => "kategorie07.png", "link" => "#"],
                            ["name" => "Pflegemittel", "image" => "kategorie08.png", "link" => "#"],
                            ["name" => "Schlauchboote", "image" => "kategorie09.png", "link" => "#"],
                            ["name" => "Trailer", "image" => "kategorie10.png", "link" => "#"],
                            ["name" => "Zubehör", "image" => "kategorie11.png", "link" => "#"],
                            ["name" => "Aktionen", "image" => "kategorie12.png", "link" => "#"],
                        ];                        

                        foreach ($categories as $category) {
                            echo '<a href="' . htmlspecialchars($category['link']) . '" class="category-item" style="background-image: url(\'' . htmlspecialchars($category['image']) . '\');">';
    echo '    <h3>' . htmlspecialchars($category['name']) . '</h3>';
                            echo '    <div class="overlay">Jetzt einkaufen</div>';
                            echo '</a>';
                        }
                    ?>
                </div>
                <!--<a href="kategorien.php" class="all-categories-link">Alle Kategorien anzeigen</a>-->
            </section>
            <!-- Sonderangebote -->
            <section class="featured-products" id="featured-products">
                <h2>Aktionen</h2>
                <div class="products-grid">
                    <?php
                        // Beispielhafte Produktanzeige, in der Realität sollten Produkte aus einer Datenbank geladen werden
                        $products = [
                            ["name" => "Einwinterungsaktion -20%", "price" => "", "image" => "aktion01.png", "link" => "#"],
                            ["name" => "Produkt 2", "price" => "149.99", "image" => "aktion01.png", "link" => "#"],
                            ["name" => "Produkt 3", "price" => "199.99", "image" => "aktion01.png", "link" => "#"],
                            ["name" => "Produkt 4", "price" => "249.99", "image" => "aktion01.png", "link" => "#"],
                        ];

                        foreach ($products as $product) {
                            echo '<div class="product-item">';
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
                        // Beispielhafte Produktanzeige, in der Realität sollten Produkte aus einer Datenbank geladen werden
                        $products = [
                            ["name" => "Produkt 1", "price" => "99.99", "image" => "product01.png", "link" => "#"],
                            ["name" => "Produkt 2", "price" => "149.99", "image" => "product01.png", "link" => "#"],
                            ["name" => "Produkt 3", "price" => "199.99", "image" => "product01.png", "link" => "#"],
                            ["name" => "Produkt 4", "price" => "249.99", "image" => "product01.png", "link" => "#"],
                            ["name" => "Produkt 5", "price" => "549.99", "image" => "product01.png", "link" => "#"],
                            ["name" => "Produkt 6", "price" => "49.99", "image" => "product01.png", "link" => "#"],
                        ];

                        foreach ($products as $product) {
                            echo '<div class="product-item">';
                            echo '    <a href="' . htmlspecialchars($product['link']) . '">';
                            echo '        <img src="' . htmlspecialchars($product['image']) . '" alt="' . htmlspecialchars($product['name']) . '" loading="lazy">';
                            echo '        <h3>' . htmlspecialchars($product['name']) . '</h3>';
                            echo '        <span class="price">€' . htmlspecialchars($product['price']) . '</span>';
                            echo '    </a>';
                            echo '</div>';
                        }
                    ?>
                </div>
            </section>
        </div>
    </main>
    <footer>
        <div class="container footer-container">
            <div class="footer-links">
                <h4>Unternehmen</h4>
                <ul>
                    <li><a href="#">Über uns</a></li>
                    <li><a href="#">Karriere</a></li>
                    <li><a href="#">Impressum</a></li>
                    <li><a href="#">AGB</a></li>
                    <li><a href="#">Datenschutz</a></li>
                </ul>
            </div>
            <div class="footer-links">
                <h4>Service</h4>
                <ul>
                    <li><a href="#">Hilfe & FAQ</a></li>
                    <li><a href="#">Kontakt</a></li>
                    <li><a href="#">Versand</a></li>
                    <li><a href="#">Zahlung</a></li>
                    <li><a href="#">Rückgabe</a></li>
                </ul>
            </div>
            <div class="footer-info">
                <h4>Newsletter</h4>
                <p>Melden Sie sich für unseren Newsletter an und verpassen Sie keine Angebote mehr!</p>
                <form action="newsletter.php" method="post">
                    <input type="email" name="email" placeholder="Ihre E-Mail-Adresse" aria-label="E-Mail-Adresse" required>
                    <button type="submit"><i class="fas fa-paper-plane"></i> Anmelden</button>
                </form>
            </div>
        </div>
        <!-- Neuer Bereich für Zahlungsmethoden und Versandarten -->
        <div class="footer-payment-shipping">
            <div class="payment-methods">
                <!--<h4>Zahlungsmethoden</h4>-->
                <img src="paypal.png" alt="PayPal">
                <img src="mastercard.png" alt="Mastercard">
                <img src="visa.png" alt="Visa">
                <img src="stripe.png" alt="Klarna">
                <!--<img src="images/vorauskasse.png" alt="Vorauskasse">-->
            </div>
            <div class="shipping-methods">
                <!--<h4>Versandarten</h4>-->
                <img src="post.png" alt="Österreichische Post">
                <img src="ups.png" alt="UPS">
                <img src="dhl.png" alt="DHL">
            </div>
        </div>
        <div class="copyright">
            <div class="container">
                &copy; <?php echo date("Y"); ?> Nauticstore24. Alle Rechte vorbehalten.
            </div>
        </div>
    </footer>
    <!-- JavaScript für interaktive Elemente -->
    <script>
        document.getElementById('mobile-search-toggle').addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('.search-bar').classList.toggle('active');
        });

        // Dropdown für mobile Geräte
        document.querySelector('.dropdown > a').addEventListener('click', function(e) {
            e.preventDefault();
            this.parentElement.classList.toggle('active');
        });
    </script>
</body>
</html>
