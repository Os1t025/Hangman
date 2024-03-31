<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $file = file('player.txt');
    foreach ($file as $line) {
        $credentials = explode(',', $line);
        if (count($credentials) >= 2) {
            $savedUsername = trim($credentials[0]);
            $savedPassword = trim($credentials[1]);
            if ($savedUsername === $username && $savedPassword === $password) {
                session_start();
                $_SESSION['username'] = $username;
                header("Location: stickman.php");
                exit;
            }
        }
    }
    header("Location: index.php?login=error");
    exit;
}
?>
