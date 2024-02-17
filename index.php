<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Tax Calculator</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5 justify-content-center">
    <div class="card w-50">
  <div class="card-header">
 <h1 class="text-center">Service Tax Calculator</h1>
  </div>
  <div class="card-body">
  
        <form action="calculate_tax.php" method="post">
            <div class="form-group">
                <label for="amount">Enter Amount:</label>
                <input type="text" class="form-control" id="amount" name="amount" required>
              <label for="income" class="pt-3">Select Payment Type:</label>
               <br>
              <input type="radio" id="monthly" name="period" value="monthly">
              <label for="monthly">Monthly</label><br>
              <input type="radio" id="bi-monthly" name="period" value="bi-monthly">
              <label for="bi-monthly">Bi-Monthly</label><br>
            </div>

            <button type="submit" class="btn">Calculate Tax</button>
        </form>
  </div>
</div>
    </div>


    <!-- Include Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
