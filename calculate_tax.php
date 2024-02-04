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
            $period = $_POST["period"];

        if ($period === 'monthly')  {
            if (!is_numeric($amount)) {
                echo '<div class="alert alert-danger" role="alert">Please enter a valid numeric amount.</div>';
            } elseif ($amount <= 20833.33) {
                $annualIncome = $amount*12;

                echo '<div class="alert alert-success" role="alert">';
                echo "<p>Annual Salary: $annualIncome </p>";
                echo "<p>Under 250,000 no tax</p>";

            } elseif ($amount > 20833.33 && $amount <= 33333.33) {
                $annualIncome = $amount*12;
                $Tax = $annualIncome - 250000;
                $annualTax = $Tax * .20;
                $monthlyTax = $annualTax / 12;

                echo '<div class="alert alert-success" role="alert">';
                echo "<p>Annual Salary: $annualIncome </p>";
                echo "<p>Annual Tax: $annualTax </p>";
                echo "<p>Monthly Tax: $monthlyTax</p>";
            }
            elseif ($amount > 33333.33 && $amount <= 66666.7) {
                $annualIncome = $amount*12;
                $Tax = $annualIncome - 400000;
                $percentage = $Tax * .25;
                $annualTax = $percentage + 22500;
                $monthlyTax = $annualTax / 12;

                echo '<div class="alert alert-success" role="alert">';
                echo "<p>Annual Salary: $annualIncome </p>";
                echo "<p>Annual Tax: $annualTax </p>";
                echo "<p>Monthly Tax: $monthlyTax</p>";
            }
            elseif ($amount > 66666.7 && $amount <= 166666.7 ) {
                $annualIncome = $amount*12;
                $Tax = $annualIncome - 800000;
                $percentage = $Tax * .30;
                $annualTax = $percentage + 102500;
                $monthlyTax = $annualTax / 12;

                echo '<div class="alert alert-success" role="alert">';
                echo "<p>Annual Salary: $annualIncome </p>";
                echo "<p>Annual Tax: $annualTax </p>";
                echo "<p>Monthly Tax: $monthlyTax</p>";
            }
            elseif ($amount > 166666.7 && $amount <= 666666.7 ) {
                $annualIncome = $amount*12;
                $Tax = $annualIncome - 2000000;
                $percentage = $Tax * .32;
                $annualTax = $percentage + 402500;
                $monthlyTax = $annualTax / 12;

                echo '<div class="alert alert-success" role="alert">';
                echo "<p>Annual Salary: $annualIncome </p>";
                echo "<p>Annual Tax: $annualTax </p>";
                echo "<p>Monthly Tax: $monthlyTax</p>";
            }
            elseif ($amount > 666666.7 ) {
                $annualIncome = $amount*12;
                $Tax = $annualIncome - 8000000;
                $percentage = $Tax * .35;
                $annualTax = $percentage + 2202500;
                $monthlyTax = $annualTax / 12;

                echo '<div class="alert alert-success" role="alert">';
                echo "<p>Annual Salary: $annualIncome </p>";
                echo "<p>Annual Tax: $annualTax </p>";
                echo "<p>Monthly Tax: $monthlyTax</p>";
            }
        }
        elseif ($period === 'bi-monthly') {
            if (!is_numeric($amount)) {
                echo '<div class="alert alert-danger" role="alert">Please enter a valid numeric amount.</div>';
            } elseif ($amount <= 10416.7) {
                $annualIncome = $amount*24;

                echo '<div class="alert alert-success" role="alert">';
                echo "<p>Annual Salary: $annualIncome </p>";
                echo "<p>Under 250,000 no tax</p>";

            } elseif ($amount > 10416.7 && $amount <= 16666.7) {
                $annualIncome = $amount*24;
                $Tax = $annualIncome - 250000;
                $annualTax = $Tax * .20;
                $monthlyTax = $annualTax / 12;

                echo '<div class="alert alert-success" role="alert">';
                echo "<p>Annual Salary: $annualIncome </p>";
                echo "<p>Annual Tax: $annualTax </p>";
                echo "<p>Monthly Tax: $monthlyTax</p>";
            }
            elseif ($amount > 16666.7 && $amount <= 33333.35) {
                $annualIncome = $amount*24;
                $Tax = $annualIncome - 400000;
                $percentage = $Tax * .25;
                $annualTax = $percentage + 22500;
                $monthlyTax = $annualTax / 12;

                echo '<div class="alert alert-success" role="alert">';
                echo "<p>Annual Salary: $annualIncome </p>";
                echo "<p>Annual Tax: $annualTax </p>";
                echo "<p>Monthly Tax: $monthlyTax</p>";
            }
            elseif ($amount > 33333.35 && $amount <= 83333.35 ) {
                $annualIncome = $amount*24;
                $Tax = $annualIncome - 800000;
                $percentage = $Tax * .30;
                $annualTax = $percentage + 102500;
                $monthlyTax = $annualTax / 12;

                echo '<div class="alert alert-success" role="alert">';
                echo "<p>Annual Salary: $annualIncome </p>";
                echo "<p>Annual Tax: $annualTax </p>";
                echo "<p>Monthly Tax: $monthlyTax</p>";
            }
            elseif ($amount > 83333.35 && $amount <= 333333.35 ) {
                $annualIncome = $amount*24;
                $Tax = $annualIncome - 2000000;
                $percentage = $Tax * .32;
                $annualTax = $percentage + 402500;
                $monthlyTax = $annualTax / 12;

                echo '<div class="alert alert-success" role="alert">';
                echo "<p>Annual Salary: $annualIncome </p>";
                echo "<p>Annual Tax: $annualTax </p>";
                echo "<p>Monthly Tax: $monthlyTax</p>";
            }
            elseif ($amount > 333333.35 ) {
                $annualIncome = $amount*24;
                $Tax = $annualIncome - 8000000;
                $percentage = $Tax * .35;
                $annualTax = $percentage + 2202500;
                $monthlyTax = $annualTax / 12;

                echo '<div class="alert alert-success" role="alert">';
                echo "<p>Annual Salary: $annualIncome </p>";
                echo "<p>Annual Tax: $annualTax </p>";
                echo "<p>Monthly Tax: $monthlyTax</p>";
            } 
        }

        } else {
            header("Location: index.php");
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
