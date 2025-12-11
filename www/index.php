<?php
// www/index.php

// session musí byť spustená pred výstupom
session_start();

// načítanie Routera a DB pripojenia
require __DIR__ . '/src/Router.php';
require __DIR__ . '/src/db.php';   // musí nastaviť $pdo

function requireLogin()
{
    if (!isset($_SESSION['user_id'])) {
        header("Location: /login");
        exit;
    }
}
// vytvoríme router
$router = new Router();

// GET routes

$router->get('/login', function () {
     $content = __DIR__ . '/views/auth/login.php';
    require __DIR__ . '/views/layout.php';
});
$router->get('/register', function () {
    $content = __DIR__ . '/views/auth/register.php';
    require __DIR__ . '/views/layout.php';
});
$router->get('/', function () use ($pdo) {

    $userLoggedIn = isset($_SESSION['user_id']);

    $stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
    $posts = $stmt->fetchAll();

    $content = __DIR__ . '/views/home_content.php';
    require __DIR__ . '/views/layout.php';
});

$router->get('/posts/create', function () {
    requireLogin(); // presmeruje na /login, ak nie je prihlásený

    $title = "Nový článok";
    $content = __DIR__ . '/views/posts/create_content.php'; // tu musí byť $content

    require __DIR__ . '/views/layout.php';
});

$router->get('/posts/edit', function () use ($pdo) {
    requireLogin();

    $id = $_GET['id'] ?? null;
    if (!$id) {
        die("Chýba ID článku.");
    }

    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ? AND user_id = ?");
    $stmt->execute([$id, $_SESSION['user_id']]);
    $post = $stmt->fetch();

    if (!$post) {
        die("Článok nenájdený alebo nemáš oprávnenie.");
    }

    $title = "Upraviť článok";
    $content = __DIR__ . '/views/posts/edit_content.php';
    require __DIR__ . '/views/layout.php';
});



$router->get('/posts/delete', function () use ($pdo) {
    requireLogin();

    $postId = $_GET['id'] ?? null;
    if (!$postId) {
        header("Location: /");
        exit;
    }

    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ? AND user_id = ?");
    $stmt->execute([$postId, $_SESSION['user_id']]);

    header("Location: /");
    exit;
});



// POST routes
$router->post('/login', function () use ($pdo) {
    // spracovanie prihlasenia
    $username = trim($_POST['email'] ?? $_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        // redirect späť s chybou
        header('Location: /login?error=1');
        exit;
    }

    // nájdeme používateľa podľa username (alebo email, ak používate email ako username)
    $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = ? LIMIT 1");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // úspešné prihlásenie
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // redirect na domov alebo dashboard
        header('Location: /');
        exit;
    } else {
        // neplatné údaje
        header('Location: /login?error=1');
        exit;
    }
});

$router->post('/register', function () use ($pdo) {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';

    // Jednoduchá validácia
    if ($username === '' || $password === '' || $password2 === '') {
        die("Vyplň všetky polia.");
    }

    if ($password !== $password2) {
        die("Heslá sa nezhodujú.");
    }

    // Hash hesla
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Uloženie do DB
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->execute([$username, $hashedPassword]);

    // Po úspechu presmerovanie na login
    header("Location: /login");
    exit;
});

$router->post('/posts/store', function () use ($pdo) {
    requireLogin();

    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if ($title === '' || $content === '') {
        die("Vyplň nadpis a obsah.");
    }

    $stmt = $pdo->prepare(
        "INSERT INTO posts (title, content, user_id, created_at)
         VALUES (?, ?, ?, NOW())"
    );

    $stmt->execute([$title, $content, $_SESSION['user_id']]);

    header("Location: /");
    exit;
});

$router->post('/posts/update', function () use ($pdo) {
    requireLogin();

    $id = $_POST['id'] ?? null;
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if (!$id || $title === '' || $content === '') {
        die("Chýbajú údaje alebo sú neplatné.");
    }

    $stmt = $pdo->prepare(
        "UPDATE posts SET title = ?, content = ? WHERE id = ? AND user_id = ?"
    );

    $stmt->execute([$title, $content, $id, $_SESSION['user_id']]);

    header("Location: /");
    exit;
});




// logout route (rýchlo)
$router->get('/logout', function () {

    session_unset();
    session_destroy();
    header('Location: /login');
    exit;
});

$router->run();
