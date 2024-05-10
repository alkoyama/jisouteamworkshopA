<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "teamworkshop_7thA";

// データベース接続
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ユニークなSIDを生成する関数
    function generateUniqueSID($conn) {
        $sql = "SELECT MAX(SID) FROM product_stock";
        $stmt = $conn->query($sql);
        $lastSID = $stmt->fetchColumn();
        if ($lastSID) {
            $lastNumber = (int)substr($lastSID, 1);
            return "S" . str_pad(++$lastNumber, 3, "0", STR_PAD_LEFT);
        } else {
            return "S001";
        }
    }

    // PIDを生成する関数
    function generateUniquePID($conn) {
        $sql = "SELECT MAX(PID) FROM poke_info";
        $stmt = $conn->query($sql);
        $lastPID = $stmt->fetchColumn();
        if ($lastPID) {
            $lastNumber = (int)substr($lastPID, 1);
            return "P" . str_pad(++$lastNumber, 3, "0", STR_PAD_LEFT);
        } else {
            return "P001";
        }
    }

    function generateUniqueGID($conn) {
        $sql = "SELECT MAX(GID) FROM poke_graphics";
        $stmt = $conn->query($sql);
        $lastGID = $stmt->fetchColumn();
        if ($lastGID) {
            $lastNumber = (int)substr($lastGID, 1);
            return "G" . str_pad(++$lastNumber, 3, "0", STR_PAD_LEFT);
        } else {
            return "G001";
        }
    }
        // フォーム表示の際にGIDを生成
        $newGID = generateUniqueGID($conn);
        $numericPartOfGID = (int)substr($newGID, 1); // GIDの数字部分

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $existingPID = $_POST['existingPID'] === 'null' ? null : $_POST['existingPID'];
            $productName = $_POST['product_name'];
            $gender = $_POST['gender'];
            $type1 = isset($_POST['type1']) ? $_POST['type1'] : null;
            $type2 = isset($_POST['type2']) && $_POST['type2'] !== "" ? $_POST['type2'] : null; // 空の場合は null
            $price = (int)$_POST['price'];
            $inventory = (int)$_POST['inventory'];

            // 新しいファイルパスを取得
            // $newImagePath = isset($_POST['newImagePath']) ? $_POST['newImagePath'] : null;
        
            $newSID = generateUniqueSID($conn);
        
            if ($existingPID) { // 既存のPIDがある場合
                $productStockSql = "INSERT INTO product_stock (SID, PID, Gender, Price, Inventory) 
                                    VALUES (:sid, :pid, :gender, :price, :inventory)";
                $productStockStmt = $conn->prepare($productStockSql);
                $productStockStmt->bindParam(':sid', $newSID);
                $productStockStmt->bindParam(':pid', $existingPID);
                $productStockStmt->bindParam(':gender', $gender);
                $productStockStmt->bindParam(':price', $price);
                $productStockStmt->bindParam(':inventory', $inventory);
                $productStockStmt->execute();
            } else { // 新しいPIDを作成
                $newPID = generateUniquePID($conn);
        
                // INSERT INTO poke_info
                $pokeInfoSql = "INSERT INTO poke_info (PID, Name, Type1, Type2, GID) 
                                VALUES (:pid, :name, :type1, :type2, :gid)";
                $pokeInfoStmt = $conn->prepare($pokeInfoSql);
                $pokeInfoStmt->bindParam(':pid', $newPID);
                $pokeInfoStmt->bindParam(':name', $productName);
                $pokeInfoStmt->bindParam(':type1', $type1);
                $pokeInfoStmt->bindParam(':type2', $type2);
                $pokeInfoStmt->bindParam(':gid', $newGID);
                $pokeInfoStmt->execute();

                if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == UPLOAD_ERR_OK) {
                    $image = $_FILES['product_image'];
                    $originalName = basename($image['name']); // オリジナルのファイル名
            
                    // 新しいファイル名のプレフィックス
                    $filePrefix = "pokemon_" . str_pad($numericPartOfGID, 3, "0", STR_PAD_LEFT) . "_";
        
                    // ファイル名に指定されたテキストを追加
                    if (!empty($_POST['file_name'])) {
                        $newFileName = $filePrefix . preg_replace("/[^a-zA-Z0-9_.-]/", "_", $_POST['file_name']); // 安全なファイル名
                    } else {
                        $newFileName = $filePrefix . $originalName;
                    }
            
                    $uploadDir = './images/pokemon/';
                    $imagePath = $uploadDir . $newFileName; // 新しい保存パス
                    
                    if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
                        throw new Exception("画像の保存に失敗しました");
                    }
                } else {
                    $imagePath = './images/pokemon/pokemon_000_preparation.jpg';
                }

                // INSERT INTO poke_graphics
                if ($imagePath) {
                    $pokeGraphicsSql = "INSERT INTO poke_graphics (GID, path) VALUES (:gid, :path)";
                    $pokeGraphicsStmt = $conn->prepare($pokeGraphicsSql);
                    $pokeGraphicsStmt->bindParam(':gid', $newGID);
                    $pokeGraphicsStmt->bindParam(':path', $imagePath);
                    $pokeGraphicsStmt->execute();
                }
        
                // INSERT INTO product_stock
                $productStockSql = "INSERT INTO product_stock (SID, PID, Gender, Price, Inventory) 
                                    VALUES (:sid, :pid, :gender, :price, :inventory)";
                $productStockStmt = $conn->prepare($productStockSql);
                $productStockStmt->bindParam(':sid', $newSID);
                $productStockStmt->bindParam(':pid', $newPID);
                $productStockStmt->bindParam(':gender', $gender);
                $productStockStmt->bindParam(':price', $price);
                $productStockStmt->bindParam(':inventory', $inventory);
                $productStockStmt->execute();
            }
        

            // 成功時のメッセージ
            echo "<script>alert('商品が正常に登録されました。');</script>";
            echo "<script>document.getElementsByTagName('form')[0].reset();</script>"; // フォームをリセット
            exit; // スクリプトを終了

        }
} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage(); // エラーメッセージ
} catch (Exception $e) {
    echo "エラー: " . $e->getMessage(); // その他のエラーメッセージ
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品登録ページ</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        // フォーム送信時の処理
        $('#product_form').on('submit', function(event) {
            event.preventDefault(); // デフォルトのフォーム送信を防止
            var formData = new FormData(this); // フォームデータのオブジェクト作成

            var productName = $('#product_name').val(); // 商品名
            var gender = $('#gender').val(); // 分類

            // iframeの中のpoke_card_register.phpのデータを取得
            var iframe = $('.right-panel iframe')[0].contentWindow; // iframeのウィンドウオブジェクト
            var pokemonData = iframe.pokemonData; // iframe内のデータ
            var isDuplicate = false; // 重複チェックフラグ

            // 重複チェック
            for (var i = 0; i < pokemonData.length; i++) {
                var pokemon = pokemonData[i];
                if (pokemon.Name === productName && pokemon.Gender === gender) {
                    isDuplicate = true; // 重複があればフラグを立てる
                    break; // ループを抜ける
                }
            }

            if (isDuplicate) {
                alert("同名同分類の重複登録は不可です。"); // 重複エラー
                return; // 登録を中断
            }

            // 重複がなければAJAXでデータを送信
            $.ajax({
                url: '', // 送信先は現在のページ
                method: 'POST', // POSTメソッドを使用
                data: formData, // フォームデータを送信
                contentType: false, // Content-Typeを自動的に設定
                processData: false, // データを処理しない
                success: function(response) {
                    // GIDの数値部分を取得して増加させる
                    var currentNumericPart = parseInt('<?= (int)substr($newGID, 1) ?>'); // 現在の数値部分
                    var newNumericPart = currentNumericPart + 1; // 1を加算

                    // 新しいプレフィックスを作成してラベルを更新
                    var newPrefix = "pokemon_" + newNumericPart.toString().padStart(3, '0') + "_"; // 3桁のゼロパッド
                    $('#file_name_label').html("保存されるファイル名<br>./images/pokemon/" + newPrefix + ""); // 改行を含むテキストでラベルを更新
                    alert('商品が正常に登録されました。'); // 成功メッセージ

                    $('#product_form')[0].reset(); // フォームをリセット
                    $('#file_name_label, #file_name_input, #image_preview_container').hide(); // 非表示
                    $('#image_preview').attr('src', ""); // 画像プレビューをクリア

                    // 隠しフィールドもリセット
                    $('#existingPID').val(""); // 隠しフィールドのリセット

                    // iframeの更新
                    $('.right-panel iframe').attr('src', 'poke_card_register.php'); // iframeを再読み込み
                },
                error: function(xhr, status, error) { // エラー時の処理
                    alert('登録中にエラーが発生しました: ' + error); // エラーメッセージ表示
                }
            });
        });

        // 商品画像選択時の処理
        $('#product_image').change(function() {
            // PIDをリセット
            $('#existingPID').val(""); // 隠しフィールドのリセット
            
            var fileInput = $(this);
            var file = fileInput[0].files[0]; // 選択されたファイル
            var fileName = fileInput.val().split('\\').pop(); // ファイル名を取得

            if (fileName && file) {
                $('#file_name_label, #file_name_input').show(); // ラベルと入力フィールドを表示
                $('#file_name_input').val(fileName); // ファイル名を入力フィールドに設定

                // プレビューの表示と画像の設定
                $('#image_preview_container').show(); 
                if (file.type.startsWith('image/')) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#image_preview').attr('src', e.target.result); // プレビューを更新
                    };
                    reader.readAsDataURL(file); // 画像のデータURLを読み込む
                }

                // 新しいファイルパスを生成
                // var newFileName = "pokemon_" + fileName; // ファイル名プレフィックス
                // var uploadDir = "./images/pokemon/"; // アップロード先のディレクトリ
                // var newImagePath = uploadDir + newFileName; // 新しい保存パス

                $('#imagePath').val(newImagePath); // 修正: 隠しフィールドに保存パスを設定
            } else {
                $('#file_name_label, #file_name_input, #image_preview_container').hide(); // 非表示
            }
        });

        // 画像取り消しボタンの処理
        $('#cancel_image').click(function() {
            $('#product_image').val(""); // ファイル選択をリセット
            $('#file_name_input').val(""); // ファイル名フィールドをリセット
            $('#file_name_label, #file_name_input, #image_preview_container').hide(); // プレビューを非表示
            $('#image_preview').attr('src', ""); // プレビュー画像をリセット
            // 隠しフィールドのリセット
            $('#existingPID').val(""); 
        });
    });
    </script>
    <style>
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
        .split-container {
            display: flex; /* フレックスボックスを有効化 */
            height: 100vh; /* ビューポートの高さに合わせる */
        }
        
        .left-panel {
            flex: 1; /* 左側を広く */
            padding: 20px; /* パディング */
            border-right: 2px solid #ccc; /* 区切り線 */
        }
        
        .right-panel {
            flex: 2; /* 右側も同じ比率 */
            padding: 20px; /* パディング */
        }

        /* iframeのスタイル */
        iframe {
            width: 100%; /* 幅を全体に合わせる */
            height: 100%; /* 高さを全体に合わせる */
            border: none; /* ボーダーを表示しない */
        }
    </style>
