<?php
// JSON ファイルを読み込む
$json_data = file_get_contents('pokemon_data.json');
$pokemon_data = json_decode($json_data, true);

// オフセットから開始して、次の5個のポケモンの情報を返す
if (isset($_GET['offset']) && is_numeric($_GET['offset'])) {
    $offset = $_GET['offset'];
    $result = '';
    for ($i = $offset; $i < min($offset + 5, count($pokemon_data)); $i++) {
        $pokemon = $pokemon_data[$i];
        $result .= '<div class="pokemon-card">';
        $result .= '<img class="pokemon-image" src="' . $pokemon['Image_path'] . '" alt="' . $pokemon['Name'] . '">';
        $result .= '<p>' . $pokemon['Name'] . '</p>';
        $result .= '<p>タイプ1: ' . $pokemon['Type1'] . '</p>';
        $result .= '<p>タイプ2: ' . ($pokemon['Type2'] ?? '-') . '</p>';
        $result .= '<p>ねだん: ' . $pokemon['Price'] . '</p>';
        $result .= '<div class="input-group mb-3">
                        <input type="number" class="form-control" placeholder="個数" aria-label="個数" aria-describedby="basic-addon2" id="quantity-' . $pokemon['PID'] . '" value="0" min="0">
                        <button class="btn btn-primary" type="button" onclick="addToCart(\'' . $pokemon['PID'] . '\', \'' . $pokemon['Name'] . '\')">カートに追加</button>
                      </div>';
        $result .= '</div>';
    }
    echo $result;
}
?>