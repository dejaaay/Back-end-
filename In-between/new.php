<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card Game</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Card Game
                    </div>
                    <div class="card-body">
                    <?php
session_start();
const rounds = '';
// Set default or get the number of rounds from user input
if (!isset($_SESSION['rounds']) || isset($_GET['rounds'])) {
    $requestedRounds = in_array($_GET['rounds'], [3, 5, 10]) ? $_GET['rounds'] : 10;
    $_SESSION['rounds'] = $requestedRounds;
    $_SESSION['currentRound'] = 0;
    $_SESSION['score'] = 100; // Starting score
}

// Function to generate a card
function generateCard() {
    $suits = ['Spades', 'Hearts', 'Diamonds', 'Clubs'];
    $ranks = range(2, 14); // 11=Jack, 12=Queen, 13=King, 14=Ace
    return [
        'rank' => $ranks[array_rand($ranks)],
        'suit' => $suits[array_rand($suits)]
    ];
}

// Check if the game is over
if ($_SESSION['currentRound'] >= $_SESSION['rounds']) {
    echo "Game Over! Your final score: " . $_SESSION['score'];
    echo "<br><a href='?restart=1'>Restart Game</a>";
    session_destroy();
    exit;
}

// Restart the game
if (isset($_GET['restart'])) {
    session_destroy();
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Deal cards
$card1 = generateCard();
$card2 = generateCard();
// Ensure card2 is different from card1
while ($card2['rank'] === $card1['rank'] && $card2['suit'] === $card1['suit']) {
    $card2 = generateCard();
}

// Save cards to session to compare after user makes a choice
$_SESSION['card1'] = $card1;
$_SESSION['card2'] = $card2;

// Increment round
$_SESSION['currentRound']++;

// Display cards and ask for user choice
echo "Round " . $_SESSION['currentRound'] . " of " . $_SESSION['rounds'];
echo "<br>Card 1: " . $card1['rank'] . " of " . $card1['suit'];
echo "<br>Card 2: " . $card2['rank'] . " of " . $card2['suit'];
echo "<br>Your score: " . $_SESSION['score'];
echo "<br>Choose your action:";
echo "<br><a href='?action=deal'>DEAL</a> | <a href='?action=no_deal'>NO DEAL</a>";


// Handle user choice
if (isset($_GET['action'])) {
    $card3 = generateCard();
    echo "<br>Card 3: " . $card3['rank'] . " of " . $card3['suit'];

    $action = $_GET['action'];
    $win = false;
    $jackpot = false;

    // Sort cards to simplify comparison
    $sortedCards = [$card1['rank'], $card2['rank'], $card3['rank']];
    sort($sortedCards);

    if ($action === 'deal') {
        // Check for win condition
        if ($card3['rank'] > min($card1['rank'], $card2['rank']) && $card3['rank'] < max($card1['rank'], $card2['rank'])) {
            $win = true;
        }
    } elseif ($action === 'no_deal') {
        // Automatic loss, handled below
    }

    // Adjust score based on win/loss
    if ($win) {
        $_SESSION['score'] += 10; // Example win points
        echo "<br>You win!";
    } else {
        $_SESSION['score'] -= 5; // Example loss points
        echo "<br>You lose.";
    }

    // Check for jackpot (third card matches the first two)
    if ($card1['rank'] === $card2['rank'] && $card1['rank'] === $card3['rank']) {
        $jackpot = true;
        $_SESSION['score'] += 50; // Example jackpot points
        echo "<br>JACKPOT!";
    }

    // Continue or end game
    if ($_SESSION['currentRound'] < $_SESSION['rounds']) {
        echo "<br><a href='?'>Next Round</a>";
    } else {
        echo "<br>Game Over! Your final score: " . $_SESSION['score'];
        echo "<br><a href='?restart=1'>Restart Game</a>";
    }
}
?>
     
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
