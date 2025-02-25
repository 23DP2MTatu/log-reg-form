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
                <input type="text" name="email" placeholder="email" class="emailNameInput">
                <input type="password" name="password" placeholder="password" class="passwordInput">
                <input type="password" name="password2" placeholder="password2" class="passwordInput">
                <input type="submit" value="register">
                <p></p>
            </form>
            <a href="../../index.php">log in</a>
        </div>
    </main>
    <?php
        $host = 'localhost';
        $dbname = 'postgres';
        $dbuser = 'postgres';
        $dbpassword = '1234';

        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];

        if (empty($username) || empty($email) || empty($password) || empty($password2)) {
            echo "All fields are required.";
        } else {
            if($password == $password2) {
            
                $password = password_hash($password, PASSWORD_DEFAULT);
                $username = trim(strtolower($username));
                $email = trim(strtolower($email));
                $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $dbuser, $dbpassword);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
                $stmt->execute(['username' => $username,'email' => $email, 'password' => $password]);

                session_start();
                $_SESSION['username'] = $username;
                header('Location: /log-reg-form/src/php/main.php');
            } else {
                echo "incorrect password";
            }
        }
    ?>
</body>
</html>