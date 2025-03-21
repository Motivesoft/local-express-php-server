<?php
require_once './public/config.php';

try {
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Table of status values for a registered user (active, inactive, ...)
    $sql = "CREATE TABLE IF NOT EXISTS status (
                id INT PRIMARY KEY AUTO_INCREMENT,
                name VARCHAR(40) UNIQUE NOT NULL,
                update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    $conn->exec($sql);

    // Values for status
    $sql = "INSERT IGNORE INTO status (id, name) VALUES 
                (1, 'active'),
                (2, 'inactive'),
                (3, 'retired'),
                (4, 'blocked')";
    $conn->exec($sql);

    // Table of all permissions (tester, puzzle admin, user admin, system admin, ...)
    $sql = "CREATE TABLE IF NOT EXISTS roles (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(40) UNIQUE NOT NULL,
        update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    $conn->exec($sql);

    // Values for permissions
    $sql = "INSERT IGNORE INTO roles (id, name) VALUES 
        (1, 'unregistered'),
        (2, 'registered'),
        (3, 'tester'),
        (4, 'admin')";
    $conn->exec($sql);

    // Table of all users
    $sql = "CREATE TABLE IF NOT EXISTS users (
                id INT PRIMARY KEY AUTO_INCREMENT,
                username VARCHAR(40) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                status_id INT DEFAULT 1,
                role_id INT DEFAULT 1,
                update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                CONSTRAINT fk_users_status FOREIGN KEY (status_id) REFERENCES status(id),
                CONSTRAINT fk_users_role FOREIGN KEY (role_id) REFERENCES roles(id)
            )";
    $conn->exec($sql);

    // Textual prompt ()
    $sql = "CREATE TABLE IF NOT EXISTS prompts (
        id INT PRIMARY KEY AUTO_INCREMENT,
        text VARCHAR(100) NOT NULL,
        update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    $conn->exec($sql);

    // Puzzle collections (regular, archive, special, playtest, test, ...)
    $sql = "CREATE TABLE IF NOT EXISTS collections (
                id INT PRIMARY KEY AUTO_INCREMENT,
                short_prompt VARCHAR(20) UNIQUE NOT NULL,
                long_prompt VARCHAR(100) UNIQUE NOT NULL,
                update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";
    $conn->exec($sql);

    // Values for collections
    $sql = "INSERT IGNORE INTO collections (id, short_prompt, long_prompt) VALUES 
                (1, 'Puzzles', 'Choose one of our puzzles to play!'),
                (2, 'Puzzle Archive', 'Choose one of our archived puzzles to play!'),
                (3, 'Test Puzzles', 'Play test our puzzles'),
                (4, 'Restricted', 'Review the restricted puzzles')";
    $conn->exec($sql);

    // Access to collections
    $sql = "CREATE TABLE IF NOT EXISTS role_collections (
                id INT PRIMARY KEY AUTO_INCREMENT,
                role_id INT,
                collection_id INT,
                update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                CONSTRAINT fk_role_collections_role FOREIGN KEY (role_id) REFERENCES roles(id),
                CONSTRAINT fk_role_collections_collection FOREIGN KEY (collection_id) REFERENCES collections(id)
    )";
    $conn->exec($sql);

    // Which roles can see which collections - where '0' is a hard-coded role for unregistered users
    $sql = "INSERT IGNORE INTO role_collections (role_id, collection_id) VALUES 
                (1, 1),
                (2, 1),
                (2, 2),
                (3, 1),
                (3, 2),
                (3, 3),
                (4, 1),
                (4, 2),
                (4, 3),
                (4, 4)";
    $conn->exec($sql);

    // Puzzles
    $sql = "CREATE TABLE IF NOT EXISTS puzzles (
                id INT PRIMARY KEY AUTO_INCREMENT,
                name VARCHAR(40) NOT NULL,
                size INT,
                letters VARCHAR(256) NOT NULL,
                user_id INT,
                collection_id INT,
                update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";
    $conn->exec($sql);

    echo "Tables created successfully\n";
} catch (PDOException $e) {
    echo $sql . "\n" . $e->getMessage() . "\n";
}

$conn = null;
?>