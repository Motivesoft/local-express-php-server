<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Hello World</title>
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
        $currentTime = date("Y-m-d H:i:s");
        echo "The current date and time is: " . $currentTime;
        ?>
        <script>console.log("Hello");</script>
    </p>
</body>
</html>
