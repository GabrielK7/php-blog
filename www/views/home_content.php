<?php if ($userLoggedIn): ?>
    <h2>Vitaj, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
    <p>Si prihlásený a môžeš používať aplikáciu.</p>
    <h1>Články</h1>
    <?php if (empty($posts)): ?>
        <p>Zatiaľ tu nie sú žiadne články.</p>
    <?php else: ?>

        <?php foreach ($posts as $post): ?>
            <article style="margin-bottom: 20px;">
                <h3><?= htmlspecialchars($post['title']) ?></h3>
                <p><?= nl2br(htmlspecialchars(substr($post['content'], 0, 200))) ?>...</p>
                <small>Publikované: <?= $post['created_at'] ?></small>
            </article>
            <hr>
        <?php endforeach; ?>

        <a href="/posts/create">+ Pridať nový článok</a>

    <?php endif; ?>
<?php else: ?>
    <h2>Vitaj na blogu!</h2>
    <p>Prosím, prihlás sa alebo zaregistruj, aby si mohol pokračovať.</p>
    <p>
        <a href="/login">Prihlásenie</a> |
        <a href="/register">Registrácia</a>
    </p>
<?php endif; ?>