</head>
<body>

<div class="split-container">
    <!-- 左側のパネル -->
    <div class="left-panel">
        <h1>商品登録ページ</h1>
        <p>※カードのラジオボタンをチェックすると情報を引用できます。</p>
        <p>　なお、同名同分類の重複登録は不可です。</p><br>
        <form id="product_form" method="post" enctype="multipart/form-data">
            <label for="product_name">商品名:</label>
            <input type="text" id="product_name" name="product_name" required><br><br>

            <label for="gender">分類:</label>
            <select id="gender" name="gender" required>
                <option value="male">♂ポケモン</option>
                <option value="female">♀ポケモン</option>
                <option value="unknown">せいべつふめいポケモン</option>
                <option value="egg">タマゴ</option>
                <option value="item">どうぐ</option>
                <option value="ball">ボール</option>
            </select><br><br>

            <div id="type1">
                <label for="type1-select">タイプ1:</label>
                <select id="type1-select" name="type1">
                    <option value="T01NML">ノーマル</option>
                    <option value="T02HNO">ほのお</option>
                    <option value="T03MIZ">みず</option>
                    <option value="T04DNK">でんき</option>
                    <option value="T05KUS">くさ</option>
                    <option value="T06KOR">こおり</option>
                    <option value="T07KKT">かくとう</option>
                    <option value="T08DOK">どく</option>
                    <option value="T09ZMN">じめん</option>
                    <option value="T10HKU">ひこう</option>
                    <option value="T11ESP">エスパー</option>
                    <option value="T12MUS">むし</option>
                    <option value="T13IWA">いわ</option>
                    <option value="T14GST">ゴースト</option>
                    <option value="T15DGN">ドラゴン</option>
                    <option value="T16AKU">あく</option>
                    <option value="T17HGN">はがね</option>
                    <option value="T18FRY">フェアリー</option>
                </select><br><br>
            </div>

            <div id="type2">
                <label for="type2-select">タイプ2:</label>
                <select id="type2-select" name="type2">
                    <option value="">なし(null)</option>
                    <option value="T01NML">ノーマル</option>
                    <option value="T02HNO">ほのお</option>
                    <option value="T03MIZ">みず</option>
                    <option value="T04DNK">でんき</option>
                    <option value="T05KUS">くさ</option>
                    <option value="T06KOR">こおり</option>
                    <option value="T07KKT">かくとう</option>
                    <option value="T08DOK">どく</option>
                    <option value="T09ZMN">じめん</option>
                    <option value="T10HKU">ひこう</option>
                    <option value="T11ESP">エスパー</option>
                    <option value="T12MUS">むし</option>
                    <option value="T13IWA">いわ</option>
                    <option value="T14GST">ゴースト</option>
                    <option value="T15DGN">ドラゴン</option>
                    <option value="T16AKU">あく</option>
                    <option value="T17HGN">はがね</option>
                    <option value="T18FRY">フェアリー</option>
                </select><br><br>
            </div>

            <label for="price">価格:</label>
            <input type="number" id="price" name="price" required><br><br>
            
            <label for="inventory">在庫数:</label>
            <input type="number" id="inventory" name="inventory" required><br><br>

            <label for="product_image">商品画像:</label>
            <input type="file" id="product_image" accept="image/*" name="product_image"><br><br>

            <div id="image_preview_container">
                <label for="image_preview">画像プレビュー:</label><br>
                <img id="image_preview" src="" style="max-width: 200px; max-height: 200px;"><br>
                <button id="cancel_image" type="button">画像取消</button> <!-- 取消ボタン -->
            </div><br>

            <label id="file_name_label" for="file_name">登録されるファイル名<br>
            ./images/pokemon/pokemon_<?= str_pad($numericPartOfGID, 3, "0", STR_PAD_LEFT) ?>_</label>
            <input id="file_name_input" type="text" name="file_name"><br><br>

            <button type="submit" class="styled-button">登録</button> <!-- 登録ボタン -->

            <!-- 隠しフィールド -->
            <input type="hidden" id="existingPID" name="existingPID" value="">
        </form>
    </div>

    <!-- 右側のパネル（iframeでpoke_card_register.phpを表示） -->
    <div class="right-panel">
        <iframe src="poke_card_register.php"></iframe> <!-- iframeでpoke_card_register.phpを表示 -->
    </div>
</div>

</body>
    <script>
    // 初期状態では非表示
    $('#file_name_label, #file_name_input, #image_preview_container').hide();
            // ジェンダーに基づくタイプ1, タイプ2の表示/非表示
            $('#gender').change(function() {
            var gender = $(this).val();
            if (gender == 'egg' || gender == 'item' || gender == 'ball') {
                $('#type1, #type2').hide();
                $('#type1-select, #type2-select').val(null);
            } else {
                $('#type1, #type2').show();
            }
        });
    </script>
</html>