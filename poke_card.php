<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品一覧</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-HmfI2l18e9VjmbK3Qt1wbPHL5Lvfzq7oFy98GYnLggSbG6X7I5k2wAp/3MhiZdTO" crossorigin="anonymous">
    <style>
        body {
            width: 60%;
            margin: 0 auto;
        }
        .pokemon-card {
            width: calc(15% - 20px);
            margin: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
            display: inline-block;
        }
        .pokemon-image {
            width: 100px;
            height: 100px;
            margin: 0 auto;
        }
        #cart {
            position: fixed;
            top: 0;
            right: 20px;
            width: 300px; /* 横幅を拡大 */
            background-color: #f8f9fa;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        #cart h2 {
            margin-top: 0;
            margin-bottom: 10px;
        }
        #cart-items {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        #type-filters label {
        display: inline-block;
        width: calc(16.66% - 10px); /* 横6つに並べるために幅を調整 */
        margin-bottom: 10px;
    }

    @media (max-width: 768px) {
        #type-filters label {
            width: calc(50% - 10px); /* レスポンシブ対応：画面幅が狭い場合は横2つに並べる */
        }
    }
    </style>
</head>
<body>

<div class="container">
    <h1 class="text-center">商品一覧</h1>
    
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
    
    <div class="text-center mt-3">
        <button class="btn btn-primary" id="load-more">さらに読み込む</button>
    </div>
</div>

<!-- カート -->
<div id="cart">
    <h2 class="text-center">カート</h2>
    <ul id="cart-items"></ul>

    <!-- 個数更新ボタン -->
    <button class="btn btn-primary" id="update-cart-quantities">個数更新</button>

    <!-- 決済へ進むボタン -->
    <button class="btn btn-success" id="proceed-to-payment">決済へ進む</button>
</div>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
<?php
// データベース接続情報
$dsn = 'mysql:host=localhost;dbname=teamworkshop_7tha;charset=utf8mb4';
$username = 'root';
$password = '';

// データベースに接続
try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('データベースに接続できません: ' . $e->getMessage());
}

// データを取得するSQLクエリ
$sql = 'SELECT 
            product_stock.SID,
            product_stock.PID,
            poke_info.Name,
            poke_type.type_name AS Type1,
            (SELECT type_name FROM poke_type WHERE poke_type.TID = poke_info.Type2) AS Type2,
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
            poke_type ON poke_type.TID = poke_info.Type1';

        // クエリを実行
        $statement = $pdo->prepare($sql);
        $statement->execute();

        // 結果を配列として取得
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        // JSON形式に変換
        $json_data = json_encode($results);

        // JavaScriptで利用できる形式で出力
        echo "var pokemonData = {$json_data};";
        ?>


var offset = 5; // 最初の5個を表示
var cartItems = []; // カートに追加された商品の情報を保持する配列
var filteredPokemon = pokemonData; // フィルターされたポケモンのリスト

function sortPokemon(type, order) {
    if (type === 'name') {
        if (order === 'asc') {
            filteredPokemon.sort((a, b) => a.Name.localeCompare(b.Name, 'ja'));
        } else {
            filteredPokemon.sort((a, b) => b.Name.localeCompare(a.Name, 'ja'));
        }
    } else if (type === 'price') {
        if (order === 'asc') {
            filteredPokemon.sort((a, b) => a.Price - b.Price);
        } else {
            filteredPokemon.sort((a, b) => b.Price - a.Price);
        }
    } else if (type === 'inventory') {
        if (order === 'asc') {
            filteredPokemon.sort((a, b) => a.Inventory - b.Inventory); // 在庫の昇順
        } else {
            filteredPokemon.sort((a, b) => b.Inventory - a.Inventory); // 在庫の降順
        }
    }

    var container = $('#pokemon-container');
    container.empty(); // 既存の表示をクリア
    offset = 5; // オフセットをリセット
    displayPokemon(filteredPokemon.slice(0, offset)); // ソート後のポケモンを再表示
}

function applyFilters() {
    var selectedTypes = [];
    $('#type-filters input:checked').each(function() {
        selectedTypes.push($(this).val());
    });

    // フィルターが何も選択されていない場合は、すべてのポケモンを表示
    if (selectedTypes.length === 0) {
        filteredPokemon = pokemonData;
    } else {
        filteredPokemon = pokemonData.filter(function(pokemon) {
            // ポケモンが選択されたすべてのタイプを持っているかをチェック
            var pokemonTypes = [pokemon.Type1];
            if (pokemon.Type2) {
                pokemonTypes.push(pokemon.Type2);
            }
            // ポケモンのタイプにすべての選択されたタイプが含まれるかを確認
            return selectedTypes.every(function(type) {
                return pokemonTypes.includes(type);
            });
        });
    }

    var container = $('#pokemon-container');
    container.empty(); // 既存の表示をクリア
    offset = 5; // リセット
    displayPokemon(filteredPokemon.slice(0, offset)); // フィルター後のポケモンを表示
}


