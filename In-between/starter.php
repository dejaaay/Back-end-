<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <style>
@import url('https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap');

        body {
            background-image: url('images/bg3.gif');
            background-position: center;
            height:100vh;
            font-family: "Bebas Neue", sans-serif;
            font-weight: 400;
            font-style: normal;

        }
        .col {
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 80vh; 
            align-items: center;
            text-align: center;
        }
        .center-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center; /* This makes the container take the full viewport height */
            text-align: center; /* Ensures the text within the container is centered as well */
        }
        a:link, a:visited, a:hover, a:active {
            color: black; /* Or use any color code, like #000000 */
            text-decoration: none; /* Removes the underline from links */
        }

        h1{
            font-family: "Bebas Neue", sans-serif;
            font-weight: 400;
            font-style: normal;
            font-size: 100px;
        }
    </style>
  <body>
     <div class="center-container pt-3">
    <h1 class="text-center pt-5 text-light">In-Between</h1>
    </div>
    <div class="row">
        <div class="col d-flex justify-content-center align-items-center pb-5">
            <div class="card text-bg-dark" style="width: 20rem; height: 20rem ; margin-left: 250px;"> <!-- You can adjust the width as needed -->
                <img src="images/bg5.gif" class="card-img" alt="...">
                <div class="card-img-overlay">
                    <h3 class="card-title">Play Now!</h3>
                    <button type="button" class="btn btn-light mt-3"><a href="index.php">Let's Play</a></button>
                </div>
            </div>
        </div>
        <div class="col d-flex justify-content-center align-items-center pb-5">
            <div class="card text-bg-dark" style="width: 20rem;height: 20rem ; margin-right: 250px;"> <!-- You can adjust the width as needed -->
                <img src="images/bg5.gif" class="card-img" alt="...">
                <div class="card-img-overlay">
                <h3 class="card-title">How To Play</h3>
                    <button type="button" class="btn btn-light mt-3"><a href="how.php">Learn How</a></button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>