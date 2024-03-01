<?php
 
// Set default or get the number of rounds from user input
if (!isset($_SESSION['rounds']) || isset($_GET['rounds'])) {
    $requestedRounds = in_array($_GET['rounds'], [3, 5, 10]) ? $_GET['rounds'] : 10;
    $_SESSION['rounds'] = $requestedRounds;
    $_SESSION['currentRound'] = 0;
    $_SESSION['score'] = 100; // Starting score
}

function generateCard() {
    $suits = ['Spades', 'Hearts', 'Diamonds', 'Clubs'];
    $ranks = range(2, 14); // 11=Jack, 12=Queen, 13=King, 14=Ace
    return [
        'rank' => $ranks[array_rand($ranks)],
        'suit' => $suits[array_rand($suits)]
    ];
}

if ($_SESSION['currentRound'] >= $_SESSION['rounds']) {
    echo "Game Over! Your final score: " . $_SESSION['score'];
    echo "<br><a href='?restart=1'>Restart Game</a>";
    session_destroy();
    exit;
}

if (isset($_GET['restart'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$card1 = generateCard();
$card2 = generateCard();


$_SESSION['card1'] = $card1;
$_SESSION['card2'] = $card2;
$_SESSION['currentRound']++;

echo "Round " . $_SESSION['currentRound'] . " of " . $_SESSION['rounds'];
echo "<br>Card 1: " . $card1['rank'] . " of " . $card1['suit'];
echo "<br>Card 2: " . $card2['rank'] . " of " . $card2['suit'];
echo "<br>Your score: " . $_SESSION['score'];

// Check if the two cards have the same rank and offer higher or lower options
if ($card1['rank'] === $card2['rank']) {
    echo "<br>Both cards have the same rank. Choose higher or lower for the next card:";
    echo "<br><a href='?action=higher'>HIGHER</a> | <a href='?action=lower'>LOWER</a>";
} else {
    echo "<br>Choose your action:";
    echo "<br><a href='?action=deal'>DEAL</a> | <a href='?action=no_deal'>NO DEAL</a>";
}

if (isset($_GET['action'])) {
    $card3 = generateCard();
    echo "<br>Card 3: " . $card3['rank'] . " of " . $card3['suit'];

    $action = $_GET['action'];
    $win = false;
    $jackpot = false;

    if ($card1['rank'] === $card2['rank']) {
        if (($action === 'higher' && $card3['rank'] > $card1['rank']) || ($action === 'lower' && $card3['rank'] < $card1['rank'])) {
            $win = true;
        }
    } elseif ($action === 'deal') {
        if ($card3['rank'] > min($card1['rank'], $card2['rank']) && $card3['rank'] < max($card1['rank'], $card2['rank'])) {
            $win = true;
        }
    } // 'no_deal' leads to automatic loss

    if ($win) {
        $_SESSION['score'] += 10;
        echo "<br>You win!";
    } else {
        $_SESSION['score'] -= 5;
        echo "<br>You lose.";
    }

    if ($card1['rank'] === $card2['rank'] && $card1['rank'] === $card3['rank']) {
        $jackpot = true;
        $_SESSION['score'] += 50;
        echo "<br>JACKPOT!";
    }

    if ($_SESSION['currentRound'] < $_SESSION['rounds']) {
        echo "<br><a href='?'>Next Round</a>";
    } else {
        echo "<br>Game Over! Your final score: " . $_SESSION['score'];
        echo "<br><a href='?restart=1'>Restart Game</a>";
    }
}
?>
