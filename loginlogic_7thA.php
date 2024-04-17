<?php
// Start the session (optional, for storing login state)
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  // Connect to database (replace with your connection logic)
  // $conn = new mysqli("localhost", "username", "password", "database_name");
  
  // Prepare SQL statement (learn about prepared statements to prevent SQL injection)
  // $sql = "SELECT * FROM users WHERE username = ?";
  // $stmt = $conn->prepare($sql);
  // $stmt->bind_param("s", $username);
  // $stmt->execute();
  // $result = $stmt->get_result();
  // $user = $result->fetch_assoc();

  // Validate user and password (hash comparison)
  // if ($user && password_verify($password, $user["password"])) {
  //   $_SESSION["loggedin"] = true;  // Set session variable (optional)
  //   echo "Login successful! (replace with success message or redirect)";
  // } else {
  //   echo "Invalid username or password.";
  // }

  // Close connection (remember to close connections!)
  // $conn->close();
}
?>
