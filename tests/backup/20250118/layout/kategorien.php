<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alle Kategorien - Dein Webshop</title>
    <link rel="stylesheet" href="style.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Font Awesome für Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4C+XwQf1GgYt9F6K9zD2V+osKgKEKq4YcXjCJ3gG3+8hHBwKxf4KqNxjE9HgYVVK9bEGg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <div class="top-bar">
            <div class="container">
                <div class="info">
                    <span class="need-help"><i class="fas fa-life-ring"></i> Brauchen Sie Hilfe?</span>
                    <span class="phone"><i class="fas fa-phone-alt"></i> +49 123 4567890</span>
                </div>
                <div class="user-actions">
                    <a href="account.php" class="my-account"><i class="fas fa-user"></i> Mein Konto</a>
                    <a href="login.php" class="login"><i class="fas fa-sign-in-alt"></i> Anmelden</a>
                </div>
            </div>
        </div>
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
                <div class="cart">
                    <a href="cart.php" aria-label="Warenkorb">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-text">Warenkorb</span>
                        <span class="cart-count">(0)</span>
                    </a>
                </div>
            </div>
        </div>
        <nav>
            <div class="container">
                <ul class="nav-links">
                    <li class="dropdown">
                        <a href="#">Kategorien <i class="fas fa-chevron-down"></i></a>
                        <div class="dropdown-content">
                            <div class="dropdown-column">
                                <h4>Hauptkategorien</h4>
                                <ul>
                                    <?php
                                        // Array mit allen Kategorien (Name => Link)
                                        $kategorien = array(
                                            "Kategorie 1" => "#",
                                            "Kategorie 2" => "#",
                                            "Kategorie 3" => "#",
                                            "Kategorie 4" => "#",
                                            "Kategorie 5" => "#",
                                            "Kategorie 6" => "#",
                                            "Kategorie 7" => "#",
                                            "Kategorie 8" => "#",
                                            "Kategorie 9" => "#",
                                            "Kategorie 10" => "#",
                                            "Kategorie 11" => "#",
                                            "Kategorie 12" => "#"
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
                                </ul>
                            </div>
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
                                    <li><a href="kategorien.php">Alle Kategorien</a></li>
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
            <h1>Alle Kategorien</h1>
            <div class="categories-grid" id="categories-grid">
                <?php
                    // Array mit allen Kategorien (Name, Bild, Link)
                    $categories = [
                        ["name" => "Kategorie 1", "image" => "kategorie01.png", "link" => "#"],
                        ["name" => "Kategorie 2", "image" => "placeholder_category2.png", "link" => "#"],
                        ["name" => "Kategorie 3", "image" => "placeholder_category3.png", "link" => "#"],
                        ["name" => "Kategorie 4", "image" => "placeholder_category4.png", "link" => "#"],
                        ["name" => "Kategorie 5", "image" => "placeholder_category5.png", "link" => "#"],
                        ["name" => "Kategorie 6", "image" => "placeholder_category6.png", "link" => "#"],
                        ["name" => "Kategorie 7", "image" => "placeholder_category7.png", "link" => "#"],
                        ["name" => "Kategorie 8", "image" => "placeholder_category8.png", "link" => "#"],
                        ["name" => "Kategorie 9", "image" => "placeholder_category9.png", "link" => "#"],
                        ["name" => "Kategorie 10", "image" => "placeholder_category10.png", "link" => "#"],
                        ["name" => "Kategorie 11", "image" => "placeholder_category11.png", "link" => "#"],
                        ["name" => "Kategorie 12", "image" => "placeholder_category12.png", "link" => "#"],
                    ];

                    foreach ($categories as $category) {
                        echo '<a href="' . htmlspecialchars($category['link']) . '" class="category-item">';
                        echo '    <img src="' . htmlspecialchars($category['image']) . '" alt="' . htmlspecialchars($category['name']) . '" loading="lazy">';
                        echo '    <h3>' . htmlspecialchars($category['name']) . '</h3>';
                        echo '</a>';
                    }
                ?>
            </div>
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
        <div class="copyright">
            <div class="container">
                &copy; <?php echo date("Y"); ?> Dein Webshop. Alle Rechte vorbehalten.
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
