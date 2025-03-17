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

    // // Table of status values
    // $sql = "DROP TABLE IF EXISTS status";
    // $conn->exec($sql);

    // // Table of all users
    // $sql = "DROP TABLE IF EXISTS users";
    // $conn->exec($sql);

    // // Table of all roles
    // $sql = "DROP TABLE IF EXISTS roles";
    // $conn->exec($sql);

    // // Table of roles for a user
    // $sql = "DROP TABLE IF EXISTS user_roles";
    // $conn->exec($sql);

    // // Puzzle collections
    // $sql = "DROP TABLE IF EXISTS collections";
    // $conn->exec($sql);

    // // Puzzle collections for a role
    // $sql = "DROP TABLE IF EXISTS role_collections";
    // $conn->exec($sql);

    // // Puzzles
    // $sql = "DROP TABLE IF EXISTS puzzles";
    // $conn->exec($sql);

    echo "Tables dropped successfully\n";
} catch (PDOException $e) {
    echo $sql . "\n" . $e->getMessage() . "\n";
}

$conn = null;
?>