<?php

// index.php

ob_start(); 
session_start();

// Error Reporting
//error_reporting(E_ALL); // Alle Fehler anzeigen
//ini_set('display_errors', 1); // Fehlerausgabe aktivieren
//ini_set('log_errors', 1); // Fehler in Log-Datei speichern
//ini_set('error_log', '/var/log/php_errors.log'); // Log-Datei festlegen
//

require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/db.php';
require_once __DIR__ . '/inc/functions.php';

// 1. Ermitteln der Sprache und Base-URL anhand der Domain
$config = Config::getInstance();
$host = $_SERVER['HTTP_HOST'];

if (isset($config->domainConfigMap[$host])) {
    $lang = $config->domainConfigMap[$host]['lang'];
    $baseUrl = $config->domainConfigMap[$host]['base_url'];
} else {
    $lang = $config->defaultLanguage;
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' 
        || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $baseUrl = $protocol . $host;
}

// 2. URL auslesen
$url = isset($_GET['url']) ? trim($_GET['url'], '/') : '';

// 3. Prüfen, ob URL auf ".html" endet
if (preg_match('/\.html$/', $url)) {
    // ===========================================
    // SEO-URLs
    // ein-wirklich-tolles-produkt-3456.html
    // eine-tolle-kategorie-c12.html
    // eine-tolle-unterkategorie-sc45.html
    // ===========================================

    // ".html" abschneiden
    $urlNoExt = preg_replace('/\.html$/', '', $url);

    // Hier die bekannten Muster prüfen:
    // Produkt => (.*)-(\d+)
    // Kategorie => (.*)-c(\d+)
    // Subkategorie => (.*)-sc(\d+)
    // Sub-Subkategorie => (.*)-ssc(\d+)

    if (preg_match('/^(.*)-c(\d+)$/', $urlNoExt, $m)) {
        // Hauptkategorie
        $slug = $m[1];
        $catId = $m[2];
        require_once __DIR__ . '/controllers/CategoryController.php';
        $controller = new CategoryController($lang, $baseUrl);
        $controller->category($catId, $slug);

    } elseif (preg_match('/^(.*)-sc(\d+)$/', $urlNoExt, $m)) {
        // Subkategorie
        $slug = $m[1];
        $subCatId = $m[2];
        require_once __DIR__ . '/controllers/CategoryController.php';
        $controller = new CategoryController($lang, $baseUrl);
        $controller->subcategory($subCatId, $slug);

    } elseif (preg_match('/^(.*)-ssc(\d+)$/', $urlNoExt, $m)) {
        // Sub-Subkategorie
        $slug = $m[1];
        $subSubCatId = $m[2];
        require_once __DIR__ . '/controllers/CategoryController.php';
        $controller = new CategoryController($lang, $baseUrl);
        $controller->subsubcategory($subSubCatId, $slug);

    } elseif (preg_match('/^(.*)-(\d+)$/', $urlNoExt, $m)) {
        // Produkt
        $slug = $m[1];
        $prodId = $m[2];
        require_once __DIR__ . '/controllers/ProductController.php';
        $controller = new ProductController($pdo, $lang, $baseUrl);
        $controller->detail($prodId, $slug);;

    } else {
        // Passt nicht zu deinen Mustern => 404
        header("HTTP/1.0 404 Not Found");
        echo ($lang === 'en') ? "404 Not Found" : "404 Nicht gefunden";
        exit;
    }

} else {
    // ===========================================
    // Slash-basierte Routen
    // ===========================================

    $segments      = explode('/', $url);
    $firstSegment  = $segments[0] ?? '';

    // 3a) Sprach­abhängige, statische Seiten (Kontakt, Impressum, AGB, …)
    if ($lang === 'de') {
        // key = URL-Slug, value = Dateiname (ohne .php)
        $staticMap = [
            'kontakt'    => 'contact',
            'impressum'  => 'imprint',
            'agb'        => 'terms',
            'datenschutz'=> 'privacy',
            'versand'    => 'shipping',
            'faq'        => 'faq',
            'retouren'   => 'returns',
            'downloads'  => 'downloads',
            'ueber-uns'  => 'about',
        ];
    } else {
        // englische Slugs = englische Dateinamen
        $staticMap = array_combine(
            ['contact','imprint','terms','privacy','shipping','faq','returns','downloads','about'],
            ['contact','imprint','terms','privacy','shipping','faq','returns','downloads','about']
        );
    }


    if (isset($staticMap[$firstSegment])) {
        $page = $staticMap[$firstSegment];
        $file = __DIR__ . "/{$lang}/{$page}.php";
        if (file_exists($file)) {
            require_once $file;
            exit;
        } else {
            header("HTTP/1.0 404 Not Found");
            echo ($lang === 'en')
                ? "404 Not Found: Page '{$firstSegment}' not available."
                : "404 Nicht gefunden: Seite '{$firstSegment}' nicht verfügbar.";
            exit;
        }
    }

    $controllerSegment = !empty($segments[0]) ? ucfirst($segments[0]) : 'Home';
    $actionSegment = isset($segments[1]) ? strtolower($segments[1]) : 'index';
    $params = array_slice($segments, 2);

    // Whitelist Slash-basierte Routen…
    $allowedControllers = ['Home','Product','Cart','Account'];
    $allowedActions     = ['index','overview','detail','add','remove','login','register','logout','profile','orders',
     'forgotpassword', 'resetpassword', 'checkemail', 'settings', 'confirmemail', 'data', 'dataedit', 'datadelete',
     'setdefault', 'unsetdefault', 'addnewsletter', 'newsletter', 'confirmnewsletter', 'removenewsletter', 'togglenewsletter',
    'security', 'wishlist', 'addwishlist', 'removewishlist'];


    if (!in_array($controllerSegment, $allowedControllers)) {
        header("HTTP/1.0 404 Not Found");
        echo ($lang === 'en') ? "404 Not Found: Controller not allowed." : "404 Nicht gefunden: Controller nicht erlaubt.";
        exit;
    }

    if (!in_array($actionSegment, $allowedActions)) {
        header("HTTP/1.0 404 Not Found");
        echo ($lang === 'en') ? "404 Not Found: Action not allowed." : "404 Nicht gefunden: Aktion nicht erlaubt.";
        exit;
    }

    $controllerName = $controllerSegment . 'Controller';
    $controllerFile = __DIR__ . '/controllers/' . $controllerName . '.php';

    if (file_exists($controllerFile)) {
        require_once $controllerFile;
        if (class_exists($controllerName)) {
            $controller = new $controllerName($lang, $baseUrl);
            if (method_exists($controller, $actionSegment)) {
                call_user_func_array([$controller, $actionSegment], $params);
            } else {
                header("HTTP/1.0 404 Not Found");
                echo ($lang === 'en') ? "404 Not Found: Action '$actionSegment' not found." : "404 Nicht gefunden: Aktion '$actionSegment' nicht gefunden.";
            }
        } else {
            header("HTTP/1.0 500 Internal Server Error");
            echo ($lang === 'en') ? "500 Internal Server Error: Controller class '$controllerName' not found." : "500 Interner Serverfehler: Controller-Klasse '$controllerName' nicht gefunden.";
        }
    } else {
        header("HTTP/1.0 404 Not Found");
        echo ($lang === 'en') ? "404 Not Found: Controller '$controllerName' not found." : "404 Nicht gefunden: Controller '$controllerName' nicht gefunden.";
    }
}
