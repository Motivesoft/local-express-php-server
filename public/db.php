<?php
require_once 'config.php';

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "Database connection established\n";

    $stmt = $pdo->query("SELECT id, short_prompt FROM collections");
    $items = $stmt->fetchAll();

} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
