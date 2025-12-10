<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title>Moje Blogové CMS</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<header>
    <h1>Blog CMS</h1>
    <?php if (isset($_SESSION['user_id'])): ?>
        <p>Prihlásený užívateľ: <?= htmlspecialchars($_SESSION['username']) ?> | <a href="/logout">Odhlásiť sa</a></p>
    <?php endif; ?>
    <hr>
</header>

<main>
    <!-- tu sa vloží obsah konkrétnej stránky -->
    <?= $content ?? '' ?>
</main>

<footer>
    <hr>
    <p>&copy; 2025</p>
</footer>

</body>
</html>
