<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理画面</title>
    <style>
        body {
            font-family: "Tanuki Magic", cursive;
            
            margin-left: 40%;
            margin-top: 5%;
        }
        h1 {
            margin-bottom: 70px;
        }

        h2 {
            color: #505050;
            padding: 0.5em 2em; /* 左右に余白を追加 */
            display: inline-block;
            line-height: 1.3;
            background: #dbebf8;
            border-radius: 25px 0px 0px 25px;
            vertical-align: middle;
            text-align: left; /* テキストを左揃えにする */
        }

        h2:before {
            content: '●';
            color: white;
            margin-right: 8px;
            vertical-align: middle;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            margin-bottom: 10px;
        }

        ul li a {
            text-decoration: none;
            color: black;
        }

        ul li a p {
            margin: 0;
            padding: 10px;
            background-color: #f0f0f0;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>    管理画面</h1>
    <ul>
        <li><a href="./order_7thA.php"><h2>受注管理</h2></a></li>
        <li><a href="./product_register_7thA.php"><h2>商品登録ページ</h2></a></li>
        <li><a href="./stock_management_7thA.php"><h2>商品在庫管理</h2></a></li>
    </ul>

    
</body>
</html>
