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