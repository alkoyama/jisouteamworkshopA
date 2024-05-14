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

// データを取得するSQLクエリ
$sql = 'SELECT 
            product_stock.SID,
            product_stock.PID,
            poke_info.Name,
            poke_type1.type_name AS Type1,  -- poke_type1を参照
            poke_type2.type_name AS Type2,  -- poke_type2を参照
            product_stock.Gender,
            product_stock.Price,
            product_stock.Inventory,
            poke_graphics.path AS Image_path
        FROM 
            product_stock
        JOIN 
            poke_info ON product_stock.PID = poke_info.PID
        LEFT JOIN 
            poke_graphics ON poke_info.GID = poke_graphics.GID
        LEFT JOIN 
            poke_type AS poke_type1 ON poke_type1.TID = poke_info.Type1
        LEFT JOIN 
            poke_type AS poke_type2 ON poke_type2.TID = poke_info.Type2';

// クエリを実行
$statement = $pdo->prepare($sql);
$statement->execute();

// 結果を配列として取得
$results = $statement->fetchAll(PDO::FETCH_ASSOC);

// JSON形式に変換
$json_data = json_encode($results);

// JavaScriptで利用できる形式で出力
echo "<script>";
echo "var pokemonData = {$json_data};";

// フィルターとソートのJavaScript関数を出力
echo "
function filterByName() {
    var searchValue = document.getElementById('search-name').value.toLowerCase();
    var filteredData = pokemonData.filter(function(item) {
        return item.Name.toLowerCase().includes(searchValue);
    });
    displayData(filteredData);
}

function filterByGender(gender) {
    var filteredData = pokemonData.filter(function(item) {
        return item.Gender === gender || gender === 'all';
    });
    displayData(filteredData);
}

function filterByType(type) {
    var filteredData = pokemonData.filter(function(item) {
        return item.Type1 === type || item.Type2 === type;
    });
    displayData(filteredData);
}

function sortData(property, order) {
    var sortedData = pokemonData.slice(0);
    sortedData.sort(function(a, b) {
        if (order === 'asc') {
            return a[property] > b[property] ? 1 : -1;
        } else {
            return a[property] < b[property] ? 1 : -1;
        }
    });
    displayData(sortedData);
}

function displayData(data) {
    // データを表示するコードをここに追加する
}
";
echo "</script>";

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>在庫商品一覧</title>
    <link rel="stylesheet" href="./css/order_7thA.css">
    <link rel="stylesheet" href="./css/stock_management_7thA.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
       
    </style>
</head>

