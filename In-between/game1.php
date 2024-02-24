<?php
session_start();

function generateCard() {
    $ranks = [2, 3, 4, 5, 6, 7, 8, 9, 10, 'Jack', 'Queen', 'King', 'Ace'];
    
    return [
        'rank' => $ranks[array_rand($ranks)]
    ];
}

function compareCards($card1, $card2) {
    $ranks = [2, 3, 4, 5, 6, 7, 8, 9, 10, 'Jack', 'Queen', 'King', 'Ace'];
    return array_search($card1['rank'], $ranks) - array_search($card2['rank'], $ranks);
}

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'start') {
        $_SESSION['card1'] = generateCard();
        $_SESSION['card2'] = generateCard();
        $_SESSION['gameStarted'] = true;
    } elseif ($_GET['action'] == 'deal' && isset($_SESSION['gameStarted'])) {
        $_SESSION['card3'] = generateCard();
        $comparison1 = compareCards($_SESSION['card1'], $_SESSION['card3']);
        $comparison2 = compareCards($_SESSION['card2'], $_SESSION['card3']);
        if ($comparison1 < 0 && $comparison2 > 0 || $comparison1 > 0 && $comparison2 < 0) {
            $_SESSION['result'] = "Congratulations! You win!";
        } else {
            $_SESSION['result'] = "Sorry, You lose.";
        }
    }
    header("Location: game1.php"); // Redirect to avoid form resubmission issues
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
    <?php if (!empty($_SESSION['gameStarted'])): ?>
        <p>Card 1: <?= $_SESSION['card1']['rank'] ?> </p>
        <p>Card 2: <?= $_SESSION['card2']['rank'] ?> </p>
        <?php if (isset($_SESSION['card3'])): ?>
            <p>Card 3: <?= $_SESSION['card3']['rank'] ?> </p>
            <p><?= $_SESSION['result'] ?></p>
            <a href="game1.php">Restart Game</a>
            <?php session_destroy(); ?>
        <?php else: ?>
            <a href="?action=deal">Deal</a>
            <a href="game1.php">No Deal</a>
            <?php session_destroy(); ?>
        <?php endif; ?>
    <?php else: ?>
        <a href="?action=start">Start Game</a>
    <?php endif; ?>
</body>
</html>
