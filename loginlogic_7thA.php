<?php
// Start the session (optional, for storing login state)
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $password = $_POST["password"];

  // Connect to database (replace with your connection logic)
  $conn = new mysqli("localhost", "root", "", "teamworkshop_7thA");
  
  // Prepare SQL statement (learn about prepared statements to prevent SQL injection)
  $sql = "SELECT * FROM customer_management WHERE name = ?";
   $stmt = $conn->prepare($sql);
   $stmt->bind_param("s", $name);
   $stmt->execute();
   $result = $stmt->get_result();
   $user = $result->fetch_assoc();

  // Validate user and password (hash comparison)
   if ($user && password_verify($password, $customer_management["password"])) {
     $_SESSION["loggedin"] = true;  // Set session variable (optional)
     echo "ログインできました";
   } else {
     echo "名前またはパスワードが違います";
   }

  // Close connection (remember to close connections!)
  $conn->close();
}
?>
