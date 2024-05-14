<!DOCTYPE html>
 <html lang="ja">
   <head>
     <meta charset="UTF-8">
     <link rel="stylesheet" href="./css/index_7thA.css">
     <link rel="stylesheet" href="./css/style.css">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css">
     <link rel="preconnect" href="https://fonts.googleapis.com">
     <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
     <link href="https://fonts.googleapis.com/css2?family=Aoboshi+One&display=swap" rel="stylesheet">
     <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
     <script src="https://use.fontawesome.com/926fe18a63.js"></script>
     <style>
              body {
            width: 60%;
            margin: 0 auto;
        }

        .main {
          display: flex;
          flex-direction: row;
        }


     </style>
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
         <li><a href="./" class="header_shop"><span title="SHOP"><img src="./images/icon/index_header-shop.png" alt="shop"></span></a></li>
         <li><a href="./" class="header_mypage"><span title="MY PAGE"><img src="./images/icon/index_header-mypage.png" alt="shop"></span></a></li>
         <li><a href="./" class="header_contact"><span title="CONTACT"><img src="./images/icon/index_header-contact.png" alt="shop"></span></a></li>
        </ul>
       </nav>
      </div>
    </header>



                <?php

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

            $sql_user = "SELECT * FROM customer_management WHERE CID = ?"; // Assuming id is the primary key
            $stmt_user = $conn->prepare($sql_user);
            $stmt_user->execute([$cid]);
            
            $user = $stmt_user->fetch(PDO::FETCH_ASSOC);
            
            if (!$user) {
              echo "User not found";
            } else {
                if (!$user) {
                    echo "User not found"; // Handle case where user is not found
                } else {
                    echo "<h2>Welcome, " . $user['Name'] . "</h2>\n";
                    echo "<p>CID: " . $user['CID'] . "</p>\n";
                    echo "<p>Address: " . $user['Address'] . "</p>\n";
                    echo "<p>Phone: " . $user['Phone'] . "</p>\n";
                    // ... Add elements for other user details
                }
            


            ///以下、オーダー履歴部分
              $sql_orders = "SELECT * FROM order_management WHERE cid = ?";
              $stmt_orders = $conn->prepare($sql_orders);
              $stmt_orders->execute([$cid]);
            
              $orders = $stmt_orders->fetchAll(PDO::FETCH_ASSOC); // Assuming multiple orders
            
              if ($orders) {
                echo "<h3>Order History:</h3>";
                foreach ($orders as $order) {
                  echo "<p>Order ID: " . $order['OID'] . "</p>";
                  echo "<p>Order Date: " . $order['Date_time'] . "</p>";
                }
              } else {
                echo "<p>No orders found.</p>";
              }
            }

        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            }

            $conn = null;

            ?>

<a href="./logout_7tha.php" class="Logout">ログアウト</a>




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
     <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
     <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
     <script type="text/javascript" src="./js/index_7thA.js"></script>
   </body>
  </html>
