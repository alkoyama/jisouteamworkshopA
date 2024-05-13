<?php
    session_start();

    // カートデータ
    $cartData = json_decode($_POST['cartData'], true);

    // カートデータをセッションに保存
    $_SESSION['cartItems'] = $cartData;
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>注文確認</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>注文最終確認</h1>
        <br>
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 顧客情報
            $cid = htmlspecialchars($_POST['cid']);
            $name = htmlspecialchars($_POST['name']);
            $address = htmlspecialchars($_POST['address']);
            $phone = htmlspecialchars($_POST['phone']);
            $cardInfo = htmlspecialchars($_POST['card_info']);

            // カートデータ
            $cartData = json_decode($_POST['cartData'], true);

            // 顧客情報の表示
            echo "<h2>お客様情報</h2>";
            echo "<p><strong>CID:</strong> $cid</p>";
            echo "<p><strong>名前:</strong> $name</p>";
            echo "<p><strong>住所:</strong> $address</p>";
            echo "<p><strong>電話番号:</strong> $phone</p>";
            echo "<p><strong>カード情報:</strong> $cardInfo</p>";

            // カート内容の表示
            if (!empty($cartData)) {
                echo '<table class="table table-striped">';
                echo '<thead><tr><th>商品ID</th><th>名前</th><th>注文個数</th><th>価格</th><th>小計</th></tr></thead>';
                echo '<tbody>';

                $grandTotal = 0;

                foreach ($cartData as $item) {
                    $sid = htmlspecialchars($item['sid']);
                    $itemName = htmlspecialchars($item['name']);
                    $quantity = (int)$item['quantity'];
                    $price = (int)$item['price'];
                    $subtotal = $quantity * $price;

                    echo '<tr>';
                    echo "<td>$sid</td>";
                    echo "<td>$itemName</td>";
                    echo "<td>$quantity</td>";
                    echo "<td>¥$price</td>";
                    echo "<td>¥$subtotal</td>";
                    echo '</tr>';

                    $grandTotal += $subtotal;
                }

                echo '</tbody>';
                echo '</table>';

                echo "<h3>合計金額: ¥$grandTotal</h3>";
            } else {
                echo "<p>カートに商品がありません。</p>";
            }
        } else {
            echo "<p>POSTデータが見つかりません。</p>";
        }
        ?>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_order'])) {
            try {
                // データベース接続設定
                $conn = new PDO("mysql:host=localhost;dbname=teamworkshop_7thA", "root", "");
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // 顧客情報
                $cid = htmlspecialchars($_POST['cid']);
                $name = htmlspecialchars($_POST['name']);
                $address = htmlspecialchars($_POST['address']);
                $phone = (string)$_POST['phone']; // 数値の場合、文字列にキャスト
                $cardInfo = (string)$_POST['card_info']; // 同様に文字列にキャスト
                $cartData = json_decode($_POST['cartData'], true);

                if (empty($cartData)) {
                    echo "<p>カートに商品がありません。</p>";
                    return;
                }

                // 在庫チェック
                foreach ($cartData as $item) {
                    $sid = htmlspecialchars($item['sid']);
                    $quantity = (int) $item['quantity'];

                    // 商品の在庫数を取得
                    $sql = "SELECT Inventory FROM product_stock WHERE SID = :sid";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':sid', $sid);
                    $stmt->execute();
                    $inventory = (int) $stmt->fetchColumn();  // 在庫数を取得

                    if ($inventory < $quantity) {
                        echo "<script>
                            alert('注文途中で在庫数が変動した可能性があります。\n決済情報ページに戻ります。');
                            window.location.href = 'payment_7thA.php';  // payment_7thA.phpへリダイレクト
                        </script>";
                        return;  // 処理を中断
                    }
                }

                // 在庫が足りている場合は在庫を減算
                foreach ($cartData as $item) {
                    $sid = htmlspecialchars($item['sid']);
                    $quantity = (int) $item['quantity'];

                    // 在庫を減算
                    $sql = "UPDATE product_stock SET Inventory = Inventory - :quantity WHERE SID = :sid";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':quantity', $quantity);
                    $stmt->bindParam(':sid', $sid);
                    $stmt->execute();
                }

                // OID生成関数
                function generateUniqueOID($conn) {
                    $sql = "SELECT OID FROM order_management ORDER BY OID DESC LIMIT 1";
                    $stmt = $conn->query($sql);
                    $lastOID = $stmt->fetchColumn();

                    if ($lastOID) {
                        $lastNumber = (int) substr($lastOID, 1);
                        return "O" . str_pad(++$lastNumber, 3, "0", STR_PAD_LEFT);
                    } else {
                        return "O001";
                    }
                }

                // ODID生成関数
                function generateUniqueODID($conn) {
                    $sql = "SELECT ODID FROM order_detail ORDER BY ODID DESC LIMIT 1";
                    $stmt = $conn->query($sql);
                    $lastODID = $stmt->fetchColumn();

                    if ($lastODID) {
                        $lastNumber = (int) substr($lastODID, 2);
                        return "OD" . str_pad(++$lastNumber, 3, "0", STR_PAD_LEFT);
                    } else {
                        return "OD001";
                    }
                }

                // Grand_totalを計算
                $grandTotal = 0;  // 初期化
                foreach ($cartData as $item) {
                    $quantity = (int) $item['quantity'];
                    $price = (int) $item['price'];
                    $grandTotal += $quantity * $price;  // 合計金額を計算
                }

                // 新しいOIDを生成
                $oid = generateUniqueOID($conn);

                // 現在の日時を取得
                $currentDateTime = date("Y-m-d H:i:s");

                // `order_management`にデータを挿入
                $sql = "INSERT INTO order_management (OID, Date_time, CID, Name, Address, Phone, Card_info, Grand_total_price) VALUES (:oid, :date_time, :cid, :name, :address, :phone, :card_info, :grand_total)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':oid', $oid);
                $stmt->bindParam(':date_time', $currentDateTime);
                $stmt->bindParam(':cid', $cid);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':address', $address);
                $stmt->bindValue(':phone', $phone, PDO::PARAM_STR);
                $stmt->bindValue(':card_info', $cardInfo, PDO::PARAM_STR);                
                $stmt->bindParam(':grand_total', $grandTotal);
                $stmt->execute();

                // 商品ごとにODIDを生成して登録
                foreach ($cartData as $item) {
                    $sid = htmlspecialchars($item['sid']);
                    $quantity = (int) $item['quantity'];
                    $totalPrice = $quantity * (int) $item['price'];

                    // 新しいODIDを生成
                    $odid = generateUniqueODID($conn);

                    // `order_detail`にデータを挿入
                    $sql = "INSERT INTO order_detail (ODID, OID, SID, Order_quantity, Total_price) VALUES (:odid, :oid, :sid, :order_quantity, :total_price)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':odid', $odid);
                    $stmt->bindParam(':oid', $oid);
                    $stmt->bindParam(':sid', $sid);
                    $stmt->bindParam(':order_quantity', $quantity);
                    $stmt->bindParam(':total_price', $totalPrice);
                    $stmt->execute();
                }

                // リダイレクトしてOIDを渡す
                header("Location: thanks_7thA.php?oid=$oid");
                exit;

            } catch (PDOException $e) {
                echo "エラー: " . $e->getMessage();
            }
        }
        ?>

        <!-- 注文確定ボタン -->
        <form method="post">
            <!-- 注文確定に必要な情報を隠しフィールドで送信 -->
            <input type="hidden" name="cid" value="<?= htmlspecialchars($_POST['cid']) ?>">
            <input type="hidden" name="cartData" value="<?= htmlspecialchars($_POST['cartData']) ?>">
            <input type="hidden" name="name" value="<?= htmlspecialchars($_POST['name']) ?>">
            <input type="hidden" name="address" value="<?= htmlspecialchars($_POST['address']) ?>">
            <input type="hidden" name="phone" value="<?= htmlspecialchars($_POST['phone']) ?>">
            <input type="hidden" name="card_info" value="<?= htmlspecialchars($_POST['card_info']) ?>">
            <div class="text-center mt-3">
                <button class="btn btn-success" name="confirm_order" type="submit">注文確定</button>
            </div>
        </form>

        <!-- "戻る" ボタン -->
        <div class="text-center mt-3">
            <button class="btn btn-secondary" onclick="window.location.href = 'payment_7thA.php';">前のページに戻る</button>
        </div>
    </div>
</body>
</html>