<html>
<?php
// headタグ内に入れてください
include("loginlogic_7thA.php");
?>




//header内に入れられたらいいかも
<header>
    <form action="" method="post">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <input type="submit" value="Login">
    </form>
    <a href="signup_7thA.php">Register</a>
</header>

</html>