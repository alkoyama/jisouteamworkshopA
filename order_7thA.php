
<?php
// データベースに接続する
$host = 'localhost';
$dbname = 'cooking';
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
    $total_stmt = $conn->prepare("SELECT COUNT(*) AS total FROM orders");
    $total_stmt->execute();
    $total_result = $total_stmt->fetch(PDO::FETCH_ASSOC);
    $total_items = $total_result['total'];

    // ページに表示する注文情報を取得
    $stmt = $conn->prepare("SELECT * FROM orders LIMIT :offset, :items_per_page");
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':items_per_page', $items_per_page, PDO::PARAM_INT);
    $stmt->execute();
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
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
</head>

<body>
    <h1>管理画面</h1>
    <div class="container">
        <table border="1">
            <tr>
                <th>ID</th>
                <th>注文日時</th>
                <th>注文商品</th>
                <th>名前</th>
                <th>住所</th>
                <th>電話番号</th>
                <th>カード情報</th>
                <th>パスワード</th>
                <th>注文数</th>
                <th>合計金額</th>
                <th>削除</th>
            </tr>
            <?php foreach ($orders as $order) : ?>
                <tr>
                    <td><?php echo $order['id']; ?></td>
                    <td><?php echo $order['order_date']; ?></td>
                    <td><?php echo $order['order_item']; ?></td>
                    <td><?php echo $order['name']; ?></td>
                    <td><?php echo $order['address']; ?></td>
                    <td><?php echo $order['phone_number']; ?></td>
                    <td><?php echo $order['card_info']; ?></td>
                    <td><?php echo $order['password']; ?></td>
                    <td><?php echo $order['order_quantity']; ?></td>
                    <td><?php echo $order['total_amount']; ?></td>
                    <td><button onclick="confirmDelete(<?php echo $order['id']; ?>)">削除</button></td>
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
            echo "<a class='$active_class' href='admin.php?page=$i'>$i</a>";
        }
        ?>
    </div>
    <script>
        function confirmDelete(id) {
            if (confirm('本当に削除しますか？')) {
                window.location = 'delete.php?id=' + id;
            }
        }
    </script>
</body>

</html>
=======

