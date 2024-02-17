<?php

function drawCard() {
    return rand(1, 10);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the user's choice from the form submission
    $userChoice = $_POST['choice'];

    // Draw two cards
    $card1 = drawCard();
    $card2 = drawCard();

    echo "<p>First card: $card1</p>";
    echo "<p>Second card: $card2</p>";

    // If the cards are the same, use the user's choice to determine win/lose
    if ($card1 == $card2) {
        $thirdCard = drawCard();
        echo "<p>Third card: $thirdCard</p>";

        if (($userChoice == "higher" && $thirdCard > $card1) ||
            ($userChoice == "lower" && $thirdCard < $card1)) {
            echo "<p>Congratulations! You win!</p>";
        } else {
            echo "<p>Sorry! You lose.</p>";
        }
    } else {
        echo "<p>The drawn cards are not the same. Please play again.</p>";
    }
} else {
    // Redirect back to the form if the request method is not POST
    header("Location: index.php");
}

?>
