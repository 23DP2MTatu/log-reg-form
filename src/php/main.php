<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <main>
        <a href="../../index.php">menu</a>
    </main>



    <?php
        session_start();
        $name = $_SESSION['username'];
        echo "Sveiki $name!";
    ?>
</body>
</html>