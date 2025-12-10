<?php
// www/index.php

// session musí byť spustená pred výstupom
session_start();

// načítanie Routera a DB pripojenia
require __DIR__ . '/src/Router.php';
require __DIR__ . '/src/db.php';   // musí nastaviť $pdo

function requireLogin() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: /login");
        exit;
    }
}
// vytvoríme router
$router = new Router();

// GET routes
$router->get('/', function () {
    requireLogin();
    require __DIR__ . '/views/home.php';
});
$router->get('/login', function () {
    require __DIR__ . '/views/auth/login.php';
});
$router->get('/register', function () {
    require __DIR__ . '/views/auth/register.php';
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


// logout route (rýchlo)
$router->get('/logout', function() {
   
    session_unset();
    session_destroy();
    header('Location: /login');
    exit;
});

$router->run();
 