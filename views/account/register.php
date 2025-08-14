<main class="container">
  <h1>Registrierung</h1>
  <?php if($errors): ?><div class="alert alert-error"><ul><?php foreach($errors as $e) echo "<li>$e</li>"; ?></ul></div><?php endif; ?>
  <form method="post">
    <label>Name</label><input name="name" value="<?=htmlspecialchars($name??'')?>" required>
    <label>E-Mail</label><input type="email" name="email" value="<?=htmlspecialchars($email??'')?>" required>
    <label>Passwort</label><input type="password" name="password" required>
    <button class="btn-primary">Registrieren</button>
  </form>
  <p>Schon Kunde? <a href="<?=url('account/login')?>">Anmelden</a></p>
</main>
