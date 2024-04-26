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

    // product_stockテーブルからPIDとSIDの関係を取得する
    $stmt = $conn->query("SELECT PID, SID, Gender FROM product_stock LIMIT $offset, $items_per_page");
    $pid_sid_gender = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // JSONファイルのパス
    $json_file = 'C:\xampp\htdocs\jisouteamworkshopA\pokemon_data.json';

    // JSONファイルを読み込む
    $data = file_get_contents($json_file);

    // JSONデータを連想配列に変換
    $products = json_decode($data, true);

    // ページング用の情報を取得する
    $total_items = $conn->query("SELECT COUNT(*) FROM product_stock")->fetchColumn();
    $total_pages = ceil($total_items / $items_per_page);
} catch (PDOException $e) {
    // エラーメッセージを出力する
    echo "Error: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>在庫商品一覧</title>
    <link rel="stylesheet" href="./css/order_7thA.css">
</head>

<body>
    <h1>商品一覧</h1>
    <div class="container_st">
        <table border="1">
            <tr>
                <th>SID</th>
                <th>PID</th>
                <th>商品名</th>
                <th>画像</th>
                <th>タイプ1</th>
                <th>タイプ2</th>
                <th>性別</th>
                <th>価格</th>
                <th>在庫数</th>
            </tr>
            <?php foreach ($pid_sid_gender as $sid_gender) : ?>
                <tr>
                    <td><?php echo $sid_gender['SID']; ?></td>
                    <td><?php echo $sid_gender['PID']; ?></td>
                    <?php
                    // $sid_genderと$productのPIDが一致する商品情報を探す
                    $matching_product = null;
                    foreach ($products as $product) {
                        if ($product['PID'] === $sid_gender['PID']) {
                            $matching_product = $product;
                            break;
                        }
                    }
                    ?>
                    <td><?php echo $matching_product['Name']; ?></td>
                    <td><img src="<?php echo $matching_product['Image_path']; ?>" alt="商品画像" width="100" height="100"></td>
                    <td><?php echo $matching_product['Type1']; ?></td>
                    <td><?php echo $matching_product['Type2'] ?? ''; ?></td>
                    <td><?php echo $sid_gender['Gender']; ?></td>
                    <td><?php echo $matching_product['Price']; ?></td>
                    <td><?php echo $matching_product['Inventory']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="pagination">
        <?php for ($page = 1; $page <= $total_pages; $page++) : ?>
            <a href="?page=<?php echo $page; ?>" <?php if ($page === $current_page) echo 'class="active"'; ?>><?php echo $page; ?></a>
        <?php endfor; ?>
    </div>
</body>

</html>
