<?php
require __DIR__ . '/src/db.php';

$username = 'testuser';
$password = 'heslo123'; // zmeň podľa potreby

$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->execute([$username, $hash]);

echo "Vytvorený user: $username\n";
