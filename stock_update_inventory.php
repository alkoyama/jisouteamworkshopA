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

// POSTリクエストからSIDとInventoryを取得
$SID = $_POST['SID'];
$newInventory = $_POST['Inventory'];

// 在庫の更新を反映するSQLクエリを準備
$sqlInventory = "UPDATE product_stock SET Inventory = :newInventory WHERE SID = :SID";

// SQL クエリの直前にログを追加
error_log("Updating inventory for SID: $SID, new inventory: $newInventory");

try {
    // 在庫の更新を実行
    $stmtInventory = $pdo->prepare($sqlInventory);
    $stmtInventory->bindParam(':newInventory', $newInventory, PDO::PARAM_INT);
    $stmtInventory->bindParam(':SID', $SID, PDO::PARAM_STR);
    $stmtInventory->execute();

    // 成功したことをクライアントに通知
    echo "Inventory updated successfully";
} catch (PDOException $e) {
    // エラーが発生した場合はエラーメッセージを出力
    echo "Error: " . $e->getMessage();
    // エラーが発生したことをログに記録
    error_log("Error updating inventory for SID: $SID - " . $e->getMessage());
}
?>
