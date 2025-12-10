<?php if (isset($_GET['error'])): ?>
    <p style="color:red;">Neplatné prihlasovacie údaje</p>
<?php endif; ?>
<h2>Prihlásenie</h2>
<form action="/login" method="post">
    <label>Username:</label><br>
    <input type="text" name="username" required><br><br>

    <label>Heslo:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Prihlásiť</button>
</form>
