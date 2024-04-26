<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>決済情報</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>決済情報</h1>

        <form method="POST" action="payment_confirmation_7thA.php" id="checkout-form">
            <!-- お客様情報 -->
            <div class="mb-3">
                <label for="cid" class="form-label">CID:</label>
                <input type="text" name="cid" class="form-control" id="cid" required>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">名前:</label>
                <input type="text" name="name" class="form-control" id="name" required>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">住所:</label>
                <input type="text" name="address" class="form-control" id="address" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">電話番号:</label>
                <input type="text" name="phone" class="form-control">
            </div>

            <div class="mb-3">
                <label for="card-info" class="form-label">カード情報:</label>
                <input type="text" name="card_info" class="form-control">
            </div>

            <!-- カート内容 -->
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cartItems'])) {
                $cartItems = $_POST['cartItems'];

                echo '<table class="table table-striped">';
                echo '<thead><tr><th>SID</th><th>名前</th><th>個数</th><th>価格</th><th>小計</th><th>操作</th></tr></thead>';
                echo '<tbody>';

                $grandTotal = 0;

                foreach ($cartItems as $index => $item) {
                    $product = json_decode($item, true);
                    $totalPrice = $product['price'] * $product['quantity'];
                    $grandTotal += $totalPrice;

                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($product['sid']) . '</td>';
                    echo '<td>' . htmlspecialchars($product['name']) . '</td>';
                    echo '<td>';
                    echo '<input type="number" min="1" value="' . htmlspecialchars($product['quantity']) . '" id="cart-quantity-' . $index . '" style="width: 50px;" data-old-quantity="' . htmlspecialchars($product['quantity']) . '">';
                    echo '<button class="btn btn-primary btn-sm update-quantity" data-index="' . $index . '" style="margin-left: 10px;">更新</button>';
                    echo '</td>';
                    echo '<td>¥' . htmlspecialchars($product['price']) . '</td>';
                    echo '<td id="subtotal-' . $index . '">¥' . htmlspecialchars($totalPrice) . '</td>';
                    echo '<td>';
                    echo '<button class="btn btn-danger btn-sm remove-from-cart" data-index="' . $index . '">削除</button>';
                    echo '</td>';
                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';

                echo '<h2>合計金額: ¥<span id="grand-total">' . htmlspecialchars($grandTotal) . '</span></h2>';
            } else {
                echo '<p>カートに商品がありません。</p>';
            }
            ?>

            <!-- 隠しフィールドでカート内容を送信 -->
            <input type="hidden" name="cartData" id="cart-data" value="">

            <!-- 注文最終確認ボタン -->
            <div class="text-center mt-3">
                <button type="submit" class="btn btn-primary">注文最終確認</button>
            </div>
        </form>

        <!-- JavaScript 部分 -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                // 更新後、カートデータをJSONで隠しフィールドに更新
                function updateCartJson() {
                    const cartData = [];

                    $('tbody tr').each(function() {
                        const sid = $(this).find('td:eq(0)').text(); 
                        const name = $(this).find('td:eq(1)').text(); 
                        const quantity = parseInt($(this).find('input[type="number"]').val()); 
                        const price = parseInt($(this).find('td:eq(3)').text().replace('¥', '')); 

                        cartData.push({ sid, name, quantity, price });
                    });

                    $('#cart-data').val(JSON.stringify(cartData)); // カートデータをJSONで更新
                }

                // インベントリをJSONファイルからチェック
                function checkInventory(sid, quantity, callback) {
                    $.getJSON("pokemon_data.json", function(data) {
                        const product = data.find(p => p.SID === sid);
                        if (product && product.Inventory >= quantity) {
                            callback(true);
                        } else {
                            callback(false);
                        }
                    });
                }

                $('.update-quantity').on('click', function(e) {
                    e.preventDefault(); 
                    
                    const index = $(this).data('index'); 
                    const oldQuantity = parseInt($('#cart-quantity-' + index).attr('data-old-quantity')); 
                    const newQuantity = parseInt($('#cart-quantity-' + index).val()); 
                    const sid = $('#cart-quantity-' + index).closest('tr').find('td:eq(0)').text(); // SID
                    const price = parseInt($('#cart-quantity-' + index).closest('tr').find('td:nth-child(4)').text().replace('¥', '')); 
                    const subtotalElement = $('#subtotal-' + index); 
                    const newSubtotal = price * newQuantity; 

                    checkInventory(sid, newQuantity, function(isAvailable) {
                        if (!isAvailable.available) {
                            alert(`${isAvailable.name}の在庫は${isAvailable.inventory}です。\n在庫以上の数量に更新できません。`);
                            $('#cart-quantity-' + index).val(oldQuantity); 
                            return;
                        }

                        subtotalElement.text('¥' + newSubtotal); 

                        let grandTotal = 0;
                        $('td[id^="subtotal-"]').each(function() {
                            grandTotal += parseInt($(this).text().replace('¥', ''));
                        });

                        $('#grand-total').text(grandTotal); 

                        if (oldQuantity !== newQuantity) { 
                            alert('個数が更新されました。');
                            $('#cart-quantity-' + index).attr('data-old-quantity', newQuantity); 
                        }

                        updateCartJson(); // カートデータをJSONに更新
                    });
                });

                $('.remove-from-cart').on('click', function(e) {
                    e.preventDefault(); 

                    const index = $(this).data('index'); 
                    const subtotalElement = $('#subtotal-' + index); 
                    const removedSubtotal = parseInt(subtotalElement.text().replace('¥', '')); 

                    $(this).closest('tr').remove(); 

                    let grandTotal = parseInt($('#grand-total').text().replace('¥', '')); 
                    grandTotal -= removedSubtotal;

                    $('#grand-total').text(grandTotal); 

                    alert('商品がカートから削除されました。'); 

                    checkIfCartIsEmpty(); 
                    updateCartJson(); // カートデータをJSONに更新
                });


                function checkInventory(sid, quantity, callback) {
                    $.getJSON("pokemon_data.json", function(data) {
                        const product = data.find(p => p.SID === sid);
                        if (product) {
                            if (product.Inventory >= quantity) {
                                callback({ available: true });
                            } else {
                                callback({ available: false, name: product.Name, inventory: product.Inventory });
                            }
                        } else {
                            callback({ available: false }); // SIDが見つからない場合
                        }
                    });
                }

                function checkIfCartIsEmpty() {
                    if ($('tbody tr').length === 0) { 
                        setTimeout(function() { 
                            alert("カートの中身が空です。\nストアフロントへ戻ります。");
                            window.location.href = 'index_7thA.php'; 
                        }, 500);
                    }
                }

                checkIfCartIsEmpty(); 
                updateCartJson();
            });
        </script>
    </div>
</body>
</html>
