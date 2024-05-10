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
    <link rel="stylesheet" href="./css/stock_management_7thA.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
   
</head>

<body>
    <h1>商品一覧</h1>

    <div class="container_st">
        <div class="mt-3" id="gender-filters">
        <label><input type="checkbox" value="male"> オスポケモン</label>
        <label><input type="checkbox" value="female"> メスポケモン</label>
        <label><input type="checkbox" value="unknown"> せいべつふめい</label>
        <label><input type="checkbox" value="egg"> タマゴ</label>
        <label><input type="checkbox" value="item"> どうぐ</label>
        <label><input type="checkbox" value="ball"> ボール</label>
        </div>
    <hr> <!-- タイプフィルターとの間に横線を追加 -->
         <!-- タイプフィルタリング用チェックボックス -->
    <div class="mt-3" id="type-filters">
        <label><input type="checkbox" value="ノーマル"> ノーマル</label>
        <label><input type="checkbox" value="ほのお"> ほのお</label>
        <label><input type="checkbox" value="みず"> みず</label>
        <label><input type="checkbox" value="でんき"> でんき</label>
        <label><input type="checkbox" value="くさ"> くさ</label>
        <label><input type="checkbox" value="こおり"> こおり</label>
        <label><input type="checkbox" value="かくとう"> かくとう</label>
        <label><input type="checkbox" value="どく"> どく</label>
        <label><input type="checkbox" value="じめん"> じめん</label>
        <label><input type="checkbox" value="ひこう"> ひこう</label>
        <label><input type="checkbox" value="エスパー"> エスパー</label>
        <label><input type="checkbox" value="むし"> むし</label>
        <label><input type="checkbox" value="いわ"> いわ</label>
        <label><input type="checkbox" value="ゴースト"> ゴースト</label>
        <label><input type="checkbox" value="ドラゴン"> ドラゴン</label>
        <label><input type="checkbox" value="あく"> あく</label>
        <label><input type="checkbox" value="はがね"> はがね</label>
        <label><input type="checkbox" value="フェアリー"> フェアリー</label>
    </div>
    <div class="text-center mt-3">
        <!-- 名前の昇順・降順 -->
        <button class="btn btn-primary" id="sort-name-asc">アイウエオ順</button>
        <button class="btn btn-primary" id="sort-name-desc">アイウエオ逆順</button>

        <!-- 価格の昇順・降順 -->
        <button class="btn btn-secondary" id="sort-price-asc">価格の安い順</button>
        <button class="btn btn-secondary" id="sort-price-desc">価格の高い順</button>
    
        <!-- 在庫の昇順・降順のボタンを追加 -->
        <button class="btn btn-warning" id="sort-inventory-asc">在庫の少ない順</button>
        <button class="btn btn-warning" id="sort-inventory-desc">在庫の多い順</button>
    </div>

    <div class="row" id="pokemon-container">
        <!-- 最初の5個を表示 -->
    </div>
    <!-- 更新情報を表示するコンテナ -->
    <div class="parent-container"> <!-- .parent-container を追加 -->
    <div class="update-container">
        <div id="last-updated"></div>
        <button id="refresh" type="button">更新する</button>
    </div>
