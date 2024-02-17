<?php
session_start();

// Function to generate a card
function generateCard() {
    $suits = ['Spades', 'Hearts', 'Diamonds', 'Clubs'];
    $ranks = [2, 3, 4, 5, 6, 7, 8, 9, 10, 'Jack', 'Queen', 'King', 'Ace'];

    return [
        'rank' => $ranks[array_rand($ranks)],
        'suit' => $suits[array_rand($suits)]
    ];
}

// Function to compare cards (simplified comparison, considering only ranks for simplicity)
function compareCards($card1, $card2) {
    $ranks = [2, 3, 4, 5, 6, 7, 8, 9, 10, 'Jack', 'Queen', 'King', 'Ace'];
    $rank1Index = array_search($card1['rank'], $ranks);
    $rank2Index = array_search($card2['rank'], $ranks);

    if ($rank1Index < $rank2Index) {
        return -1;
    } elseif ($rank1Index > $rank2Index) {
        return 1;
    } else {
        return 0;
    }
}

// Start or reset the game
if (isset($_GET['action']) && $_GET['action'] == 'start') {
    $_SESSION['card1'] = generateCard();
    $_SESSION['card2'] = generateCard();
    $_SESSION['gameStarted'] = true;
    header("Location: game.php"); // Redirect to avoid form resubmission issues
    exit;
}

// Handle guess submission
$guessResult = '';
if (isset($_POST['guess'])) {
    $card3 = generateCard();
    $comparison = compareCards($_SESSION['card2'], $card3);
    $guess = $_POST['guess'];

    if (($guess == 'higher' && $comparison < 0) || ($guess == 'lower' && $comparison > 0)) {
        $guessResult = 'Congratulations! You win!';
    } else {
        $guessResult = 'Sorry, you lose.';
    }

    // End game after guess
    unset($_SESSION['gameStarted']);
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
    <?php if (isset($_SESSION['gameStarted'])): ?>
        <p>Card 1: <?= $_SESSION['card1']['rank'] ?> of <?= $_SESSION['card1']['suit'] ?></p>
        <p>Card 2: <?= $_SESSION['card2']['rank'] ?> of <?= $_SESSION['card2']['suit'] ?></p>
        <?php if ($_SESSION['card1']['rank'] === $_SESSION['card2']['rank']): ?>
            <form action="game.php" method="post">
                <input type="submit" name="guess" value="higher">
                <input type="submit" name="guess" value="lower">
            </form>
        <?php endif; ?>
        <?php if (!empty($guessResult)): ?>
            <p><?= $guessResult ?></p>
        <?php endif; ?>
    <?php else: ?>
        <a href="?action=start">Start Game</a>
    <?php endif; ?>
</body>
</html>
