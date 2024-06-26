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

    // データベースから全体の件数を取得する
    $total_stmt = $conn->prepare("SELECT COUNT(*) AS total FROM order_management");
    $total_stmt->execute();
    $total_result = $total_stmt->fetch(PDO::FETCH_ASSOC);
    $total_items = $total_result['total'];

    // ページに表示する注文情報を取得する
    $stmt = $conn->prepare("SELECT DISTINCT o.*, o.CID, o.Name, o.Address, o.Phone, o.Card_info
                        FROM order_management o
                        JOIN order_detail od ON o.OID = od.OID
                        LIMIT :offset, :items_per_page");

    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':items_per_page', $items_per_page, PDO::PARAM_INT);
    $stmt->execute();
    $customer_management = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // エラーメッセージを出力する
    echo "Error: " . $e->getMessage();
}

// データ削除処理
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['OID'])) {
    $OID = $_GET['OID'];

    // 指定されたOIDの注文データと関連する注文詳細データを削除する
    try {
        // まずorder_detailから関連するレコードを削除
        $delete_detail_stmt = $conn->prepare("DELETE FROM order_detail WHERE OID = :OID");
        $delete_detail_stmt->bindParam(':OID', $OID, PDO::PARAM_STR);
        $delete_detail_stmt->execute();

        // 次にorder_managementから関連するレコードを削除
        $delete_management_stmt = $conn->prepare("DELETE FROM order_management WHERE OID = :OID");
        $delete_management_stmt->bindParam(':OID', $OID, PDO::PARAM_STR);
        $delete_management_stmt->execute();

        // 削除が成功したかどうかを確認
        $deleted_rows_detail = $delete_detail_stmt->rowCount();
        $deleted_rows_management = $delete_management_stmt->rowCount();

        if ($deleted_rows_detail > 0 || $deleted_rows_management > 0) {
            // 削除成功メッセージを出力する
            echo "削除が成功しました。";
        } else {
            // 削除失敗メッセージを出力する
            echo "削除に失敗しました。";
        }

        // 削除後、現在のページにリダイレクトする
        header("Location: order_7thA.php?page=$current_page");
        exit();
    } catch (PDOException $e) {
        // エラーメッセージを出力する
        echo "削除エラー: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="./css/order_7thA.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>受注管理画面</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        function confirmDelete(OID) {
            if (confirm('本当に削除しますか？')) {
                var startTime = performance.now(); // 開始時間を記録

                $.ajax({
                    url: 'http://localhost/jisouteamworkshopA/order_7thA.php',
                    type: 'GET',
                    data: {
                        action: 'delete',
                        OID: OID
                    },
                    success: function(response) {
                        // 削除成功時にテーブルの行を削除
                        $('#row_' + OID).remove();

                        var endTime = performance.now(); // 終了時間を記録
                        var duration = endTime - startTime; // 処理時間を計算
                        console.log("処理時間：" + duration + "ミリ秒");
                    },
                    error: function(xhr, status, error) {
                        console.error("Error occurred:", error);
                        alert("削除に失敗しました。エラーが発生しました。");
                    }
                });
            }
        }
    </script>
</head>

<body>
    <h1>受注管理画面</h1>
    <div class="container">
        <table border="1">
        <a href="http://localhost/jisouteamworkshopA/Integration_Hub_7th.php" class="back-btn">
                <button id="back-to-admin" class="btn">
                    <i class="fa fa-cog" aria-hidden="true"></i>
                </button>
                <div id="hover-message" class="hidden">管理画面へ</div>
            </a>
            <tr>
                <th>受注ID</th>
                <th>注 文 日 時</th>
                <th>顧客ID</th>
                <th>名 前</th>
                <th class="address">住 所</th>
                <th>電 話 番 号</th>
                <th>カード情報</th>
                <th>合計金額</th>
                <th>注文詳細</th>
                <th>削 除</th>
            </tr>
            <?php foreach ($customer_management as $order) : ?>

                <tr id="row_<?php echo $order['OID']; ?>">
                    <td><?php echo $order['OID']; ?></a></td>
                    <td><?php echo $order['Date_time']; ?></td>
                    <td><?php echo $order['CID']; ?></a></td>
                    <td><?php echo $order['Name']; ?></td>
                    <td class="address"><?php echo $order['Address']; ?></td>
                    <td><?php echo $order['Phone']; ?></td>
                    <td><?php echo $order['Card_info']; ?></td>
                    <td class="price"><?php echo number_format($order['Grand_total_price']); ?></td>
                    <td><button class="button detail-button" onclick="openModal('<?php echo $order['OID']; ?>')">詳細を表示</button></td>
                    <td><button class="button delete-button" onclick="confirmDelete('<?php echo $order['OID']; ?>')">削除</button></td>

                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <!-- 注文詳細を表示するモーダル -->
    <div id="orderDetailsModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div id="orderDetailsContainer"></div>
        </div>
    </div>

    <script>
        // モーダルを開く関数
        function openModal(OID) {
            // 注文IDを使用してサーバーから注文詳細を取得する
            $.ajax({
                url: 'order_detail_7thA.php',
                type: 'GET',
                data: {
                    OID: OID
                },
                success: function(response) {
                    // 取得した注文詳細をモーダル内のコンテナに表示する
                    $('#orderDetailsContainer').html(response);
                    // モーダルを表示する
                    $('#orderDetailsModal').css('display', 'block');
                },
                error: function(xhr, status, error) {
                    console.error("Error occurred:", error);
                    alert("注文詳細の取得に失敗しました。エラーが発生しました。");
                }
            });
        }

        // モーダルを閉じる関数
        function closeModal() {
            // モーダルを非表示にする
            $('#orderDetailsModal').css('display', 'none');
        }

        // 管理画面へ戻る
        document.getElementById('back-to-admin').addEventListener('mouseover', function() {
                document.getElementById('hover-message').style.display = 'block';
            });

            document.getElementById('back-to-admin').addEventListener('mouseout', function() {
                document.getElementById('hover-message').style.display = 'none';
            });
    </script>
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
    <!-- <video id="myVideo" autoplay loop muted playsinline style="width: 50%; height: 30%; position: fixed; top:680px; bottom: 0; left: 0; z-index: -1;">
        <source src="./images/background/@Terrajin05 .mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video> -->

</body>

</html>