<?php
// Start the session (optional, for storing login state)
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $password = $_POST["password"];

  // Basic validation (always improve on validation!)
  if (empty($name) or empty($password)) {
    echo "Please enter username and password.";
  } else {
    // Connect to database (replace with your database connection logic)
    $conn = new mysqli("localhost", "root", "", "teamworkshop_7tha");

    // Prepare and execute SQL statement (learn about prepared statements to prevent SQL injection)
    $sql = "SELECT * FROM customer_management WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();

      if ($password == $row["password"]) {
        echo "Login successful!";
        // You can potentially start a session here to store user information
      } else {
        echo "Incorrect password.";
      }
    } else {
      echo "Username not found.";
    }

    // Close connection (remember to close connections!)
    $conn->close();
  }
}
?>
