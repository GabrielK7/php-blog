
<?php
// Obsah domovskej stránky
$content = '<h2>Domovská stránka</h2><p>Vitaj, ' . htmlspecialchars($_SESSION['username']) . '!</p>';

// na konci layout.php vložíme tento obsah
require __DIR__ . '/layout.php';

