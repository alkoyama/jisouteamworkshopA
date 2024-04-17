<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form action="" method="post">
        <label for="username">ユーザー名:</label>
        <input type="text" name="username" id="username" required><br>

        <label for="password">パスワード:</label>
        <input type="password" name="password" id="password" required><br>

        <input type="submit" value="ログイン">
    </form>

    <?php
        //  This part will process the login attempt (replace with your logic)
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST["username"];
            $password = $_POST["password"];

            //  Connect to database (replace with your connection logic)
            //  $conn = new mysqli("localhost", "username", "password", "database_name");
            
            //  Prepare SQL statement (learn about prepared statements to prevent SQL injection)
            //  $sql = "SELECT * FROM users WHERE username = ?";
            //  $stmt = $conn->prepare($sql);
            //  $stmt->bind_param("s", $username);
            //  $stmt->execute();
            //  $result = $stmt->get_result();
            //  $user = $result->fetch_assoc();

            //  Validate user and password (hash comparison)
            if ($user && password_verify($password, $user["password"])) {
                //  Login successful (redirect or display success message)
                echo "Login successful! (replace with success message or redirect)";
            } else {
                echo "Invalid username or password.";
            }

            //  Close connection (remember to close connections!)
            //  $conn->close();
        }
    ?>
</body>
</html>
