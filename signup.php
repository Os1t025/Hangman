<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $new_user_score=0;

    // Check if the username already exists in player.txt
    $file = fopen('player.txt', 'r');
    $username_exists = false;
    while (($line = fgets($file)) !== false) {
        $user_data = explode(',', $line);
        if ($user_data[0] == $username) {
            $username_exists = true;
            break;
        }
    }
    fclose($file);

    // Add the new user to player.txt if username doesn't exist
    if (!$username_exists) {
        $file = fopen('player.txt', 'a');
        fwrite($file, $username . ',' . $password . ',' . $new_user_score . PHP_EOL);
        fclose($file);
        header("Location: index.php?signup=success");
        exit;
    } else {
        header("Location: index.php?signup=exists");
        exit;
    }
}
?>
