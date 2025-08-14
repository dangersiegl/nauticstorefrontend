<?php
// inc/WishlistHelper.php

/**
     * Fügt ein Produkt (ggf. mit Variante) zur Wunschliste hinzu.
     *
     * @param PDO      $pdo
     * @param int      $productId   ID des Produkts
     * @param int|null $variantId   ID der Variante (oder null für Default)
     * @return bool   true, wenn neu hinzugefügt, false wenn schon vorhanden oder Fehler
     */
    function addToWishlist(PDO $pdo, int $productId, ?int $variantId = null): bool
    {
        // 1) Bestimme user_id oder session_id
        $userId    = $_SESSION['user_id'] ?? null;
        $sessionId = session_id();

        // 2) Falls keine Variante übergeben, nimm die "Hauptvariante"
        if ($variantId === null) {
            $stmt = $pdo->prepare("
                SELECT variant_id
                FROM products_variants
                WHERE product_id = :pid
                ORDER BY variant_id ASC
                LIMIT 1
            ");
            $stmt->execute(['pid' => $productId]);
            $variantId = $stmt->fetchColumn();
            if (!$variantId) {
                // Kein Varianteneintrag gefunden
                return false;
            }
        }

        // 3) Ermittle aktuellen Preis: zuerst 'special', wenn aktiv, sonst 'list'
        $now = date('Y-m-d H:i:s');
        // a) try special
        $stmt = $pdo->prepare("
        SELECT price
        FROM products_prices
        WHERE 
            product_id = :pid
            AND variant_id = :vid
            AND price_type = 'special'
            AND (start_date IS NULL OR start_date <= :now)
            AND (end_date   IS NULL OR end_date   >= :now)
        ORDER BY quantity_from ASC
        LIMIT 1
        ");
        $stmt->execute([
        'pid' => $productId,
        'vid' => $variantId,
        'now' => $now
        ]);
        $price = $stmt->fetchColumn();

        // b) fallback auf list
        if ($price === false) {
            $stmt = $pdo->prepare("
            SELECT price
            FROM products_prices
            WHERE 
                product_id = :pid
                AND variant_id = :vid
                AND price_type = 'list'
            ORDER BY quantity_from ASC
            LIMIT 1
            ");
            $stmt->execute([
            'pid' => $productId,
            'vid' => $variantId
            ]);
            $price = $stmt->fetchColumn();
        }

        if ($price === false) {
            // Kein Preis gefunden
            return false;
        }

        // 4) Prüfe auf bestehendes Wishlist-Item (Duplikatschutz)
        if ($userId) {
            $stmt = $pdo->prepare("
            SELECT id
            FROM wishlist_items
            WHERE user_id = :uid
                AND product_id = :pid
                AND variant_id = :vid
            LIMIT 1
            ");
            $stmt->execute([
            'uid' => $userId,
            'pid' => $productId,
            'vid' => $variantId
            ]);
        } else {
            $stmt = $pdo->prepare("
            SELECT id
            FROM wishlist_items
            WHERE session_id = :sid
                AND user_id IS NULL
                AND product_id = :pid
                AND variant_id = :vid
            LIMIT 1
            ");
            $stmt->execute([
            'sid' => $sessionId,
            'pid' => $productId,
            'vid' => $variantId
            ]);
        }
        if ($stmt->fetch()) {
            // bereits in der Wunschliste
            return false;
        }

        // 5) Insert in wishlist_items
        $stmt = $pdo->prepare("
        INSERT INTO wishlist_items
            (user_id, session_id, product_id, variant_id, price_at_added)
        VALUES
            (:uid, :sid, :pid, :vid, :price)
        ");
        $ok = $stmt->execute([
        'uid'   => $userId,
        'sid'   => $userId ? null : $sessionId,
        'pid'   => $productId,
        'vid'   => $variantId,
        'price' => $price
        ]);

        return (bool)$ok;
    }