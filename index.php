<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sign Up & Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <img id="hangman-image" src="hangman.png" alt="Hangman Image">
        <div>
            <div class="form-container">
                <h2>Sign Up</h2>
                <form action="signup.php" method="post">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit">Sign Up</button>
                </form>
                <!-- Display username exists error message -->
            </div>
            <div class="form-container">
                <h2>Login</h2>
                <form action="login.php" method="post">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit">Login</button>
                </form>
            </div>
        </div>
        <!-- Display success message OR error messages -->
        <?php if(isset($_GET['signup']) && $_GET['signup'] == 'success'): ?>
            <div class="success-message">
                <h3>You have Successfully Signed up, Login and enjoy the GAME.</h3>
            </div>
            <?php endif; ?>
            
            <?php if(isset($_GET['login']) && $_GET['login'] == 'error'): ?>
                <div class="error-message">
                    <h3>ERROR: WRONG USERNAME OR PASSWORD.</h3>
                </div>
                <?php endif; ?>
            <?php if(isset($_GET['signup']) && $_GET['signup'] == 'exists'): ?>
                <div class="error-message">
                    <h3>ERROR: Username Already Exists.</h3>
                </div>
            <?php endif; ?>
            </div>
        </body>
        </html>