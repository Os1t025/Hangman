<?php
session_start(); 
if (isset($_SESSION['user'])) {
    unset($_SESSION['user']);
}

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['sign_out'])) {
    session_destroy(); 
    header("Location: index.php"); 
    exit;
}
if (isset($_POST['quit'])){
    unset($_SESSION['answer']);
    $_SESSION['attempts'] = 1;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stickman Page</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="container">
        <div class="image-container">
          <img id="hangman-image" src="hangman.png" alt="Hangman Image"> 
            <h1>WELCOME <?php echo strtoupper($_SESSION['username']); ?></h1> <!-- Displaying the username -->
        </div>

        <div class = "dance">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <button class="play-music-btn" type="submit" name="play_music">
                    <img src="dance.gif" alt="Dancing Stickman">
                </button>
            </form>
        </div>
        <div class="image-wrapper">
          <!--   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <button class="play-music-btn" type="submit" name="play_music">
                    <img src="dance.gif" alt="Dancing Stickman">
                </button> -->
            </form>
            <a href="./easy/easyGame.php"><img src="easy.png" alt="Easy"></a>
            <a href="./medium/mediumGame.php"><img src="medium.png" alt="Medium"></a>
            <a href="./hard/hardGame.php"><img src="hard.png" alt="Hard"></a>
        </div>

        <!-- Add buttons here -->
        <div class="button-container">
            <form action="" method="post">
                <button class="sign-out-btn" type="submit" name="sign_out">Sign Out</button>
            </form>
            <form action="scoreboard.php" method="post">
                <button class="score-btn" type="submit">Score</button>
            </form>
        </div>
    </div>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["play_music"])) {
        if (!isset($_SESSION["music_playing"])) {
            $_SESSION["music_playing"] = true;
        } else {
            $_SESSION["music_playing"] = !$_SESSION["music_playing"];
        }
        
        if ($_SESSION["music_playing"]) {
            echo '<audio autoplay controls>
                      <source src="music1.mp3" type="audio/mpeg">
                      Your browser does not support the audio element.
                  </audio>';
        }
    }
    ?>
</body>
</html>



