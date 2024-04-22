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
    </style>
</head>
<body>

<div class="container">
    <h1 class="text-center">Pokemon Information</h1>
    <div class="row" id="pokemon-container">
        <?php
        // JSON ファイルを読み込む
        $json_data = file_get_contents('pokemon_data.json');
        $pokemon_data = json_decode($json_data, true);

        // ポケモンの情報を表示する関数
        function displayPokemon($data, $offset) {
            for ($i = $offset; $i < min($offset + 5, count($data)); $i++) {
                $pokemon = $data[$i];
                echo '<div class="pokemon-card">';
                echo '<img class="pokemon-image" src="' . $pokemon['Image_path'] . '" alt="' . $pokemon['Name'] . '">';
                echo '<p>' . $pokemon['Name'] . '</p>';
                echo '<p>タイプ1: ' . $pokemon['Type1'] . '</p>';
                echo '<p>タイプ2: ' . ($pokemon['Type2'] ?? '-') . '</p>';
                echo '<p>ねだん: ' . $pokemon['Price'] . '</p>';
                echo '<div class="input-group mb-3">
                        <input type="number" class="form-control" placeholder="個数" aria-label="個数" aria-describedby="basic-addon2" id="quantity-' . $pokemon['PID'] . '" value="0" min="0">
                        <button class="btn btn-primary" type="button" onclick="addToCart(\'' . $pokemon['PID'] . '\', \'' . $pokemon['Name'] . '\')">カートに追加</button>
                      </div>';
                echo '</div>';
            }
        }

        // 最初の5個のポケモンの情報を表示する
        displayPokemon($pokemon_data, 0);
        ?>
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
    // カートに追加された商品の情報を保持する配列
    var cartItems = [];

    $(document).ready(function() {
        var offset = 5; // 最初の5個を表示したので、次のデータはoffsetから開始

        // さらに読み込むボタンがクリックされた時の処理
        $('#load-more').on('click', function() {
            $.ajax({
                url: 'get_more_pokemon.php', // 追加のポケモン情報を取得するPHPファイルのパス
                type: 'GET',
                data: {offset: offset},
                success: function(data) {
                    $('#pokemon-container').append(data); // 返されたHTMLを追加
                    offset += 5; // offsetを更新して次の5個のデータを取得するために準備
                },
                error: function() {
                    alert('データの読み込み中にエラーが発生しました。');
                }
            });
        });
    });

    function addToCart(pid, name) {
        var quantity = $('#quantity-' + pid).val();
        if (quantity <= 0) {
            alert('正しい個数を入力してください。');
            return;
        }
        // カートに商品を追加し、配列に保存
        cartItems.push({pid: pid, name: name, quantity: quantity});
        // カートの内容を更新
        updateCartDisplay();
        // アラート表示
        alert(name + ' を ' + quantity + ' 個カートに追加しました。');
    }

    // カートの内容を表示する関数
    function updateCartDisplay() {
        var cartList = $('#cart-items');
        cartList.empty(); // カートの内容を一旦空にする
        // カートに追加された商品を表示
        cartItems.forEach(function(item) {
            cartList.append('<li>' + item.name + ' x ' + item.quantity + '</li>');
        });
    }
</script>

</body>
</html>
