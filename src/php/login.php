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
    $name = $_POST['name'];
    $password = $_POST['password'];
    if (empty($name) || empty($password)) {
        echo "All fields are required.";
    } else {
        $file = fopen("../csv/data.csv", "r");
        while (($row = fgetcsv($file)) !== false) {
            if ($row[0] == $name || $row[1] == $name) {
                if(password_verify($password,$row[2])) {
                    fclose($file);
                    session_start();
                    $_SESSION['username'] = $row[0];
                    header('Location: /src/php/main.php');
                }
            }
        }
        fclose($file);
        header('Location: /index.php');
    }
    ?>
</body>
</html>