<?php if ($userLoggedIn): ?>
    <h2>Vitaj, <?= htmlspecialchars($_SESSION['username']) ?>!</h2>
    <p>Si prihlásený a môžeš používať aplikáciu.</p>
    <h1>Články</h1>
    <?php if (empty($posts)): ?>
        <p>Zatiaľ tu nie sú žiadne články.</p>
    <?php else: ?>

        <?php foreach ($posts as $post): ?>
            <article style="margin-bottom: 20px;">
                <div class="post">
                    <h3><?= htmlspecialchars($post['title']) ?></h3>
                    <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                </div>
                <small>Publikované: <?= $post['created_at'] ?></small>
                <?php if ($userLoggedIn && $post['user_id'] == $_SESSION['user_id']): ?>
                    <div>
                        <a href="/posts/edit?id=<?= $post['id'] ?>">Upraviť</a> |
                        <a href="/posts/delete?id=<?= $post['id'] ?>" onclick="return confirm('Naozaj vymazať?')">Vymazať</a>
                    </div>
                <?php endif; ?>
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