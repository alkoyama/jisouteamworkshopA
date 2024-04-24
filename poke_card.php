<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokemon Information</title>
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
            width: 200px;
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
    <h1 class="text-center">Pokemon Information</h1>
    
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
        <!-- 名前の昇順・降順ボタン -->
        <button class="btn btn-primary" id="sort-name-asc">名前の昇順</button>
        <button class="btn btn-primary" id="sort-name-desc">名前の降順</button>
    
        <!-- 価格の昇順・降順ボタンを追加 -->
        <button class="btn btn-secondary" id="sort-price-asc">価格の昇順</button>
        <button class="btn btn-secondary" id="sort-price-desc">価格の降順</button>
    </div>

    <div class="row" id="pokemon-container">
        <!-- 最初の5個を表示 -->
    </div>
    
    <div class="text-center mt-3">
        <button class="btn btn-primary" id="load-more">さらに読み込む</button>
    </div>
</div>

<!-- カートの領域 -->
<div id="cart">
    <h2 class="text-center">カート</h2>
    <ul id="cart-items"></ul>
</div>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
var pokemonData = <?php 
    $json_data = file_get_contents('pokemon_data.json');
    $pokemon_data = json_decode($json_data, true);
    echo json_encode($pokemon_data); 
?>; // JSON データを JavaScript に取り込む

var offset = 5; // 最初の5個を表示
var cartItems = []; // カートに追加された商品の情報を保持する配列
var filteredPokemon = pokemonData; // フィルターされたポケモンのリスト

function sortPokemon(type, order) {
    if (type === 'name') {
        if (order === 'asc') {
            filteredPokemon.sort((a, b) => a.Name.localeCompare(b.Name, 'ja'));
        } else if (order === 'desc') {
            filteredPokemon.sort((a, b) => b.Name.localeCompare(a.Name, 'ja'));
        }
    } else if (type === 'price') {
        if (order === 'asc') {
            filteredPokemon.sort((a, b) => a.Price - b.Price); // 価格の昇順
        } else if (order === 'desc') {
            filteredPokemon.sort((a, b) => b.Price - a.Price); // 価格の降順
        }
    }

    var container = $('#pokemon-container');
    container.empty(); // 既存の表示をクリア
    offset = 5; // オフセットをリセット
    displayPokemon(filteredPokemon.slice(0, offset)); // ソート後のポケモンを再表示
}

$(document).ready(function() {
    // 最初の5個のポケモンを表示
    displayPokemon(filteredPokemon.slice(0, offset));

    // "さらに読み込む" ボタンがクリックされたときの処理
    $('#load-more').on('click', function() {
        if (offset < filteredPokemon.length) {
            var nextPokemon = filteredPokemon.slice(offset, offset + 5);
            displayPokemon(nextPokemon);
            offset += 5;
        } else {
            alert('すべてのポケモンを読み込みました。');
        }
    });

    // 名前の昇順・降順ボタンのクリックイベント
    $('#sort-name-asc').on('click', function() {
        sortPokemon('name', 'asc'); // 名前の昇順
    });

    $('#sort-name-desc').on('click', function() {
        sortPokemon('name', 'desc'); // 名前の降順
    });

    // 価格の昇順・降順ボタンのクリックイベント
    $('#sort-price-asc').on('click', function() {
        sortPokemon('price', 'asc'); // 価格の昇順
    });

    $('#sort-price-desc').on('click', function() {
        sortPokemon('price', 'desc'); // 価格の降順
    });

    // タイプフィルターの変更処理
    $('#type-filters input').on('change', function() {
        applyFilters();
    });
});


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
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" placeholder="個数" aria-label="個数" aria-describedby="basic-addon2" id="quantity-${pokemon.PID}" value="0" min="0">
                        <button class="btn btn-primary" type="button" onclick="addToCart('${pokemon.PID}', '${pokemon.Name}')">カートに追加</button>
                    </div>
                </div>
            `);
        });
    }

// カートに商品を追加する関数
function addToCart(pid, name) {
    var quantity = parseInt($('#quantity-' + pid).val()); // 文字列を整数に変換
    if (quantity <= 0) {
        alert('正しい個数を入力してください。');
        return;
    }

    // カート内に同じ商品があるかをチェック
    var existingItem = cartItems.find(item => item.pid === pid);

    if (existingItem) {
        // 既存の商品がある場合、個数を追加
        existingItem.quantity += quantity;
    } else {
        // 新しい商品を追加
        cartItems.push({ pid, name, quantity });
    }

    updateCartDisplay(); // カートの表示を更新
    alert(name + ' を ' + quantity + ' 個カートに追加しました。');
}

// カートの表示を更新する関数
function updateCartDisplay() {
    var cartList = $('#cart-items');
    cartList.empty(); // カートの内容を一旦クリア
    cartItems.forEach(item => {
        cartList.append(`
            <li>
                ${item.name} 
                <input type="number" min="1" value="${item.quantity}" 
                       data-pid="${item.pid}" class="cart-quantity-input">
            </li>
        `);
    });

    // カート内の個数変更用のイベントリスナーを追加
    $('.cart-quantity-input').on('input', function() {
        var pid = $(this).data('pid');
        var newQuantity = parseInt($(this).val());

        if (isNaN(newQuantity) || newQuantity < 1) {
            alert('個数は1以上にしてください。');
            return;
        }

        var item = cartItems.find(i => i.pid === pid);
        if (item) {
            item.quantity = newQuantity; // カート内の個数を更新
        }

        updateCartDisplay(); // カートの表示を再更新
    });
}
</script>

</body>
</html>
