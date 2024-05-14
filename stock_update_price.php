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

// データベースに価格の更新を反映する処理を実装

// POSTリクエストからSIDとPriceを取得
$SID = $_POST['SID'];
$newPrice = $_POST['Price'];

// データベースに価格の更新を反映するSQLクエリを準備
$sql = "UPDATE product_stock SET Price = :newPrice WHERE SID = :SID";

// SQL クエリの直前にログを追加
error_log("Updating price for SID: $SID, new price: $newPrice");

try {
    // SQL クエリを準備
    $stmt = $pdo->prepare($sql);
    
    // パラメータをバインド
    $stmt->bindParam(':newPrice', $newPrice, PDO::PARAM_STR);
    $stmt->bindParam(':SID', $SID, PDO::PARAM_STR); // SIDを文字列としてバインドする
    
    // クエリを実行
    $stmt->execute();

    // SQL クエリの直後に成功したことをログに記録
    error_log("Price updated successfully for SID: $SID");
    
    // 成功したことをクライアントに通知
    echo "Price updated successfully";
} catch (PDOException $e) {
    // エラーが発生した場合はエラーメッセージを出力
    echo "Error: " . $e->getMessage();
    // エラーが発生したことをログに記録
    error_log("Error updating price for SID: $SID - " . $e->getMessage());
}
?>
