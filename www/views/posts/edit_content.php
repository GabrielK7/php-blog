<h2>Upraviť článok</h2>

<form action="/posts/update" method="POST">
    <input type="hidden" name="id" value="<?= htmlspecialchars($post['id']) ?>">

    <label>Názov:</label><br>
    <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required><br><br>

    <label>Obsah:</label><br>
    <textarea name="content" rows="8" cols="50" required><?= htmlspecialchars($post['content']) ?></textarea><br><br>

    <button type="submit">Uložiť zmeny</button>
</form>


