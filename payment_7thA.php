<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>
<body>

<?php

session_start();

if (isset($_SESSION["user_id"])) {
  // User is logged in, display content or functionalities specific to logged-in users
} else {
  // User is not logged in, redirect to login page or display a login prompt
}

?>

    <h1>Order Confirmation</h1>

    <h2>Shopping Cart</h2>
    <table border="1">  <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Item 1</td>
                <td>1</td>
                <td>$10.00</td>
            </tr>
            </tbody>
    </table>

    <h2>Shipping Information</h2>
    <form action="" method="post">

        <?php
            //  This part will pre-populate user data (replace with your logic)
            session_start();  //  Start session if using sessions

            if (isset($_SESSION["customer_management"])) {
                $customer_management = $_SESSION["customer_management"];
                $prefill_address = true;  //  Flag to control pre-filling
            } else {
                $prefill_address = false;
            }
        ?>

        <label for="name">名前:</label>
        <input type="text" name="name" id="name" required <?php if ($prefill_address) echo "value='$customer_management[name]'"; ?>><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required <?php if ($prefill_address) echo "value='$customer_management[email]'"; ?>><br>

        <label for="address">住所:</label>
        <input type="text" name="address" id="address" required <?php if ($prefill_address) echo "value='$customer_management[address]'"; ?>><br>

        <label for="phone">電話番号:</label>
        <input type="tel" name="phone" id="phone" required <?php if ($prefill_address) echo "value='$customer_management[phone]'"; ?>><br>

        <input type="submit" value="Confirm Order">
    </form>

    <?php
        //  This part will process the order confirmation (replace with your logic)
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST["name"];
            $email = $_POST["email"];
            $address = $_POST["address"];
            $phone = $_POST["phone"];

            //  Order processing logic (connect to database, process payment, etc.)
            echo "Order confirmation successful! (replace with success message)";
        }
    ?>
</body>
</html>
