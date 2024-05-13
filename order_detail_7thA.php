<!DOCTYPE html>
<html>

<head>
    <title>受注明細画面</title>
</head>

<body>
    <?php
    // データベース接続情報
    $host = 'localhost';
    $dbname = 'teamworkshop_7tha';
    $username = 'root';
    $password = '';

    // 注文IDの取得
    $OID = isset($_GET['OID']) ? $_GET['OID'] : null;

    // 注文IDが指定されていない場合はエラーメッセージを表示して終了
    if (!$OID) {
        echo "注文IDが指定されていません。";
        exit();
    }

    try {
        // データベースに接続する
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 注文詳細を取得するクエリを準備する
        // $stmt = $conn->prepare("
        //     SELECT od.ODID, od.OID, ps.SID, pi.Name, od.Order_quantity, od.Total_price
        //     FROM order_detail od
        //     INNER JOIN product_stock ps ON od.SID = ps.SID
        //     INNER JOIN poke_info pi ON ps.PID = pi.PID
        //     WHERE od.OID = :OID
        // ");
        $stmt = $conn->prepare("

            SELECT od.ODID, od.OID, pi.Name, od.Order_quantity, od.Total_price
            FROM order_detail od
            INNER JOIN product_stock ps ON od.SID = ps.SID
            INNER JOIN poke_info pi ON ps.PID = pi.PID
            WHERE od.OID = :OID
        ");



        $stmt->bindParam(':OID', $OID, PDO::PARAM_STR);
        $stmt->execute();
        $order_details = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 取得した注文詳細を表示する
        echo "<h1>受注明細画面</h1>";
        echo "<table border='1'>";
        echo "<tr><th>受注詳細ID</th><th>受注ID</th><th>商品名</th><th>注文個数</th><th>合計金額</th></tr>";
        foreach ($order_details as $detail) {
            echo "<tr>";
            echo "<td>{$detail['ODID']}</td>";
            echo "<td>{$detail['OID']}</td>";
            echo "<td>{$detail['Name']}</td>";
            echo "<td class='qty'>" . $detail['Order_quantity'] . "</td>"; // 修正点
            echo "<td class='price'>" . number_format($detail['Total_price']) . "</td>"; // 修正点
            echo "</tr>";
        }
        echo "</table>";
    } catch (PDOException $e) {
        // エラーメッセージを出力する
        echo "Error: " . $e->getMessage();
    }
    ?>

</body>
</html>