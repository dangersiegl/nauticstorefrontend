<?php
// views/account/sidebar.php

// 1) Aktuellen Pfad ermitteln (z. B. "/account/orders")
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$currentPath = rtrim($currentPath, '/');

$items = [
  ['route'=>'account',           'icon'=>'',         'label_de'=>'Übersicht',                  'label_en'=>'Dashboard'],
  ['route'=>'account/orders',    'icon'=>'',         'label_de'=>'Meine Bestellungen',        'label_en'=>'My Orders'],
  ['route'=>'account/wishlist',  'icon'=>'',         'label_de'=>'Meine Merkliste',           'label_en'=>'My Wishlist'],
  ['route'=>'account/data',      'icon'=>'',         'label_de'=>'Meine Adressen',            'label_en'=>'My Addresses'],
  ['route'=>'account/settings',  'icon'=>'',         'label_de'=>'Persönliche Einstellungen', 'label_en'=>'Settings'],
  ['route'=>'account/security',  'icon'=>'',         'label_de'=>'Sicherheit',                'label_en'=>'Security'],
  ['route'=>'account/newsletter','icon'=>'',         'label_de'=>'Newsletter',               'label_en'=>'Newsletter'],
  ['route'=>'account/logout',    'icon'=>'',         'label_de'=>'Abmelden',                  'label_en'=>'Logout'],
];
?>
<aside class="account-sidebar">
  <h3 class="sidebar-title">
    <?= $lang==='en' ? 'My Account' : 'Mein Nauticstore24' ?>
  </h3>
  <nav>
    <ul class="sidebar-nav">
      <?php foreach($items as $it):
        // Link erzeugen
        $href = url($it['route']);
        // Nur den Pfadteil ("/account/...") extrahieren und slashes angleichen
        $linkPath = parse_url($href, PHP_URL_PATH);
        $linkPath = rtrim($linkPath, '/');
        // active, wenn gleich
        $active = $linkPath === $currentPath ? 'active' : '';
      ?>
      <li>
        <a href="<?= $href ?>" class="<?= $active ?>">
          <?php if($it['icon']): ?>
            <i class="fa <?= $it['icon'] ?>"></i>
          <?php endif ?>
          <?= $lang==='en' ? $it['label_en'] : $it['label_de'] ?>
        </a>
      </li>
      <?php endforeach ?>
    </ul>
  </nav>
</aside>
