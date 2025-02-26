<?php
    $usernameError = "";
    $passwordError = "";

    $host = 'localhost';
    $dbname = 'postgres';
    $dbuser = 'postgres';
    $dbpassword = '1234';

    if (isset($_POST['submit'])) {
        $username = $_POST['name'];
        $password = $_POST['password'];
        
        if (empty($username)) {
            $usernameError = "field are required.";
        } else {
            $username = trim(strtolower($username));
            $username = htmlspecialchars($username);

            if (!preg_match("/^[a-zA-Z0-9@._-]+$/",$username)) {
                $usernameError = "Name should contain only letters and no spaces.";
            }
        }

        if (empty($password)) {
            $passwordError = "field are required.";
        } else {
            $password = trim($password);
            $password = htmlspecialchars($password);

            if (preg_match("/\s/", $password)) {
                $passwordError = "password contains spaces";
            }
        }

        if (empty($usernameError) && empty($passwordError)) {
            $pdo = new PDO("pgsql:host=$host; dbname=$dbname", $dbuser, $dbpassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if (str_contains($username,"@")) {
                $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :username");
                $stmt->execute(['username' => $username]);
            } else {
                $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
                $stmt->execute(['username' => $username]);
            }
            
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if(password_verify($password,$user['password'])) {
                session_start();
                $_SESSION['username'] = $user['username'];
                header('Location: /log-reg-form/src/php/main.php');
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <header></header>
    <main>
        <div class="login-cont">
            <h1>Log in</h1>
            <form action="login.php" method="post" class="log-form">
                <input type="text" name="name" placeholder="username or email" class="userNameInput">
                <span><?php echo $usernameError?></span>
                <input type="password" name="password" placeholder="password" class="passwordInput">
                <span><?php echo $passwordError?></span>
                <input type="submit" name="submit" value="login">
            </form>
            <a href="register.php">register</a>
        </div>
    </main>
</body>
</html>