<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Tax Calculator - Result</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Service Tax Calculator - Result</h1>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $amount = $_POST["amount"];
            if (!is_numeric($amount)) {
                echo '<div class="alert alert-danger" role="alert">Please enter a valid numeric amount.</div>';
            } else {
                $serviceTax = $amount * 0.12;
                $totalAmount = $amount + $serviceTax;

                echo '<div class="alert alert-success" role="alert">';
                echo "<p>Original Amount: $amount</p>";
                echo "<p>Service Tax (12%): $serviceTax</p>";
                echo "<p>Total Amount (including tax): $totalAmount</p>";
                echo '</div>';
            }
        } else {
            header("Location: header.php");
            exit();
        }
        ?>
    </div>

    <!-- Include Bootstrap JS and Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
