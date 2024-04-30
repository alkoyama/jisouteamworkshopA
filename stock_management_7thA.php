<?php
// データベース接続情報
$dsn = 'mysql:host=localhost;dbname=teamworkshop_7tha;charset=utf8mb4';
$username = 'root';
$password = '';

// 1回の読み込みで取得するアイテム数
$items_per_page = 10;

// データベース接続とデータ取得
try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // オフセットとページ数を取得
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($current_page - 1) * $items_per_page;

    // データ取得クエリ
    $sql = 'SELECT 
                product_stock.SID,
                product_stock.PID,
                poke_info.Name,
                poke_type.type_name AS Type1,
                (SELECT type_name FROM poke_type WHERE poke_type.TID = poke_info.Type2) AS Type2,
                product_stock.Gender,
                product_stock.Price,
                product_stock.Inventory,
                poke_graphics.path AS Image_path
            FROM 
                product_stock
            JOIN 
                poke_info ON product_stock.PID = poke_info.PID
            JOIN 
                poke_graphics ON poke_info.GID = poke_graphics.GID
            JOIN 
                poke_type ON poke_type.TID = poke_info.Type1
            LIMIT :offset, :items_per_page';

    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindValue(':items_per_page', $items_per_page, PDO::PARAM_INT);
    $stmt->execute();

    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 合計アイテム数を取得
    $total_items_sql = 'SELECT COUNT(*) FROM product_stock';
    $total_items = $pdo->query($total_items_sql)->fetchColumn();

    // レスポンスデータ
    $data = [
        'products' => $products,
        'total_pages' => ceil($total_items / $items_per_page),
        'current_page' => $current_page,
    ];

    if (isset($_GET['ajax'])) {
        // AJAXリクエストの場合、JSONとして返す
        header('Content-Type: application/json');
        echo json_encode($data);
        exit; // スクリプト終了
    }
} catch (PDOException $e) {
    // エラーが発生した場合のレスポンス
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    exit; // スクリプト終了
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>在庫商品一覧</title>
    <link rel="stylesheet" href="./css/order_7thA.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let currentPage = 0; // 0から開始、初回ロード後にインクリメント

        function loadMoreProducts() {
            currentPage++; // ページ数をインクリメント

            $.ajax({
                url: `?ajax=1&page=${currentPage}`, // ページ数を指定してAJAXリクエスト
                type: 'GET',
                success: function(response) {
                    if (response.error) {
                        alert(response.error);
                        return;
                    }

                    // データを追加
                    response.products.forEach(product => {
                        const type2 = product.Type2 ? product.Type2 : '';
                        const row = `<tr>
                            <td>${product.SID}</td>
                            <td>${product.PID}</td>
                            <td>${product.Name}</td>
                            <td><img src="${product.Image_path}" alt="商品画像" width="100" height="100"></td>
                            <td>${product.Type1}</td>
                            <td>${type2}</td>
                            <td>${product.Gender}</td>
                            <td>${product.Price}</td>
                            <td>${product.Inventory}</td>
                        </tr>`;
                        $('#product-table tbody').append(row);
                    });

                    // 最後のページならメッセージを表示
                    if (response.current_page >= response.total_pages) {
                        $('#load-more').hide(); // ボタンを非表示
                        $('.no-more-data').show(); // メッセージを表示
                    }
                },
                error: function() {
                    alert('Error loading products.');
                }
            });
        }

        $(document).ready(function() {
            loadMoreProducts(); // 初回読み込み
        });
    </script>
    <style>
        .button-center {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px; 
            /* // 上マージン */
            margin-bottom: 20px; 
            /* // 下マージン */
        }
        /* // 初期状態では非表示 */
        .no-more-data {
            display: none; 
            justify-content: center;
            text-align: center; 
            margin-top: 20px; 
            margin-bottom: 20px; 
            color: #777; 
            /* // グレーで表示 */
        }
        /* 画面最下部の隙間 */
        .bottom-margin {
            height: 20px; /* 適切なマージンを設定してください */
        }
    </style>
</head>
<body>
    <h1>商品一覧</h1>
    <div class="container_st">
        <table border="1" id="product-table">
            <thead>
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
            </thead>
            <tbody>
                <!-- データがここに追加されます -->
            </tbody>
        </table>
    </div>
    <div class="button-center">
        <button id="load-more" onclick="loadMoreProducts()">さらに読み込む</button> <!-- ボタン -->
    </div>
    <div class="no-more-data">これ以上データはありません</div> <!-- 最後のページに到達したときに表示 -->

    <!-- 画面最下部の隙間 -->
    <div class="bottom-margin"></div>
</body>
</html>
