<?php
require_once './public/config.php';

try {
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $tables = [
        'puzzles',
        'role_collections',
        'collections',
        'prompts',
        'user_roles',
        'users',
        'roles',
        'status'
    ];

    foreach($tables as $table) {
        $sql = "DROP TABLE IF EXISTS `$table`";
        $conn->exec($sql);
        echo "Dropped table: $table\n";
    }

    echo "Tables dropped successfully\n";
} catch (PDOException $e) {
    echo $sql . "\n" . $e->getMessage() . "\n";
}

$conn = null;
?>