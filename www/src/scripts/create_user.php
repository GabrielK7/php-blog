<?php
require __DIR__ . '/../db.php';

$username = 'testuser';
$password = 'heslo123'; 

$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->execute([$username, $hash]);

echo "Vytvorený user: $username\n";
