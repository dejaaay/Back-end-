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
    $ranks = [  
        1 => 'images/1.gif',
        2 => 'images/2.gif',
        3 => 'images/3.gif',
        4 => 'images/4.gif',
        5 => 'images/5.gif',
        6 => 'images/6.gif',
        7 => 'images/7.gif',
        8 => 'images/8.gif',
        9 => 'images/9.gif',
        ];
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

            if ($correct) {
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
            $min = min($_SESSION['card1']['rank'], $_SESSION['card2']['rank']);
            $max = max($_SESSION['card1']['rank'], $_SESSION['card2']['rank']);

            if ($_SESSION['card3']['rank'] > $min && $_SESSION['card3']['rank'] < $max) {
                $_SESSION['score'] += 10;
                $_SESSION['guessResult'] = 'Congratulations! You win! The third card falls between the first two.';
            } elseif ($_SESSION['card1']['rank'] == $_SESSION['card2']['rank'] && $_SESSION['card2']['rank'] == $_SESSION['card3']['rank']) {
                $_SESSION['score'] *= 2; // Double the score for jackpot
                $_SESSION['guessResult'] = 'Jackpot! All cards match. Your score is doubled.';}
             else {
                $_SESSION['score'] -= 10;
                $_SESSION['guessResult'] = 'Sorry, you lose. The third card does not fall between the first two.';
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-image: url("images/pixels.gif");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            
            
        }

        h1, p{
            color: #e7dfd9; 

        }

        .header{
            font-family: georgia; 
            font-size: 100px;
        }

        img{
            width: 100%;
            height: 100%;
            border-radius: 15px 30px 15px 30px;
        }

        .col .card-body img{
            width: 100%;
            height: 100%;
        }

        .card{
            border-radius: 15px 30px 15px 30px;
        }
        a:link, a:visited, a:hover, a:active {
            color: black; /* Or use any color code, like #000000 */
            text-decoration: none; /* Removes the underline from links */
        }

    </style>
</head>
<body>
    <div class="header">
        <p>In Between Game</p>
        <h1>Round: <?= $_SESSION['round'] ?> / 10</h1>
        <h1>Score: <?= $_SESSION['score'] ?></h1>
    </div>
    
    <?php if (!isset($_SESSION['stage']) || $_SESSION['stage'] == 'start' || $_SESSION['round'] >= 10): ?>
        <p>Game Over. Your final score is: <?= $_SESSION['score'] ?></p>
        <a href="?action=start">
            <button type="button" class="btn btn-light">Play again!</button>
        </a>
        <!-- High or Low Cards -->
    <?php elseif ($_SESSION['stage'] == 'guessHigherLower'): ?>
        <div class="row">
            <div class="col d-flex justify-content-center align-items-center pb-5">        
            <div class="card text-bg-dark" style="width: 20rem; height:30rem ; margin-left: 50px;">
                    <div class="card-header">
                        1st Card
                        <div class="card-body">
                            <img src="<?php echo $_SESSION['card1']['rank']; ?>" class="cardCustom" alt="Left Card">
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="col d-flex justify-content-center align-items-center pb-5"> 
            <div class="card text-bg-dark" style="width: 20rem; height: 30rem ; margin-left: 250px;">
                    <div class="card-header">
                        2nd Card
                        <div class="card-body">
                            <img src="<?php echo $_SESSION['card2']['rank']; ?>" class="cardCustom" alt="Left Card">
                        </div>
                    </div>
                </div>
            </div>  
        </div>
        <form action="index.php" method="get">
            <input type="hidden" name="action" value="deal">
            <button type="submit" name="guess" value="higher">Higher</button>
            <button type="submit" name="guess" value="lower">Lower</button>
        </form>

        <!-- Deal of 2 cards -->
    <?php elseif ($_SESSION['stage'] == 'started'): ?>
    <div class="container">
        <div class="row">
            <div class="col d-flex justify-content-center align-items-center pb-5">        
            <div class="card text-bg-dark" style="width: 20rem; height:30rem ; margin-left: 50px;">
                <img src="<?php echo $_SESSION['card1']['rank']; ?>" class="cardCustom" alt="Left Card">
                    <div class="card-header">
                        1st Card
                        <div class="card-body">
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="col d-flex justify-content-center align-items-center pb-5"> 
            <div class="card text-bg-dark" style="width: 20rem; height: 30rem ; margin-left: 50px;">
                    <img src="<?php echo $_SESSION['card2']['rank']; ?>" class="cardCustom" alt="Left Card">
                    <div class="card-header">
                        2nd Card
                        <div class="card-body">
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
        <a href="?action=deal">
            <button type="button" class="btn btn-light mb-4">Deal</button>
        </a>
        <a href="?action=start">
        <button type="button" class="btn btn-light mb-4">No Deal</button>  
        
        <!-- Deal of 3 Cards -->
    <?php elseif ($_SESSION['stage'] == 'guessed'): ?>
        <div class="row">
            <div class="col d-flex justify-content-center align-items-center pb-5">
            <div class="card text-bg-dark" style="width: 20rem; height:30rem ; margin-left: 50px;">
                <img src="<?php echo $_SESSION['card1']['rank']; ?>" class="cardCustom" alt="Left Card">
                    <div class="card-header">
                        1st Card
                        <div class="card-body">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col d-flex justify-content-center align-items-center pb-5"> 
            <div class="card text-bg-dark" style="width: 20rem; height: 30rem ; margin-left: 50px;">
                <img src="<?php echo $_SESSION['card2']['rank']; ?>" class="cardCustom" alt="Left Card">
                    <div class="card-header">
                            2nd Card
                        <div class="card-body">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col d-flex justify-content-center align-items-center pb-5"> 
            <div class="card text-bg-dark" style="width: 20rem; height: 30rem ; margin-left: 50px;">
                <img src="<?php echo $_SESSION['card3']['rank']; ?>" class="cardCustom" alt="Left Card">
                    <div class="card-header">
                        3rd Card
                        <div class="card-body">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p><?= $_SESSION['guessResult'] ?></p>
        <a href="?action=start">
            <button type="button" class="btn btn-light">Next Round</button>
        </a>
    <?php endif; ?>
</body>
</html>
