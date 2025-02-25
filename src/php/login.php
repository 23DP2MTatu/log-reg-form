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
                <input type="password" name="password" placeholder="password" class="passwordInput">
                <input type="submit" value="login">
            </form>
            <a href="register.php">register</a>
        </div>
    </main>
    <?php

    $host = 'localhost';
    $dbname = 'postgres';
    $dbuser = 'postgres';
    $dbpassword = '1234';

    $username = $_POST['name'];
    $password = $_POST['password'];
    
    if (empty($username) || empty($password)) {
        echo "All fields are required.";
    } else {
        try {
            $username = trim(strtolower($username));
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
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
    ?>
</body>
</html>