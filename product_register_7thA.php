<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "teamworkshop_7thA";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 関数定義: SID, PID, GID生成関数
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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $productName = $_POST['product_name'];
        $gender = $_POST['gender'];
        $type1 = isset($_POST['type1']) ? $_POST['type1'] : null;
        $type2 = isset($_POST['type2']) ? $_POST['type2'] : null;
        $price = (int)$_POST['price'];
        $inventory = (int)$_POST['inventory'];

        if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == UPLOAD_ERR_OK) {
            $image = $_FILES['product_image'];
            $uploadDir = './images/';
            $imagePath = $uploadDir . basename($image['name']);
            if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
                throw new Exception("画像の保存に失敗しました");
            }
        } else {
            $imagePath = null;
        }

        $newSID = generateUniqueSID($conn);
        $newPID = generateUniquePID($conn);
        $newGID = generateUniqueGID($conn);

        // poke_infoへのデータ挿入
        $pokeInfoSql = "INSERT INTO poke_info (PID, Name, Type1, Type2, GID) VALUES (:pid, :name, :type1, :type2, :gid)";
        $pokeInfoStmt = $conn->prepare($pokeInfoSql);
        $pokeInfoStmt->bindParam(':pid', $newPID);
        $pokeInfoStmt->bindParam(':name', $productName);
        $pokeInfoStmt->bindParam(':type1', $type1);
        $pokeInfoStmt->bindParam(':type2', $type2);
        $pokeInfoStmt->bindParam(':gid', $newGID);
        $pokeInfoStmt->execute();

        if ($imagePath) {
            $pokeGraphicsSql = "INSERT INTO poke_graphics (GID, path) VALUES (:gid, :path)";
            $pokeGraphicsStmt = $conn->prepare($pokeGraphicsSql);
            $pokeGraphicsStmt->bindParam(':gid', $newGID);
            $pokeGraphicsStmt->bindParam(':path', $imagePath);
            $pokeGraphicsStmt->execute();
        }

        // product_stockへのデータ挿入
        $productStockSql = "INSERT INTO product_stock (SID, PID, Gender, Price, Inventory) VALUES (:sid, :pid, :gender, :price, :inventory)";
        $productStockStmt = $conn->prepare($productStockSql);
        $productStockStmt->bindParam(':sid', $newSID);
        $productStockStmt->bindParam(':pid', $newPID);
        $productStockStmt->bindParam(':gender', $gender);
        $productStockStmt->bindParam(':price', $price);
        $productStockStmt->bindParam(':inventory', $inventory);
        $productStockStmt->execute();

        // フィールドをリセットして登録完了を通知
        echo "<script>alert('商品が正常に登録されました。');</script>";
        echo "<script>document.getElementsByTagName('form')[0].reset();</script>";
        exit;
    }
} catch (PDOException $e) {
    echo "エラー: " . $e->getMessage();
} catch (Exception $e) {
    echo "エラー: " . $e->getMessage();
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
        $('#gender').change(function() {
            var gender = $(this).val();
            if (gender == 'egg' || gender == 'item' || gender == 'ball') {
                $('#type1, #type2').hide();
                $('#type1-select, #type2-select').val(null);
            } else {
                $('#type1, #type2').show();
            }
        });

        // ページがロードされたときの初期状態
        var initialGender = $('#gender').val();
        if (initialGender == 'egg' || initialGender == 'item' || initialGender == 'ball') {
            $('#type1, #type2').hide();
        }
    });
    </script>
    <style>
        .styled-button {
            background-color: #4CAF50; /* グリーン */
            color: white; /* 文字は白色 */
            padding: 15px 32px; /* パディング */
            text-align: center; /* テキストの配置 */
            text-decoration: none; /* テキスト装飾なし */
            display: inline-block; /* インラインブロック */
            font-size: 16px; /* フォントサイズ */
            margin: 4px 2px; /* マージン */
            cursor: pointer; /* マウスカーソル */
            border-radius: 12px; /* ボーダーの丸み */
            border: none; /* ボーダーを削除 */
            transition: 0.3s; /* トランジション */
        }

        .styled-button:hover {
            background-color: #45a049; /* ホバー時の色 */
        }
    </style>
</head>
<body>

<h1>商品登録ページ</h1>
<form method="post" action="" enctype="multipart/form-data">
    <label for="product_name">商品名:</label>
    <input type="text" id="product_name" name="product_name" required><br><br>

    <label for="gender">ジェンダー:</label>
    <select id="gender" name="gender" required>
        <option value="male">♂</option>
        <option value="female">♀</option>
        <option value="unknown">せいべつふめい</option>
        <option value="egg">タマゴ</option>
        <option value="item">どうぐ</option>
        <option value="ball">ボール</option>
    </select><br><br>

    <div id="type1">
        <label for="type1-select">タイプ1:</label>
        <select id="type1-select" name="type1">
            <option value="T01NML">ノーマル</option>
            <option value="T02HNO">ほのお</option>
            <!-- 他のオプション -->
        </select><br><br>
    </div>

    <div id="type2">
        <label for="type2-select">タイプ2:</label>
        <select id="type2-select" name="type2">
            <option value="T01NML">ノーマル</option>
            <option value="T02HNO">ほのお</option>
            <!-- 他のオプション -->
        </select><br><br>
    </div>

    <label for="price">価格:</label>
    <input type="number" id="price" name="price" required><br><br>
    
    <label for="inventory">在庫数:</label>
    <input type="number" id="inventory" name="inventory" required><br><br>

    <label for="product_image">商品画像:</label>
    <input type="file" accept="image/*" name="product_image"><br><br>
    
    <!-- グラフィカルな登録ボタン -->
    <button type="submit" class="styled-button">登録</button>
</form>

</body>
</html>
