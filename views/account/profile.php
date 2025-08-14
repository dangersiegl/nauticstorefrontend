<main class="container">
  <h1>Mein Profil</h1>
  <?php if($errors): ?><div class="alert alert-error"><ul><?php foreach($errors as $e) echo "<li>$e</li>"; ?></ul></div><?php endif; ?>
  <form method="post">
    <label>Name</label><input name="name" value="<?=htmlspecialchars($user['name'])?>" required>
    <button class="btn-primary">Speichern</button>
  </form>
  <p><a href="<?=url('account/logout')?>">Abmelden</a></p>
</main>
