<?php
$host = 'localhost';
$dbname = 'teamworkshop_7tha';
$username = 'root';
$password = '';

$items_per_page = 10;
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($current_page - 1) * $items_per_page;

try {
    // データベースに接続する
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ページに表示する商品在庫情報を取得する
    $stmt = $conn->prepare("SELECT ps.*, pi.Name AS ProductName
                            FROM product_stock ps
                            JOIN poke_info pi ON ps.PID = pi.PID
                            LIMIT :offset, :items_per_page");

    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':items_per_page', $items_per_page, PDO::PARAM_INT);
    $stmt->execute();
    $product_stock = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // エラーメッセージを出力する
    echo "Error: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/order_7thA.css">
    <title>商品在庫管理</title>
</head>

<body>
    <h1>商品在庫管理</h1>
    <div class="container">
        <table border="1">
            <tr>
                <th>在庫ID</th>
                <th>PID</th>
                <th>商品名</th>
                <th>性別</th>
                <th>価格</th>
                <th>在庫数</th>
            </tr>
            <?php foreach ($product_stock as $item) : ?>
                <tr>
                    <td><?php echo $item['SID']; ?></td>
                    <td><?php echo $item['PID']; ?></td>
                    <td><?php echo $item['ProductName']; ?></td>
                    <td><?php echo $item['Gender']; ?></td>
                    <!-- <td><?php echo $item['Price']; ?></td> -->
                    <td><?php echo isset($item['Price']) ? $item['Price'] : 'N/A'; ?></td>
                    <td><?php echo $item['Inventory']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div class="pagination">
        <?php
        // ページングリンクを表示
        echo '<div class="pagination">';
        $total_items_stmt = $conn->query("SELECT COUNT(*) AS total FROM product_stock");
        $total_items = $total_items_stmt->fetch(PDO::FETCH_ASSOC)['total'];
        $total_pages = ceil($total_items / $items_per_page); // 総ページ数
        for ($i = 1; $i <= $total_pages; $i++) {
            $active_class = ($i == $current_page) ? 'active' : '';
            echo "<a class='$active_class' href='stock_management_7thA.php?page=$i'>$i</a>";

        }
        echo '</div>';
        ?>
    </div>
</body>

</html>