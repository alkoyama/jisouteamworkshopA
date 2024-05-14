<?php
// データベース接続情報
$dsn = 'mysql:host=localhost;dbname=teamworkshop_7thA';
$username = 'root';
$password = '';

try {
    // PDOインスタンスを作成
    $pdo = new PDO($dsn, $username, $password);

    // エラーモードを例外モードに設定
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL文の作成
    $sql = 'SELECT 
                product_stock.SID,
                product_stock.PID,
                poke_info.Name,
                poke_type1.type_name AS Type1,
                poke_type2.type_name AS Type2,
                product_stock.Price,
                product_stock.Inventory,
                poke_graphics.path AS Image_path
            FROM 
                product_stock
            JOIN 
                poke_info ON product_stock.PID = poke_info.PID
            LEFT JOIN 
                poke_graphics ON poke_info.GID = poke_graphics.GID
            LEFT JOIN 
                poke_type AS poke_type1 ON poke_type1.TID = poke_info.Type1
            LEFT JOIN 
                poke_type AS poke_type2 ON poke_type2.TID = poke_info.Type2
            WHERE 
                product_stock.Gender IN ("male", "female", "unknown")
            ORDER BY 
                RAND()
            LIMIT 
                1';

    // SQLを実行して結果を取得
    $stmt = $pdo->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // ポケモン情報を取得
    $name = $row['Name'];
    $type1 = $row['Type1'];
    $type2 = $row['Type2'];
    $price = $row['Price'];
    $inventory = $row['Inventory'];
    $image_path = $row['Image_path'];

    // ポケモンカードのHTMLを作成
    $enemyPokemonCardHTML = '
        <div class="enemy-pokemon-card" style="display: flex; flex-direction: row-reverse; position: absolute; top: 20px; background-color: rgba(255, 255, 255, .7); padding: 20px; border-radius: 10px;">
            <img class="pokemon-image" src="'.$image_path.'" alt="'.$name.'">
            <div class="pokemon-details" style="margin-right: 50px;">
                <p><strong>'.$name.'</strong></p>
                <p><strong>Type1:</strong> '.$type1.'</p>
                <p><strong>Type2:</strong> '.$type2.'</p>
                <p><strong>ねだん:</strong> '.$price.'</p>
                <p><strong>在庫:</strong> <span>'.$inventory.'</span></p>
            </div>
        </div>
    ';

    // ポケモンカードを表示
    // echo $pokemonCardHTML;
} catch (PDOException $e) {
    // エラーハンドリング
    echo 'Error: '.$e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>バトルスタジアム</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://rawgit.com/RickStrahl/jquery-resizable/master/src/jquery-resizable.js"></script>
    <script>
        $(document).ready(function() {
            $("#column1").resizable({
                handleSelector: "#splitter1",
                resizeHeight: false,
            });
        });
        // 子ドキュメントからポケモンカードを受け取り、左側パネルに表示
        function receivePokemonCard(pokemonCardHTML) {
            $('#column1').append(pokemonCardHTML);
        }

        // iframe内の子ドキュメントからのメッセージを受け取る
        window.addEventListener('message', function(event) {
            // メッセージがポケモンカードのHTMLであることを確認
            if (event.data && event.data.pokemonCardHTML) {
                // ポケモンカードを左側パネルに表示
                receivePokemonCard(event.data.pokemonCardHTML);
            }
        }, false);
        // バトル開始ボタンがクリックされたときの処理
        $(document).on('click', '#battleButton', function() {
            // サイコロの目をランダムに決定
            var enemyDiceRoll = Math.floor(Math.random() * 6) + 1;
            var playerDiceRoll = Math.floor(Math.random() * 6) + 1;

            // バトルの結果を表示
            var battleResult = '引き分け';
            if (enemyDiceRoll > playerDiceRoll) {
                battleResult = '敵の勝利！';
            } else if (enemyDiceRoll < playerDiceRoll) {
                battleResult = 'プレイヤーの勝利！';
            }
            alert('敵のサイコロ: ' + enemyDiceRoll + '\nプレイヤーのサイコロ: ' + playerDiceRoll + '\n' + battleResult);
            console.log('あ');
        });
        
    </script>
    <style>
        body {
            height: 100%;
        }
        .styled-button {
            background-color: #4CAF50;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 12px;
            border: none;
            transition: 0.3s;
        }

        .styled-button:hover {
            background-color: #45a049;
        }
        /* Flexboxを使って画面を左右に分割 */
        .horizontal {
            display: flex;
            flex-direction: row;
            flex-wrap: nowrap;
            height: 97vh;
            justify-content: center;
        }

        .left-panel {
            background-image: url(./images/background/battle_stadium.jpg);
            background-size: cover;
            flex: 0 1 auto;
            min-width: 30%;
            display: flex; /* Use flexbox */
            flex-direction: column; /* Stack items vertically */
            align-items: center; /* Center-align items horizontally */
        }

        .right-panel {
            flex: 1 1 auto;
            min-width: 28%;
        }

        .splitter {
            flex: 0 0 auto;
            width: 10px;
            background: url(https://raw.githubusercontent.com/RickStrahl/jquery-resizable/master/assets/vsizegrip.png) center center no-repeat #c1d0ea;
            cursor: col-resize;
        }

        /* iframeのスタイル */
        iframe {
            width: 100%; /* 幅を全体に合わせる */
            height: 100%; /* 高さを全体に合わせる */
            border: none; /* ボーダーを表示しない */
        }
        #column1 {
            position: relative;
        }

        #battle-button {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
</head>
    <body>

        <div class="horizontal">
            <!-- 左側のパネル -->
            <div id="column1" class="left-panel">
                <?php echo $enemyPokemonCardHTML; ?>
            </div>
            <div class="splitter" id="splitter1"></div>
            <!-- 右側のパネル（iframeでpoke_card_register.phpを表示） -->
            <div id="column2" class="right-panel">
                <iframe src="poke_card_battle.php"></iframe> <!-- iframeでpoke_card_register.phpを表示 -->
            </div>
        </div>

    </body>
</html>