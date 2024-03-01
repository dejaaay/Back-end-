<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card Game</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                Card Game
            </div>
            <div class="card-body">
                <?php
                session_start();

                // Your PHP script goes here

                // Check if the game is over
                if ($_SESSION['currentRound'] >= $_SESSION['rounds']) {
                    echo "<p>Game Over! Your final score: " . $_SESSION['score'] . "</p>";
                    echo "<a href='?restart=1' class='btn btn-primary'>Restart Game</a>";
                    session_destroy();
                    exit;
                }

                // Restart the game
                if (isset($_GET['restart'])) {
                    session_destroy();
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit;
                }

                // Display cards and ask for user choice
                echo "<h5 class='card-title'>Round " . $_SESSION['currentRound'] . " of " . $_SESSION['rounds'] . "</h5>";
                echo "<p class='card-text'>Card 1: " . $card1['rank'] . " of " . $card1['suit'] . "</p>";
                echo "<p class='card-text'>Card 2: " . $card2['rank'] . " of " . $card2['suit'] . "</p>";
                echo "<p class='card-text'>Your score: " . $_SESSION['score'] . "</p>";
                echo "<p class='card-text'>Choose your action:</p>";
                echo "<a href='?action=deal' class='btn btn-success'>DEAL</a> | <a href='?action=no_deal' class='btn btn-danger'>NO DEAL</a>";

                // Continue the rest of your PHP script here

                ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
