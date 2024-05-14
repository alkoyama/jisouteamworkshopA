<!DOCTYPE html>
 <html lang="ja">
   <head>
     <meta charset="UTF-8">
     <link rel="stylesheet" href="./css/index_7thA.css">
     <link rel="stylesheet" href="./css/style.css">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css">
     <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
     <script src="https://use.fontawesome.com/926fe18a63.js"></script>
     <title>index</title>
   </head>
   <body>
    <header class="header" id="header">
      <div class="header_container">
       <div class="header_container_small">
        <a class="head_A">
         <img src="./images/icon/index_header-ball.gif" alt="ゆらゆら">
        </a>
        <button type="button" class="head_C">
         <span class="fa fa-bars" title="MEMU"></span><span class="sr-only">MEMU</span>
        </button>
       </div>
       <nav class="head_B">
        <ul>
                 <?php
             session_start();
             if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true) {
              echo "<p>ID: " . $_SESSION["CID"] . "</p>";
    
    } else {
     // User is not logged in, redirect to login page or display a login prompt
     echo "ログインしてください。</p>";
     }
    ?>
         <li><a href="./index_7tha.php" class="header_shop"><span title="SHOP"><img src="./images/icon/index_header-shop.png" alt="shop"></span></a></li>
         <li><a href="./my_page_7tha.php" class="header_mypage"><span title="MY PAGE"><img src="./images/icon/index_header-mypage.png" alt="shop"></span></a></li>
         <li><a href="./" class="header_contact"><span title="CONTACT"><img src="./images/icon/index_header-contact.png" alt="shop"></span></a></li>
        </ul>
       </nav>
      </div>
    </header>
       

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

       
    <footer class="footer" id="footer">
       <div class="footer_menu">
          <nav>
           <ul class="foot_B">
             <li><a href="./">Shop</a></li>
             <li><a href="./">My Page</a></li>
             <li><a href="./">Contact</a></li>
           </ul>
          </nav>
         <div class="foot_C"><p class="copyright">&copy; JS7th_teamA 2024</p></div>
       </div>
       <div class="foot_A"><img src="./images/icon/index_footer-ball.gif" alt="ころころ"></div>
    </footer>
  
     <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
     <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
     <script type="text/javascript" src="./js/index_7thA.js"></script>
   </body>
  </html>
