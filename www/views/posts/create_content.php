<h2>Pridať nový článok</h2>

<form action="/posts/store" method="POST">
    <label>Názov:</label><br>
    <input type="text" name="title" required><br><br>

    <label>Obsah:</label><br>
    <textarea name="content" rows="8" cols="50" required></textarea><br><br>

    <button type="submit">Pridať článok</button>
</form>
