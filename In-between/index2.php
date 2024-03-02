<?php
session_start();

// Initialize score and rounds if they are not set
if (!isset($_SESSION['score'])) {
    $_SESSION['score'] = 100; // Starting score
}
if (!isset($_SESSION['round'])) {
    $_SESSION['round'] = 0; // Starting round
}

function generateCard() {
    $ranks = [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]; // Including face cards and Ace as 11, 12, 13, 14
    return ['rank' => $ranks[array_rand($ranks)]];
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action == 'start') {
        if ($_SESSION['round'] < 10) {
            $_SESSION['card1'] = generateCard();
            $_SESSION['card2'] = generateCard();
            $_SESSION['round']++; // Increase the round count
            unset($_SESSION['guessResult']); // Clear previous guess result
            // Determine if a guess of higher or lower is needed (when card1 == card2)
            if ($_SESSION['card1']['rank'] == $_SESSION['card2']['rank']) {
                $_SESSION['stage'] = 'guessHigherLower';
            } else {
                $_SESSION['stage'] = 'started';
            }
        } else {
            // Reset for a new game after 10 rounds
            $_SESSION['score'] = 100;
            $_SESSION['round'] = 0;
            unset($_SESSION['guessResult']); // Clear guess result
            $_SESSION['stage'] = 'start';
        }
    } elseif ($action == 'deal') {
        if (isset($_GET['guess']) && $_SESSION['stage'] == 'guessHigherLower') {
            // User is guessing higher or lower for identical cards
            $guess = $_GET['guess']; // Expect 'higher' or 'lower'
            $_SESSION['card3'] = generateCard();
            $correct = false;

            if ($guess == 'higher' && $_SESSION['card3']['rank'] > $_SESSION['card1']['rank']) {
                $correct = true;
            } elseif ($guess == 'lower' && $_SESSION['card3']['rank'] < $_SESSION['card1']['rank']) {
                $correct = true;
            }

            // Handle edge cases for identical highest or lowest cards
            if (($_SESSION['card1']['rank'] == 14 && $guess == 'lower' && $_SESSION['card3']['rank'] < 14) ||
                ($_SESSION['card1']['rank'] == 2 && $guess == 'higher' && $_SESSION['card3']['rank'] > 2)) {
                $correct = true;
            }

            // Check for jackpot condition
            if ($_SESSION['card1']['rank'] == $_SESSION['card2']['rank'] && $_SESSION['card2']['rank'] == $_SESSION['card3']['rank']) {
                $_SESSION['score'] *= 2; // Double the score
                $_SESSION['guessResult'] = 'Jackpot! All cards match. Your score is doubled.';
            } elseif ($correct) {
                $_SESSION['score'] += 10;
                $_SESSION['guessResult'] = 'Correct guess! You win 10 points.';
            } else {
                $_SESSION['score'] -= 10;
                $_SESSION['guessResult'] = 'Wrong guess! You lose 10 points.';
            }

            $_SESSION['stage'] = 'guessed';
        } elseif ($_SESSION['stage'] == 'started') {
            // Proceed with the original game logic when the cards are not identical
            $_SESSION['card3'] = generateCard();

            // Check for jackpot condition
            if ($_SESSION['card1']['rank'] == $_SESSION['card2']['rank'] && $_SESSION['card2']['rank'] == $_SESSION['card3']['rank']) {
                $_SESSION['score'] *= 2; // Double the score for jackpot
                $_SESSION['guessResult'] = 'Jackpot! All cards match. Your score is doubled.';
            } else {
                $min = min($_SESSION['card1']['rank'], $_SESSION['card2']['rank']);
                $max = max($_SESSION['card1']['rank'], $_SESSION['card2']['rank']);

                if ($_SESSION['card3']['rank'] > $min && $_SESSION['card3']['rank'] < $max) {
                    $_SESSION['score'] += 10;
                    $_SESSION['guessResult'] = 'Congratulations! You win! The third card falls between the first two.';
                } else {
                    $_SESSION['score'] -= 10;
                    $_SESSION['guessResult'] = 'Sorry, you lose. The third card does not fall between the first two.';
                }
            }

            $_SESSION['stage'] = 'guessed';
        }
    }

    header("Location: index.php"); // Redirect to avoid form resubmission issues
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>In Between Game</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>In Between Game</h1>
    <p>Round: <?= $_SESSION['round'] ?> / 10</p>
    <p>Score: <?= $_SESSION['score'] ?></p>
    
    <?php // The rest of your HTML output remains the same ?>
</body>
</html>
