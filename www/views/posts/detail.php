<h2><?= htmlspecialchars($postData['title']) ?></h2>

<p>
    <?= nl2br(htmlspecialchars($postData['content'])) ?>
</p>

<p class="post-info">
    <small>
        Publikované: <?= $postData['created_at'] ?>
        <span class="separator">|</span>
        Autor: <?= htmlspecialchars($postData['username']) ?>
    </small>
</p>

<a href="/">← Späť na zoznam článkov</a>
