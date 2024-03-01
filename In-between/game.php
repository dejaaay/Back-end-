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
    $ranks = [2, 3, 4, 5, 6, 7, 8, 9, 10, 'Jack', 'Queen', 'King', 'Ace'];
    return ['rank' => $ranks[array_rand($ranks)]];
}

function compareCards($card1, $card2) {
    $ranks = [2, 3, 4, 5, 6, 7, 8, 9, 10, 'Jack', 'Queen', 'King', 'Ace'];
    $rank1Index = array_search($card1['rank'], $ranks);
    $rank2Index = array_search($card2['rank'], $ranks);
    return $rank1Index - $rank2Index;
}

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'start') {
        if ($_SESSION['round'] < 10) {
            $_SESSION['card1'] = generateCard();
            $_SESSION['card2'] = generateCard();
            $_SESSION['stage'] = 'started';
            $_SESSION['round']++; // Increase the round count
        } else {
            // Reset for a new game after 10 rounds
            $_SESSION['score'] = 100;
            $_SESSION['round'] = 0;
        }
    } elseif ($_GET['action'] == 'deal' && isset($_SESSION['stage']) && $_SESSION['stage'] == 'started') {
        $_SESSION['card3'] = generateCard();
        $_SESSION['stage'] = 'dealt';
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
    } else {
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
        <p>Card 1: <?= $_SESSION['card1']['rank'] ?>  </p>
        <p>Card 2: <?= $_SESSION['card2']['rank'] ?>  </p>
        <a href="?action=deal">Deal</a>
    <?php elseif ($_SESSION['stage'] == 'dealt'): ?>
        <p>Card 1: <?= $_SESSION['card1']['rank'] ?> </p>
        <p>Card 2: <?= $_SESSION['card2']['rank'] ?> </p>
        <p>Card 3: <?= $_SESSION['card3']['rank'] ?> </p>
        <?php if ($_SESSION['card1']['rank'] === $_SESSION['card2']['rank']): ?>
            <form action="index.php" method="post">
                <input type="submit" name="guess" value="higher">
                <input type="submit" name="guess" value="lower">
            </form>
        <?php else: ?>
            <?php
            // Automatically determine win/lose if card1 and card2 are not the same
            if (compareCards($_SESSION['card1'], $_SESSION['card3']) < 0 && compareCards($_SESSION['card2'], $_SESSION['card3']) > 0) {
                echo '<p>The rank of the third card falls between the ranks of the two initial cards. You win!</p>';
                $_SESSION['score'] += 10; // Add 10 points for win
            } else {
                echo '<p>The rank of the third card does not fall between the ranks of the two initial cards. You lose.</p>';
                $_SESSION['score'] -= 10; // Add 10 points for win
            }
            $_SESSION['stage'] = 'completed'; // Mark the game as completed
            ?>
        <?php endif; ?>
    <?php endif; ?>
    <?php if (!empty($guessResult)): ?>
        <p><?= $guessResult ?></p>
    <?php endif; ?>
    <?php if (isset($_SESSION['stage']) && ($_SESSION['stage'] == 'guessed' || $_SESSION['stage'] == 'completed') && $_SESSION['round'] < 10): ?>
        <a href="?action=start">Next Round</a>
    <?php endif; ?>
</body>
</html>

