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

        /* カードのアニメーション */
        @keyframes flipIn {
            0% {
                transform: rotateY(90deg); /* 90度回転 */
                opacity: 0; /* 不透明度を0に */
            }
            100% {
                transform: rotateY(0); /* 回転を0に戻す */
                opacity: 1; /* 不透明度を1に */
            }
        }

        /* カードのスタイル */
        .pokemon-card {
            width: calc(22% - 20px);
            height: 300px; /* 固定の高さを設定 */
            margin: 10px;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.9);
            border: 1px solid #ccc;
            border-radius: 10px;
            text-align: center;
            display: inline-block;
            opacity: 0; /* 初期状態で不透明度を0に */
            animation: flipIn 0.5s ease-in-out; /* アニメーションの設定 */
            animation-fill-mode: forwards; /* アニメーション後に最終状態を維持 */
            transform-origin: center; /* 回転の基準を中心に */
            white-space: nowrap; /* テキストを折り返さない */
            font-size: 0.9vw;
            overflow: hidden; /* コンテンツがカードの高さを超えないようにする */
        }


        /* 画像のサイズを調整して、カード内に収まるようにする */
        .pokemon-image {
            max-width: 90%;
            height: auto;
            margin: 0 20;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        /* 在庫や価格の表示のスタイルを調整 */
        .pokemon-details {
            text-align: left; /* テキストを左揃え */
            padding-top: 10px; /* 上部にパディングを追加 */
        }
        
        /* カートの最大高さを設定し、スクロールを可能にする */
        #cart {
            position: fixed; /* 固定位置 */
            bottom: 550px; /* 下からの距離 */
            right: 20px; /* 右からの距離 */
            width: 300px; /* 横幅 */
            max-height: 300px; /* 最大高さ */
            overflow-y: auto; /* 縦方向のスクロールを可能に */
            background-color: rgba(255, 255, 255, 0.7); /* 背景色 */
            padding: 10px; /* パディング */
            border: 1px solid #ccc; /* 境界線 */
            border-radius: 5px; /* 角を丸める */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* 影を追加 */
            z-index: 1000; /* 重なり順の設定 */
        }

        /* カートの項目を適切に配置し、要素間に余白を設ける */
        #cart-items {
            list-style-type: none; /* リストスタイルを無効に */
            padding: 0; /* パディングをゼロに */
            margin: 0; /* マージンをゼロに */
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

          /* 吹き出しのスタイル */
        .speech-bubble {
            background-image: url('./images/assets/index_fukidashi.png');
            width: 330px; /* 吹き出しの幅 */
            height: 142px; /* 吹き出しの高さ */
            background-size: cover; /* 画像をサイズに合わせる */
            position: fixed; /* 固定位置 */
            bottom: 400px;
            right: 20px; /* 右からの距離 */
        }

        #speechBubbleText {
            text-align: center;
            line-height: 1.5;
        }
        
        /* 立ち絵のスタイル */
        .character {
            background-image: url('./images/assets/index_Iono.png');
            width: 600px; /* 立ち絵の幅 */
            height: 400px; /* 立ち絵の高さ */
            background-size: cover; /* 画像をサイズに合わせる */
            position: fixed; /* 固定位置 */
            bottom: 0; /* カートの下に配置 */
            right: -90px; /* 右からの距離 */
            opacity: 0; /* 透明度を0に設定して非表示にする */
            animation: floatUpDown 2s infinite ease-in-out, fadeIn 1s ease-in; /* アニメーションを適用 */
            animation-fill-mode: forwards; /* アニメーション後に最終状態を維持 */
            overflow: visible;
            z-index: -1;
        }

        @keyframes floatUpDown {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(20px); } /* 上下に10pxふわふわさせる */
        }

        @keyframes fadeIn {
            from { opacity: 0; } /* 透明度を0から開始 */
            to { opacity: 1; } /* 透明度を1に変化させる */
        }

        #type-filters label {
            display: inline-block;
            width: calc(16.66% - 10px); /* 横6つに並べるために幅を調整 */
            margin-bottom: 10px;
        }
        .text-center {
            display: flex;
            justify-content: space-around; /* 中央寄せ */
            margin-left: 10px;
            margin-right: 10px;
            font-size: 1vw;
        }
        .large-input {
            width: 30%; /* 幅をコンテナに合わせる */
            padding: 10px; /* 内側の余白を増やす */
            font-size: 16px; /* フォントサイズを大きくする */
            border: 1px solid #ccc; /* 境界線 */
            border-radius: 5px; /* 角を少し丸める */
        }   
        /* ライトグレーのテキスト用のクラス */
        .light-gray {
            color: lightgray; /* ライトグレーに設定 */
        }
        @media (max-width: 768px) {
            #type-filters label {
                width: calc(50% - 10px); /* レスポンシブ対応：画面幅が狭い場合は横2つに並べる */
            }
        }

        #gender-filters {
            display: flex; /* ラベルをフレックスボックスで均等配置 */
            flex-wrap: wrap; /* ラベルを折り返す */
            justify-content: space-between; /* 均等に配置 */
        }

        #gender-filters label {
            width: calc(16.66% - 10px); /* タイプフィルターと同様の幅 */
            margin-bottom: 10px; /* ラベルの間隔を確保 */
        }

        @media (max-width: 768px) {
            #gender-filters label {
                width: calc(50% - 10px); /* レスポンシブ対応：狭い画面では2つずつ配置 */
            }
        }

        /* 画面幅が小さい場合のフォントサイズ調整 */
        @media (max-width: 768px) {
            .pokemon-card {
                font-size: 0.875rem; /* 小さい画面ではフォントサイズを少し小さくする */
            }
        }

        /* 画面幅が非常に小さい場合のフォントサイズ調整 */
        @media (max-width: 480px) {
            .pokemon-card {
                font-size: 0.75rem; /* スマートフォンの画面に適したサイズ */
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="text-center">商品一覧</h1>
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
    <hr> <!-- タイプフィルターとの間に横線を追加 -->

    <h3 class="text-left">ポケモンのタイプでさがす</h3>
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
    <hr>
    <h3 class="text-left">ソートする</h3>
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
    
        <!-- "さらに読み込む" ボタンの配置を修正 -->
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
    <div class="speech-bubble" id="speechBubbleText"></div>
    <div class="character"></div>


    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.2.3/howler.min.js"></script>
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
        echo "var pokemonData = {$json_data};";
    ?>


    var offset = 8; // 最初の8個を表示
    var cartItems = []; // カートに追加された商品の情報を保持する配列
    var filteredPokemon = pokemonData; // フィルターされたポケモンのリスト

    // 検索フィールドの変更時に検索処理を行う
    $('#search-name').on('input', function() {
        var searchText = $(this).val().toLowerCase(); // 入力されたテキストを小文字に変換
        var container = $('#pokemon-container');
        container.empty(); // 既存の表示をクリア

        // 検索結果を取得
        filteredPokemon = pokemonData.filter(function(pokemon) {
            return pokemon.Name.toLowerCase().includes(searchText); // 名前に検索テキストが含まれているかチェック
        });

        // フィルタリングされたポケモンを表示
        displayPokemon(filteredPokemon.slice(0, offset));
    });


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
        offset = 8; // オフセットをリセット
        displayPokemon(filteredPokemon.slice(0, offset)); // ソート後のポケモンを再表示
    }

    function applyFilters() {
        var searchText = $('#search-name').val().toLowerCase();
        var selectedTypes = [];
        $('#type-filters input:checked').each(function() {
            selectedTypes.push($(this).val());
        });

        var selectedGenders = [];
        $('#gender-filters input:checked').each(function() {
            selectedGenders.push($(this).val());
        });

        // フィルタリングされた結果を生成
        filteredPokemon = pokemonData.filter(function(pokemon) {
            var matchesSearchText = pokemon.Name.toLowerCase().includes(searchText);

            var pokemonTypes = [pokemon.Type1];
            if (pokemon.Type2) {
                pokemonTypes.push(pokemon.Type2);
            }

            var typeMatch = selectedTypes.length === 0 || selectedTypes.every(function(type) {
                return pokemonTypes.includes(type);
            });

            var genderMatch = selectedGenders.length === 0 || selectedGenders.includes(pokemon.Gender);

            return matchesSearchText && typeMatch && genderMatch;
        });

        // データ表示のリセット
        var container = $('#pokemon-container');
        container.empty();
        offset = 8; // フィルタリング後に最初の8個を表示する
        displayPokemon(filteredPokemon.slice(0, offset));
    }

    // ボタンの処理
    $('#load-more').on('click', function() {
        if (offset < filteredPokemon.length) {
            var nextPokemon = filteredPokemon.slice(offset, offset + 8);
            displayPokemon(nextPokemon);
            offset += 8; // 読み込みオフセットを更新
        } else {
            displayMessageWithSound('\nすべての商品を読み込みました！', "./audio/voice/index_008_voice.mp3");
        }
    });

    // フィルター変更時の処理
    $('#type-filters input').on('change', applyFilters);
    $('#gender-filters input').on('change', applyFilters);
    $('#search-name').on('input', applyFilters);



    function getGenderIconPath(gender) {
        switch (gender) {
            case 'male':
                return './images/assets/male.png';
            case 'female':
                return './images/assets/female.png';
            default:
                return '';
        }
    }

    function getClassIconPath(gender) {
        switch (gender) {
            case 'unknown':
                return './images/assets/unknown.png';
            case 'egg':
                return './images/assets/egg.png';
            case 'item':
                return './images/assets/item.png';
            case 'ball':
                return './images/assets/ball.png';
            default:
                return '';
        }
    }

    function getCartIconPath(gender) {
        switch (gender) {
            case 'male':
                return './images/assets/male.png';
            case 'female':
                return './images/assets/female.png';
            case 'unknown':
                return './images/assets/unknown.png';
            case 'egg':
                return './images/assets/egg.png';
            case 'item':
                return './images/assets/item.png';
            case 'ball':
                return './images/assets/ball.png';
            default:
                return '';
        }
    }

    function getClassLabel(gender) {
        switch (gender) {
            case 'unknown':
                return 'せいべつふめい';
            case 'egg':
                return 'タマゴ';
            case 'item':
                return 'どうぐ';
            case 'ball':
                return 'ボール';
            default:
                return '';
        }
    }

    function displayPokemon(pokemonArray) {
        var container = $('#pokemon-container');
        var delay = 0; // アニメーションの遅延を設定するための変数

        pokemonArray.forEach(function(pokemon) {
            var type1Label = pokemon.Type2 ? 'タイプ1' : 'タイプ';
            var type1Display = pokemon.Type1 ? `<p><strong>${type1Label}</strong></p><p>&nbsp;&nbsp;&nbsp;&nbsp;${pokemon.Type1}</p>` : `<div style="height: 50px;"></div>`;
            var type2Display = pokemon.Type2 ? `<p><strong>タイプ2</strong></p><p>&nbsp;&nbsp;&nbsp;&nbsp;${pokemon.Type2}</p>` : `<div style="height: 50px;"></div>`;

            var genderIconPath = getGenderIconPath(pokemon.Gender);
            var classIconPath = getClassIconPath(pokemon.Gender);
            var classLabel = getClassLabel(pokemon.Gender);

            var genderIconDisplay = ''; // 性別アイコンを表示するためのHTML
            if (pokemon.Gender === 'male' || pokemon.Gender === 'female') {
                genderIconDisplay = `<img src="${genderIconPath}" alt="${pokemon.Gender}" style="height: 20px; width: 20px; margin-left: 5px; vertical-align: middle;">`; // 名前の横にアイコン
            }

            var classIconDisplay = ''; // クラスアイコンとラベルを表示するためのHTML
            if (classIconPath && classLabel) {
                if (classLabel === 'せいべつふめい') { // 特定のテキストの場合
                    classIconDisplay = `<div style="display: flex; justify-content: center; align-items: center; margin-top: 10px;">
                        <img src="${classIconPath}" style="height: 20px; width: 20px; vertical-align: middle;">
                        <span style="color: lightgray;">&nbsp;${classLabel}</span> <!-- ライトグレーに設定 -->
                    </div>`;
                } else {
                    classIconDisplay = `<div style="display: flex; justify-content: center; align-items: center; margin-top: 10px;">
                        <img src="${classIconPath}" style="height: 20px; width: 20px; vertical-align: middle;">
                        &nbsp;${classLabel}
                    </div>`;
                }
            }

            var card = `
                <div class="pokemon-card" style="animation-delay: ${delay}s; line-height: 1.0;">
                    <div style="display: flex; justify-content: space-between;">
                        <div>
                            <img class="pokemon-image" src="${pokemon.Image_path}" alt="${pokemon.Name}" style="margin-top: 40px;">
                            <p><strong>${pokemon.Name}</strong>${genderIconDisplay}</p> <!-- 名前の横にアイコン -->
                            ${classIconDisplay} <!-- クラスアイコンとラベル -->
                        </div>
                        <div>
                            ${type1Display}
                            ${type2Display}
                            <p><strong>ねだん</strong></p>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;${pokemon.Price}</p>
                            <p><strong>在庫:</strong> <span id="inventory-${pokemon.SID}">${pokemon.Inventory}</span></p>
                        </div>
                    </div>
                    ${pokemon.Inventory === 0 ? `<img src="./images/assets/index_soldout.png" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border-radius: 10px; opacity: 0.7;">` : ''}
                    <div style="display: flex; justify-content: center; align-items: center; margin-top: 10px;">
                        <input type="number" class="form-control" style="width: 60px; margin-right: 10px;" placeholder="個数" aria-label="個数" aria-describedby="basic-addon2" id="quantity-${pokemon.SID}" value="0" min="0">
                        <button class="btn btn-primary" type="button" onclick="addToCart('${pokemon.SID}', '${pokemon.Name}')">カートに追加</button>
                    </div>
                </div>
            `;
            container.append(card);
            delay += 0.1; // アニメーションの遅延を徐々に増やす
        });
    }

    $(document).ready(function() {

        displayMessage('\nいらっしゃいませ！！\n商品をカートに追加してね♪');

        // 最初にカートの内容を更新してボタンの状態をチェック
        updateCartDisplay();

        // 最初に8個のポケモンを表示
        displayPokemon(filteredPokemon.slice(0, offset));

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
                        displayMessageWithSound('\n個数は1以上である必要があります。', "./audio/voice/index_001_voice.mp3");
                        $(`#cart-quantity-${index}`).val(item.quantity); // 元の個数に戻す
                        hasInvalidUpdate = true; // フラグを立てる
                        return; // 処理を終了
                    }

                    var availableInventory = pokemon.Inventory + item.quantity; // 利用可能な在庫

                    if (newQuantity > availableInventory) { // 在庫を超える場合
                        displayMessageWithSound(`\n${pokemon.Name} の\n在庫を超える個数は追加できません。`, "./audio/voice/index_002_voice.mp3"); // 名前を含めたアラート
                        $(`#cart-quantity-${index}`).val(item.quantity); // 元の個数に戻す
                        hasInvalidUpdate = true; // フラグを立てる
                        return; // 処理を終了
                    }

                    if (newQuantity !== item.quantity) { // 個数が変わったか確認
                        hasChanges = true; // 変更があったフラグ
                        var quantityDifference = newQuantity - item.quantity; // 個数差
                        pokemon.Inventory -= quantityDifference; // 在庫調整

                        // 在庫表示を更新
                        $(`#inventory-${pokemon.SID}`).text(`${pokemon.Inventory}`);

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
                    displayMessageWithSound('\n個数が更新されました。', "./audio/voice/index_003_voice.mp3");
                }
            });
        });
    });

    function addToCart(sid, name) {
        var quantity = parseInt($('#quantity-' + sid).val());
        var pokemon = pokemonData.find(p => p.SID === sid);

        if (quantity <= 0) {
            displayMessageWithSound('\n正しい個数を入力してください。', "./audio/voice/index_004_voice.mp3");
            return;
        }

        if (quantity > pokemon.Inventory) {
            displayMessageWithSound(`\n${name} の\n在庫を超える個数は追加できません。`, "./audio/voice/index_005_voice.mp3");
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
        $(`#inventory-${pokemon.SID}`).text(`${pokemon.Inventory}`);

        // カートの内容を更新
        updateCartDisplay();

        displayMessageWithSound(`\n${name} を ${quantity} 個\nカートに追加しました。`, "./audio/voice/index_006_voice.mp3");

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
                var pokemon = pokemonData.find(p => p.SID === item.sid);
                var genderIconPath = getCartIconPath(pokemon.Gender); // 分類アイコンのパスを取得
                var genderIconHtml = genderIconPath ? `<img src="${genderIconPath}" alt="${pokemon.Gender}" style="height: 20px; width: 20px;">` : '';

                var totalPrice = item.price * item.quantity; // 小計
                grandTotalPrice += totalPrice; // 合計金額に加算

                // アイテムのレイアウトを変更
                cartList.append(`
                    <li style="margin-bottom: 10px;"> <!-- 要素間に余白を追加 -->
                        <!-- 性別アイコンと商品名 -->
                        ${item.name}
                        ${genderIconHtml} <br> <!-- 性別アイコンの後に改行 -->

                        <!-- 商品情報 -->
                        <div style="margin-left: 20px; display: inline-block;">
                            個数
                            <input type="number" class="form-control" style="width: 50px;" min="1" value="${item.quantity}" id="cart-quantity-${index}"/>
                            小計¥${totalPrice.toLocaleString()}
                            <button class="btn btn-danger btn-sm remove-from-cart" data-index="${index}">削除</button>
                        </div>
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
                $(`#inventory-${pokemon.SID}`).text(`${pokemon.Inventory}`);

                // カートの内容を更新
                updateCartDisplay();

                displayMessageWithSound(`\n${removedItem.name} を\nカートから削除しました。`, "./audio/voice/index_007_voice.mp3");
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

    function displayMessage(message) {
        const speechBubble = document.getElementById('speechBubbleText');
        speechBubble.innerText = message;
    }

    function playSound(mp3Path) {
        const sound = new Howl({
        src: [mp3Path],
        preload: true,
        autoplay: true,
        onload: () => {
            console.log("load!");
        }
    });
}


    function displayMessageWithSound(message, mp3Path) {
        displayMessage(message); // メッセージを表示
        playSound(mp3Path); // MP3を再生
    }
</script>
</body>
</html>