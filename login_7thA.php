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
    <label for="name">名前:</label>
    <input type="text" name="name" id="name" required><br>

    <label for="password">パスワード:</label>
    <input type="password" name="password" id="password" required><br>

    <input type="submit" value="Login">
  </form>

  <?php
  session_start();
  
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $name = $_POST["name"];
      $password = $_POST["password"];

      // Connect to database
      $conn = new mysqli("localhost", "root", "", "teamworkshop_7thA");
      
      // Prepare SQL statement
      $sql = "SELECT * FROM customer_management WHERE name = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("s", $name);
      $stmt->execute();
      $result = $stmt->get_result();
      $user = $result->fetch_assoc();

      // Validate user
      if ($user) {
        // Verify password using password hashing (replace with your actual hashed password)
        if (password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $customer_management["name"]; // Replace "id" with your actual user identifier column name
            echo "ログイン成功！";
        } else {
          echo "パスワードが違います";
        }
      } else {
        echo "名前が違います";
      }

      $conn->close();
    }
  ?>
</body>
</html>
