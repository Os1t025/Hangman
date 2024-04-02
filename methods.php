<?php
function fetchRandomWord($wordtxtFile)
{
    $txtFile = fopen($wordtxtFile, 'r');
    if ($txtFile) {
        $count = 0;
        $random_line = null;
        while (($line = fgets($txtFile)) !== false) {
            $count++;
            if (rand() % $count == 0) {
                $random_line = trim($line);
            }
        }
        fclose($txtFile);
    }
    if (!isset($random_line)) {
        return null; // Return null if no line was found
    }
    return trim($random_line);
}

function hideCharacters($answer)
{
    $hidden = []; 
    foreach ($answer as $letter) {
        $hidden[] = '_'; // Add an underscore to the hidden array for each letter in the answer
    }
    return $hidden; // Return the array of hidden characters of correct length
}


function handleGuesses($userInput, &$hidden, $answer){
    $rightGuess = true; // Assume the guess is correct initially
    $userInput=strtolower($userInput);
    //loop through each word and change underscore to the letter if correct
    for ($i = 0; $i < count($answer); $i++) {
        if ($answer[$i] == $userInput) {
            $hidden[$i] = $userInput;
            $rightGuess = false; // Correct guess, set flag to true
        }
    }
    // Decrement attempts if the guess was wrong
    if (!$rightGuess) {
        $_SESSION['attempts']--; 
    }
    return $hidden;
}

function addScore($score_to_add) {
    // Get the username from the session
    $username = $_SESSION['username'];
    // Read the contents of the user file into an array
    $users = file('../player.txt', FILE_IGNORE_NEW_LINES);
    if ($users === false) {
        // Handle file reading error
        return false;
    }

    // Loop through each line in the file
    foreach ($users as &$user) {
        // Split the line into username, password, and score
        list($fileUsername, $password, $score) = explode(',', $user);

        // Check if the username in the file matches the session username
        if ($fileUsername === $username) {
            // Update the score
            $score += $score_to_add;
            // Update the line with the new score
            $user = "$fileUsername,$password,$score";
        }
    }

    // Write the updated user array back to the file
    if (file_put_contents('../player.txt', implode(PHP_EOL, $users)) !== false) {
        return true; // Success
    } else {
        // Handle file writing error
        return false;
    }
}

function checkGameOver($MAX_ATTEMPTS, $userAttempts, $answer, $hidden, $POINTS_FOR_WIN){
    // Display fly image
    if ($_SESSION['attempts'] >= $MAX_ATTEMPTS) {
        echo '<img src="fly.png" alt="Fly" class="fly">';
    }
    // Display win image
    if ($hidden == $answer) {
        echo '<img src="winner.gif" alt="win" class="fly">';
    }

    // Clear session variables if any of the game over conditions are met
    if ($userAttempts >= $MAX_ATTEMPTS || $hidden == $answer){
        unset($_SESSION['attempts']);
        unset($_SESSION['answer']);
        unset($_SESSION['hidden']);
    }

    // Handle loss
    if ($userAttempts >= $MAX_ATTEMPTS) {
        echo "Game Over. The correct word was ";
        foreach ($answer as $letter) echo $letter;
        echo "<br>Points earned: 0";
        echo "<br>Your score: " . getScore();
        echo '<div class="game-buttons"><button class="submit-button"><a href="../stickman.php">Play Again</a></button></div><br>';
        die();
    }
    // Handle win
    if ($hidden == $answer) {
        addScore($POINTS_FOR_WIN);
        echo "Correct!! The answer was ";
        foreach ($answer as $letter) echo $letter;
        echo "<br>Points earned: " . $POINTS_FOR_WIN;
        echo "<br>Your new score: " . getScore();
        echo '<div class="game-buttons"><button class="submit-button"><a href="../stickman.php">Play Again</a></button></div><br>';
        die();
    }
}

function getScore(){
    // Get the username from the session
    $username = $_SESSION['username'];

    // Read the contents of the user file into an array
    $users = file('../player.txt', FILE_IGNORE_NEW_LINES);

    if ($users === false) {
        // Handle file reading error
        return false;
    }

    // Loop through each line in the file
    foreach ($users as &$user) {
        // Split the line into username, password, and score
        list($fileUsername, $password, $score) = explode(',', $user);

        // If user is found return their score
        if ($fileUsername === $username) {
            return $score;
        }
    }
}
?>


