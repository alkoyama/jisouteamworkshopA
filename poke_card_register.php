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
            width: 95%;
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
            height: 250px; /* 固定の高さを設定 */
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
            font-size: 1.2vw;
            overflow: hidden; /* コンテンツがカードの高さを超えないようにする */
        }

        /* カード内のテキストコンテンツのスタイル */


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
    var searchText = $('#search-name').val().toLowerCase(); // 検索フィールドの文字列
    var selectedTypes = []; // 選択されたタイプ
    $('#type-filters input:checked').each(function() {
        selectedTypes.push($(this).val());
    });

    var selectedGenders = []; // 選択されたジェンダー
    $('#gender-filters input:checked').each(function() {
        selectedGenders.push($(this).val());
    });

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

    var container = $('#pokemon-container');
    container.empty(); // 既存の表示をクリア
    offset = 0; // オフセットをリセット
    displayPokemon(filteredPokemon.slice(0, offset + 8)); // フィルタリングされたポケモンを表示
}

// 文字列検索の変更イベント
$('#search-name').on('input', applyFilters);

// タイプフィルターの変更イベント
$('#type-filters input').on('change', applyFilters);

// ジェンダーフィルターの変更イベント
$('#gender-filters input').on('change', applyFilters);

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
                    <!-- ラジオボタン -->
                    <div style="position: absolute; top: 10px; left: 10px; transform:scale(2.5)">
                        <input type="radio" name="product_select" value="${pokemon.SID}")> <!-- 商品選択用のラジオボタン -->
                    </div>
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
            </div>
        `;
        container.append(card);
        delay += 0.1; // アニメーションの遅延を徐々に増やす
    });
}



$(document).ready(function() {
    // デフォルトでSIDの数字部分を使用して降順にソート
    filteredPokemon.sort((a, b) => {
        const sidA = parseInt(a.SID.replace(/[^0-9]/g, '')); // SIDの数字部分を抽出して整数化
        const sidB = parseInt(b.SID.replace(/[^0-9]/g, ''));
        return sidB - sidA; // 降順にソート
    });

    // 最初に8個のポケモンを表示
    displayPokemon(filteredPokemon.slice(0, offset));

    // ポケモンタイプの名前と `value` の対応表を作成
    var typeMapping = {
        "ノーマル": "T01NML",
        "ほのお": "T02HNO",
        "みず": "T03MIZ",
        "でんき": "T04DNK",
        "くさ": "T05KUS",
        "こおり": "T06KOR",
        "かくとう": "T07KKT",
        "どく": "T08DOK",
        "じめん": "T09ZMN",
        "ひこう": "T10HKU",
        "エスパー": "T11ESP",
        "むし": "T12MUS",
        "いわ": "T13IWA",
        "ゴースト": "T14GST",
        "ドラゴン": "T15DGN",
        "あく": "T16AKU",
        "はがね": "T17HGN",
        "フェアリー": "T18FRY"
    };

        // ラジオボタンの変更イベント
        $('#pokemon-container').on('change', 'input[name="product_select"]', function() {
        var selectedSID = $(this).val(); // チェックされた SID を取得
        var selectedProduct = filteredPokemon.find(pokemon => pokemon.SID === selectedSID);

        if (selectedProduct) {
            var productName = selectedProduct.Name;
            var gender = selectedProduct.Gender;

            var type1Value = typeMapping[selectedProduct.Type1] || null;
            var type2Value = typeMapping[selectedProduct.Type2] || null;

            var imagePath = selectedProduct.Image_path; // 画像パスを取得
            var pid = selectedProduct.PID; // PID を取得

            // 親ドキュメントのフィールドを更新
            $('#product_name', parent.document).val(productName); // 商品名
            $('#gender', parent.document).val(gender); // ジェンダー
            $('#type1-select', parent.document).val(type1Value); // タイプ1
            $('#type2-select', parent.document).val(type2Value); // タイプ2
            
            // PIDを隠しフィールドにセット
            $('#existingPID', parent.document).val(pid);

            // 画像プレビューをリセット
            resetImagePreview(parent.document);

            // 画像プレビューに画像をセット
            $('#image_preview', parent.document).attr('src', imagePath); // 画像プレビューにセット
            $('#image_preview_container', parent.document).show(); // プレビューを表示
        
            // タイプの表示/非表示を制御
            updateTypeVisibility(gender, parent.document);
        }
    });

    // 画像プレビューをリセットする関数
    function resetImagePreview(parentDoc) {
        var $parent = $(parentDoc);
        $parent.find('#product_image').val(""); // ファイル選択をリセット
        $parent.find('#file_name_input').val(""); // ファイル名をリセット
        $parent.find('#file_name_label, #file_name_input, #image_preview_container').hide(); // プレビューを非表示
        $parent.find('#image_preview').attr('src', ""); // 画像プレビューをクリア
    }
    
    // "さらに読み込む" ボタンの処理
    $('#load-more').on('click', function() {
        if (offset < filteredPokemon.length) {
            var nextPokemon = filteredPokemon.slice(offset, offset + 8);
            displayPokemon(nextPokemon);
            offset += 8;
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
});

    // 親ドキュメントでタイプの表示/非表示を制御する関数
    function updateTypeVisibility(gender, parentDoc) {
        var $parent = $(parentDoc);

        if (gender === 'egg' || gender === 'item' || gender === 'ball') {
            $parent.find('#type1, #type2').hide();
            $parent.find('#type1-select, #type2-select').val(null); // 値をクリア
        } else {
            $parent.find('#type1, #type2').show(); // 表示
        }
    }
</script>

</body>
</html>