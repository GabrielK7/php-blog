<h1>Články</h1>

<?php if (isset($_SESSION['user_id'])): ?>
    <p><a href="/add-post">➕ Pridať článok</a></p>
<?php endif; ?>

<?php if (empty($posts)): ?>
    <p>Zatiaľ tu nie sú žiadne články.</p>
<?php endif; ?>

<?php foreach ($posts as $post): ?>
    <article>
        <h2>
            <a href="/post?id=<?= $post['id'] ?>">
                <?= htmlspecialchars($post['title']) ?>
            </a>
        </h2>
        <p>Autor: <?= htmlspecialchars($post['username']) ?></p>
    </article>
<?php endforeach; ?>
