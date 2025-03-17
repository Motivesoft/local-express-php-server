<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Hello World</title>
    <link rel="stylesheet" href="style.css">
    <script src="/script.js"></script>
</head>
<body>
    <h1>
        <?php
        echo "Hello, World!";
        ?>
    </h1>
    <p>
        <?php
        session_start();
                
        $currentTime = date("Y-m-d H:i:s");
        echo "The current date and time is: " . $currentTime;
        echo "<br>";
        echo "The current user is '" . $_SESSION['username'] . "'";
        echo "<br>";
        echo "<button type='button' class='button' onclick='login()'>Log in</button>"
        ?>
        <script>
            console.log("Index page");

            function login() {
                window.location.href="/auth/login.php";
            }
        </script>
    </p>
</body>
</html>
