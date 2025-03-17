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

    // Table of all users
    $sql = "CREATE TABLE IF NOT EXISTS users (
                id INT PRIMARY KEY AUTO_INCREMENT,
                username VARCHAR(40) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                status_id INT,
                update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                CONSTRAINT fk_users_status FOREIGN KEY (status_id) REFERENCES status(id)
            )";
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
                (0, 'player'),
                (1, 'tester'),
                (2, 'puzzle_admin'),
                (3, 'user_admin'),
                (4, 'system_admin'),
                (5, 'developer')";
    $conn->exec($sql);

    // Table of applicable permissions for a user
    $sql = "CREATE TABLE IF NOT EXISTS user_roles (
                id INT PRIMARY KEY AUTO_INCREMENT,
                user_id INT,
                role_id INT,
                update_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                CONSTRAINT fk_user_roles_user FOREIGN KEY (user_id) REFERENCES users(id),
                CONSTRAINT fk_user_roles_role FOREIGN KEY (role_id) REFERENCES roles(id)
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

    // Puzzles
    $sql = "CREATE TABLE IF NOT EXISTS puzzles (
                id INT PRIMARY KEY AUTO_INCREMENT,
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