<body>
    <h1>商品在庫管理</h1>
    <div class="container">
        <!-- 通知メッセージを表示するためのエリア -->
        <div id="notification" class="notification"></div>


        <!-- フィルターとソート -->
        <div class="filter-sort-section">
            <h3 class="text-left">文字列でさがす</h3>
            <div class="mt-3">
                <input type="text" id="search-name" class="form-control large-input" placeholder="商品名で検索" />
            </div>
            <hr>
            <h3 class="text-left">genderでさがす</h3>
            <div class="mt-3" id="gender-filters">
                <label><input type="checkbox" value="male" onclick="filterByGender('male')"> オスポケモン</label>
                <label><input type="checkbox" value="female" onclick="filterByGender('female')"> メスポケモン</label>
                <label><input type="checkbox" value="unknown" onclick="filterByGender('unknown')"> せいべつふめい</label>
                <label><input type="checkbox" value="egg" onclick="filterByGender('egg')"> タマゴ</label>
                <label><input type="checkbox" value="item" onclick="filterByGender('item')"> どうぐ</label>
                <label><input type="checkbox" value="ball" onclick="filterByGender('ball')"> ボール</label>
            </div>
            <hr>
            <h3 class="text-left">ポケモンのタイプでさがす</h3>
            <div class="mt-3" id="type-filters">
                <label><input type="checkbox" value="ノーマル" onclick="filterByType('ノーマル')"> ノーマル</label>
                <label><input type="checkbox" value="ほのお" onclick="filterByType('ほのお')"> ほのお</label>
                <label><input type="checkbox" value="みず" onclick="filterByType('みず')"> みず</label>
                <label><input type="checkbox" value="でんき" onclick="filterByType('でんき')"> でんき</label>
                <label><input type="checkbox" value="くさ" onclick="filterByType('くさ')"> くさ</label>
                <label><input type="checkbox" value="こおり" onclick="filterByType('こおり')"> こおり</label>
                <label><input type="checkbox" value="かくとう" onclick="filterByType('かくとう')"> かくとう</label>
                <label><input type="checkbox" value="どく" onclick="filterByType('どく')"> どく</label>
                <label><input type="checkbox" value="じめん" onclick="filterByType('じめん')"> じめん</label>
                <label><input type="checkbox" value="ひこう" onclick="filterByType('ひこう')"> ひこう</label>
                <label><input type="checkbox" value="エスパー" onclick="filterByType('エスパー')"> エスパー</label>
                <label><input type="checkbox" value="むし" onclick="filterByType('むし')"> むし</label>
                <label><input type="checkbox" value="いわ" onclick="filterByType('いわ')"> いわ</label>
                <label><input type="checkbox" value="ゴースト" onclick="filterByType('ゴースト')"> ゴースト</label>
                <label><input type="checkbox" value="ドラゴン" onclick="filterByType('ドラゴン')"> ドラゴン</label>
                <label><input type="checkbox" value="あく" onclick="filterByType('あく')"> あく</label>
                <label><input type="checkbox" value="はがね" onclick="filterByType('はがね')"> はがね</label>
                <label><input type="checkbox" value="フェアリー" onclick="filterByType('フェアリー')"> フェアリー</label>
            </div>
            <hr>
            <h3 class="text-left">ソートする</h3>
            <div class="text-center mt-3">
                <button class="btn btn-primary" onclick="sortData('Name', 'asc')">アイウエオ順</button>
                <button class="btn btn-primary" onclick="sortData('Name', 'desc')">アイウエオ逆順</button>
                <button class="btn btn-secondary" onclick="sortData('Price', 'asc')">価格の安い順</button>
                <button class="btn btn-secondary" onclick="sortData('Price', 'desc')">価格の高い順</button>
                <button class="btn btn-warning" onclick="sortData('Inventory', 'asc')">在庫の少ない順</button>
                <button class="btn btn-warning" onclick="sortData('Inventory', 'desc')">在庫の多い順</button>
            </div>
            <button class="btn btn-danger" id="reset-button" onclick="resetFilters()">リセット</button>
            <a href="http://localhost/jisouteamworkshopA/Integration_Hub_7th.php" class="back-btn">
                <button id="back-to-admin" class="btn">
                    <i class="fa fa-cog" aria-hidden="true"></i>
                </button>
                <div id="hover-message" class="hidden">管理画面へ</div>
            </a>


        </div>

        <div class="container_st">
            <div class="row">
                <div class="update-container">
                    <div id="last-updated"></div>
                    <button id="refresh" type="button" onclick="refreshData()">最新の情報を取得</button>
                    <div id="update-notification" class="notification hidden"></div>
                </div>
            </div>
            <table border="1" id="product-table">
                <thead>
                    <tr>
                        <th>SID</th>
                        <th>PID</th>
                        <th>商品名</th>
                        <th>画 像</th>
                        <th>タイプ1</th>
                        <th>タイプ2</th>
                        <th>分 類</th>
                        <th>価 格</th>
                        <th>在 庫</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- データがここに追加されます -->
                </tbody>
            </table>

            <div class="button-center">
                <button id="load-more" onclick="loadMoreProducts()">さらに読み込む</button>
            </div>
            <div class="no-more-data">これ以上のデータはありません</div>
            <div class="bottom-margin"></div>
        </div>

        <script>
            var displayedData = 10; // 初期表示するデータ数
            var increment = 10; // 追加で表示するデータ数


            // データを表示する関数
            function displayData(data) {
                var tableBody = document.querySelector('#product-table tbody');
                tableBody.innerHTML = ''; // テーブルの内容をクリア

                var searchValue = document.getElementById('search-name').value.toLowerCase();
                var genderFilters = Array.from(document.querySelectorAll('#gender-filters input:checked')).map(function(checkbox) {
                    return checkbox.value;
                });
                var typeFilters = Array.from(document.querySelectorAll('#type-filters input:checked')).map(function(checkbox) {
                    return checkbox.value;
                });

                var filteredData = data.filter(function(item) {
                    return item.Name.toLowerCase().includes(searchValue) &&
                        (genderFilters.length === 0 || genderFilters.includes(item.Gender)) &&
                        (typeFilters.length === 0 || (item.Type1 !== null && typeFilters.includes(item.Type1)) || (item.Type2 !== null && typeFilters.includes(item.Type2)));
                });

                filteredData.slice(0, displayedData).forEach(function(item) {
                    var row = document.createElement('tr');
                    row.innerHTML = `
            <td>${item.SID}</td>
            <td>${item.PID}</td>
            <td>${item.Name}</td>
            <td><img src="${item.Image_path}" alt="商品画像" width="100" height="100"></td>
            <td>${item.Type1 || ''}</td> <!-- タイプが null の場合は空白表示 -->
            <td>${item.Type2 || ''}</td> <!-- タイプが null の場合は空白表示 -->
            <td>${item.Gender}</td>
            
            <!-- 価格のセル -->
            <td>
                <span class="price-display">${item.Price}</span>
                <input type="text" class="price-input" style="display: none;">
                <button class="edit-price-btn" onclick="togglePriceEdit(this)">
                    <i class="fas fa-pencil-alt"></i> <!-- 編集アイコン -->
                </button>
                <button class="save-price-btn" onclick="savePrice(this)" style="display: none;">
                    <i class="fas fa-save"></i> <!-- 保存アイコン -->
                </button>
            </td>

            <!-- 在庫のセル -->
            <td>
                <span class="inventory-display">${item.Inventory}</span>
                <input type="text" class="inventory-input" style="display: none;">
                <button class="edit-inventory-btn" onclick="toggleInventoryEdit(this)">
                    <i class="fas fa-pencil-alt"></i> <!-- 編集アイコン -->
                </button>
                <button class="save-inventory-btn" onclick="saveInventory(this)" style="display: none;">
                    <i class="fas fa-save"></i> <!-- 保存アイコン -->
                </button>
            </td>
        `;
                    tableBody.appendChild(row);
                });

                // データを全て表示したらさらに読み込むボタンを非表示にする
                if (filteredData.length <= displayedData) {
                    document.getElementById('load-more').style.display = 'none';
                    document.querySelector('.no-more-data').style.display = 'block';
                } else {
                    document.getElementById('load-more').style.display = 'block';
                    document.querySelector('.no-more-data').style.display = 'none';
                }
            }

            // 初期表示
            displayData(pokemonData);

            // さらに読み込むボタンが押された時の処理
            function loadMoreProducts() {
                displayedData += increment;
                displayData(pokemonData);
            }

            // フィルターが変更された時の処理
            function applyFilters() {
                displayedData = 10;
                displayData(pokemonData);
            }

            // フィルターの変更イベントを追加
            document.getElementById('search-name').addEventListener('input', applyFilters);
            document.querySelectorAll('#gender-filters input[type="checkbox"]').forEach(function(checkbox) {
                checkbox.addEventListener('change', applyFilters);
            });
            document.querySelectorAll('#type-filters input[type="checkbox"]').forEach(function(checkbox) {
                checkbox.addEventListener('change', applyFilters);
            });

            // 最新の情報を取得する
            function refreshData() {
                // サーバーから最新のデータを取得するためにページをリロードする
                location.reload();
            }

            // 時間の表示ページのロード時
            $(document).ready(function() {
                const currentTime = new Date();
                const formattedTime = currentTime.toLocaleString(); // 現在時刻を表示
                $('#last-updated').text('最終更新: ' + formattedTime);

                loadMoreProducts(); // 初期商品を読み込み
            });


            /////////////////////////////////////

            // 価格の編集
            // 価格の編集をトグルする関数
            function togglePriceEdit(button) {
                var row = button.parentNode.parentNode;
                var SID = row.querySelector('td:first-child').textContent;
                var priceDisplay = row.querySelector('.price-display');
                var priceInput = row.querySelector('.price-input');
                var editBtn = row.querySelector('.edit-price-btn');
                var saveBtn = row.querySelector('.save-price-btn');

                // 表示と入力フィールドを切り替える
                priceDisplay.style.display = 'none';
                priceInput.style.display = 'inline-block';
                editBtn.style.display = 'none';
                saveBtn.style.display = 'inline-block';

                // 保存ボタンに商品IDをデータ属性としてセット
                saveBtn.dataset.sid = SID;
            }

            // 価格を保存する関数
            function savePrice(button) {
                var SID = button.dataset.sid;
                var row = button.parentNode.parentNode;
                var priceDisplay = row.querySelector('.price-display');
                var priceInput = row.querySelector('.price-input');
                var editBtn = row.querySelector('.edit-price-btn');
                var saveBtn = row.querySelector('.save-price-btn');

                // 入力された価格を取得し、表示を更新する
                var newPrice = priceInput.value;
                priceDisplay.textContent = newPrice;

                // 表示と入力フィールドを切り替える
                priceDisplay.style.display = 'inline-block';
                priceInput.style.display = 'none';
                editBtn.style.display = 'inline-block';
                saveBtn.style.display = 'none';

                // 保存した価格をデータベースに反映するためのAjaxリクエストを送信する
                var formData = new FormData();
                formData.append('SID', SID);
                formData.append('Price', newPrice);

                // Ajaxリクエスト
                $.ajax({
                    url: 'stock_update_price.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        showNotification('価格の変更を登録しました', 'success');
                        console.log(data);
                    },
                    error: function(error) {
                        showNotification('Error updating price', 'error');
                        console.error('There was a problem with your fetch operation:', error);
                    }
                });
            }

            // 在庫の編集をトグルする関数
            function toggleInventoryEdit(button) {
                var row = button.parentNode.parentNode;
                var SID = row.querySelector('td:first-child').textContent;
                var inventoryDisplay = row.querySelector('.inventory-display');
                var inventoryInput = row.querySelector('.inventory-input');
                var editBtn = row.querySelector('.edit-inventory-btn');
                var saveBtn = row.querySelector('.save-inventory-btn');

                // 表示と入力フィールドを切り替える
                inventoryDisplay.style.display = 'none';
                inventoryInput.style.display = 'inline-block';
                editBtn.style.display = 'none';
                saveBtn.style.display = 'inline-block';

                // 保存ボタンに商品IDをデータ属性としてセット
                saveBtn.dataset.sid = SID;
            }

            // 在庫を保存する関数
            function saveInventory(button) {
                var SID = button.dataset.sid;
                var row = button.parentNode.parentNode;
                var inventoryDisplay = row.querySelector('.inventory-display');
                var inventoryInput = row.querySelector('.inventory-input');
                var editBtn = row.querySelector('.edit-inventory-btn');
                var saveBtn = row.querySelector('.save-inventory-btn');

                // 入力された在庫を取得し、表示を更新する
                var newInventory = inventoryInput.value;
                inventoryDisplay.textContent = newInventory;

                // 表示と入力フィールドを切り替える
                inventoryDisplay.style.display = 'inline-block';
                inventoryInput.style.display = 'none';
                editBtn.style.display = 'inline-block';
                saveBtn.style.display = 'none';

                // 保存した在庫をデータベースに反映するためのAjaxリクエストを送信する
                var formData = new FormData();
                formData.append('SID', SID);
                formData.append('Inventory', newInventory);

                // Ajaxリクエスト
                $.ajax({
                    url: 'stock_update_inventory.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        showNotification('在庫数の変更が出来ました', 'success');
                    },
                    error: function(error) {
                        showNotification('Error updating inventory', 'error');
                        console.error('There was a problem with your fetch operation:', error);
                    }
                });
            }
            // 通知メッセージを表示する関数
            function showNotification(message, type) {
                var notification = document.getElementById('notification');
                notification.textContent = message;
                notification.className = 'notification ' + type;
                notification.style.display = 'block';
                setTimeout(function() {
                    notification.style.display = 'none';
                }, 3000); // 3秒後に通知を非表示にする
            }


            // 左側検索とソート固定
            $(window).on('scroll', function() {
                var scrollTop = $(window).scrollTop();
                var filterSortSection = $('.filter-sort-section');
                var offsetTop = 10; // 適切な位置に調整
                if (scrollTop > offsetTop) {
                    filterSortSection.css('position', 'fixed');
                    filterSortSection.css('top', '30px'); // 固定位置の調整
                    filterSortSection.css('height', 'calc(100% - 30px)'); // 固定時の高さ調整
                } else {
                    filterSortSection.css('position', 'static');
                    filterSortSection.css('height', 'auto'); // デフォルトの高さに戻す
                }
            });

            // リセットボタンがクリックされた時の処理
            document.getElementById('reset-button').addEventListener('click', function() {
                // 検索ボックスの値をクリア
                document.getElementById('search-name').value = '';

                // ジェンダーフィルターをクリア
                document.querySelectorAll('#gender-filters input[type="checkbox"]').forEach(function(checkbox) {
                    checkbox.checked = false;
                });

                // タイプフィルターをクリア
                document.querySelectorAll('#type-filters input[type="checkbox"]').forEach(function(checkbox) {
                    checkbox.checked = false;
                });

                // データを再表示
                displayedData = 10; // 表示するデータ数を初期値にリセット
                displayData(pokemonData);
            });
            // 最新情報を取得する関数
            function refreshData() {
                // ここに最新情報を取得する処理を追加する

                // 通知を表示する
                displayNotification("最新情報を取得しました。");
            }

            // 通知を表示する関数
            function displayNotification(message) {
                var notificationElement = document.getElementById('notification');
                notificationElement.innerHTML = message;
                notificationElement.style.display = 'block';

                // 一定時間後に通知を非表示にする
                setTimeout(function() {
                    notificationElement.style.display = 'none';
                }, 3000); // 3秒間表示した後、非表示にする
            }

            // 最新の情報を取得
            document.getElementById("refresh").addEventListener("click", function() {
                // データベースとの通信をシミュレートする
                var success = Math.random() < 0.5; // 成功率50%を仮定する

                var notification = document.getElementById("update-notification");

                if (success) {
                    notification.textContent = "最新の情報を取得しました。";
                    notification.classList.remove("update-error");
                    notification.classList.add("update-success");
                } else {
                    notification.textContent = "情報の取得に失敗しました。もう一度試してください。";
                    notification.classList.remove("update-success");
                    notification.classList.add("update-error");
                }

                notification.classList.remove("hidden");
            });
            // 管理画面へ戻る
            document.getElementById('back-to-admin').addEventListener('mouseover', function() {
                document.getElementById('hover-message').style.display = 'block';
            });

            document.getElementById('back-to-admin').addEventListener('mouseout', function() {
                document.getElementById('hover-message').style.display = 'none';
            });
        </script>


</body>


</html>