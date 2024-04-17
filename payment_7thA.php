<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>
<body>
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

            if (isset($_SESSION["user"])) {
                $user = $_SESSION["user"];
                $prefill_address = true;  //  Flag to control pre-filling
            } else {
                $prefill_address = false;
            }
        ?>

        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required <?php if ($prefill_address) echo "value='$user[name]'"; ?>><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required <?php if ($prefill_address) echo "value='$user[email]'"; ?>><br>

        <label for="address">Address:</label>
        <input type="text" name="address" id="address" required <?php if ($prefill_address) echo "value='$user[address]'"; ?>><br>

        <label for="city">City:</label>
        <input type="text" name="city" id="city" required <?php if ($prefill_address) echo "value='$user[city]'"; ?>><br>

        <label for="state">State:</label>
        <input type="text" name="state" id="state" required <?php if ($prefill_address) echo "value='$user[state]'"; ?>><br>

        <label for="zip">Zip Code:</label>
        <input type="text" name="zip" id="zip" required <?php if ($prefill_address) echo "value='$user[zip]'"; ?>><br>

        <label for="phone">Phone Number:</label>
        <input type="tel" name="phone" id="phone" required <?php if ($prefill_address) echo "value='$user[phone]'"; ?>><br>

        <input type="submit" value="Confirm Order">
    </form>

    <?php
        //  This part will process the order confirmation (replace with your logic)
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST["name"];
            $email = $_POST["email"];
            $address = $_POST["address"];
            $city = $_POST["city"];
            $state = $_POST["state"];
            $zip = $_POST["zip"];
            $phone = $_POST["phone"];

            //  Order processing logic (connect to database, process payment, etc.)
            echo "Order confirmation successful! (replace with success message)";
        }
    ?>
</body>
</html>
