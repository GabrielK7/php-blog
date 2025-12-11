<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Blog CMS' ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f4f4f4; }
        header { background: #333; color: white; padding: 10px 20px; }
        nav a { color: white; margin-right: 15px; text-decoration: none; }
        main { padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 20px; border-radius: 5px; }
    </style>
</head>
<body>
<header>
    <nav>
        <a href="/">Domov</a>
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="/logout">Odhlásiť</a>
        <?php else: ?>
            <a href="/login">Prihlásenie</a>
            <a href="/register">Registrácia</a>
        <?php endif; ?>
    </nav>
</header>
<main>
     <div class="container">
        <?php
        if (isset($content) && file_exists($content)) {
            require $content;
        } else {
            echo "<p>Content file not found.</p>";
        }
        ?>
    </div>
</main>
</body>
</html>
