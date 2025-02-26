<?php
    $usernameError = "";
    $emailError = "";
    $passwordError = "";
    $password2Error = "";

    $host = 'localhost';
    $dbname = 'postgres';
    $dbuser = 'postgres';
    $dbpassword = '1234';

    if (isset($_POST['submit'])) {

        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];

        if (empty($username)) {
            $usernameError = "field are required.";
        } else {
            $username = trim(strtolower($username));
            $username = htmlspecialchars($username);
            
            if (!preg_match("/^[a-zA-Z0-9]+$/",$username)) {
                $usernameError = "Name should contain only letters and no spaces.";
            } elseif (strlen($username) < 3 || strlen($username) > 20) {
                $usernameError = "Name should be between 3 and 20 characters.";
            }
        }

        if(empty($email)) {
            $emailError = "field are required.";
        } else {
            $email = trim(strtolower($email));
            $email = htmlspecialchars($email);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailError = "Invalid email format.";
            } elseif (strlen($email) > 100) {
                $emailError = "Email is so long";
            }
        }

        if(empty($password)) {
            $passwordError = "field are required.";
        } else {
            $password = trim($password);
            if (preg_match("/\s/", $password)) {
                $passwordError = "password contains spaces";
            } else if (strlen($password) < 8) {
                $passwordError = "password is short";
            }
        }
        if(empty($password2)) {
            $password2Error = "field are required.";
        } else {
            if ($password != $password2) {
                $password2Error = "passwords do not match";
            }
        }

        if (empty($usernameError) && empty($emailError) && empty($passwordError) && empty($password2Error)) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            
            $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $dbuser, $dbpassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
            $stmt->execute(['username' => $username,'email' => $email, 'password' => $password]);

            session_start();
            $_SESSION['username'] = $username;
            header('Location: /log-reg-form/src/php/main.php');
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
    <main>
        <div class="login-cont">
            <h1>Register</h1>
            <form action="register.php" method="post" class="log-form">
                <input type="text" name="username" placeholder="username" class="userNameInput">
                <span><?php echo $usernameError ?></span>
                <input type="email" name="email" placeholder="email" class="emailNameInput">
                <span><?php echo $emailError ?></span>
                <input type="password" name="password" placeholder="password" class="passwordInput">
                <span><?php echo $passwordError ?></span>
                <input type="password" name="password2" placeholder="password2" class="passwordInput">
                <span><?php echo $password2Error ?></span>
                <input type="submit" name="submit" value="register">
                <p></p>
            </form>
            <a href="../../index.php">log in</a>
        </div>
    </main>
</body>
</html>