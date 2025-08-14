<?php
// /en/product-not-found.php
require_once __DIR__ . '/../inc/header.php'; // Optional: Gemeinsamer Header

?>
<div class="error-page">
    <h1>404 - Product Not Found</h1>
    <p>The product you are looking for does not exist or has been removed.</p>
    <a href="<?= htmlspecialchars($baseUrl); ?>">Back to Homepage</a>
</div>
<?php
require_once __DIR__ . '/../inc/footer.php'; // Optional: Gemeinsamer Footer
?>
