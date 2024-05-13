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
    <?php
     session_start();
     if (isset($_SESSION["user_id"])) {
     // User is logged in, display content or functionalities specific to logged-in users
     } else {
     // User is not logged in, redirect to login page or display a login prompt
     }
    ?>
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
         <li><a href="./" class="header_shop"><span title="SHOP"><img src="./images/icon/index_header-shop.png" alt="shop"></span></a></li>
         <li><a href="./" class="header_mypage"><span title="MY PAGE"><img src="./images/icon/index_header-mypage.png" alt="shop"></span></a></li>
         <li><a href="./" class="header_contact"><span title="CONTACT"><img src="./images/icon/index_header-contact.png" alt="shop"></span></a></li>
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
