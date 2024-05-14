<?php
session_start();  // Start session for storing user data

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $CID = $_POST["cid"];
  $password = $_POST["password"];

  // Connect to database
  $conn = new mysqli("localhost", "root", "", "teamworkshop_7tha");

  // Prepare and execute SQL statement
  $sql = "SELECT CID, Name FROM customer_management WHERE CID = ? AND password = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $CID, $password);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    // Login successful
    $row = $result->fetch_assoc();
    $_SESSION["loggedIn"] = true;  // Store login status in session
    $_SESSION["CID"] = $row["CID"];  // Store user CID in session
    $_SESSION["Name"] = $row["Name"];  // Store user Name in session

    echo "Login successful! Welcome back, " . $row["Name"] . ".<br>";
    echo '<a href="index_7thA.php">ストアフロントへ戻る</a>'; // Link to index_7thA.php
  } else {
    echo "Invalid CID or password.";
    echo '<a href="index_7thA.php">ストアフロントへ戻る</a>'; // Link to index_7thA.php
  }

  $conn->close();
}
?>

