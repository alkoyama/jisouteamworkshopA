<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理画面</title>
    <style>
        body {
            font-family: "Tanuki Magic", cursive;
            background-image: url(./images/background/index_background.png);
            margin-top: 5%;
        }

        .title{
            position: relative;
            text-align: center;
            right: 30px;
            bottom: 30px;
        }
        .title img {
            width: 300px;
        }
        .title h1 {
            position: absolute;
            top: 50%;
            left: 50%;
            -ms-transform: translate(-50%,-50%);/*ベンダープレフィックス*/
            -webkit-transform: translate(-50%,-50%);/*ベンダープレフィックス*/
            transform: translate(-50%,-50%);/*センター寄せの修正*/
            color: #000000;
            margin: 10px 0 0 !important;/*文字がずれている場合や*/
            padding: 0!important;/*文字が折り返される場合*/
        }
        
        .select ul {
            width: fit-content;
	        margin: auto;
	        padding: 0;
	        font-size: 100%;
	        list-style: none;
        }
        .select ul li {
            padding-bottom: 25px;
        	padding-left: 35px;
	        line-height: 2.5em;
	        background: left top no-repeat;
	        background-size: 40px auto;
            -webkit-transition: all 0.5s ease-out;
            transition: all 0.5s ease-out;
        }
        .select ul li:nth-child(1) {
	        background-image: url(./images/integration/integration_icon_001_pippi.png);
        }
        .select ul li:nth-child(2) {
	        background-image: url(./images/integration/integration_icon_002_purin.png);
        }
        .select ul li:nth-child(3) {
	        background-image: url(./images/integration/integration_icon_003_yadon.png)
        }
        .select ul li a{
            position: relative;
            text-decoration: none;
            color: black;
            padding: 0.5em;
            font-size: x-large;
            font-weight:bold
        }
        .select ul li a::after  {
            position: absolute;
            content: "";
            display: block;
            height: 4px;
            background-color: #ff67cc;
            bottom: 2px;
            left: 0;
            width: 0;
            -webkit-transition: all 0.5s ease;
            transition: all 0.5s ease;
        }
        .select ul li a:hover::after {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="title">
      <img src="./images/integration/integration_h1-bg.png" alt="">    
      <h1>管理画面</h1>
    </div>
    <div class="select">
      <ul>
        <li><a href="./order_7thA.php">受注管理</a></li>
        <li><a href="./product_register_7thA.php">商品登録ページ</a></li>
        <li><a href="./stock_management_7thA.php">商品在庫管理</a></li>
      </ul>
    </div>
    
</body>
</html>
