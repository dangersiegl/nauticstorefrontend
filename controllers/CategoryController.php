<?php
class CategoryController {
    private $lang;
    private $baseUrl;

    public function __construct($lang, $baseUrl) {
        $this->lang = $lang;
        $this->baseUrl = $baseUrl;
    }

    public function category($catId, $slug) {
        // Beispiel: Datenbankabfrage
        // SELECT * FROM products_categories WHERE id = :catId

        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM products_categories WHERE id = ?");
        $stmt->execute([$catId]);
        $category = $stmt->fetch();

        if (!$category) {
            header("HTTP/1.0 404 Not Found");
            
            // Bestimme den Pfad zur Fehlerseite
            $errorPage = ($this->lang === 'en') 
                ? __DIR__ . '/../en/category-not-found.php' 
                : __DIR__ . '/../de/category-not-found.php';
            
            // Binde die Fehlerseite ein
            include $errorPage;
            
            exit;
        }
       
        // Dann das entsprechende View-Template einbinden
        require __DIR__ . '/../inc/header.php';

        // Ggf. sprachspezifische Datei:
        //   /../en/category.php oder /../de/kategorie.php

        
        $viewFile = ($this->lang === 'en') 
                        ? __DIR__ . '/../en/category.php' 
                        : __DIR__ . '/../de/category.php';

        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            echo ($this->lang === 'en') ? "Category view not found." : "Kategorien-View nicht gefunden.";
        }

        require __DIR__ . '/../inc/footer.php';
    }

    // Subkategorien
    public function subcategory($subCatId, $slug) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM products_categories_subcategories WHERE id = ?");
        $stmt->execute([$subCatId]);
        $category = $stmt->fetch();

        if (!$category) {
            header("HTTP/1.0 404 Not Found");
            
            // Bestimme den Pfad zur Fehlerseite
            $errorPage = ($this->lang === 'en') 
                ? __DIR__ . '/../en/category-sub-not-found.php' 
                : __DIR__ . '/../de/category-sub-not-found.php';
            
            // Binde die Fehlerseite ein
            include $errorPage;
            
            exit;
        }
       
        // Dann das entsprechende View-Template einbinden
        require __DIR__ . '/../inc/header.php';

        // Ggf. sprachspezifische Datei:
        //   /../en/category.php oder /../de/kategorie.php

        
        $viewFile = ($this->lang === 'en') 
                        ? __DIR__ . '/../en/category-sub.php' 
                        : __DIR__ . '/../de/category-sub.php';

        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            echo ($this->lang === 'en') ? "Subcategory view not found." : "Subkategorien-View nicht gefunden.";
        }

        require __DIR__ . '/../inc/footer.php';
    }

    //Sub-Subkategorien
    public function subsubcategory($subSubCatId, $slug) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM products_categories_sub_subcategories WHERE id = ?");
        $stmt->execute([$subSubCatId]);
        $category = $stmt->fetch();

        if (!$category) {
            header("HTTP/1.0 404 Not Found");
            
            // Bestimme den Pfad zur Fehlerseite
            $errorPage = ($this->lang === 'en') 
                ? __DIR__ . '/../en/category-sub-sub-not-found.php' 
                : __DIR__ . '/../de/category-sub-sub-not-found.php';
            
            // Binde die Fehlerseite ein
            include $errorPage;
            
            exit;
        }
       
        // Dann das entsprechende View-Template einbinden
        require __DIR__ . '/../inc/header.php';

        // Ggf. sprachspezifische Datei:
        //   /../en/category.php oder /../de/kategorie.php

        
        $viewFile = ($this->lang === 'en') 
                        ? __DIR__ . '/../en/category-sub-sub.php' 
                        : __DIR__ . '/../de/category-sub-sub.php';

        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            echo ($this->lang === 'en') ? "Sub-Subcategory view not found." : "Sub-Subkategorien-View nicht gefunden.";
        }

        require __DIR__ . '/../inc/footer.php';
    }
}
