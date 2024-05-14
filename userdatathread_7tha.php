<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['CID'])) {
  header("Location: login_7tha.php"); // Redirect to login page if not logged in
  exit();
}

$cid = $_SESSION['CID'];

// Database connection details (replace with your actual connection info)
$host = "localhost";
$dbname = "teamworkshop_7tha";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Prepare the SQL query
  $sql = "SELECT * FROM customer_management WHERE CID = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bindValue(1, $cid, PDO::PARAM_STR); // Bind as string
  $stmt->execute();
  

  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$user) {
    $data = array('error' => 'User not found');
  } else {
    $data = array(
      'CID' => $user['CID'],
      'Name' => $user['Name'],
      'Address' => $user['Address'],
      'Phone' => $user['Phone'],
      'Card_info' => $user['Card_info'],
      // ... Add more user details as needed
    );
  }

  // Encode data to JSON
  $json_data = json_encode($data);

  echo $json_data; // Send JSON data to the client-side script

} catch(PDOException $e) {
  echo json_encode(array('error' => $e->getMessage())); // Send error message as JSON
}

$conn = null;
?>
