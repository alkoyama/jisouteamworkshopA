<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>注文確認</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>注文確認</h1>

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
                echo '<thead><tr><th>SID</th><th>名前</th><th>個数</th><th>価格</th><th>小計</th></tr></thead>';
                echo '<tbody>';

                $grandTotal = 0;

                foreach ($cartData as $item) {
                    $sid = htmlspecialchars($item['sid']);
                    $itemName = htmlspecialchars($item['name']);
                    $quantity = (int) $item['quantity'];
                    $price = (int) $item['price'];
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

        <div class="text-center mt-3">
            <button class="btn btn-success">注文確定</button>
        </div>
    </div>
</body>
</html>
