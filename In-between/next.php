<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sugalan sa Paaralan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <style>
        a:link, a:visited, a:hover, a:active {
    color: black; /* Or use any color code, like #000000 */
    text-decoration: none; /* Removes the underline from links */
}
.center-container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 500px; /* This makes the container take the full viewport height */
    text-align: center; /* Ensures the text within the container is centered as well */
}

button {
    margin-top: 20px; /* Adds some space between the h1 and the button */
}

a {
    text-decoration: none; /* Optional: Removes the underline from the link */
    color: inherit; /* Optional: Makes the link color inherit from the button */
}
  </style>
  <body>
  <div class="center-container">
    <h2 class="text-center">Are you 18 years old or above?</h2>
    <div class="row">
        <div class="col">
        <button id="secondButton">Yes</button>
        <button id=""><a href="landing.php"></a>No</button>
        </div>
    </div>

    <!-- Initially hidden second button -->
    <div id="hiddenContent" style="display: none;">
        <label for="birthYear">Enter your birth year:</label>
            <input type="number" id="birthYear" name="birthYear">
            <button onclick="validateAge()">Submit</button>
        </div>

    </div>
    <script>

    document.getElementById('secondButton').addEventListener('click', function() {
    document.getElementById('hiddenContent').style.display = 'block';
    });


        function validateAge() {
            var birthYear = parseInt(document.getElementById('birthYear').value, 10); // Get the entered birth year
            var currentYear = new Date().getFullYear(); // Get the current year
            var age = currentYear - birthYear; // Calculate the age
            
            if(age >= 18) {
                // If 18 or older, redirect to the welcome page
                window.location.href = 'welcome.php';
            } else {
                // If under 18, redirect to the exit page
                window.location.href = 'exit.php';
            }
        }


    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>