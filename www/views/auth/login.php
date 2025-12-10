<!-- www/views/auth/login.php -->
<!DOCTYPE html>
<html lang="sk">
<head>
  <meta charset="utf-8">
  <title>Login</title>
</head>
<body>
  <h1>Login</h1>

  <?php if (!empty($_GET['error'])): ?>
    <p style="color: red;">Neplatné prihlasovacie údaje alebo vyplň všetky polia.</p>
  <?php endif; ?>

  <form action="/login" method="POST">
    <label for="email">Meno / Email:</label><br>
    <input id="email" name="email" type="text" required><br><br>

    <label for="password">Heslo:</label><br>
    <input id="password" name="password" type="password" required><br><br>

    <button type="submit">Prihlásiť</button>
   
  </form>

  <p><a href="/register">Registrovať</a></p>
</body>
</html>
