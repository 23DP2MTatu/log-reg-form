<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="src/css/styles.css">
</head>
<body>
    <header></header>
    <main>
        <div class="login-cont">
            <form action="src/php/login.php" method="post" class="log-form">
                <input type="text" name="name" placeholder="username or email" class="userNameInput">
                <input type="password" name="password" placeholder="password" class="passwordInput">
                <input type="submit" value="login">
            </form>
            <a href="src/php/register.php">register</a>
        </div>
    </main>
    <?php
    ?>
</body>
</html>