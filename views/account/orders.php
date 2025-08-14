<main class="container">
  <h1>Meine Bestellungen</h1>
  <?php if(empty($orders)): ?>
    <p>Bisher keine Bestellungen.</p>
  <?php else: ?>
    <ul>
      <?php foreach($orders as $o): ?>
        <li>Bestellung #<?= $o['id'] ?> am <?= $o['created_at'] ?> – Status: <?=htmlspecialchars($o['status'])?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</main>
