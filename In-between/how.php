<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <style>
          body {
            background-image: url('images/bggold.png');
            background-size: cover;
            background-attachment: fixed;
            background-repeat: no-repeat;

            margin-bottom:300px;
        }
        .card {
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 80vh; 
            align-items: center;
            text-align: center;
           
            padding-top:20px;
        }
    </style>
  <body>
    <a href="starter.php" class="btn btn btn-outline-light mx-5 my-5">Go Back</a>
    <div class="row">
        <div class="col d-flex justify-content-center align-items-center">
        <div class="card text-center text-bg-dark" style="width: 50rem; height: 41rem ;">
            <div class="card-header">
                 <h5 class="card-title pt-2">IN-BETWEEN GAME</h5>
            </div>
                <div class="card-body">
                    
                    <h4>The game mechanics will be played as followed:</h4>
                    <p class="card-text">The game shall randomly draw two cards (shown to the player)</p>
                    <p class="card-text">Then, ask the user to choose DEAL or NO DEAL. <br>
                        Then it will only show the THIRD card after the player chooses his option. <br>
                        (The two cards are NOT identical) <br>
                        The player has the option to choose between DEAL or NO DEAL. <br>
                        If the user chooses DEAL - the player WINS the game if the THIRD number is in-between (exclusively) the first two drawn cards. Otherwise, the player LOSES. <br>
                        WIN: Add points to his current points (the developer has the option to change this mechanic) <br>
                    </p>
                    <p>
                    LOSE: Deduct points to his current points (the developer has the option to change this mechanic) <br>
                    If the user chooses NO DEAL, deduct a portion his current points. <br>
                    (The two cards are identical)  <br>
                    The player can choose between “HIGHER” or “LOWER”. <br>
                    If the user chooses HIGHER - the player  WINS the game if the THIRD number is higher than the first two identical drawn cards. Otherwise, the player LOSES. <br>
                    If the user chooses LOWER- the player WINS the game if the THIRD number is lower than the first two identical drawn cards. Otherwise, the player LOSES. <br>
                    Winning and Losing: Same mechanics indicated above.  <br>
                    If the THIRD card is the SAME as the first two numbers, the player will get a JACKPOT prize. <br>

                    </p>
                    <a href="index.php" class="btn btn-outline-secondary">Ready to Play!</a>
                </div>

        </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>