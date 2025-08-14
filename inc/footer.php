<?php
// inc/footer.php

// Ensure $lang is available
global $lang;

// Fallback to German if language is not set or unsupported
if (!isset($translations_footer[$lang])) {
    $lang = 'de';
}

// Assign translations to a variable for easier access
$t = $translations_footer[$lang];
?>
    </main>

    <div class="divider-blue"></div>

    <!-- ============================= FOOTER ============================== -->
    <footer>
        <div class="footer-wrapper">
            <!-- Erster Bereich: 4 Spalten -->
            <div class="footer-container">
                <!-- Spalte 1: Kontakt -->
                <div class="footer-section">
                    <h4><?php echo $t['contact']; ?></h4>
                    <p>
                        Nauticstore24<br>
                        Thomas Dall<br>
                        Unterhart 3<br>
                        4113 St. Martin, Austria<br>
                        Austria
                    </p>
                    <p>
                        <strong>Phone:</strong> <a href="tel:+436605198793">+43 660 5198793</a><br>
                        <strong>WhatsApp:</strong> <a href="https://wa.me/436605198793">+43 660 5198793</a><br>
                        <strong>Email:</strong> <a href="mailto:<?php echo ($lang === 'en') ? 'shop@nauticstore24.com">shop@nauticstore24.com' : 'shop@nauticstore24.at">shop@nauticstore24.at'; ?></a><br>
                        <strong>Web:</strong> <a href="<?php echo $currentBaseUrl; echo ($lang === 'en') ? '">www.nauticstore24.com' : '">www.nauticstore24.at' ;?></a>
                    </p>
                    <p><?php echo ($lang === 'en') ? "Business Owner" : "Geschäftsführer" ?>: Thomas Dall<br>UID: ATU 651 665 44</p>
                </div>

                <!-- Spalte 2: Produktkategorien -->
                <div class="footer-section">
                    <h4><?php echo $t['product_categories']; ?></h4>
                    <ul>
                        <?php foreach ($categories as $category): ?>
                            <li>
                                <a href="<?= url($category['link']); ?>">
                                    <?= htmlspecialchars($category['name']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Spalte 3: Mein Konto + Kataloge -->
                <div class="footer-section">
                    <h4><?= htmlspecialchars($t['my_account']) ?></h4>
                    <ul>
                        <?php if (empty($_SESSION['user_id'])): ?>
                            <li>
                                <a href="<?= url($lang === 'en' ? 'account/login' : 'account/login') ?>">
                                    <?= ($lang === 'en') ? 'Login/Register' : 'Anmelden/Registrieren' ?>
                                </a>
                            </li>
                        <?php endif; ?>

                        <li>
                            <a href="<?= url($lang === 'en' ? 'account' : 'account') ?>">
                                <?= ($lang === 'en') ? 'My Account' : 'Mein Konto' ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url($lang === 'en' ? 'account/orders' : 'account/orders') ?>">
                                <?= ($lang === 'en') ? 'My Orders' : 'Meine Bestellungen' ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url($lang === 'en' ? 'account/settings' : 'account/settings') ?>">
                                <?= ($lang === 'en') ? 'Settings' : 'Persönliche Einstellungen' ?>
                            </a>
                        </li>
                        <?php if (!empty($_SESSION['user_id'])): ?>
                            <li>
                                <a href="<?= url($lang === 'en' ? 'account/logout' : 'account/logout') ?>">
                                    <?= ($lang === 'en') ? 'Logout' : 'Abmelden' ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>

                    <h4><?= htmlspecialchars($t['catalog_downloads']) ?></h4>
                    <ul>
                        <li>
                            <a href="<?= url($lang === 'en' ? 'downloads' : 'downloads') ?>">
                                <?= ($lang === 'en') ? 'Download Area' : 'Downloadbereich' ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url($lang === 'en' ? 'downloads' : 'downloads') ?>">
                                <?= ($lang === 'en') ? 'Online Spare Parts Catalogs' : 'Online Ersatzteilkataloge' ?>
                            </a>
                        </li>
                    </ul>
                </div>


                <!-- Spalte 4: Service & Information -->
                <div class="footer-section">
                    <h4><?= htmlspecialchars($t['service']) ?></h4>
                    <ul>
                        <li>
                            <a href="<?= url($lang === 'en' ? 'about'    : 'ueber-uns') ?>">
                                <?= ($lang === 'en') ? 'About Nauticstore24' : 'Über Nauticstore24' ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url($lang === 'en' ? 'terms'    : 'agb') ?>">
                                <?= ($lang === 'en') ? 'Terms & Conditions' : 'AGB' ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url($lang === 'en' ? 'shipping' : 'versand') ?>">
                                <?= ($lang === 'en') ? 'Shipping Terms'     : 'Versandbestimmungen' ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= url($lang === 'en' ? 'returns'  : 'retouren') ?>">
                                <?= ($lang === 'en') ? 'Returns'            : 'Retouren' ?>
                            </a>
                        </li>
                    </ul>

                    <h4><?= htmlspecialchars($t['service_information']) ?></h4>
                    <p>
                        <strong>
                            <?= ($lang === 'en') ? 'Availability' : 'Erreichbarkeit' ?>
                        </strong><br>
                        <?= ($lang === 'en') ? 'Mon–Thu 09:00 AM – 03:00 PM' : 'Mo.–Do. 09:00 – 15:00 Uhr' ?>
                    </p>
                    <p>
                        <?= ($lang === 'en')
                            ? 'You can also find us on:'
                            : 'Sie finden uns auch auf:' ?>
                    </p>
                    <div class="social-icons">
                        <a href="https://www.facebook.com/nauticstore24/" target="_blank"><img src="<?= $baseUrl ?>/assets/img/icons/facebook.png" alt="Facebook"></a>
                        <a href="https://twitter.com/nauticstore24/" target="_blank"><img src="<?= $baseUrl ?>/assets/img/icons/twitter.png" alt="Twitter"></a>
                        <a href="https://www.instagram.com/nauticstore24/" target="_blank"><img src="<?= $baseUrl ?>/assets/img/icons/instagram.png" alt="Instagram"></a>
                    </div>
                </div>
            </div>

            <!-- Trennlinie (optional) -->
            <div class="divider-black"></div>

            <!-- Zahlungs- und Versandarten -->
            <div class="footer-payment-shipping container">
                <div class="payment-methods">
                    <img src="<?php echo $baseUrl; ?>/assets/img/payment/paypal.png" alt="PayPal">
                    <img src="<?php echo $baseUrl; ?>/assets/img/payment/visa.png" alt="Visa">
                    <img src="<?php echo $baseUrl; ?>/assets/img/payment/mastercard.png" alt="Mastercard">
                    <img src="<?php echo $baseUrl; ?>/assets/img/payment/stripe.png" alt="Stripe">
                </div>
                <div class="shipping-methods">
                    <img src="<?php echo $baseUrl; ?>/assets/img/shipping/post.png" alt="<?php echo ($lang === 'en') ? 'Austrian Post' : 'Österreichische Post'; ?>">
                    <img src="<?php echo $baseUrl; ?>/assets/img/shipping/ups.png" alt="UPS">
                    <img src="<?php echo $baseUrl; ?>/assets/img/shipping/dhl.png" alt="DHL">
                </div>
            </div>

            <?php
                // Am besten oben im Template oder direkt vor dem Footer definieren:
                // Schlüssel sind hier die Routennamen, Werte die Slugs
                $footerRoutes = [
                    'contact'        => ($lang === 'de') ? 'kontakt'                 : 'contact',
                    'imprint'        => ($lang === 'de') ? 'impressum'               : 'imprint',
                    'terms'          => ($lang === 'de') ? 'agb'                     : 'terms',
                    'privacy'        => ($lang === 'de') ? 'datenschutz'             : 'privacy',
                    'shipping_terms' => ($lang === 'de') ? 'versand'      : 'shipping',
                    'faq'            => ($lang === 'de') ? 'faq'                     : 'faq',
                ];
            ?>
            <!-- Copyright -->
            <div class="copyright">
                <div class="copyright-container">
                    <span>&copy; <?= date("Y") ?> Nauticstore24.at</span>
                    <div class="copyright-links">
                        <a href="<?= url($footerRoutes['contact']) ?>">
                            <?= htmlspecialchars($t['contact_us']) ?>
                        </a>
                        <a href="<?= url($footerRoutes['imprint']) ?>">
                            <?= htmlspecialchars($t['imprint']) ?>
                        </a>
                        <a href="<?= url($footerRoutes['terms']) ?>">
                            <?= htmlspecialchars($t['terms']) ?>
                        </a>
                        <a href="<?= url($footerRoutes['privacy']) ?>">
                            <?= htmlspecialchars($t['privacy']) ?>
                        </a>
                        <a href="<?= url($footerRoutes['shipping_terms']) ?>">
                            <?= htmlspecialchars($t['shipping_terms']) ?>
                        </a>
                        <a href="<?= url($footerRoutes['faq']) ?>">
                            <?= htmlspecialchars($t['faq']) ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <button id="scrollTopBtn" aria-label="<?php echo $t['scroll_top']; ?>" title="<?php echo $t['scroll_top']; ?>">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- ============================= SCRIPTS ============================== -->
    <script>
        const categoriesJS = <?php echo json_encode($categories); ?>;
    </script>
    <script>
    window.NS = window.NS||{};
    NS.baseUrl = '<?= $baseUrl ?>';
    NS.lang    = '<?= $lang ?>';  // hier wird 'de' oder 'en' gesetzt
    </script>
    <script src="<?php echo $baseUrl; ?>/assets/js/scripts.js"></script>
    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <!-- Cookie Consent Banner -->
    <?php
    require __DIR__ . '/../inc/cookie-consent-banner.php';
    ?>

</body>
</html>
