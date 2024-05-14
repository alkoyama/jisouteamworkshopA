<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Account</title>
</head>
<body>
    <h1>Create New Account</h1>
    <form action="" method="post"> <label for="name">名前:</label>
        <input type="text" name="name" id="name" required><br>

        <label for="address">住所:</label>
        <input type="text" name="address" id="address" required><br>

        <label for="phone">電話番号:</label>
        <input type="int" name="phone" id="phone" required><br>

        <label for="card_info">カード番号:</label>
        <input type="int" name="card_info" id="card_info" required><br>

        

        <label for="password">パスワード:</label>
        <input type="password" name="password" id="password" required><br>

        <label for="confirm_password">パスワード確認:</label>
        <input type="password" name="confirm_password" id="confirm_password" required><br>

        <input type="submit" value="Create Account">
    </form>

    <br><a href="index_7thA.php">ストアフロントへ戻る</a>

    <?php
        //  This part will process the form submission (replace with your logic)

//↓ここからIDを生成するファンクションです
        function generateUniqueCID($conn) {
        $sql = "SELECT CID FROM customer_management ORDER BY CID DESC LIMIT 1";
        $result = $conn->query($sql);
        $lastCID = $result->fetch_assoc()["CID"];  

        if ($lastCID) {
            $lastNumber = (int)substr($lastCID, 1);  // 一番大きい数字から　"C"　を一旦外す
            return "C" . str_pad(++$lastNumber, 3, "0", STR_PAD_LEFT);  // autoincrementして、桁数に合うように０を追加する。Cを戻す
        } else {
            return "C001";  // カラムがからの場合 C001　にする
        }
        }
//↑ここまで


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST["name"];
            $address = $_POST["address"];
            $phone = $_POST["phone"];
            $card_info = $_POST["card_info"];
            $password = $_POST["password"];
            $confirmPassword = $_POST["confirm_password"];
            
            //  Basic validation (always improve on validation!)
            if (empty($name) or empty($address) or empty($phone) or empty($card_info) or empty($password) or empty($confirmPassword)) {
                echo "すべての情報を入力してください。";
            } else if ($password != $confirmPassword) {
                echo "パスワードが一致しません。";
            } else {
                //  Connect to database (replace with your database connection logic)
                $conn = new mysqli("localhost", "root", "", "teamworkshop_7tha");

//↓ここで生成使ってます
                $CID = generateUniqueCID($conn);  // Generate unique CID

                // Prepare and execute SQL statement
                $sql = "INSERT INTO customer_management (CID, name, address, phone, card_info, password) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssss", $CID, $name, $address, $phone, $card_info, $password);
                $stmt->execute();


                // Close connection (remember to close connections!)
                $conn->close();

                $message = "アカウント登録が完了しました。 CID: " . $CID;
                echo $message;
              }
        }
    ?>
</body>
</html>
