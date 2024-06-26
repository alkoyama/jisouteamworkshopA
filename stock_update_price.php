<?php
// MySQLに接続するためのPDOインスタンスを作成
$dsn = "mysql:host=localhost;dbname=teamworkshop_7thA;charset=utf8";
$username = "root";
$password = ""; // パスワードが空欄の場合
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// POSTリクエストからSIDとPriceを取得
$SID = $_POST['SID'];
$newPrice = $_POST['Price'];

// 価格の更新を反映するSQLクエリを準備
$sqlPrice = "UPDATE product_stock SET Price = :newPrice WHERE SID = :SID";

// SQL クエリの直前にログを追加
error_log("Updating price for SID: $SID, new price: $newPrice");

try {
    // 価格の更新を実行
    $stmtPrice = $pdo->prepare($sqlPrice);
    $stmtPrice->bindParam(':newPrice', $newPrice, PDO::PARAM_STR);
    $stmtPrice->bindParam(':SID', $SID, PDO::PARAM_STR);
    $stmtPrice->execute();

    // 成功したことをクライアントに通知
    echo "Price updated successfully";
} catch (PDOException $e) {
    // エラーが発生した場合はエラーメッセージを出力
    echo "Error: " . $e->getMessage();
    // エラーが発生したことをログに記録
    error_log("Error updating price for SID: $SID - " . $e->getMessage());
}
?>
