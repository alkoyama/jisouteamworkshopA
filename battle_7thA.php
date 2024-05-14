<?php
session_start(); // セッションを開始

// セッションからCIDを取得してテキストで表示
if (isset($_SESSION['CID'])) {
    $cid = $_SESSION['CID']; // 現在のCIDを取得
    // データベース接続情報
    $servername = "localhost";
    $username = "root"; // データベースのユーザー名
    $password = ""; // データベースのパスワード
    $dbname = "teamworkshop_7tha"; // データベース名

    try {
        // データベースに接続
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // クエリの準備
        $query = "SELECT Name FROM customer_management WHERE CID = :cid";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':cid', $cid);
        $stmt->execute();

        // 結果を取得
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            $name = $result['Name'];
        } else {
        }
    } catch (PDOException $e) {
        echo "データベースエラー: " . $e->getMessage();
    }
} else {
    // セッションにCIDが設定されていない場合の処理
    echo "<script>alert('バトルスタジアムは会員専用サービスです。ログイン後にご利用下さい。'); window.location.href='index_7thA.php';</script>";
}
?>

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

    // HPをランダムな値に設定
    $hp = rand(100, 150);

    // ポケモンカードのHTMLを作成
    // $enemyPokemonCardHTML = '
    //     <div class="enemy-pokemon-card" style="display: flex; flex-direction: row-reverse; position: absolute; top: 20px; background-color: rgba(255, 255, 255, .7); padding: 20px; border-radius: 10px;">
    //         <img class="pokemon-image" src="'.$image_path.'" alt="'.$name.'">
    //         <div class="pokemon-details" style="margin-right: 50px;">
    //             <p><strong>'.$name.'</strong></p>
    //             <p><strong>タイプ1:</strong> '.$type1.'</p>
    //             <p><strong>タイプ2:</strong> '.$type2.'</p>
    //             <p><strong>ねだん:</strong> '.$price.'</p>
    //             <p><strong>在庫:</strong> <span>'.$inventory.'</span></p>
    //         </div>
    //     </div>
    // ';
    $enemyPokemonCardHTML = '
        <div class="enemy-pokemon-card" style="display: flex; flex-direction: row-reverse; position: absolute; top: 20px; background-color: rgba(255, 255, 255, .7); padding: 20px; border-radius: 10px;">
            <img class="pokemon-image" src="'.$image_path.'" alt="'.$name.'">
            <div class="pokemon-details" style="margin-right: 50px;">
                <p><strong>'.$name.'</strong></p>
                <p><strong>タイプ1:</strong> '.$type1.'</p>';
    if ($type2) {
        $enemyPokemonCardHTML .= '<p><strong>タイプ2:</strong> '.$type2.'</p>';
    }
    $enemyPokemonCardHTML .= '<p><strong>HP:</strong> <span>'.$hp.'</span></p>
            </div>
        </div>
    ';

    $pokemon2name = $row['Name'];

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



        $(document).on('click', '#battleButton', function() {
    // 勝利と敗北のオーバーレイを削除
    $('.win-overlay, .draw-overlay').remove();

    // バトルボタンを非表示にし、ラジオボタンを無効化
    $('#battleButton').addClass('hidden');
    $('iframe').contents().find('input[type="radio"]').prop('disabled', true);

    // ポケモンのアニメーション設定
    $('.pokemon-card').removeClass('loser').addClass('winner');
    $('.enemy-pokemon-card').removeClass('loser').addClass('winner');

    // ランダムな座標でシェイクを実行
    var shakeInterval = setInterval(function() {
        $('.enemy-pokemon-card').addClass('shake');
        $('.pokemon-card').addClass('shake');
        setTimeout(function() {
            $('.enemy-pokemon-card').removeClass('shake');
            $('.pokemon-card').removeClass('shake');
        }, 500); // シェイクアニメーションの時間
    }, Math.random() * 2000 + 1000); // シェイクの間隔をランダムに設定

    var pokemon1name = $('#selectedPokemonName', window.parent.document).val();
    var pokemon1HP = 100;
    var pokemon2HP = <?php echo $hp; ?>;
    var turn = 1;
    var battleLog = 'バトルスタート！<br>';
    $('#battleLog').html(battleLog);
    battleLog += '(<span style="color: blue;">' + pokemon1name + '</span>の残りHP: ' + pokemon1HP + ', 相手<span style="color: red;"><?php echo $pokemon2name; ?></span>の残りHP: ' + pokemon2HP + ')<br>';
    $('#battleLog').html(battleLog);
    var battleInterval = setInterval(function() {
        battleLog += '<br>【' + turn + 'ターン目】<br>';
        var pokemon1Evades = Math.random() < 0.2;
        if (pokemon1Evades && Math.random() >= 0.5) {
            battleLog += '相手<?php echo $pokemon2name; ?>が' + pokemon1name + 'の攻撃を避けた！<br>';
        } else {
            var pokemon1Attack = Math.floor(Math.random() * 20) + 1;
            if (pokemon1Evades && Math.random() < 0.5) {
                pokemon1Attack *= 2;
                if (pokemon1Attack <= 30) pokemon1Attack = 40;
                battleLog += '急所に当たった！ ' + pokemon1name + 'の急所攻撃: ' + pokemon1Attack + '<br>';
                pokemon2HP -= pokemon1Attack;
            } else {
                pokemon2HP -= pokemon1Attack;
                battleLog += '' + pokemon1name + 'の攻撃: ' + pokemon1Attack + '<br>';
            }
        }

        var pokemon2Evades = Math.random() < 0.2;
        if (pokemon2Evades && Math.random() >= 0.5) {
            battleLog += '' + pokemon1name + 'が相手<?php echo $pokemon2name; ?>の攻撃を避けた！<br>';
        } else {
            var pokemon2Attack = Math.floor(Math.random() * 20) + 1;
            if (pokemon2Evades && Math.random() < 0.5) {
                pokemon2Attack *= 2;
                if (pokemon2Attack <= 30) pokemon2Attack = 40;
                battleLog += '急所に当たった！ 相手<?php echo $pokemon2name; ?>の急所攻撃: ' + pokemon2Attack + '<br>';
                pokemon1HP -= pokemon2Attack;
            } else {
                pokemon1HP -= pokemon2Attack;
                battleLog += '相手<?php echo $pokemon2name; ?>の攻撃: ' + pokemon2Attack + '<br>';
            }
        }

        pokemon1HP = Math.max(pokemon1HP, 0);
        pokemon2HP = Math.max(pokemon2HP, 0);

        battleLog += '(<span style="color: blue;">' + pokemon1name + '</span>の残りHP: ' + pokemon1HP + ', 相手<span style="color: red;"><?php echo $pokemon2name; ?></span>の残りHP: ' + pokemon2HP + ')<br>';

        $('#battleLog').html(battleLog);

        if (pokemon1HP <= 0 || pokemon2HP <= 0) {
            clearInterval(battleInterval);
            clearInterval(shakeInterval);
            if (pokemon1HP <= 0 && pokemon2HP <= 0) {
                battleLog += '<br>引き分け！<br>';
                $('.pokemon-card').append('<div class="draw-overlay"></div>');
                $('.enemy-pokemon-card').append('<div class="draw-overlay"></div>');
            } else if (pokemon1HP <= 0) {
                battleLog += '<br>相手<span style="color: red;"><?php echo $pokemon2name; ?></span>の勝利！<br>';
                $('.pokemon-card').removeClass('winner').addClass('loser');
                $('.enemy-pokemon-card').append('<div class="win-overlay"></div>');
            } else {
                battleLog += '<br><span style="color: blue;">' + pokemon1name + '</span>の勝利！<br>';
                $('.enemy-pokemon-card').removeClass('winner').addClass('loser');
                $('.pokemon-card').append('<div class="win-overlay"></div>');
            }
            $('#battleLog').html(battleLog);
            $('#battleButton').removeClass('hidden');
            $('iframe').contents().find('input[type="radio"]').prop('disabled', false);
        }

        turn++;
    }, 1000);
});




    
</script>
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
            min-width: 20%;
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

        @keyframes shake {
            0% { transform: translate(-100px, 0); }
            25% { transform: translate(150px, 200px); }
            50% { transform: translate(100px, -100px); }
            75% { transform: translate(50px, 100px); }
            100% { transform: translate(0, 0); }
        }

        .enemy-pokemon-card.shake {
            animation: shake 0.5s ease;
        }

        .pokemon-card.shake {
            animation: shake 0.3s ease;
        }

        .pokemon-card,
        .enemy-pokemon-card {
            transform-origin: bottom; /* 下端を軸に */
            position: relative;
        }

        .win-overlay, .draw-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0);
        width: 100px; /* 適切なサイズに調整してください */
        height: 100px; /* 適切なサイズに調整してください */
        background-size: contain;
        background-repeat: no-repeat;
        z-index: 10;
        }

        .win-overlay {
            background-image: url('./images/assets/battle_win.png'); /* 画像パスを適切に変更してください */
            animation: expandWin 1s infinite alternate; /* アニメーションを無限ループで繰り返す */
        }

        .draw-overlay {
            background-image: url('./images/assets/battle_draw.png'); /* 画像パスを適切に変更してください */
            animation: expandWin 3s infinite alternate; /* アニメーションを無限ループで繰り返す */
        }

        @keyframes expandWin {
            0% {
                transform: translate(-50%, -50%) scale(2);
            }
            100% {
                transform: translate(-50%, -50%) scale(5);
            }
        }

        .loser {
            transform: rotateX(90deg);
            transition: transform 1s ease-in-out;
        }

        .winner {
            transform: rotateX(0deg);
            transition: transform 1s ease-in-out;
        }

        #battleButton {
            display: block; /* デフォルトは表示 */
        }

        #battleButton.hidden {
            display: none; /* 非表示にする */
        }
    </style>
</head>
    <body>

        <div class="horizontal">
            <!-- 左側のパネル -->
            <div id="column1" class="left-panel">
                <?php echo $enemyPokemonCardHTML; ?>
                <div id="battleLog" style="position: fixed; left: 10px; border: 1px solid black; padding: 10px; margin: 10px 0; background-color: white; max-height: 800px; overflow-y: auto; z-index: 100;"></div>
            </div>
            <div class="splitter" id="splitter1"></div>
            <!-- 右側のパネル（iframeでpoke_card_register.phpを表示） -->
            <div id="column2" class="right-panel">
                <iframe src="poke_card_battle.php"></iframe> <!-- iframeでpoke_card_register.phpを表示 -->
            </div>
            <input type="hidden" id="selectedPokemonName" name="selectedPokemonName">
        </div>
    </body>
</html>