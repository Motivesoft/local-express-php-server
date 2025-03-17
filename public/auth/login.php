<?php
session_start();

include '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Sanitise the username before use, using the same rules as when registering
    $username = trim($username);
    $username = filter_var($username, FILTER_SANITIZE_STRING);
    $username = substr($username, 0, 30);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid credentials!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="/auth/style.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php 
        if(isset($_GET['registered'])) echo "<p class='success'>Registration successful! Please login.</p>";
        if(isset($error)) echo "<p class='error'>$error</p>"; 
        ?>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</body>
</html>