</div>

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
        <button id="load-more" onclick="loadMoreProducts()">さらに読み込む</button>
    </div>
    <div class="no-more-data">これ以上のデータはありません</div> <!-- 最後のページに到着したときに表示 -->
    <!-- 画面最下部の隙間 -->
    <div class="bottom-margin">
    </div>

    <script>
        // 初期のページ番号を定義
        let currentPage = 0;

        // 商品を追加する関数
        function loadMoreProducts() {
            // ページ番号をインクリメント
            currentPage++;

            // AJAXリクエストを送信
            $.ajax({
                url: `?ajax=1&page=${currentPage}`, // ページ番号を含むURL
                type: 'GET', // GETリクエスト
                success: function(response) { // リクエスト成功時の処理
                    if (response.error) { // エラーチェック
                        alert(response.error); // エラーメッセージを表示
                        return; // 関数を終了
                    }
                    appendProducts(response.products, currentPage, response.total_pages); // 商品を追加する関数を呼び出す
                },
                error: function() { // リクエスト失敗時の処理
                    alert('製品の読み込みエラー。'); // エラーメッセージを表示
                }
            });
        }

        // 商品を追加する関数
        function appendProducts(products, currentPage, total_pages) {
            // 取得した商品リストを反復処理
            products.forEach(product => {
                // 商品情報をHTMLテーブルの行に変換
                const type2 = product.Type2 ? product.Type2 : ''; // タイプ2があるかどうかの条件付き代入
                const row = `<tr>
            <td>${product.SID}</td>
            <td>${product.PID}</td>
            <td>${product.Name}</td>
            <td><img src="${product.Image_path}" alt="商品画像" width="80" height="80"></td>
            <td>${product.Type1}</td>
            <td>${type2}</td>
            <td>${product.Gender}</td>
            <td>${product.Price}</td>
            <td>${product.Inventory}</td>
        </tr>`;
                // テーブルのtbody要素に行を追加
                $('#product-table tbody').append(row);
            });

            // 最後のページならメッセージを表示
            if (currentPage >= total_pages) {
                console.log("最後のページ");
                $('#load-more').hide(); // ボタンを非表示
                $('.no-more-data').show(); // メッセージを表示
            }
        }

        // 更新ボタンをクリックしたときの処理
        $('#refresh').click(function() {
            // 現在の日時を取得
            const currentTime = new Date();
            const formattedTime = currentTime.toLocaleString(); // 日時を文字列に変換

            // 最終更新時刻を表示
            $('#last-updated').text('最終更新: ' + formattedTime);

            currentPage = 0; // ページ番号をリセット
            $('#product-table tbody').empty(); // テーブルの内容をクリア
            $('#load-more').show(); // 読み込むボタンを表示
            $('.no-more-data').hide(); // メッセージを非表示
            loadMoreProducts(); // 商品情報を再読み込み
        });

        // ページが読み込まれたときの処理
        $(document).ready(function() {
            // 現在の日時を取得
            const currentTime = new Date();
            const formattedTime = currentTime.toLocaleString(); // 日時を文字列に変換

            // 最終更新時刻を表示
            $('#last-updated').text('最終更新: ' + formattedTime);
        });

        // ドキュメントのロード完了時の処理
        $(document).ready(function() {
            loadMoreProducts(); // 商品情報を読み込み
        });

        function applyFilters() {
    // フィルターされた商品を表示するためにテーブルの内容をクリア
    $('#product-table tbody').empty();

    // チェックされた性別フィルターを取得
    const genders = [];
    $('#gender-filters input:checked').each(function() {
        genders.push($(this).val());
    });

    // チェックされたタイプフィルターを取得
    const types = [];
    $('#type-filters input:checked').each(function() {
        types.push($(this).val());
    });

    // フィルターされた商品を取得
    const filteredProducts = products.filter(product => {
        // 性別フィルターを適用
        if (!genders.length || genders.includes(product.Gender)) {
            // タイプフィルターを適用
            if (!types.length || types.includes(product.Type1) || types.includes(product.Type2)) {
                return true;
            }
        }
        return false;
    });

    // フィルターされた商品をテーブルに表示
    appendProducts(filteredProducts, currentPage, total_pages);
}
 
// チェックボックスの変更を監視してフィルターを適用
$('#gender-filters input, #type-filters input').change(function() {
    applyFilters();
});

// 商品をソートする関数
function sortProducts(key, order) {
    // テーブルの内容をクリア
    $('#product-table tbody').empty();

    // ソート
    products.sort((a, b) => {
        if (a[key] < b[key]) return order === 'asc' ? -1 : 1;
        if (a[key] > b[key]) return order === 'asc' ? 1 : -1;
        return 0;
    });

    // ソートされた商品を表示
    appendProducts(products, currentPage, total_pages);
}

// ソートボタンのクリックを監視してソートを実行
$('#sort-name-asc').click(function() {
    sortProducts('Name', 'asc');
});

$('#sort-name-desc').click(function() {
    sortProducts('Name', 'desc');
});

$('#sort-price-asc').click(function() {
    sortProducts('Price', 'asc');
});

$('#sort-price-desc').click(function() {
    sortProducts('Price', 'desc');
});

$('#sort-inventory-asc').click(function() {
    sortProducts('Inventory', 'asc');
});

$('#sort-inventory-desc').click(function() {
    sortProducts('Inventory', 'desc');
});

   </script>
</body>

</html>