<?php
session_start();  // Start session for storing user data

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $CID = $_POST["cid"];
  $password = $_POST["password"];

  // Connect to database
  $conn = new mysqli("localhost", "root", "", "teamworkshop_7tha");

  // Prepare and execute SQL statement
  $sql = "SELECT * FROM customer_management WHERE CID = ? AND password = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $CID, $password);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    // Login successful
    $row = $result->fetch_assoc();
    $_SESSION["loggedIn"] = true;  // Store login status in session
    $_SESSION["CID"] = $CID;  // Store user CID in session

    echo "Login successful! Welcome back.";
  } else {
    echo "Invalid CID or password.";
  }

  $conn->close();
}
?>
