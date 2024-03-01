<?php
session_start();

function generateCard() {
    // Simplified to generate numbers 1-13 representing the cards
    return rand(1, 13);
}

if (!isset($_SESSION['rounds_played'])) {
    $_SESSION['rounds_played'] = 0;
    $_SESSION['wins'] = 0;
}

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'start' && $_SESSION['rounds_played'] < 10) {
        $_SESSION['card1'] = generateCard();
        $_SESSION['card2'] = generateCard();
        $_SESSION['stage'] = 'started';
    } elseif ($_GET['action'] == 'deal' && isset($_SESSION['stage']) && $_SESSION['stage'] == 'started') {
        $_SESSION['card3'] = generateCard();
        $_SESSION['stage'] = 'dealt';
    }

    header("Location: game2.php"); // Redirect to avoid form resubmission issues
    exit;
}

if (isset($_POST['guess']) && $_SESSION['stage'] == 'dealt') {
    $guess = $_POST['guess'];
    $card1 = $_SESSION['card1'];
    $card2 = $_SESSION['card2'];
    $card3 = $_SESSION['card3'];
    
    // Sort the first two cards to simplify comparison
    $sortedCards = [$card1, $card2];
    sort($sortedCards);
    
    if ($card1 == $card2) {
        // Special case: card1 and card2 are the same
        if (($guess == 'higher' && $card3 > $card1) || ($guess == 'lower' && $card3 < $card1)) {
            $guessResult = 'Congratulations! You win!';
            $_SESSION['wins']++;
        } else {
            $guessResult = 'Sorry, you lose.';
        }
    } elseif ($card3 >= $sortedCards[0] && $card3 <= $sortedCards[1]) {
        // Win condition: card3 falls between card1 and card2 (inclusive)
        $guessResult = 'Congratulations! You win!';
        $_SESSION['wins']++;
    } else {
        $guessResult = 'Sorry, you lose.';
    }

    $_SESSION['rounds_played']++;
    $_SESSION['stage'] = 'guessed';
} else {
    $guessResult = '';
}

if ($_SESSION['rounds_played'] >= 10) {
    $finalMessage = "Game Over. You won {$_SESSION['wins']} out of 10 rounds.";
    // Consider adding session_unset() before session_destroy() for a cleaner reset
    session_unset(); // Clear session variables
    session_destroy(); // Destroy the session
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
    <?php if (!isset($_SESSION['stage']) || $_SESSION['rounds_played'] >= 10): ?>
        <?php if (isset($finalMessage)) echo "<p>$finalMessage</p>"; ?>
        <a href="?action=start">Start New Game</a>
    <?php elseif ($_SESSION['stage'] == 'started'): ?>
        <p>Card 1: <?= $_SESSION['card1'] ?></p>
        <p>Card 2: <?= $_SESSION['card2'] ?></p>
        <a href="?action=deal">Deal</a>
    <?php elseif ($_SESSION['stage'] == 'dealt'): ?>
        <p>Card 1: <?= $_SESSION['card1'] ?></p>
        <p>Card 2: <?= $_SESSION['card2'] ?></p>
        <p>Card 3: <?= $_SESSION['card3'] ?></p>
        <?php if ($_SESSION['card1'] === $_SESSION['card2']): ?>
            <form action="game.php" method="post">
                <input type="submit" name="guess" value="higher">
                <input type="submit" name="guess" value="lower">
            </form>
        <?php endif; ?>
    <?php endif; ?>
    <?php if (!empty($guessResult)): ?>
        <p><?= $guessResult ?></p>
    <?php endif; ?>
    <!-- The rest of your HTML structure -->
</body>
</html>
