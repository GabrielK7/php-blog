<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Blog' ?></title>
   <link rel="stylesheet" href="/public/style.css?v=<?= time() ?>">
   
</head>

<body>
    <div class="page-wrapper">
        <header>
            <nav>
                <a href="/">Domov</a>
                <a href="/posts">Články</a>

                <?php if (isset($_SESSION['user_id'])): ?>
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

        <footer>
            <p>&copy; 2026 Blog</p>
        </footer>
    </div>
</body>

</html>