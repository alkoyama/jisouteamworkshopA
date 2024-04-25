<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Test Login Status</title>
</head>
<body>
<?php
  session_start();

  // Check if user is logged in
  if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) {
    echo "<h1>ログインされています！</h1>";
    echo "<p>CIDは: " . $_SESSION["CID"] . "</p>";
    echo "<a href='logout.php'>ログアウト</a>";  // Link to logout page
  } else {
    echo "<h1>ログインされていません</h1>";
    echo "<p>ログインするとコンテンツが表示されます。</p>";
  }
?>
</body>
</html>
