<!DOCTYPE html>
 <html lang="ja">
   <head>
     <meta charset="UTF-8">
     <link rel="stylesheet" href="./css/index_7thA.css">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
     <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
     <script type="text/javascript" src="./js/index_7thA.js"></script>
         <script type="text/javascript" src="./js/symbolreplacement.js"></script>
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
    <header class="header">
       <div class="header_wrap">
         <div class="header_logo">
           <a href=""><img src="./images/icon/index_header-ball.gif" alt="ゆらゆら"></a>
         </div>
         <ul class="header_menu"> 
           <li><a href="">login</a></li> 
           <li><a href="">main</a></li>
           <li><a href="">(仮1)</a></li>
           <li><a href="">(仮2)</a></li>
         </ul>
       </div>
      </header>


     <div class="slider">
       <img src="./images/sale/index_SALE_001.png" width="500" height="300" alt="ポケモン デー">
       <img src="./images/sale/index_SALE_002.png" width="500" height="300" alt="サンドの日">
       <img src="./images/sale/index_SALE_003.png" width="500" height="300" alt="ロコンの日">
       <img src="./images/sale/index_SALE_004.png" width="500" height="300" alt="ナッシーの日">
       <img src="./images/sale/index_SALE_005.png" width="500" height="300" alt="ヤドンの日">
       <img src="./images/sale/index_SALE_006.png" width="500" height="300" alt="イーブイの日">
     </div>


     <div class="sort">

     </div>


     <div class="main">
     <?php include 'poke_card.php'; ?>
     </div>


     <div class="cart">

     </div>


    <footer class="footer">
     <div class="footer_logo"><img src="./images/icon/index_footer-ball.gif" alt="ころころ"></div>
     <ul class="footer-menu">
       <li>login</li>
       <li>main</li>
       <li>(仮1)</li>
       <li>(仮2)</li>
     </ul>
     <div class="footer_copyright">（C）CRI.LTD. 2019</div>
    </footer> 
   </body>
  </html>
