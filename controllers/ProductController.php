<?php
class ProductController {
    private PDO   $pdo;
    private string $lang;
    private string $baseUrl;

    public function __construct(PDO $pdo, string $lang, string $baseUrl) {
        $this->pdo     = $pdo;
        $this->lang    = $lang;
        $this->baseUrl = $baseUrl;
    }

    public function detail(int $prodId, string $slug) {
        // Product in DB suchen
        $stmt = $this->pdo->prepare("SELECT * FROM products_products WHERE id = ?");
        $stmt->execute([$prodId]);
        $product = $stmt->fetch();

        if (!$product) {
            header("HTTP/1.0 404 Not Found");
            if ($this->lang === 'en') {
                include __DIR__ . '/../en/product-not-found.php';
            } else {
                include __DIR__ . '/../de/product-not-found.php';
            }
            exit;
        }

        // View einbinden
        require __DIR__ . '/../inc/header.php';

        $viewFile = ($this->lang === 'en')
                        ? __DIR__ . '/../en/product-detail.php'
                        : __DIR__ . '/../de/product-detail.php';

        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            echo ($this->lang === 'en')
                 ? "Product detail template missing."
                 : "Produktdetail-Template fehlt.";
        }

        require __DIR__ . '/../inc/footer.php';

        // Besuch speichern (session- oder user-bezogen)
        $this->saveRecentlyViewed($prodId);
    }

    protected function saveRecentlyViewed(int $productId): void {
        // Stelle sicher, dass session_start() bereits aufgerufen wurde
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId    = $_SESSION['user_id'] ?? null;
        $sessionId = session_id();

        // Duplikats-Check
        $stmtCheck = $this->pdo->prepare("
            SELECT 1
            FROM recently_viewed
            WHERE product_id = :pid
              AND (
                     (user_id = :uid AND :uid IS NOT NULL)
                  OR (user_id IS NULL AND session_id = :sid)
                  OR (user_id = :uid AND session_id = :sid)
              )
            LIMIT 1
        ");
        $stmtCheck->execute([
            'pid' => $productId,
            'uid' => $userId,
            'sid' => $sessionId
        ]);

        if ($stmtCheck->fetchColumn()) {
            // Bereits vorhanden → nur Timestamp updaten
            $stmtUpd = $this->pdo->prepare("
                UPDATE recently_viewed
                SET viewed_at = NOW()
                WHERE product_id = :pid
                  AND (
                         (user_id = :uid AND :uid IS NOT NULL)
                      OR (user_id IS NULL AND session_id = :sid)
                      OR (user_id = :uid AND session_id = :sid)
                  )
            ");
            $stmtUpd->execute([
                'pid' => $productId,
                'uid' => $userId,
                'sid' => $sessionId
            ]);
        } else {
            // Neuer Eintrag
            $stmtIns = $this->pdo->prepare("
                INSERT INTO recently_viewed
                  (user_id, session_id, product_id, viewed_at)
                VALUES
                  (:uid, :sid, :pid, NOW())
            ");
            $stmtIns->execute([
                'uid' => $userId,
                'sid' => $sessionId,
                'pid' => $productId
            ]);
        }
    }
}

