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

    <!-- フィルターとソート -->
    <div class="filter-sort-section">
        <h3 class="text-left">文字列でさがす</h3>
        <div class="mt-3">
            <input type="text" id="search-name" class="form-control large-input" placeholder="商品名で検索" />
        </div>
        <hr>
        <h3 class="text-left">分類でさがす</h3>
        <div class="mt-3" id="gender-filters">
            <label><input type="checkbox" value="male"> オスポケモン</label>
            <label><input type="checkbox" value="female"> メスポケモン</label>
            <label><input type="checkbox" value="unknown"> せいべつふめい</label>
            <label><input type="checkbox" value="egg"> タマゴ</label>
            <label><input type="checkbox" value="item"> どうぐ</label>
            <label><input type="checkbox" value="ball"> ボール</label>
        </div>
        <hr>
        <h3 class="text-left">ポケモンのタイプでさがす</h3>
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
        <hr>
        <h3 class="text-left">ソートする</h3>
        <div class="text-center mt-3">
            <button class="btn btn-primary" id="sort-name-asc">アイウエオ順</button>
            <button class="btn btn-primary" id="sort-name-desc">アイウエオ逆順</button>
            <button class="btn btn-secondary" id="sort-price-asc">価格の安い順</button>
            <button class="btn btn-secondary" id="sort-price-desc">価格の高い順</button>
            <button class="btn btn-warning" id="sort-inventory-asc">在庫の少ない順</button>
            <button class="btn btn-warning" id="sort-inventory-desc">在庫の多い順</button>
        </div>
    </div>

    <div class="container_st">
        <div class="row">
            <div class="search-container">
                <input type="text" id="search-input" placeholder="SIDまたは商品名を入力してください">
                <button id="search-button">検索</button>
                <button id="reset-button">リセット</button>
            </div>
            <div class="update-container">
                <div id="last-updated"></div>
                <button id="refresh" type="button">最新情報を取得する</button>
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
                    <th>分類</th>
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
    <div class="no-more-data">これ以上のデータはありません</div>
    <div class="bottom-margin"></div>

    <script>
        // ページ番号の初期値
        let currentPage = 0; // 初期ページを1に変更
        let productsData = []; // 全ての商品データを保持するリスト

        // 商品を追加する関数
        function loadMoreProducts() {
            currentPage++; // ページ番号をインクリメント

            // AJAXリクエスト
            $.ajax({
                url: `?ajax=1&page=${currentPage}`, // ページ番号を含むURL
                type: 'GET',
                success: function(response) {
                    if (response.error) {
                        alert(response.error);
                        return;
                    }
                    productsData = productsData.concat(response.products); // 追加された商品を保存
                    appendProducts(response.products); // 商品を表示
                    checkEndOfData(response.current_page, response.total_pages); // データの終わりを確認
                },
                error: function() {
                    alert('データの読み込みエラー');
                },
            });
        }

        // テーブルに商品を追加
        function appendProducts(products) {
            products.forEach(product => {
                const type2 = product.Type2 ? product.Type2 : ''; // タイプ2が空の場合の考慮
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
        }

        // データが終了したかをチェックし、ボタンとメッセージを更新
        function checkEndOfData(current_page, total_pages) {
            if (current_page >= total_pages) {
                $('#load-more').hide();
                $('.no-more-data').show();
            } else {
                $('#load-more').show();
                $('.no-more-data').hide();
            }
        }

        // リセットボタンを押したときの処理
        $('#reset-button').click(function() {
            $('#search-input').val('');
            $('#product-table tbody tr').show(); // 全ての行を表示
        });

        // 検索ボタンのクリックイベントリスナー
        $('#search-button').click(function() {
            searchTable(); // テーブルの検索
        });

        // テーブルの検索
        function searchTable() {
            const searchKeyword = $('#search-input').val().toUpperCase(); // 大文字変換
            $('#product-table tbody tr').each(function() {
                const sid = $(this).find('td:eq(0)').text().toUpperCase(); // SID
                const name = $(this).find('td:eq(2)').text().toUpperCase(); // 商品名
                if (sid.includes(searchKeyword) || name.includes(searchKeyword)) {
                    $(this).show(); // 一致したら表示
                } else {
                    $(this).hide(); // 一致しないなら非表示
                }
            });
        }

        // 更新ボタンをクリックしたときの処理
        $('#refresh').click(function() {
            const currentTime = new Date();
            const formattedTime = currentTime.toLocaleString(); // 現在時刻を表示
            $('#last-updated').text('最終更新: ' + formattedTime);

            currentPage = 1; // ページをリセット
            $('#product-table tbody').empty(); // テーブルの内容をクリア
            productsData = []; // 商品データをリセット
            loadMoreProducts(); // 商品を再読み込み
        });

        // テーブルのフィルター
        function filterProducts() {
            const searchName = $('#search-name').val().toUpperCase(); // 商品名の検索
            const selectedGenders = $('#gender-filters input:checked').map(function() {
                return $(this).val().toUpperCase(); // 選択された性別
            }).get();

            const selectedTypes = $('#type-filters input:checked').map(function() {
                return $(this).val().toUpperCase(); // 選択されたポケモンのタイプ
            }).get();

            $('#product-table tbody tr').each(function() {
                const name = $(this).find('td:eq(2)').text().toUpperCase(); // 商品名
                const gender = $(this).find('td:eq(6)').text().toUpperCase(); // 性別
                const type1 = $(this).find('td:eq(4)').text().toUpperCase(); // タイプ1
                const type2 = $(this).find('td:eq(5)').text().toUpperCase(); // タイプ2

                const matchesName = name.includes(searchName);
                const matchesGender = selectedGenders.length === 0 || selectedGenders.includes(gender);
                const matchesType = selectedTypes.length === 0 || selectedTypes.includes(type1) || selectedTypes.includes(type2);

                if (matchesName && matchesGender && matchesType) {
                    $(this).show(); // フィルタに一致したら表示
                } else {
                    $(this).hide(); // フィルタに一致しないなら非表示
                }
            });
        }

// フィルターの変更イベントリスナー
$('#search-name').on('input', updateTable); // 商品名のフィルタリング
$('#gender-filters input').on('change', updateTable); // 性別のフィルタリング
$('#type-filters input').on('change', updateTable); // タイプのフィルタリング

// 現在のフィルターを適用してテーブルを更新
function updateTable() {
    filterProducts();
    sortTable();
}

// フィルター関数
function filterProducts() {
    const searchName = $('#search-name').val().toUpperCase(); // 商品名の検索
    const selectedGenders = $('#gender-filters input:checked').map(function() {
        return $(this).val().toUpperCase(); // 選択された性別
    }).get();

    const selectedTypes = $('#type-filters input:checked').map(function() {
        return $(this).val().toUpperCase(); // 選択されたポケモンのタイプ
    }).get();

    $('#product-table tbody tr').each(function() {
        const name = $(this).find('td:eq(2)').text().toUpperCase(); // 商品名
        const gender = $(this).find('td:eq(6)').text().toUpperCase(); // 性別
        const type1 = $(this).find('td:eq(4)').text().toUpperCase(); // タイプ1
        const type2 = $(this).find('td:eq(5)').text().toUpperCase(); // タイプ2

        const matchesName = name.includes(searchName);
        const matchesGender = selectedGenders.length === 0 || selectedGenders.includes(gender);
        const matchesType = selectedTypes.length === 0 || selectedTypes.includes(type1) || selectedTypes.includes(type2);

        if (matchesName && matchesGender && matchesType) {
            $(this).show(); // フィルタに一致したら表示
        } else {
            $(this).hide(); // フィルタに一致しないなら非表示
        }
    });
}


        // ソート関数
        function sortTable(columnIndex, isAscending) {
            const rows = $('#product-table tbody tr').get(); // テーブルの行を取得

            rows.sort(function(a, b) {
                const valueA = $(a).find(`td:eq(${columnIndex})`).text();
                const valueB = $(b).find(`td:eq(${columnIndex})`).text();

                if (isAscending) {
                    return valueA.localeCompare(valueB, 'ja'); // 昇順ソート
                } else {
                    return valueB.localeCompare(valueA, 'ja'); // 降順ソート
                }
            });

            $.each(rows, function(index, row) {
                $('#product-table tbody').append(row); // ソートされた行を再配置
            });
        }

        // ソートボタンのクリックイベントリスナー
        $('#sort-name-asc').click(function() {
            sortTable(2, true); // 名前の昇順
        });

        $('#sort-name-desc').click(function() {
            sortTable(2, false); // 名前の降順
        });

        $('#sort-price-asc').click(function() {
            sortTable(7, true); // 価格の昇順
        });

        $('#sort-price-desc').click(function() {
            sortTable(7, false); // 価格の降順
        });

        $('#sort-inventory-asc').click(function() {
            sortTable(8, true); // 在庫の少ない順
        });

        $('#sort-inventory-desc').click(function() {
            sortTable(8, false); // 在庫の多い順
        });

        // ページのロード時
        $(document).ready(function() {
            const currentTime = new Date();
            const formattedTime = currentTime.toLocaleString(); // 現在時刻を表示
            $('#last-updated').text('最終更新: ' + formattedTime);

            loadMoreProducts(); // 初期商品を読み込み
        });

        
    </script>
</body>

</html>