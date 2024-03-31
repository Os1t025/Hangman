<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['sign_out'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}
if (isset($_POST['quit'])) {
    unset($_SESSION['answer']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="scoreStyle.css">
    <title>Leaderboard</title>
</head>

<body>
    <h1>LEADERBOARD - TOP 5 SCORES</h1>
    <table border="1">
        <tr>
            <th>RANK</th>
            <th>USERNAME</th>
            <th>SCORE</th>
        </tr>

        <?php
        $file = file('player.txt');
        $scores = [];
        foreach ($file as $line) {
            $data = explode(',', $line);
            $username = strtoupper($data[0]);
            $score = (int) $data[2];
            $scores[$username] = $score;
        }
        arsort($scores);
        $rank = 1;
        foreach ($scores as $username => $score) {
            if ($rank <= 5) {
                echo "<tr>";
                echo "<td>{$rank}</td>";
                echo "<td>{$username}</td>";
                echo "<td>{$score}</td>";
                echo "</tr>";
            }
            $rank++;
        }
        ?>
    </table>
    <br>
    <table border="1">
        <tr>
            <th>MY SCORE</th>
        </tr>
        <?php
        $currentUser = strtoupper($_SESSION['username']);
        $userScore = isset($scores[$currentUser]) ? $scores[$currentUser] : 'N/A';
        echo "<tr>";
        echo "<td>{$userScore}</td>";
        echo "</tr>";
        ?>
    </table>
    <br>
    
    <form action="stickman.php" method="post">
        <button class="back-btn" type="submit">Back</button>
    </form>
</body>

</html>




