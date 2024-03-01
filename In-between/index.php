<?php
session_start();

function generateCard() {

    $ranks = [2, 3, 4, 5, 6, 7, 8, 9, 10, 'Jack', 'Queen', 'King', 'Ace'];
    
    return [
        'rank' => $ranks[array_rand($ranks)],
    ];
}

function compareCards($card1, $card2) {
    $ranks = [2, 3, 4, 5, 6, 7, 8, 9, 10, 'Jack', 'Queen', 'King', 'Ace'];
    $rank1Index = array_search($card1['rank'], $ranks);
    $rank2Index = array_search($card2['rank'], $ranks);
    
    return $rank1Index - $rank2Index;
}

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'start') {
        $_SESSION['card1'] = generateCard();
        $_SESSION['card2'] = generateCard();
        $_SESSION['stage'] = 'started';
    } elseif ($_GET['action'] == 'deal' && isset($_SESSION['stage']) && $_SESSION['stage'] == 'started') {
        $_SESSION['card3'] = generateCard();
        $_SESSION['stage'] = 'dealt';
    }

    header("Location: game.php"); // Redirect to avoid form resubmission issues
    exit;
}

if (isset($_POST['guess']) && $_SESSION['stage'] == 'dealt') {
    $guess = $_POST['guess'];
    $comparison = compareCards($_SESSION['card2'], $_SESSION['card3']);

    if (($guess == 'higher' && $comparison < 0) || ($guess == 'lower' && $comparison > 0)) {
        $guessResult = 'Congratulations! You win!';
    } else {
        $guessResult = 'Sorry, you lose.';
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
    <?php if (!isset($_SESSION['stage'])): ?>
        <a href="?action=start">Start Game</a>
    <?php elseif ($_SESSION['stage'] == 'started'): ?>
        <p>Card 1: <?= $_SESSION['card1']['rank'] ?>  </p>
        <p>Card 2: <?= $_SESSION['card2']['rank'] ?>  </p>
        <a href="?action=deal">Deal</a>
    <?php elseif ($_SESSION['stage'] == 'dealt'): ?>
        <p>Card 1: <?= $_SESSION['card1']['rank'] ?> </p>
        <p>Card 2: <?= $_SESSION['card2']['rank'] ?> </p>
        <p>Card 3: <?= $_SESSION['card3']['rank'] ?> </p>
        <?php if ($_SESSION['card1']['rank'] === $_SESSION['card2']['rank']): ?>
            <form action="game.php" method="post">
                <input type="submit" name="guess" value="higher">
                <input type="submit" name="guess" value="lower">
            </form>
        <?php else: ?>
            <?php
            // Automatically determine win/lose if card1 and card2 are not the same
            if (compareCards($_SESSION['card1'], $_SESSION['card3']) < 0 && compareCards($_SESSION['card2'], $_SESSION['card3']) > 0) {
                echo '<p>The rank of the third card falls between the ranks of the two initial cards. You win!</p>';
            } else {
                echo '<p>The rank of the third card does not fall between the ranks of the two initial cards. You lose.</p>';
            }
            $_SESSION['stage'] = 'completed'; // Mark the game as completed
            ?>
        <?php endif; ?>
    <?php endif; ?>
    <?php if (!empty($guessResult)): ?>
        <p><?= $guessResult ?></p>
    <?php endif; ?>
    <?php if (isset($_SESSION['stage']) && $_SESSION['stage'] == 'guessed' || $_SESSION['stage'] == 'completed'): ?>
        <a href="?action=start">Restart Game</a>
        <?php session_destroy(); ?>
    <?php endif; ?>
</body>
</html>
