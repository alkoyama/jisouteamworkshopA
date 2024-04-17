<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Account</title>
</head>
<body>
    <h1>Create New Account</h1>
    <form action="" method="post"> <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>

        <label for="adress">Email:</label>
        <input type="email" name="email" id="email" required><br>

        <label for="tel number">Email:</label>
        <input type="email" name="email" id="email" required><br>

        

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" id="confirm_password" required><br>

        <input type="submit" value="Create Account">
    </form>

    <?php
        //  This part will process the form submission (replace with your logic)
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST["username"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $confirmPassword = $_POST["confirm_password"];
            
            //  Basic validation (always improve on validation!)
            if (empty($username) or empty($email) or empty($password) or empty($confirmPassword)) {
                echo "Please fill out all required fields.";
            } else if ($password != $confirmPassword) {
                echo "Passwords do not match.";
            } else {
                //  Connect to database (replace with your database connection logic)
                //  $conn = new mysqli("localhost", "username", "password", "database_name");
                
                //  Prepare and execute SQL statement (learn about prepared statements to prevent SQL injection)
                //  $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
                //  $stmt = $conn->prepare($sql);
                //  $stmt->bind_param("sss", $username, $email, password_hash($password, PASSWORD_DEFAULT));
                //  $stmt->execute();

                //  Close connection (remember to close connections!)
                //  $conn->close();

                echo "Account created successfully! (replace with success message)";
            }
        }
    ?>
</body>
</html>
