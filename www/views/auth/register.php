<?php

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        // bezpečné hashovanie hesla
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // pripravený SQL príkaz (prepared statement)
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");

        try {
            $stmt->execute([$username, $hashedPassword]);
            $message = "Registrácia úspešná!";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // unikátne meno
                $message = "Používateľ s týmto menom už existuje!";
            } else {
                $message = "Chyba: " . $e->getMessage();
            }
        }
    } else {
        $message = "Vyplň meno aj heslo!";
    }
}
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Registrácia</title>
</head>
<body>
    <h2>Registrácia</h2>
    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <form method="post" action="">
        <label>Meno:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Heslo:</label><br>
        <input type="password" name="password" required><br><br>
        <label>Zopakujte heslo:</label><br>
        <input type="password" name="password2" required><br><br>

        <button type="submit">Registrovať</button>
    </form>
</body>
</html>
