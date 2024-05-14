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
     <script type="text/javascript" src="./js/index_admin_7thA.js"></script>
     <title>index</title>
   </head>
   <body>
  <div class="login-container">
    <?php
    session_start();

    $dsn = 'mysql:host=localhost;dbname=teamworkshop_7thA;charset=utf8mb4';
    $username = 'root';
    $password = '';

    try {
      $pdo = new PDO($dsn, $username, $password);
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      if (isset($_POST['login'])) {
        $login_value = $_POST['login_value'];
        $pass = $_POST['Password'];

        // Check if login value is CID or Name
        $stmt = $pdo->prepare('SELECT CID, Name FROM customer_management WHERE (CID = ? OR Name = ?) AND Password = ?');
        $stmt->execute([$login_value, $login_value, $pass]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
          $_SESSION['loggedIn'] = true;
          $_SESSION['CID'] = $user['CID'];
          $_SESSION['Name'] = $user['Name'];
        } else {
          echo '<p>ログインに失敗しました。</p>';
        }
      }

      if (isset($_POST['logout'])) {
        session_destroy();
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
      }

      if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) {
        echo '<p>ようこそ, ' . htmlspecialchars($_SESSION['Name']) . ' さん</p>';
        echo '<form method="post"><button type="submit" name="logout">ログアウト</button></form>';
      } else {
        echo '<form method="post">';
        echo '<input type="text" name="login_value" placeholder="CIDまたはName" required>';
        echo '<input type="password" name="Password" placeholder="Password" required>';
        echo '<button type="submit" name="login">ログイン</button>';
        echo '</form>';
      }
      // ログイン中かどうかを確認
      if (!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] !== true) {
        // ログインしていない場合は表示
        echo '<p>新規会員の方は <a href="signup_7thA.php">こちら</a></p>';
      }
    } catch (PDOException $e) {
      echo 'Connection failed: ' . $e->getMessage();
    }
    ?>
  </div>
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
         <li><a href="./index_7thA.php" class="header_shop"><span title="SHOP"><img src="./images/icon/index_header-shop.png" alt="shop"></span></a></li>
         <li><a href="./my_page_7thA.php" class="header_mypage"><span title="MY PAGE"><img src="./images/icon/index_header-mypage.png" alt="shop"></span></a></li>
         <li><a href="./" class="header_contact"><span title="CONTACT"><img src="./images/icon/index_header-contact.png" alt="shop"></span></a></li>
         <li><a href="./battle_7thA.php" class="header_battle"><span title="BATTLE"><img src="./images/icon/index_go-battle.png" alt="shop"></span></a></li>
        </ul>
       </nav>
      </div>
    </header>

    <div class="sale_container">
      <div class="sale_slick">
        <div class="sale_slick_img"><img src="./images/sale/index_SALE_001.png" alt="" ></div>
        <div class="sale_slick_img"><img src="./images/sale/index_SALE_002.png" alt="" ></div>
        <div class="sale_slick_img"><img src="./images/sale/index_SALE_003.png" alt="" ></div>
        <div class="sale_slick_img"><img src="./images/sale/index_SALE_004.png" alt="" ></div>
        <div class="sale_slick_img"><img src="./images/sale/index_SALE_005.png" alt="" ></div>
        <div class="sale_slick_img"><img src="./images/sale/index_SALE_006.png" alt="" ></div>
      </div>
    </div>

    <div class="main">
     <?php include 'poke_card.php'; ?>
    </div>

    <footer class="footer" id="footer">
       <div class="footer_menu">
          <nav>
           <ul class="foot_B">
             <li><a href="./index_7thA.php">Shop</a></li>
             <li><a href="./my_page_7thA.php">My Page</a></li>
             <li><a href="./">Contact</a></li>
             <li><a href="./Integration_Hub_7th.php" class="admin-link">管理者ページ</a></li>
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