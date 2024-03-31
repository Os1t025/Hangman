<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hang Man</title>
    <link rel="stylesheet" href="../gameStyles.css">
</head>

<body>
    <h1>Hang Man (Easy)</h1>
    <div class="container">
        <?php
        session_start();
        include 'hardConfiguration.php';
        include '../methods.php';

        if (!isset($_SESSION['attempts'])) $_SESSION['attempts'] = 1;
        if (!isset($_SESSION['usedLetters'])) $_SESSION['usedLetters'] = [];

        // Checks if the "Change Word" button was clicked, if so unsets the $_SESSION['answer'] variable
        if (isset($_POST['newWord'])) {
            unset($_SESSION['answer']);
            $_SESSION['attempts'] = 1;
            $_SESSION['usedLetters'] = []; // Reset used letters when starting a new game
            // Check if user input was submitted and not blank
        } elseif (isset($_POST['userInput']) && trim($_POST['userInput'])!= "") { 
            // Get the input, update the hidden word, and check if the game is over
            $userInput = $_POST['userInput'];
            $_SESSION['hidden'] = handleGuesses(strtolower($userInput), $_SESSION['hidden'], $_SESSION['answer']);
            checkGameOver($MAX_ATTEMPTS_ALLOWED, $_SESSION['attempts'], $_SESSION['answer'], $_SESSION['hidden'], $POINTS_FOR_WIN);

            // Increment attempts used only if the form is submitted with user input
            $_SESSION['attempts']++;

            // Add the user input to the used letters array if it is unique
            if (!in_array(strtolower($userInput), $_SESSION['usedLetters'])) {
                $_SESSION['usedLetters'][] = strtolower($userInput);
            }
        }

        // Checks if the $_SESSION['answer'] variable is set. If not, initializes the game and displays attempts remaining.
        if (!isset($_SESSION['answer'])) {
            $animal_array = explode(',', fetchRandomWord($WORD_LIST_FILE));
            $answer = str_split($animal_array[0]);
            $hint = $animal_array[1];
            $_SESSION['answer'] = $answer;
            $_SESSION['hint'] = $hint;
            $_SESSION['hidden'] = hideCharacters($answer);
            $_SESSION['usedLetters'] = [];
            echo 'Lives remaining: ' . ($MAX_ATTEMPTS_ALLOWED - $_SESSION['attempts']) . '<br>';
        } else {
            // Display attempts remaining if the game is ongoing
            echo 'Lives remaining: ' . ($MAX_ATTEMPTS_ALLOWED - $_SESSION['attempts']) . "<br>";
            // Give hint if less than 3 lives
            echo ($MAX_ATTEMPTS_ALLOWED - $_SESSION['attempts'] >= 3) ? "<br>Hint given when you have 2 or less lives<br>" : "<br>Hint: " . $_SESSION['hint'] . "<br>";

            // Print used letters
            echo "Used Guesses: " . strtolower(implode(', ', $_SESSION['usedLetters'])) . "<br>";
        }
        // Display all characters of $hidden
        $hidden = $_SESSION['hidden'];
        echo '<div class="hidden-characters">';
        foreach ($hidden as $char) {
            echo $char . "  ";
        }
        echo '</div>';
        ?>
        <!--submit guesses or ask for a different word-->
        <form name="inputForm" action="hardGame.php" method="post"><br>
            Your Guess: <input name="userInput" type="text" size="1" maxlength="1" />
            <input type="submit" name="check" value="Submit Guess" />
            <input type="submit" name="newWord" value="Change Word" />
        </form>

        <!-- Quit button form -->
        <form action="../stickman.php" method="post">
            <input type="submit" name="quit" value="Quit">
        </form>
    </div>
</body>

</html>