function displayPokemon(pokemonArray) {
    var container = $('#pokemon-container');
    pokemonArray.forEach(function(pokemon) {
        container.append(`
            <div class="pokemon-card">
                <img class="pokemon-image" src="${pokemon.Image_path}" alt="${pokemon.Name}">
                <p>${pokemon.Name}</p>
                <p>タイプ1: ${pokemon.Type1}</p>
                <p>タイプ2: ${(pokemon.Type2 || '-')}</p>
                <p>ねだん: ${pokemon.Price}</p>
                <p id="inventory-${pokemon.SID}">在庫: ${pokemon.Inventory}</p> <!-- 在庫表示に ID を追加 -->
                <div class="input-group mb-3">
                    <input type="number" class="form-control" style="width: 50px;" placeholder="個数" aria-label="個数" aria-describedby="basic-addon2" id="quantity-${pokemon.SID}" value="0" min="0">
                    <button class="btn btn-primary" type="button" onclick="addToCart('${pokemon.SID}', '${pokemon.Name}')">カートに追加</button>
                </div>
            </div>
        `);
    });
}

$(document).ready(function() {
    // 最初にカートの内容を更新してボタンの状態をチェック
    updateCartDisplay();

    // 最初に5個のポケモンを表示
    displayPokemon(filteredPokemon.slice(0, offset));

    // "さらに読み込む" ボタンの処理
    $('#load-more').on('click', function() {
        if (offset < filteredPokemon.length) {
            var nextPokemon = filteredPokemon.slice(offset, offset + 5);
            displayPokemon(nextPokemon);
            offset += 5;
        } else {
            alert('すべてのポケモンを読み込みました。');
        }
    });

    // 名前の昇順・降順
    $('#sort-name-asc').on('click', function() {
        sortPokemon('name', 'asc');
    });

    $('#sort-name-desc').on('click', function() {
        sortPokemon('name', 'desc');
    });

    // 価格の昇順・降順
    $('#sort-price-asc').on('click', function() {
        sortPokemon('price', 'asc');
    });

    $('#sort-price-desc').on('click', function() {
        sortPokemon('price', 'desc');
    });

    // 在庫の昇順・降順のクリックイベント
    $('#sort-inventory-asc').on('click', function() {
        sortPokemon('inventory', 'asc'); // 在庫の昇順
    });

    $('#sort-inventory-desc').on('click', function() {
        sortPokemon('inventory', 'desc'); // 在庫の降順
    });

    // タイプフィルターの変更処理
    $('#type-filters input').on('change', function() {
        applyFilters(); 
    });

    // 個数更新ボタンのクリックイベント
    $(document).ready(function() {

        $('#update-cart-quantities').on('click', function() {
            var hasInvalidUpdate = false; // 不正な更新があったかどうか
            var hasChanges = false; // 変更があったかどうか

            cartItems.forEach(function(item, index) {
                var newQuantity = parseInt($(`#cart-quantity-${index}`).val());
                var pokemon = pokemonData.find(p => p.SID === item.sid);

                if (newQuantity <= 0) { // 個数が1未満の場合
                    alert('個数は1以上である必要があります。');
                    $(`#cart-quantity-${index}`).val(item.quantity); // 元の個数に戻す
                    hasInvalidUpdate = true; // フラグを立てる
                    return; // 処理を終了
                }

                var availableInventory = pokemon.Inventory + item.quantity; // 利用可能な在庫

                if (newQuantity > availableInventory) { // 在庫を超える場合
                    alert(`${pokemon.Name} の在庫を超える個数は追加できません。`); // 名前を含めたアラート
                    $(`#cart-quantity-${index}`).val(item.quantity); // 元の個数に戻す
                    hasInvalidUpdate = true; // フラグを立てる
                    return; // 処理を終了
                }

                if (newQuantity !== item.quantity) { // 個数が変わったか確認
                    hasChanges = true; // 変更があったフラグ
                    var quantityDifference = newQuantity - item.quantity; // 個数差
                    pokemon.Inventory -= quantityDifference; // 在庫調整

                    // 在庫表示を更新
                    $(`#inventory-${pokemon.SID}`).text(`在庫: ${pokemon.Inventory}`);

                    // カートアイテムの個数を更新
                    item.quantity = newQuantity;
                }
            });

            if (hasInvalidUpdate) {
                return; // フラグが立っている場合、処理を終了
            }

            if (hasChanges) { // 変更があった場合のみ
                // カートの内容を更新
                updateCartDisplay();

                // アラートで個数更新を通知
                alert('個数が更新されました。');
            }
        });
    });
});

    function addToCart(sid, name) {
        var quantity = parseInt($('#quantity-' + sid).val());
        var pokemon = pokemonData.find(p => p.SID === sid);

        if (quantity <= 0) {
            alert('正しい個数を入力してください。');
            return;
        }

        if (quantity > pokemon.Inventory) {
            alert(`${name} の在庫を超える個数は追加できません。`);
            return;
        }

        // カートにすでに同じ商品があるか確認
        var existingItem = cartItems.find(item => item.sid === sid);

        if (existingItem) {
            // 既存の商品の数量を更新
            existingItem.quantity += quantity;
        } else {
            // 新しい商品を追加
            cartItems.push({ sid, name, quantity, price: pokemon.Price, inventory: pokemon.Inventory });
        }

        // 在庫を減らす
        pokemon.Inventory -= quantity;

        // 在庫表示を更新
        $(`#inventory-${pokemon.SID}`).text(`在庫: ${pokemon.Inventory}`);

        // カートの内容を更新
        updateCartDisplay();

        alert(`${name} を ${quantity} 個カートに追加しました。`);
    }

    var grandTotalPrice = 0; // 合計金額の変数を宣言

    function updateCartDisplay() {
        var cartList = $('#cart-items');
        cartList.empty(); // カートをクリア

        grandTotalPrice = 0; // 合計金額をリセット

        if (cartItems.length === 0) {
            // カートが空のときの表示
            cartList.append('<li>カートの中身は空です</li>');

            // ボタンを非表示にする
            $('#update-cart-quantities').hide();
            $('#proceed-to-payment').hide();
        } else {
            cartItems.forEach(function(item, index) {
                var totalPrice = item.price * item.quantity; // 小計
                grandTotalPrice += totalPrice; // 合計金額に加算

                cartList.append(`
                    <li>
                        ${item.name} 
                        <input type="number" class="form-control" style="width: 50px; display: inline-block;" min="1" value="${item.quantity}" id="cart-quantity-${index}"/>
                        ¥${totalPrice.toLocaleString()}
                        <button class="btn btn-danger btn-sm remove-from-cart" data-index="${index}">削除</button>
                    </li>
                `);
            });

            cartList.append(`
                <li>
                    <strong>合計金額: ¥${grandTotalPrice.toLocaleString()}</strong>
                </li>
            `);

            // ボタンを表示
            $('#update-cart-quantities').show();
            $('#proceed-to-payment').show();

            // 削除ボタンのイベントリスナー
            $('.remove-from-cart').on('click', function() {
                var index = $(this).data('index'); // 削除するアイテムのインデックス
                var removedItem = cartItems.splice(index, 1)[0]; // カートから削除されたアイテム
                var pokemon = pokemonData.find(p => p.SID === removedItem.sid);

                pokemon.Inventory += removedItem.quantity; // 在庫を戻す

                // HTML 上の在庫表示を更新
                $(`#inventory-${pokemon.SID}`).text(`在庫: ${pokemon.Inventory}`);

                // カートの内容を更新
                updateCartDisplay();

                alert(`${removedItem.name} をカートから削除しました。`);
            });
        }
    }

    // JavaScript: カート内の商品と合計金額を Payment_7thA.php へ送信
    $('#proceed-to-payment').on('click', function() {
        var form = $('<form></form>'); // 新しいフォームを作成
        form.attr('method', 'POST'); // POST メソッド
        form.attr('action', 'Payment_7thA.php'); // 送信先

        cartItems.forEach(function(item) {
            // アイテムの情報を JSON 形式で送信
            form.append($('<input>').attr({
                type: 'hidden',
                name: 'cartItems[]',
                value: JSON.stringify(item) // JSON データとして送信
            }));
        });

        // 合計金額も追加
        form.append($('<input>').attr({
            type: 'hidden',
            name: 'grand_total_price',
            value: grandTotalPrice
        }));

        $('body').append(form); // フォームをボディに追加
        form.submit(); // フォームを送信
    });



</script>

</body>
</html>
