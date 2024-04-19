<?php
// データベースに接続する
$host = 'localhost';
$dbname = 'teamworkshop_7tha';
$username = 'root';
$password = '';

// ページング用の設定
$items_per_page = 10; // 1ページあたりのアイテム数
$current_page = isset($_GET['page']) ? $_GET['page'] : 1; // 現在のページ番号
$offset = ($current_page - 1) * $items_per_page; // オフセット

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 全体の件数を取得
    $total_stmt = $conn->prepare("SELECT COUNT(*) AS total FROM customer_management");
    $total_stmt->execute();
    $total_result = $total_stmt->fetch(PDO::FETCH_ASSOC);
    $total_items = $total_result['total'];

    // ページに表示する注文情報を取得
    $stmt = $conn->prepare("SELECT * FROM customer_management LIMIT :offset, :items_per_page");
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':items_per_page', $items_per_page, PDO::PARAM_INT);
    $stmt->execute();
    $customer_management = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// 削除処理
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['CID'])) {
    $CID = $_GET['CID']; // CIDを取得する
    echo "削除対象のCID: " . $CID;

    try {
        $delete_stmt = $conn->prepare("DELETE FROM customer_management WHERE CID = :CID");
        $delete_stmt->bindParam(':CID', $CID, PDO::PARAM_STR); // $CIDを文字列としてバインドする
        $delete_stmt->execute();

        // 削除が成功したかどうかを確認
        if ($delete_stmt->rowCount() > 0) {
            echo "削除が成功しました。";
        } else {
            echo "削除に失敗しました。";
        }

        header("Location: http://localhost/jisouteamworkshopA/order_7thA.php"); // 削除後に再読み込み
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>




<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>管理画面</title>
    <style>
        body {
            justify-content: center;
            /* コンテンツを水平中央揃え */
            align-items: center;
            /* コンテンツを垂直中央揃え */
            height: 100vh;
            /* ビューポートの高さを100%に設定 */
            margin: 0;
            /* デフォルトのマージンを削除 */
        }

        .container {
            width: 80%;
            /* 必要に応じて幅を調整 */
            max-width: 800px;
            /* 最大幅を設定 */
            padding: 20px;
            /* 余白を追加 */
            border: 1px solid #ccc;
            /* 可視化のための境界線を追加 */
            margin: auto;
        }

        h1 {
            text-align: center;
        }

        .pagination {
            margin-top: 20px;
            text-align: center;
        }

        .pagination a {
            display: inline-block;
            padding: 5px 10px;
            margin: 0 5px;
            border: 1px solid #ccc;
            text-decoration: none;
        }

        .pagination a.active {
            background-color: #ccc;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function confirmDelete(CID) {
            if (confirm('本当に削除しますか？')) {
                $.ajax({
                    url: 'order_7thA.php',
                    type: 'GET',
                    data: {
                        action: 'delete',
                        CID: CID
                    },
                    success: function(response) {
                        // 削除成功時にテーブルの行を削除
                        $('#row_' + CID).remove();
                    },
                    error: function(xhr, status, error) {
                    }
                });
            }
        }
    </script>
</head>

<body>
    <h1>管理画面</h1>
    <div class="container">
        <table border="1">
            <tr>
                <th>ID</th>
                <!-- <th>注文日時</th> -->
                <!-- <th>注文商品</th> -->
                <th>名前</th>
                <th>住所</th>
                <th>電話番号</th>
                <th>カード情報</th>
                <th>パスワード</th>
                <!-- <th>注文数</th> -->
                <!-- <th>合計金額</th> -->
                <th>削除</th>
            </tr>
            <?php foreach ($customer_management as $order) : ?>

                <tr id="row_<?php echo $order['CID']; ?>">
                    <td><?php echo $order['CID']; ?></td>
                    <!-- <td><?php echo $order['order_date']; ?></td> -->
                    <!-- <td><?php echo $order['order_item']; ?></td> -->
                    <td><?php echo $order['Name']; ?></td>
                    <td><?php echo $order['Address']; ?></td>
                    <td><?php echo $order['Phone']; ?></td>
                    <td><?php echo $order['Card_info']; ?></td>
                    <td><?php echo $order['Password']; ?></td>
                    <!-- <td><?php echo $order['order_quantity']; ?></td> -->
                    <!-- <td><?php echo $order['Total_amount']; ?></td> -->
                    <td><button onclick="confirmDelete(<?php echo intval($order['CID']); ?>)">削除</button></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="pagination">
        <?php
        // ページングリンクを表示
        $total_pages = ceil($total_items / $items_per_page); // 総ページ数
        for ($i = 1; $i <= $total_pages; $i++) {
            $active_class = ($i == $current_page) ? 'active' : '';
            // echo "<a class='$active_class' href='admin.php?page=$i'>$i</a>";
            echo "<a class='$active_class' href='order_7thA.php?page=$i'>$i</a>";
        }

        ?>
    </div>

</body>

</html>