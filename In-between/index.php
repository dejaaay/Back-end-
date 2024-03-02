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
    $ranks = [2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14]; // Assuming 11=Jack, 12=Queen, 13=King, 14=Ace
    return ['rank' => $ranks[array_rand($ranks)]];
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action == 'start') {
        if ($_SESSION['round'] < 10) {
            $_SESSION['card1'] = generateCard();
            $_SESSION['card2'] = generateCard();
            $_SESSION['stage'] = 'started';
            $_SESSION['round']++; // Increase the round count
            unset($_SESSION['guessResult']); // Clear previous guess result
        } else {
            // Reset for a new game after 10 rounds
            $_SESSION['score'] = 100;
            $_SESSION['round'] = 0;
            unset($_SESSION['guessResult']); // Clear guess result
        }
    } elseif ($action == 'deal' && isset($_SESSION['stage']) && $_SESSION['stage'] == 'started') {
        $_SESSION['card3'] = generateCard();
        $_SESSION['stage'] = 'dealt';

        // Determine the boundaries
        $min = min($_SESSION['card1']['rank'], $_SESSION['card2']['rank']);
        $max = max($_SESSION['card1']['rank'], $_SESSION['card2']['rank']);

        // Check if the third card falls between the first two
        if ($_SESSION['card3']['rank'] > $min && $_SESSION['card3']['rank'] < $max) {
            $_SESSION['score'] += 10; // Add 10 points for win
            $_SESSION['guessResult'] = 'Congratulations! You win! The third card falls between the first two.';
        } else {
            $_SESSION['score'] -= 10; // Subtract 10 points for loss
            $_SESSION['guessResult'] = 'Sorry, you lose. The third card does not fall between the first two.';
        }

        $_SESSION['stage'] = 'guessed';
    }

    header("Location: index.php"); // Redirect to avoid form resubmission issues
    exit;
}
    if (isset($_POST['guess']) && $_SESSION['stage'] == 'dealt') {
        $guess = $_POST['guess'];
        $comparison = compareCards($_SESSION['card2'], $_SESSION['card3']);

        if (($guess == 'higher' && $comparison < 0) || ($guess == 'lower' && $comparison > 0)) {
            $guessResult = 'Congratulations! You win!';
            $_SESSION['score'] += 10; // Add 10 points for win
        } elseif ($_SESSION['card1']['rank'] === $_SESSION['card2']['rank'] && $_SESSION['card2']['rank'] === $_SESSION['card3']['rank']) {
            $_SESSION['score'] *= 2; // Double the score
            $guessResult = 'Jackpot! All cards are the same. Your score doubled!';
        }

        else  {
            $guessResult = 'Sorry, you lose.';
            $_SESSION['score'] -= 10; // Add 10 points for win
        }

        $_SESSION['stage'] = 'guessed';
    } else {
        $guessResult = '';
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
    
    <?php if (!isset($_SESSION['stage']) || $_SESSION['round'] >= 10): ?>
        <p>Game Over. Your final score is: <?= $_SESSION['score'] ?></p>
        <a href="?action=start">Start New Game</a>
    <?php elseif ($_SESSION['stage'] == 'started'): ?>
        <p>Card 1: <?= $_SESSION['card1']['rank'] ?></p>
        <p>Card 2: <?= $_SESSION['card2']['rank'] ?></p>
        <a href="?action=deal">Deal</a>
        <a href="?action=start">No Deal</a> 
    <?php elseif ($_SESSION['stage'] == 'dealt' || $_SESSION['stage'] == 'guessed'): ?>
        <p>Card 1: <?= $_SESSION['card1']['rank'] ?></p>
        <p>Card 2: <?= $_SESSION['card2']['rank'] ?></p>
        <p>Card 3: <?= $_SESSION['card3']['rank'] ?></p>
        <p><?= isset($_SESSION['guessResult']) ? $_SESSION['guessResult'] : '' ?></p>
        <a href="?action=start">Next Round</a>
    <?php endif; ?>
</body>
</html>
